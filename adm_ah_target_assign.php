<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Zone Wise Collection Concern Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-4">
							<select name="emp_ah_id" class="form-control">
								 <option selected value="">Select Area Head</option>
								      <?php
									   
									   
									   $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									   $USER_BRAND=$_SESSION['user_brand'];
									   $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									
									  $strSQL  = oci_parse($objConnect, "select EMP_NAME,RML_ID from RML_COLL_APPS_USER
                                            where IS_ACTIVE=1
                                            and LEASE_USER in('AH')
                                            and ACCESS_APP='RML_COLL'
                                            and is_active=1
                                            order by EMP_NAME");
									  	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['RML_ID'];?>"><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
							  
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">
                          	 <div class="col-sm-4">
							  </div>
							 <div class="col-sm-4">
							  </div>
							   <div class="col-sm-4">
							   <input class="form-control btn btn-primary" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
							  </div>
								
						</div>
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					  <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Emp ID</center></th>
								  <th scope="col"><center>Emp Name</center></th>
								  <th scope="col"><center>Target Month</center></th>
								  <th scope="col"><center>Target</center></th>
								  <th scope="col"><center>Collection Start Date</center></th>
								  <th scope="col"><center>Collection End Date</center></th>
								  <th scope="col"><center>Collection</center></th>
								  <th scope="col"><center>Collection(%)</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
						@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$emp_ah_id = $_REQUEST['emp_ah_id'];
						
						

			if(isset($_POST['emp_ah_id'])){
				
				 $strSQL  = oci_parse($objConnect, 
							   "select b.RML_ID,b.EMP_NAME,
									RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
									 --(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
									 COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT 
									 FROM RML_COLL_APPS_USER b 
									 where  b.ACCESS_APP='RML_COLL'
									 and B.IS_ACTIVE=1  
									 and b.LEASE_USER='AH' 
									  and ('$emp_ah_id' is null OR b.RML_ID='$emp_ah_id')");  


						  oci_execute($strSQL);
						  $number=0;
						  $GRANT_TOTAL_TARGET=0;
						  $GRANT_TOTAL_COLLECTION=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php echo $attn_start_date;?></td>
							  <td align="center"><?php echo $row['TARGET_AMNT']; $GRANT_TOTAL_TARGET=$GRANT_TOTAL_TARGET+$row['TARGET_AMNT'];?></td>
							  <td align="center"><?php echo $attn_start_date;?></td>
							  <td align="center"><?php echo $attn_end_date;?></td>
							  <td align="center"><?php echo $row['COLLECTION_AMNT']; $GRANT_TOTAL_COLLECTION=$GRANT_TOTAL_COLLECTION+$row['COLLECTION_AMNT']?></td>
							  <td align="center"><?php 
							                      if($row['COLLECTION_AMNT']==0 || $row['TARGET_AMNT']==0){
								                     echo "0";
							                        }else{
													 echo ceil(($row['COLLECTION_AMNT']*100)/$row['TARGET_AMNT']);	
													}
											     ?> 
								%</td>
						  </tr>
						 <?php
						  }
						   ?>
						   <tr>
						      <td align="center"></td> 
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center">Grand Total:</td>
							  <td align="center"><?php echo $GRANT_TOTAL_TARGET;?></td>
							  <td align="center"></td>
							  <td align="center">Grand Total:</td>
							  <td align="center"><?php echo $GRANT_TOTAL_COLLECTION;?></td>
							  <td align="center">
							  <?php 
							   if($row['COLLECTION_AMNT']==0 || $row['TARGET_AMNT']==0){
								     echo "0";			  
							   }else{
								  echo ceil(($GRANT_TOTAL_COLLECTION*100)/$GRANT_TOTAL_TARGET);	
							   }
							  
							  
							  ?>
							  %</td>
							  <td align="center"></td>
							  <td align="center"></td>
						 </tr>
						  <?php
						  }
						
						?>
					</tbody>	
				 
		              </table>
					</div>
					<div>
					
					
					<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
					</div>
				  </div>
				</div>
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
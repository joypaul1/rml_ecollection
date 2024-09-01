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
          <a href="">Reason code wise report</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-3">
							<select name="emp_zone" class="form-control">
								 <option selected value="">Select Zone</option>
								      <?php
									   
						               $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");  
									   
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	
									  <option value="<?php echo $row['ZONE_NAME'];?>"><?php echo $row['ZONE_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
							  
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							<div class="col-sm-3">
							        <select name="reason_code" class="form-control">
								      <option selected value="">Select Reason Code</option>
								      <?php
						               $reasonSQL  = oci_parse($objConnect, "select TITLE from RML_COLL_ALKP where PAREN_ID=1 and is_active=1 order by SORT_ORDER");  
									   
						                oci_execute($reasonSQL);
									   while($row=oci_fetch_assoc($reasonSQL)){	
									  ?>
									  <option value="<?php echo $row['TITLE'];?>"><?php echo $row['TITLE'];?></option>
									  <?php
									   }
									  ?>
							       </select>
							</div>
						</div>	
						<div class="row mt-3">
                          	  <div class="col-sm-3">
							  </div>
							  <div class="col-sm-3">
							  </div>
							  <div class="col-sm-3">
							  </div>
							  <div class="col-sm-3">
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
								  <th scope="col"><center>Concern Name</center></th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Reason Code</center></th>
								  <th scope="col"><center>Concern Remarks</center></th>
								  <th scope="col"><center>Zone Name</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						@$emp_zone = $_REQUEST['emp_zone'];
						@$visit_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$visit_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$reason_code = $_REQUEST['reason_code'];
						
						

			  if(isset($_POST['start_date'])){
							 $strSQL  = oci_parse($objConnect, 
										   "select B.RML_ID,B.EMP_NAME,A.REF_ID,a.CREATED_DATE,A.CUSTOMER_COMMENTS, B.AREA_ZONE,a.CONCERN_COMMENTS 
										   from RML_COLL_CUST_VISIT a,RML_COLL_APPS_USER b
											where A.RML_COLL_APPS_USER_ID=b.id
											and ('$emp_zone' is null OR B.AREA_ZONE='$emp_zone')
											and ('$reason_code' is null OR A.CUSTOMER_COMMENTS='$reason_code')
											and a.CUSTOMER_COMMENTS in (select title from RML_COLL_ALKP where PAREN_ID=1 and is_active=1)
											and trunc(a.CREATED_DATE) between to_date('$visit_start_date','dd/mm/yyyy') and  to_date('$visit_end_date','dd/mm/yyyy')");  
					
					
						  
						  oci_execute($strSQL);
						  $number=0;
						  $GRANT_TOTAL_TARGET=0;
						  $GRANT_TOTAL_COLLECTION=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['REF_ID'];?></td>
							 <td><?php echo $row['CUSTOMER_COMMENTS'];?></td>
							 <td><?php echo $row['CONCERN_COMMENTS'];?></td>
							 <td><?php echo $row['AREA_ZONE'];?></td>
						  </tr>
						 <?php
						  }
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
		  elem.setAttribute("download", "Reason_Code_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
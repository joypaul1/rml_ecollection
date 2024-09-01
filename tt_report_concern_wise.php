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
          <a href="">Bank TT Zone Wise Report Panel</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						 
						    <div class="col-sm-3">
							<select name="concern_name" class="form-control">
								 <option selected value="">Select Concern</option>
								      <?php
									  
						               $strSQL  = oci_parse($objConnect, "select DISTINCT(EMP_NAME) EMP_NAME,RML_ID,ID from RML_COLL_APPS_USER where ACCESS_APP='RML_COLL' AND LEASE_USER='CC' AND IS_ACTIVE=1 AND RML_ID NOT IN ('955','956') ORDER BY EMP_NAME");  
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
									  <option value="<?php echo $row['EMP_NAME'];?>"><?php echo $row['EMP_NAME'];?></option>
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
								<select  name="tt_status" class="form-control">
									 <option selected value="">Select Status</option>
										  <option value="1">Confirm</option>
										  <option value="0">Pending</option>
								</select>
							</div>
						</div>	
						<div class="row">
                          	
                            						
							<div class="col-sm-12">
								<div class="md-form mt-3">
									<input class="form-control" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
								</div>
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
								  <th scope="col"><center>Sl</center></th>
								  <th scope="col"><center>From Date</center></th>
								  <th scope="col"><center>To Date</center></th>
								  <th scope="col"><center>Concern Name</center></th>
								  <th scope="col"><center>EMI TT Amount</center></th>
								  <th scope="col"><center>Total TT Amount</center></th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						@$concern_name=$_REQUEST['concern_name'];
						@$tt_from_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$tt_to_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$tt_status=$_REQUEST['tt_status'];
						

			if(isset($_POST['start_date'])){
			
                     
					$strSQL = oci_parse($objConnect, 
					           "SELECT DISTINCT(B.EMP_NAME),SUM(A.AMOUNT) TT_AMOUNT,SUM(TT_TOTAL_TAKA) TT_TOTAL_TAKA FROM RML_COLL_MONEY_COLLECTION A,RML_COLL_APPS_USER B
								WHERE A.RML_COLL_APPS_USER_ID=B.ID
								and ('$concern_name' is null OR B.EMP_NAME='$concern_name')
								AND A.PAY_TYPE='Bank TT'
								AND A.BANK='Sonali Bank'
								AND B.IS_ACTIVE=1
								AND TRUNC(A.CREATED_DATE) BETWEEN TO_DATE('$tt_from_date','dd/mm/yyyy') AND TO_DATE('$tt_to_date','dd/mm/yyyy')
								GROUP BY B.EMP_NAME
								ORDER BY  B.EMP_NAME");  
						
						  oci_execute($strSQL);
						  $number=0;
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
						   $emi_tt_amount=$row['TT_AMOUNT'];
						   $total_tt_amount=$row['TT_TOTAL_TAKA'];
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $tt_from_date ;?></td>
							  <td align="center"><?php echo $tt_to_date;?></td>
							  <td align="center"><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php 
												   if($emi_tt_amount== $total_tt_amount)
													  echo $row['TT_AMOUNT'];
												   else{
													  echo '<span style="color:red;text-align:center;">';
													  echo $row['TT_AMOUNT'];
													  echo '</span>'; 
												   }
													  
													
												?>
							  </td>
							  <td align="center"><?php echo $row['TT_TOTAL_TAKA'];?></td>

						  </tr>
						 <?php
						  }}
						
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
		  elem.setAttribute("download", "TT_Report-1.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
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
          <a href="">Date Wise Confirm TT  Confirm Report Panel</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						 
							<div class="col-sm-6">
							<label for="title"><b>TT Confirm Start Date:</b><sup style="color:red;">*</sup></label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-6">
							<label for="title"><b>TT Confirm End Date:</b><sup style="color:red;">*</sup></label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
						</div>	
						<div class="row">
                          	
                            						
							<div class="col-sm-12">
								<div class="md-form mt-3">
									<input class="btn btn-primary btn pull-right form-control" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
								</div>
							</div>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 
					 <div class="table-responsive resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="table" style="width:100% border:solid black">   
						<thead class="thead-dark">
								<tr>
								  <th scope="col"><center>Sl</center></th>
								  <th scope="col"><center>TT ID</center></th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>TT Type</center></th>
								  <th scope="col"><center>TT Date</center></th>
								  <th scope="col"><center>TT Amount</center></th>
								  <th scope="col"><center>Total TT Amount</center></th>
								  <th scope="col"><center>Branch</center></th>
								  <th scope="col"><center>Concern Name</center></th>
								  <th scope="col"><center>Concern Zone</center></th>
								  <th scope="col"><center>TT Remarks</center></th>
								  <th scope="col"><center>Confirm Date</center></th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						@$visit_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$visit_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
					
						

			if(isset($_POST['start_date'])){
			

					$strSQL = oci_parse($objConnect, 
					           "SELECT TO_CHAR(CREATED_DATE,'dd/mm/yyyy') CREATED_DATE,ID,
								 REF_ID,
								 TT_TYPE,
								 TO_CHAR(TT_DATE,'dd/mm/yyyy') TT_DATE,
								 AMOUNT,
								 TT_TOTAL_TAKA,
								 UPPER(TT_BRANCH) TT_BRANCH,
								 UPPER(TT_REMARKS) TT_REMARKS,
								(select emp_name from RML_COLL_APPS_USER where ID=RML_COLL_APPS_USER_ID and ACCESS_APP='RML_COLL') CONCERN_NAME,
								(select MOBILE_NO from RML_COLL_APPS_USER where ID=RML_COLL_APPS_USER_ID and ACCESS_APP='RML_COLL') MOBILE_NO,
								(select AREA_ZONE from RML_COLL_APPS_USER where ID=RML_COLL_APPS_USER_ID and ACCESS_APP='RML_COLL') CONCERN_ZONE,
								TO_CHAR(TT_CONFIRM_DATE,'dd/mm/yyyy') TT_CONFIRM_DATE,
								 TT_CHECK
						 from RML_COLL_MONEY_COLLECTION
						where PAY_TYPE = 'Bank TT'
						AND BANK = 'Sonali Bank'
						AND TT_TYPE IS NOT NULL
						AND TRUNC(TT_CONFIRM_DATE)  BETWEEN TO_DATE('$visit_start_date','dd/mm/yyyy') AND TO_DATE('$visit_end_date','dd/mm/yyyy')
						AND TRUNC(CREATED_DATE) >=TO_DATE('12/12/2019','dd/mm/yyyy')");  
						
						  oci_execute($strSQL);
						  $number=0;
						  $EMI_TOTAL=0;
						  $EMI_TT_TOTAL_TAKA=0;
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
						   
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['ID'];?></td>
							  <td align="center"><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['REF_ID'];?></td>
							  <td align="center"><?php echo $row['TT_TYPE'];?></td>
							  <td align="center"><?php echo $row['TT_DATE'];?></td>
							  <td align="center">
												<?php echo number_format($row['AMOUNT']); 
													  $EMI_TOTAL=$EMI_TOTAL + $row['AMOUNT']; 
												 ?>
							  </td>
							  </td>
							  <td align="center">
												<?php echo number_format($row['TT_TOTAL_TAKA']); 
												 $EMI_TT_TOTAL_TAKA= $EMI_TT_TOTAL_TAKA + $row['TT_TOTAL_TAKA'];
												 ?>
							  
							  </td>
							  <td align="center"><?php echo $row['TT_BRANCH'];?></td>
							  <td align="center"><?php echo $row['CONCERN_NAME'];?></td>
							  <td align="center"><?php echo $row['CONCERN_ZONE'];?></td>
							  <td align="center"><?php echo $row['TT_REMARKS'];?></td>
							  <td align="center"><?php echo $row['TT_CONFIRM_DATE'];?></td>

						  </tr>
						  <?php
						    }
						   ?>
						   <tr>
							 
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td>TOTAL:</td>
							 <td align="center"><?php echo number_format($EMI_TOTAL);?></td>
							 <td align="center"><?php echo number_format($EMI_TT_TOTAL_TAKA);?></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td></td>
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
		  elem.setAttribute("download", "TT_Report-1.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
	// Page access
	if($_SESSION['user_role_id']!= 5 && $_SESSION['user_role_id']!= 3 && $_SESSION['user_role_id']!= 8)
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
          <a href="">SC Bank NOC Report</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						     <div class="col-sm-4">
							    <label for="title">Start Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							
							<div class="col-sm-4">
							    <label for="title">End Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">
						   
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
								  <th scope="col">Sl No</th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Bank Name</center></th>
								  <th scope="col"><center>Registration No</center></th>
								  <th scope="col"><center>Requsition Date</center></th>
								  <th scope="col"><center>Accounts Received Date</center></th>
								  <th scope="col"><center>CCD Received Date</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						
						
						

			           if(isset($_POST['start_date'])){
						@$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
				    
						$strSQL  = oci_parse($objConnect, 
						    "SELECT A.REF_CODE, 
                                   (Select pp.BANK_NAME from RML_COLL_CCD_BANK pp Where pp.id=A.BANK_ID) BANK_NAME,
                                   a.REG_NO,
                                   a.CURRENT_PARTY_NAME as CUSTOMER_NAME,
                                   A.BANK_REQUISITION_DATE,
								   b.NOC_RECEIVED_ACC_DATE,
								   B.NOC_RECEIVED_CCD_DATE
									FROM RML_COLL_SC_CCD a,RML_COLL_CCD_BNAK_NOC b
									WHERE A.ID=B.RML_COLL_SC_CCD_ID 
									AND B.NOC_RECEIVED_ACC_STATUS IS NULL
									and trunc(a.BANK_REQUISITION_DATE) between to_date('$start_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')");
                       
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['BANK_NAME'];?></td>
							  <td align="center"><?php echo $row['REG_NO'];?></td>
							  <td align="center"><?php echo $row['BANK_REQUISITION_DATE'];?></td>
							  <td align="center"><?php echo $row['NOC_RECEIVED_ACC_DATE'];?></td>
							  <td align="center"><?php echo $row['NOC_RECEIVED_CCD_DATE'];?></td>
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
		  elem.setAttribute("download", "SC_Handover_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
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
          <a href="">SC Request Report</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-4">
							 <label for="title">Select Approval Type:</label>
							    <select name="approval_type" required="" class="form-control">
								 <option value="">--</option>
								 <option value="LEASE">Lease Approval to Forwarding Accounts</option>
								 <option value="ACC">Account Approval to Forwarding CCD Waiting List</option>
								 <option value="CCDW">CCD Waiting to File Clear</option>
								 <option value="CCDFC">File Clear or CCD Issued</option>
							    </select> 
							</div>
						     <div class="col-sm-4">
							    <label for="title">Approval Start Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							
							<div class="col-sm-4">
							    <label for="title">Approval End Date:</label>
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
						   
							 <div class="col-sm-8">
									
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
					  <table class="table table-striped table-bordered table-sm table-responsive" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl No</th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Model Name</center></th>
								  <th scope="col"><center>Lease Approval By</center></th>
								  <th scope="col"><center>Lease Approval Date</center></th>
								  <th scope="col"><center>Account Approval By</center></th>
								  <th scope="col"><center>Account Approval Date</center></th>
								  <th scope="col"><center>CCD Accept By</center></th>
								  <th scope="col"><center>CCD Accept Date</center></th>
								  <th scope="col"><center>SC Prepared By</center></th>
								  <th scope="col"><center>SC Prepared Date</center></th>
								  <th scope="col"><center>SC Handover To</center></th>
								  <th scope="col"><center>SC Handover Date</center></th>
								  <th scope="col"><center>SC CAR Receive Date</center></th>
								  <th scope="col"><center>Bank NOC Requsition Date</center></th>
								  <th scope="col"><center>Bank NOC Receive Date</center></th>
								  <th scope="col"><center>Bank NOC Disbursed Date</center></th>
								  <th scope="col"><center>NOC Handover To</center></th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						
						
						

			           if(isset($_POST['start_date'])){
						@$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						$approval_type=$_REQUEST['approval_type'];
				    
					if($approval_type=="LEASE"){
						$strSQL  = oci_parse($objConnect, 
						           "SELECT ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   MODEL_NAME, 
									   CLOSING_DATE,  
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   FILE_CLEAR_BY,
									   FILE_CLEAR_DATE,
									  (select HANDOVER_ZH from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)HANDOVER_ZH,
									  (select SC_HANDOVER_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_HANDOVER_DATE,
									  (select SC_CAR_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_CAR_DATE,
									  (select NOC_REQUISITION_CCD_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_REQUISITION_CCD_DATE,
									  (select NOC_RECEIVED_ACC_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_RECEIVED_ACC_DATE,
									   aa.BANK_NOC_DISBURSED_DATE,
									   aa.NOC_DISBURSED_ZH
									FROM RML_COLL_SC_CCD aa
									where trunc(LEASE_APPROVAL_DATE) BETWEEN to_date('$start_date','dd/mm/yyyy') AND to_date('$end_date','dd/mm/yyyy')
									AND LEASE_APPROVAL_STATUS=1");
						
					}else if($approval_type=="ACC"){
						$strSQL  = oci_parse($objConnect, 
						           "SELECT ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   MODEL_NAME, 
									   CLOSING_DATE,  
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   FILE_CLEAR_BY,
									   FILE_CLEAR_DATE,
									   (select HANDOVER_ZH from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)HANDOVER_ZH,
									  (select SC_HANDOVER_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_HANDOVER_DATE,
									  (select SC_CAR_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_CAR_DATE,
									  (select NOC_REQUISITION_CCD_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_REQUISITION_CCD_DATE,
									  (select NOC_RECEIVED_ACC_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_RECEIVED_ACC_DATE,
									   aa.BANK_NOC_DISBURSED_DATE,
									   aa.NOC_DISBURSED_ZH
									FROM RML_COLL_SC_CCD aa
									where trunc(ACC_APPROVAL_DATE) BETWEEN to_date('$start_date','dd/mm/yyyy') AND to_date('$end_date','dd/mm/yyyy')
									AND ACC_APPROVAL_STATUS=1");
					}else if($approval_type=="CCDW"){
						$strSQL  = oci_parse($objConnect, 
						           "SELECT ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   MODEL_NAME, 
									   CLOSING_DATE,  
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   FILE_CLEAR_BY,
									   FILE_CLEAR_DATE,
									   (select HANDOVER_ZH from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)HANDOVER_ZH,
									  (select SC_HANDOVER_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_HANDOVER_DATE,
									  (select SC_CAR_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_CAR_DATE,
									  (select NOC_REQUISITION_CCD_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_REQUISITION_CCD_DATE,
									  (select NOC_RECEIVED_ACC_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_RECEIVED_ACC_DATE,
									   aa.BANK_NOC_DISBURSED_DATE,
									   aa.NOC_DISBURSED_ZH
									FROM RML_COLL_SC_CCD aa
									where trunc(CCD_APPROVAL_DATE) BETWEEN to_date('$start_date','dd/mm/yyyy') AND to_date('$end_date','dd/mm/yyyy')
									AND CCD_APPROVAL_STATUS=1");
					}else if($approval_type=="CCDFC"){
						$strSQL  = oci_parse($objConnect, 
						           "SELECT ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   MODEL_NAME, 
									   CLOSING_DATE,  
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   FILE_CLEAR_BY,
									   FILE_CLEAR_DATE,
									   (select HANDOVER_ZH from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)HANDOVER_ZH,
									  (select SC_HANDOVER_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_HANDOVER_DATE,
									  (select SC_CAR_DATE from RML_COLL_CCD_SC_HANDOVER where RML_COLL_SC_CCD_ID=aa.ID)SC_CAR_DATE,
									  (select NOC_REQUISITION_CCD_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_REQUISITION_CCD_DATE,
									  (select NOC_RECEIVED_ACC_DATE from RML_COLL_CCD_BNAK_NOC where RML_COLL_SC_CCD_ID=aa.ID)NOC_RECEIVED_ACC_DATE,
									   aa.BANK_NOC_DISBURSED_DATE,
									   aa.NOC_DISBURSED_ZH
									FROM RML_COLL_SC_CCD aa
									where trunc(FILE_CLEAR_DATE) BETWEEN to_date('$start_date','dd/mm/yyyy') AND to_date('$end_date','dd/mm/yyyy')
									AND FILE_CLEAR_STATUS=1");
					}
						
                       
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['MODEL_NAME'];?></td>
							  
							  <td><?php 
							     if($row['LEASE_APPROVAL_BY']!='')
							       echo $row['LEASE_APPROVAL_BY'];
							  ?></td>
							   <td><?php 
							     if($row['LEASE_APPROVAL_BY']!='')
							       echo $row['LEASE_APPROVAL_DATE'];
							  ?></td>
							  <td><?php 
							     if($row['ACC_APPROVAL_BY']!='')
							       echo $row['ACC_APPROVAL_BY'];
							  ?></td>
							   <td><?php 
							     if($row['ACC_APPROVAL_BY']!='')
							       echo $row['ACC_APPROVAL_DATE'];
							  ?></td>
							  <td><?php echo $row['CCD_APPROVAL_BY'];?></td>
							  <td><?php echo $row['CCD_APPROVAL_DATE'];?></td>
							  <td><?php echo $row['FILE_CLEAR_BY'];?></td> 
									   
							  <td><?php echo $row['FILE_CLEAR_DATE'];?></td>
							  <td><?php echo $row['HANDOVER_ZH'];?></td>
							  <td><?php echo $row['SC_HANDOVER_DATE'];?></td>
							  <td><?php echo $row['SC_CAR_DATE'];?></td>
							  <td><?php echo $row['NOC_REQUISITION_CCD_DATE'];?></td>
							  <td><?php echo $row['NOC_RECEIVED_ACC_DATE'];?></td>
							  <td><?php echo $row['BANK_NOC_DISBURSED_DATE'];?></td>
							  <td><?php echo $row['NOC_DISBURSED_ZH'];?></td>
							  
							  
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
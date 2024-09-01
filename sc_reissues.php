<?php 
	session_start();
	if($_SESSION['user_role_id']!= 5)
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
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">List</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						   
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Ref-Code:</label>
								  <input required="" name="ref_code" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title"> <br></label>
								  <input class="form-control btn btn-primary" type="submit" value="Search Data">
								</div>
							</div>
							
						</div>	
						
						
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="table" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Customer Mobile</center></th>
								  <th scope="col"><center>Requester Name</center></th>
								  <th scope="col"><center>Requester Mobile</center></th>
								  <th scope="col"><center>Request Date</center></th>
								  <th scope="col"><center>Reason Code</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['ref_code'])){
							
						  $reference_code = $_REQUEST['ref_code'];
						  $strSQL  = oci_parse($objConnect, "SELECT 
															   ID, REF_CODE, CURRENT_PARTY_NAME, 
															   CURRENT_PARTY_MOBILE, CURRENT_PARTY_ADDRS, MODEL_NAME, 
															   INSTALLMENT_RECEIVED, SALES_AMOUNT, DP, 
															   FIRST_PARTY_NAME, FIRST_PARTY_DP, FRIST_PARTY_INSTALLMENT_REC, 
															   RESOLED_DP, RESOLED_RECEIVED, RECEIVABLE, 
															   DISCOUNT, RECEIVED, CLOSING_DATE, 
															   RESALE_APPROVAL_DATE, REQUEST_DATE, REQUEST_BY, 
															   REQUESTER_NAME, REQUESTER_MOBILE, LEASE_APPROVAL_STATUS, 
															   LEASE_APPROVAL_DATE, LEASE_APPROVAL_BY, ACC_APPROVAL_DATE, 
															   ACC_APPROVAL_BY, ACC_APPROVAL_STATUS, CCD_APPROVAL_DATE, 
															   CCD_APPROVAL_BY, CCD_APPROVAL_STATUS, FILE_CLEAR_STATUS, 
															   FILE_CLEAR_DATE, FILE_CLEAR_BY, CLOSING_FEE, 
															   CCD_INFO_UPDATE, CCD_INFO_UPDATE_BY, ENG_NO, 
															   REG_NO, CHASSIS_NO, BRTA_LOCATION, 
															   RESPONSIBLE_PERSON, RESPONSIBLE_DESIGNATION, CUSTOMER_SO, 
															   BANK_ID, FATHER_OR_HUSBAND_NAME, CUSTOMER_HANDOVER_STATUS, 
															   CUSTOMER_HANDOVER_DATE, CUSTOMER_HANDOVER_BY, CUSTOMER_RECEIVED_STATUS, 
															   CUSTOMER_RECEIVED_DATE, CUSTOMER_RECEIVED_BY, RE_ISSUES_STATUS, 
															   RE_ISSUES_DATE, RE_ISSUES_BY,RE_ISSUES_REASON
															FROM RML_COLL_SC_CCD
															WHERE REF_CODE='$reference_code'
															AND RE_ISSUES_STATUS =1
															"); 	
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							<td><?php echo $number;?></td>
							<td><?php echo $row['REF_CODE'];?></td>
							<td><?php echo $row['CURRENT_PARTY_NAME'];?></td>
							<td><?php echo $row['CURRENT_PARTY_MOBILE'];?></td>
							<td><?php echo $row['REQUESTER_NAME'];?></td>
							<td><?php echo $row['REQUESTER_MOBILE'];?></td>
							<td><?php echo $row['REQUEST_DATE'];?></td>
							<td><?php echo $row['RE_ISSUES_REASON'];?></td>
						 
						 </tr>
						 <?php
						  }
						  }else{
							 
						     $allDataSQL  = oci_parse($objConnect, "SELECT 
															   ID, REF_CODE, CURRENT_PARTY_NAME, 
															   CURRENT_PARTY_MOBILE, CURRENT_PARTY_ADDRS, MODEL_NAME, 
															   INSTALLMENT_RECEIVED, SALES_AMOUNT, DP, 
															   FIRST_PARTY_NAME, FIRST_PARTY_DP, FRIST_PARTY_INSTALLMENT_REC, 
															   RESOLED_DP, RESOLED_RECEIVED, RECEIVABLE, 
															   DISCOUNT, RECEIVED, CLOSING_DATE, 
															   RESALE_APPROVAL_DATE, REQUEST_DATE, REQUEST_BY, 
															   REQUESTER_NAME, REQUESTER_MOBILE, LEASE_APPROVAL_STATUS, 
															   LEASE_APPROVAL_DATE, LEASE_APPROVAL_BY, ACC_APPROVAL_DATE, 
															   ACC_APPROVAL_BY, ACC_APPROVAL_STATUS, CCD_APPROVAL_DATE, 
															   CCD_APPROVAL_BY, CCD_APPROVAL_STATUS, FILE_CLEAR_STATUS, 
															   FILE_CLEAR_DATE, FILE_CLEAR_BY, CLOSING_FEE, 
															   CCD_INFO_UPDATE, CCD_INFO_UPDATE_BY, ENG_NO, 
															   REG_NO, CHASSIS_NO, BRTA_LOCATION, 
															   RESPONSIBLE_PERSON, RESPONSIBLE_DESIGNATION, CUSTOMER_SO, 
															   BANK_ID, FATHER_OR_HUSBAND_NAME, CUSTOMER_HANDOVER_STATUS, 
															   CUSTOMER_HANDOVER_DATE, CUSTOMER_HANDOVER_BY, CUSTOMER_RECEIVED_STATUS, 
															   CUSTOMER_RECEIVED_DATE, CUSTOMER_RECEIVED_BY, RE_ISSUES_STATUS, 
															   RE_ISSUES_DATE, RE_ISSUES_BY,RE_ISSUES_REASON
															FROM RML_COLL_SC_CCD
															WHERE RE_ISSUES_STATUS =1"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							<td><?php echo $number;?></td>
							<td><?php echo $row['REF_CODE'];?></td>
							<td><?php echo $row['CURRENT_PARTY_NAME'];?></td>
							<td><?php echo $row['CURRENT_PARTY_MOBILE'];?></td>
							<td><?php echo $row['REQUESTER_NAME'];?></td>
							<td><?php echo $row['REQUESTER_MOBILE'];?></td>
							<td><?php echo $row['REQUEST_DATE'];?></td>
							<td><?php echo $row['RE_ISSUES_REASON'];?></td>
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
		  elem.setAttribute("download", "SC Reissues List.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
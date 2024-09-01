<?php 
	session_start();
		if($_SESSION['user_role_id']!= 9 && $_SESSION['user_role_id']!= 7 && $_SESSION['user_role_id']!= 10)
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
	  <div class="container-fluid">
			<div class="row">			
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						$ref_code=$_REQUEST['ref_id'];
					
						
						  $strSQL  = oci_parse($objConnect, "select CUSTOMER_NAME,
						                                            CUSTOMER_MOBILE_NO,
						                                            REF_CODE,
																	INSTALLMENT_AMOUNT,
																	CHASSIS_NO,
																	TOTAL_RECEIVED_AMOUNT,
																	TOTAL_EMI_AMT,
																	NUMBER_OF_DUE,
																	DUE_AMOUNT,
																	ENG_NO,
																	REG_NO,
																	SALES_AMOUNT,
																	DP,
																	LAST_PAYMENT_DATE,
																	LAST_PAYMENT_AMOUNT,
																	COLL_CONCERN_NAME
																	from lease_all_info@ERP_LINK_LIVE 
						  where REF_CODE='$ref_code'"); 
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   <form action="" method="post">
								<div class="md-form mt-3">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you create anything here.
									</li>
								</ol>
								 <div class="resume-item d-flex flex-column flex-md-row">						   
	<div class="container">
	
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Ref Code:</label>
						  <input type="text"class="form-control" required="" id="title" value= "<?php echo $row['REF_CODE'];?>" readonly>
						</div>
					</div>
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Customer Name:</label>
						  <input type="text"class="form-control" required="" id="title" value= "<?php echo $row['CUSTOMER_NAME'];?>" readonly>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Customer Mobile No:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['CUSTOMER_MOBILE_NO'];?>" readonly>
						</div>
					</div>
				   <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Sales Amount:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['SALES_AMOUNT'];?>" readonly>
						</div>
					</div>
				
				</div>
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Chassis no:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['CHASSIS_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Eng No:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['ENG_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Registration no:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['REG_NO'];?>" readonly>
						</div>
					</div>
						<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Installment Amount:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['INSTALLMENT_AMOUNT'];?>" readonly>
						</div>
					</div>
					
				</div>
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Total EMI Amount:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['TOTAL_EMI_AMT'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Total Received Amount:</label>
						  <input type="text"class="form-control" required="" id="title"   value= "<?php echo $row['TOTAL_RECEIVED_AMOUNT'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Number of Due:</label>
						  <input type="text"class="form-control" required="" id="title"   value= "<?php echo $row['NUMBER_OF_DUE'];?>" readonly>
						</div>
					</div>
						<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Due Amount:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['DUE_AMOUNT'];?>" readonly>
						</div>
					</div>
					
				</div>
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Last Payment Amount:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['LAST_PAYMENT_AMOUNT'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Last Payment Date:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['LAST_PAYMENT_DATE'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">DP:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['DP'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Collection Concern:</label>
						  <input type="text"class="form-control" required="" id="title" value= "<?php echo $row['COLL_CONCERN_NAME'];?>" readonly>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
						  <label for="title">Participants Name:</label>
						  <input type="text"class="form-control" required="" id="title"  name="participant_name">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
						  <label for="title">Impact Status:</label>
						  <select required="" name="impact_status" class="form-control">
							<option value="">--</option>
							<option value="Positive">Positive</option>
							<option value="Negative">Negative</option>
						  </select>
						 
						</div>
					</div>	
				</div>
				
				<div class="row">
				    <div class="col-sm-12">
						<div class="form-group">
						  <label for="title">Customer Comments</label>
						  <textarea required=""  class="form-control" rows="2" id="comment" name="customer_comments"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					 <div class="col-lg-12">
						<div class="md-form mt-5">
						<button type="submit" name="submit" class="btn btn-info" > Create</button>
						</div>
					 </div>	
				</div>
			</div>
		</div>
	</div>
	 <?php
	  }
	 ?>					
	</div>
  </div>
  </form>
</div>

	 <?php                        
	  if(isset($_POST['customer_comments'])){
		  
		  $emp_session_id=$_SESSION['emp_id'];
		  $participant_name = $_REQUEST['participant_name'];
		  $impact_status = $_REQUEST['impact_status'];
		  $customer_comments = $_REQUEST['customer_comments'];
		  
		 
		   
		   
		   $strSQL  = oci_parse($objConnect, "begin RML_COLL_SERVICE_CREATE('$ref_code','$participant_name','$impact_status','$customer_comments','$emp_session_id');end;"); 
						   if(oci_execute($strSQL)){
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Information is Created successfully.
									  
									  <?php
										  echo $htmlHeader;
										  while($stuff){
											echo $stuff;
										  }
										  echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/service_report.php'</script>";
										?>
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
		if($_SESSION['user_role_id']!= 2 && $_SESSION['user_role_id']!= 1)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 			
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	$entry_id=$_REQUEST['entry_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT ID, RML_COLL_APPS_USER_ID, REF_ID, 
													   AMOUNT, PAY_TYPE, BANK, 
													   MEMO_NO, INSTALLMENT_AMOUNT, CREATED_DATE, 
													   REGISTRATION_NO, CHASIS_NO, ENGINE_NO, 
													   MEET_LOCATION, LATITUDE, LONGITUDE, 
													   IS_OTP_CONFIRM, OTP, AREA_ZONE, 
													   OTP_CONFIRN_DATE, MESSAGE_ID, MESSAGES, 
													   SMS_URL, LEISE_CONFIRM_AMOUNT, LEISE_CONFIRM_DATE, 
													   LEISE_CONFIRM_RML_ID, UPDATE_DATE, TT_DATE, 
													   TT_BRANCH, TT_TYPE, TT_REMARKS, 
													   TT_TOTAL_TAKA, TT_DUE_AMOUNT, TT_FILE_CLOSE_AMOUNT, 
													   TT_CHECK, TT_CONFIRM_DATE, IS_TT_CHANGED, 
													   TT_CHANGED_REMARKS, TT_UPDATED_DATE, TT_UPDATED_BY, 
													   IS_CONFIRM
													FROM RML_COLL_MONEY_COLLECTION where  id='$entry_id'"); 
						
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   <form action="" method="post">
								<div class="md-form mt-5">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you update anything here.
									</li>
								</ol>
								 <div class="resume-item d-flex flex-column flex-md-row">
						   
						   
							<div class="container">
							
							    <div class="row">
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">REF_ID:</label>
										  <input type="text"class="form-control" id="title" name="form_rml_id" value= "<?php echo $row['REF_ID'];?>" readonly>
										</div>
									</div>
										
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">Collection Amount:</label>
										  <input type="text" required="" name="collection_amnt" class="form-control" id="title" value= "<?php echo $row['AMOUNT'];?>">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">Pay Type:</label>
										  <input type="text" required="" name="emp_mobile_no"  class="form-control" id="title" value= "<?php echo $row['PAY_TYPE'];?>" readonly>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">Bank Name:</label>
										  <input type="text" class="form-control" id="title" name="form_iemi_no" value= "<?php echo $row['BANK'];?>" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">Created Date:</label>
										  <input type="text"class="form-control" id="title" name="form_rml_id" value= "<?php echo $row['CREATED_DATE'];?>" readonly>
										</div>
									</div>
										
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">Installment Amount:</label>
										  <input type="text" required="" name="emp_form_name" class="form-control" id="title" value= "<?php echo $row['INSTALLMENT_AMOUNT'];?>" readonly>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">Pay Type:</label>
										  <input type="text" required="" name="emp_mobile_no"  class="form-control" id="title" value= "<?php echo $row['PAY_TYPE'];?>" readonly>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
										  <label for="title">Bank Name:</label>
										  <input type="text" class="form-control" id="title" name="form_iemi_no" value= "<?php echo $row['BANK'];?>" readonly>
										</div>
									</div>
								</div>
								 
								<div class="row">
									 <div class="col-sm-4">
										<div class="md-form mt-5">
										<button type="submit" name="submit" class="btn btn-info" > Update</button>
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

                    if(isset($_POST['collection_amnt'])){
							 
						$collection_amnt = $_REQUEST['collection_amnt'];  
						$strSQL  = oci_parse($objConnect, "update RML_COLL_MONEY_COLLECTION SET 
																		AMOUNT=$collection_amnt,
																		UPDATE_DATE=SYSDATE
																	where ID='$entry_id'"); 
						   if(oci_execute($strSQL)){
							  echo $htmlHeader;
							  while($stuff){
								echo $stuff;
							  }
							  echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/entry_list_update.php?entry_id=$entry_id'</script>";
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
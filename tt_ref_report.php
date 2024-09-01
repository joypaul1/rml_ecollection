<?php 
	session_start();
	if($_SESSION['user_role_id']== 4 || $_SESSION['user_role_id'] == 3)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
	
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
          <a href="">Ref Code Report</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-6">
								 <input required=""  type="text" class="form-control" id="title" placeholder="Ref-Code" name="bank_tt_id" form="Form1">
							</div>
							<div class="col-sm-6">
							<div class="md-form mt-0">
									<input class="form-control btn btn-primary btn pull-right" type="submit" value="Search Code" form="Form1">
								</div>
							</div>
						</div>	
						<hr>
				</div>

				
				
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						@$bank_tt_ref_id=$_REQUEST['bank_tt_id'];
						
						if(isset($_POST['bank_tt_id'])){
					       
							$strSQL  = oci_parse($objConnect, "select a.ID,B.RML_ID,b.MOBILE_NO,B.EMP_NAME,b.AREA_ZONE, a.REF_ID,A.AMOUNT,
																A.CREATED_DATE,A.TT_BRANCH,A.TT_DATE,A.TT_TYPE,A.TT_TOTAL_TAKA,a.TT_REMARKS,a.TT_CHECK,
																a.TT_CONFIRM_DATE,a.TT_FILE_CLOSE_AMOUNT,a.TT_DUE_AMOUNT,a.TT_CHANGED_REMARKS,a.TT_UPDATED_BY
															 from RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER b
															where A.RML_COLL_APPS_USER_ID=b.ID
														     and a.REF_ID='$bank_tt_ref_id'
															and a.PAY_TYPE='Bank TT'
															and a.BANK='Sonali Bank'
															and a.TT_BRANCH IS NOT NULL
															 order by CREATED_DATE desc"); 
						  
						    oci_execute($strSQL);	
							while($row=oci_fetch_assoc($strSQL)){	

                            ?>
						   <div class="col-lg-12">
								<div class="md-form mt-2">
								<hr>
								<div class="row" style="border:3px; border-style:solid; border-color:#FF0000; padding: 1em;">
									<div class="col-lg-12">
										<div class="row">
										   
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Ref-Code:</label>
												  <input type="text" class="form-control" id="title" form="Form2" value= "<?php echo $row['REF_ID'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">TT Date:</label>
												  <input type="text"  class="form-control" id="title" value= "<?php echo $row['TT_DATE'];?>" readonly >
												</div>
											</div>
										
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Entry By:</label>
												  <input type="text" class="form-control" id="title"  value= "<?php echo $row['EMP_NAME'];?>" readonly>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Concern Zone:</label>
												  <input type="text" name="eng_no" class="form-control" id="title" value= "<?php echo $row['AREA_ZONE'];?>" readonly form="Form2">
												</div>
											</div>
										</div>
										
										
										
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Entry Date:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['CREATED_DATE'];?>" readonly>
												</div>
											</div>
																						
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">TT Amount:</label>
												  <input type="text" name="tt_changed_amount" class="form-control" id="title" value= "<?php echo $row['AMOUNT'];?>"  readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Total TT Amount:</label>
												  <input type="text" name="total_tt_amount" class="form-control" id="title" value= "<?php echo $row['TT_TOTAL_TAKA'];?>"  readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">TT Type:</label>
												  <input type="text"class="form-control" id="title" value= "<?php  echo $row['TT_TYPE'];?>" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											
											<div class="col-sm-3">
												<div class="form-group">
												    <label for="title">TT Branch: </label>
												  <input required="" type="text" name="tt_changed_branch" class="form-control" id="title" value= "<?php echo $row['TT_BRANCH'];?>" readonly>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												    <label for="title">TT Remarks:</label>
												  <input required="" type="text" name="tt_remarks" class="form-control" id="title" value= "<?php echo $row['TT_REMARKS'];?>" readonly>
												</div>
											</div> 
											<div class="col-sm-3">
												<div class="form-group">
												    <label for="title">Is-Confirm:</label>
												 <input type="text" class="form-control" id="title" value= "<?php echo $row['TT_CHECK'];?>" readonly>
												</div>
											</div> 
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Confirm Date:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['TT_CONFIRM_DATE'];?>" readonly>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">TT File Close Amount: </label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['TT_FILE_CLOSE_AMOUNT'];?>" readonly>
												</div>
											</div>
					
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title"> TT Due Amount:</label>
												 <input type="text" class="form-control" id="title" value= "<?php echo $row['TT_DUE_AMOUNT'];?>" readonly>
												 
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Change Remarks: </label>
												   <input type="text" class="form-control" id="title" value= "<?php echo $row['TT_CHANGED_REMARKS'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Updated By:</label>
												   <input type="text" class="form-control" id="title" value= "<?php echo $row['TT_UPDATED_BY'];?>" readonly>
												</div>
											</div>
										</div>
										
									</div>
								</div>
						
							</div>
						 <?php
						  }}
						 ?>
						 
					
					
				  </div>
			
				</div>
				  
			
		
	
	              <?php
                          $emp_session_id=$_SESSION['emp_id'];
                          @$tt_id = $_REQUEST['tt_id'];
						  
                          @$tt_changed_branch = $_REQUEST['tt_changed_branch'];
                          @$tt_changed_amount = $_REQUEST['tt_changed_amount'];
                          @$tt_remarks = $_REQUEST['tt_remarks'];
						  
                          @$tt_changed_date = date("d/m/Y", strtotime($_REQUEST['tt_changed_date']));
                          @$total_tt_amount = $_REQUEST['total_tt_amount'];
                          @$tt_due_amount = $_REQUEST['tt_due_amount'];
                          @$tt_file_close_amount = $_REQUEST['tt_file_close_amount'];
                          @$tt_change_remarks = $_REQUEST['tt_change_remarks'];
						  
						  
						 
						  
						  
						  
						  if(isset($_POST['tt_change_remarks'])){
						
							   $strSQL  = oci_parse($objConnect, "update RML_COLL_MONEY_COLLECTION 
																	 set AMOUNT='$tt_changed_amount' ,
																	 TT_DATE=to_date('$tt_changed_date','dd/mm/yyyy')  ,
																	 TT_BRANCH='$tt_changed_branch',
																	 TT_REMARKS='$tt_remarks',
																	 TT_TOTAL_TAKA='$total_tt_amount',
																	 TT_DUE_AMOUNT='$tt_due_amount',
																	 TT_FILE_CLOSE_AMOUNT='$tt_file_close_amount',
																	 IS_TT_CHANGED=1,
																	 TT_UPDATED_DATE=SYSDATE,
																	 TT_CHANGED_REMARKS='$tt_change_remarks',
																	 TT_UPDATED_BY='$emp_session_id'
																	 where id='$tt_id'"); 
									 
								 
						 
						   if(@oci_execute($strSQL)){

							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Data Updated successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						   }else{
							    $lastError = error_get_last();
				                $error=$lastError ? "".$lastError["message"]."":"";
							    if (strpos($error, 'RML_COLL_REF_CODE_UNIQUE') !== false) {
											?>
											 <div class="container-fluid">
											  <div class="md-form mt-5">
												<ol class="breadcrumb">
												<li class="breadcrumb-item">
												  Please contact with IT.
												</li>
											   </ol>
											  </div>
											  </div>
											<?php
										}
						   }
						   
						  }
						?>
		 </div>
       </div>
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
	
<?php require_once('layouts/footer.php'); ?>	
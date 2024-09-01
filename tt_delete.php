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
          <a href="">Bank TT Delete Panel</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-6">
								 <input required=""  type="text" class="form-control" id="title" placeholder="Bank TT ID" name="bank_tt_id" form="Form1">
							</div>
							<div class="col-sm-6">
							<div class="md-form mt-0">
									<input class="form-control" type="submit" value="Search Employee" form="Form1">
								</div>
							</div>
						</div>	
						<hr>
				</div>

				
				
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						@$bank_tt_id=$_REQUEST['bank_tt_id'];
						
						if(isset($_POST['bank_tt_id'])){
					       
							$strSQL  = oci_parse($objConnect, "select a.ID,B.RML_ID,b.MOBILE_NO,B.EMP_NAME,b.AREA_ZONE, a.REF_ID,A.AMOUNT,
																A.CREATED_DATE,A.TT_BRANCH,A.TT_DATE,A.TT_TYPE,A.TT_TOTAL_TAKA,a.TT_REMARKS
															 from RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER b
															where A.RML_COLL_APPS_USER_ID=b.ID
														     and a.id=$bank_tt_id
															and a.PAY_TYPE='Bank TT'
															and a.TT_CHECK=0
															and a.BANK='Sonali Bank'
															"); 
						  
						    @oci_execute($strSQL);	
							while($row=@oci_fetch_assoc($strSQL)){	

                            ?>
						   <div class="col-lg-12">
								<div class="md-form mt-2">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you change anything here.
									</li>
								</ol>
						
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
										    <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">TT ID:</label>
												  <input type="text" required="" name="tt_id"  class="form-control" id="title" value= "<?php echo $row['ID'];?>" readonly form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Ref-Code:</label>
												  <input type="text"  name="tt_ref_code" class="form-control" id="title" form="Form2" value= "<?php echo $row['REF_ID'];?>" readonly >
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
												  <label for="title">TT Date:</label>
												  <input type="text"  class="form-control" id="title" value= "<?php echo $row['TT_DATE'];?>" readonly >
												</div>
											</div>
										
											
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">TT Amount:<font color="red">**</font> </label>
												  <input type="text" name="tt_changed_amount" class="form-control" id="title" value= "<?php echo $row['AMOUNT'];?>"  form="Form2" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Total TT Amount:<font color="red">**</font> </label>
												  <input type="text" name="total_tt_amount" class="form-control" id="title" value= "<?php echo $row['TT_TOTAL_TAKA'];?>"  form="Form2" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">TT Type:</label>
												  <input type="text"class="form-control" id="title" value= "<?php  echo $row['TT_TYPE'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												    <label for="title">TT Branch:<font color="red">**</font> </label>
												  <input required="" type="text" name="tt_changed_branch" class="form-control" id="title" value= "<?php echo $row['TT_BRANCH'];?>" form="Form2" readonly>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												    <label for="title">TT Remarks:<font color="red">**</font> </label>
												  <input required="" type="text" name="tt_remarks" class="form-control" id="title" value= "<?php echo $row['TT_REMARKS'];?>" form="Form2" readonly>
												</div>
											</div> 
										
										</div>
										
										<div class="row">
										
				
											<div class="col-sm-12">
												<div class="form-group">
												   <label for="title">Delete Remarks:<font color="red">**</font> </label>
												  <input required="" type="text" name="tt_change_remarks"  class="form-control" id="title"  form="Form2">
												</div>
											</div>
										</div>
										<div class="row">
											 <div class="col-lg-12">
												<div class="md-form mt-5">
												
												<button type="submit" name="submit" class="form-control btn btn-primary" form="Form2">Submit To Delete</button>
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
                          @$tt_change_remarks = $_REQUEST['tt_change_remarks'];
                          @$tt_ref_code = $_REQUEST['tt_ref_code'];
						  
						  
						 
						  
						  
						  
						  if(isset($_POST['tt_change_remarks'])){
							  $strSQL  = oci_parse($objConnect, "BEGIN RML_COLL_DELETE_BANK_TT('$tt_id','$emp_session_id', '$tt_change_remarks','$tt_ref_code');END;");  
						       if(@oci_execute($strSQL)){

							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Data Deleted successfully.
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
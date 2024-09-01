<?php 
	session_start();
	if($_SESSION['user_role_id']== 4)
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
          <a href="">Bank TT Edit Panel</a>
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
						
					
					
				</div>

				
				
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						@$bank_tt_id=$_REQUEST['bank_tt_id'];

						if(isset($_POST['bank_tt_id'])){
						  
						  $strSQL  = oci_parse($objConnect, "select a.ID,B.RML_ID,b.MOBILE_NO,B.EMP_NAME,b.AREA_ZONE, a.REF_ID,A.AMOUNT,A.CREATED_DATE,A.TT_BRANCH,A.TT_DATE,A.TT_TYPE,A.TT_TOTAL_TAKA
															 from RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER b
															where A.RML_COLL_APPS_USER_ID=b.ID
														     and a.id=$bank_tt_id
															and a.PAY_TYPE='Bank TT'
															and a.BANK='Sonali Bank'"); 
						  
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
								<div class="md-form mt-5">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you update anything here.
									</li>
								</ol>
								 <div class="resume-item d-flex flex-column flex-md-row">
						   
					<div class="container">
							
						<div class="row">
							<div class="col-lg-12">
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">Concern Name:</label>
											<input type="text"class="form-control" id="title" form="Form2" name="form_rml_id" value= "<?php echo $row['EMP_NAME'];?>" readonly>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">Concern ID:</label>
											<input type="text" name="emp_form_name" class="form-control" id="title"  value= "<?php echo $row['RML_ID'];?>" readonly>
											</div>
										</div>
											
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">Concern Mobile:</label>
											<input type="text" class="form-control" id="title" value= "<?php echo $row['MOBILE_NO'];?>" readonly>
											</div>
										</div>
											
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">Ref-Code:</label>
											<input type="text" class="form-control" id="title" value= "<?php echo $row['REF_ID'];?>" readonly>
											</div>
										</div>
									</div>
										
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">Entry Date:</label>
											<input type="text" class="form-control" id="title"  name="form_res1_id" value= "<?php echo $row['CREATED_DATE'];?>" readonly>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">TT Date:</label>
											<input type="text" class="form-control" id="title" name="form_res2_id" value= "<?php echo $row['TT_DATE'];?>" readonly>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">Area Zone:</label>
											<input type="text" class="form-control" id="title" name="form_zone_name" value= "<?php echo $row['AREA_ZONE'];?>" form="Form2">
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
											<label for="title">TT Type:</label>
											<input type="text" class="form-control" id="title" name="form_iemi_no" value= "<?php echo $row['TT_TYPE'];?>" form="Form2">
											</div>
										</div>
									</div>
										
										
									<div class="row">
										<div class="col-lg-12">
										<div class="md-form mt-5">
										<button type="submit" name="submit" class="btn btn-info" form="Form2">Submit Update</button>
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
			
				</div>
		
	              <?php
                          $emp_session_id=$_SESSION['emp_id'];
                          @$form_rml_id = $_REQUEST['form_rml_id'];
						  @$form_zone_name = $_REQUEST['form_zone_name'];
						  @$form_iemi_no = $_REQUEST['form_iemi_no'];
						 
						  if(isset($_POST['form_iemi_no'])){
							   
							   $UpdateSQL  = oci_parse($objConnect, "update RML_COLL_APPS_USER 
																		set IEMI_NO='$form_iemi_no',
																		AREA_ZONE='$form_zone_name',
																		UPDATED_BY='$emp_session_id',
																	    UPDATED_DATE=SYSDATE
																	where RML_ID='$form_rml_id'
																	AND ACCESS_APP='RML_COLL'
																	and is_active=1"); 
						
						   if(oci_execute($UpdateSQL)){
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Information is updated successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						   }else{
							   ?>
							   <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Update Fail. Please contact with IT.
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
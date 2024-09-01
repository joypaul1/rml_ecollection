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
          <a href="">User Information Change for Collection Apps</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-6">
							<select required="" name="emp_id" class="form-control" form="Form1">
								 <option selected value="">Select One</option>
								      <?php
									   require_once('inc/connoracle.php');
									   
									   $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									   $USER_BRAND=$_SESSION['user_brand'];
									   $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									   
									   if($USER_ROLE=="AH"){
										    $strSQL  = oci_parse($objConnect, "select EMP_NAME,RML_ID from RML_COLL_APPS_USER
                                            where IS_ACTIVE=1
                                            and LEASE_USER in('CC','ZH')
                                            --and USER_FOR='$USER_BRAND'
                                            and ACCESS_APP='RML_COLL'
                                            and AREA_ZONE in (select distinct(ZONE_NAME) from COLL_EMP_ZONE_SETUP where AREA_HEAD='$USER_ID')
                                            order by EMP_NAME");
									   }else if($USER_ROLE=="ADM"){
						                $strSQL  = oci_parse($objConnect, "select EMP_NAME,RML_ID from RML_COLL_APPS_USER
											where IS_ACTIVE=1
											and RML_ID NOT IN ('955','956','001','002','878')
											and ACCESS_APP='RML_COLL'
											order by LEASE_USER"); 
									   }	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['RML_ID'];?>"><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
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
						@$emp_id=$_REQUEST['emp_id'];
						@$emp_concern = $_REQUEST['emp_concern'];
						@$emp_status = $_REQUEST['emp_status'];
						@$emp_brand = $_SESSION['user_brand'];

						if(isset($_POST['emp_id'])){
						 
						  $strSQL  = oci_parse($objConnect, "select ID,RML_ID,
																	EMP_NAME,MOBILE_NO,
																	CREATED_DATE,LEASE_USER,
																	USER_FOR,AREA_ZONE,IEMI_NO 
																from RML_COLL_APPS_USER
																where RML_ID='$emp_id'
																AND ACCESS_APP='RML_COLL'
																--AND USER_FOR='$emp_brand'
																AND IS_ACTIVE=1"); 
						  
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
												  <label for="title">Emp ID:</label>
												  <input type="text"class="form-control" id="title" form="Form2" name="form_rml_id" value= "<?php echo $row['RML_ID'];?>" readonly>
												</div>
											</div>
										
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Name:</label>
												  <input type="text" name="emp_form_name" class="form-control" id="title"  value= "<?php echo $row['EMP_NAME'];?>" readonly>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Mobile:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['MOBILE_NO'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Brand:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['USER_FOR'];?>" readonly>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">User Role:</label>
												  <input type="text" class="form-control" id="title"  name="form_res1_id" value= "<?php echo $row['LEASE_USER'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">User Created Date:</label>
												  <input type="text" class="form-control" id="title" name="form_res2_id" value= "<?php echo $row['CREATED_DATE'];?>" readonly>
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
												  <label for="title">IEMI NO-1:</label>
												  <input type="text" class="form-control" id="title" name="form_iemi_no" value= "<?php echo $row['IEMI_NO'];?>" form="Form2">
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
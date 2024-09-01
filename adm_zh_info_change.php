<?php 
	session_start();
	if($_SESSION['user_role_id']!= 2)
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
								 <option selected value="">Select Zonal Head</option>
								      <?php
									  
									   
									   $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									   $USER_BRAND=$_SESSION['user_brand'];
									   $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									
									  $strSQL  = oci_parse($objConnect, "select EMP_NAME,RML_ID from RML_COLL_APPS_USER
                                            where IS_ACTIVE=1
                                            and LEASE_USER in('ZH')
                                            and ACCESS_APP='RML_COLL'
                                            and is_active=1
                                            order by EMP_NAME");
									  	
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
									<input class="form-control btn btn-primary" type="submit" value="Search Employee" form="Form1">
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
						  
						  $strSQL  = oci_parse($objConnect, "select b.ID,b.RML_ID,
																	EMP_NAME,MOBILE_NO,
																	(select NVL(a.TARGET,0) from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) ZH_SELF_TARGET,
																	b.CREATED_DATE,b.LEASE_USER,
																	b.USER_FOR,b.AREA_ZONE,b.IEMI_NO,
                                                                    (SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) from dual) TERGET_COLLECTION,
																	 COLL_VISIT_UNIT(b.RML_ID,'','') AS VISIT_UNIT																	
																from RML_COLL_APPS_USER b
																where b.RML_ID='$emp_id'
																AND b.ACCESS_APP='RML_COLL'
																AND b.IS_ACTIVE=1"); 
						  
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
												  <input type="text" name="emp_form_name" class="form-control" id="title"  value= "<?php echo $row['EMP_NAME'];?>" form="Form2">
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Mobile:</label>
												  <input type="text" class="form-control" id="title"  name="emp_mobile_no" value= "<?php echo $row['MOBILE_NO'];?>" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">IEMI NO</label>
												  <input type="text" class="form-control" id="title" name="form_iemi_no" value= "<?php echo $row['IEMI_NO'];?>" form="Form2">
												</div>
											</div>
											
										</div>
										
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">User Role:</label>
												   <select required="" name="user_role" class="form-control" form="Form2">
												   <option value="ZH">Zonal Head</option>
								                    <option value="CC">Collection Concern</option>
							                     </select>
												 
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Area Zone:</label>
												  <select required="" name="form_zone_name" class="form-control" form="Form2">
															  <?php
																$strSQLA  = oci_parse($objConnect, "select distinct(ZONE_NAME) AS AREA_ZONE_NAME 
																										from COLL_EMP_ZONE_SETUP 
																										 order by AREA_ZONE_NAME"); 
																oci_execute($strSQLA);
															   
															   while($rowdata=oci_fetch_assoc($strSQLA)){
																       
																       if($row['AREA_ZONE']==$rowdata['AREA_ZONE_NAME']){
																	  ?> 
																	   <option selected value="<?php echo $rowdata['AREA_ZONE_NAME'];?>"><?php echo $rowdata['AREA_ZONE_NAME'];?></option>
																	  
																	  <?php
															           }else{
																		   ?> 
																		    <option value="<?php echo $rowdata['AREA_ZONE_NAME'];?>"><?php echo $rowdata['AREA_ZONE_NAME'];?></option>
																		   <?php
																	   }
															           }
															  ?>
														</select>
												 
												</div>
											</div>
										<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Self Target(Current Month):</label>
												  <input type="text" class="form-control" id="title" name="target_amount" value= "<?php echo $row['ZH_SELF_TARGET'];?>" form="Form2">
												</div>
										</div>
										<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Visit Unit(Current Month):</label>
												  <input type="text" class="form-control" id="title" name="visit_unit" value= "<?php echo $row['VISIT_UNIT'];?>" form="Form2">
												</div>
										</div>
										</div>
										<div class="row">
										<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Total Target(Current Month):</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['TERGET_COLLECTION'];?>" form="Form2">
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
                          @$emp_form_name = $_REQUEST['emp_form_name'];
						  @$emp_mobile_no = $_REQUEST['emp_mobile_no'];
						  @$form_iemi_no = $_REQUEST['form_iemi_no'];
						   
						   
						  @$user_role = $_REQUEST['user_role'];
						  @$form_zone_name = $_REQUEST['form_zone_name'];
						  @$target_amount = $_REQUEST['target_amount'];
						  @$visit_unit = $_REQUEST['visit_unit'];
						  
						 
						  if(isset($_POST['form_iemi_no'])){
							   $UpdateSQL  = oci_parse($objConnect, "update RML_COLL_APPS_USER SET
							                                            EMP_NAME='$emp_form_name',
																		MOBILE_NO='$emp_mobile_no',
																		IEMI_NO='$form_iemi_no',
																		LEASE_USER='$user_role',
																		AREA_ZONE='$form_zone_name',
																		UPDATED_BY='$emp_session_id',
																	    UPDATED_DATE=SYSDATE
																	where RML_ID='$form_rml_id'
																	AND ACCESS_APP='RML_COLL'
																	and is_active=1"); 
	                   
						$TargetSQL  = oci_parse($objConnect, "update MONTLY_COLLECTION set 
																	  TARGET='$target_amount',
																	  TARGETSHOW='$target_amount',
																	  VISIT_UNIT='$visit_unit'
																		where is_active=1
																		and RML_ID='$form_rml_id'"); 
						oci_execute($TargetSQL);
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
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
	
	$emp_ref_id=$_REQUEST['emp_ref_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  $strSQL  = oci_parse($objConnect, 
						                       "select ID,
							                         b.EMP_NAME,
													 b.RML_ID,
													 b.MOBILE_NO,
													 b.LEASE_USER,
													 b.AREA_ZONE ,USER_TYPE,
													 b.USER_FOR,b.IEMI_NO,b.IS_ACTIVE,
													 COLL_SUMOF_TARGET_AMOUNT(RML_ID,LEASE_USER,USER_FOR) TERGET_COLLECTION,
													 (select NVL(a.TARGET,0) from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) ZH_SELF_TARGET,
													 (select ZONAL_HEAD from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) ZONAL_HEAD,
                                                     (select AREA_HEAD from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) AREA_HEAD,
													 (select VISIT_UNIT from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) VISIT_UNIT
										    FROM RML_COLL_APPS_USER b
												WHERE ACCESS_APP='RML_COLL'
												and id='$emp_ref_id'"); 
						
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
												  <label for="title">Emp ID:</label>
												  <input type="text"class="form-control" id="title" name="form_rml_id" value= "<?php echo $row['RML_ID'];?>" readonly>
												</div>
											</div>
										
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Name:</label>
												  <input type="text" required="" name="emp_form_name" class="form-control" id="title" value= "<?php echo $row['EMP_NAME'];?>">
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Mobile:</label>
												  <input type="text" required="" name="emp_mobile_no"  class="form-control" id="title" value= "<?php echo $row['MOBILE_NO'];?>" >
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">IEMI NO-1:</label>
												  <input type="text" class="form-control" id="title" name="form_iemi_no" value= "<?php echo $row['IEMI_NO'];?>">
												</div>
											</div>
										</div>
								       <div class="row">
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">User Role:</label>
												  <select required="" name="user_role" class="form-control">
															  <?php
																$strSQLA  = oci_parse($objConnect, "select distinct(LEASE_USER) AS LEASE_USER 
																									from RML_COLL_APPS_USER 
																									where ACCESS_APP='RML_COLL'
																									and is_active=1
																									 order by LEASE_USER"); 
																oci_execute($strSQLA);
															   
															   while($rowdata=oci_fetch_assoc($strSQLA)){
																       
																       if($row['LEASE_USER']==$rowdata['LEASE_USER']){
																	  ?> 
																	   <option selected value="<?php echo $rowdata['LEASE_USER'];?>"><?php echo $rowdata['LEASE_USER'];?></option>
																	  
																	  <?php
															           }else{
																		   ?> 
																		    <option value="<?php echo $rowdata['LEASE_USER'];?>"><?php echo $rowdata['LEASE_USER'];?></option>
																		   <?php
																	   }
															           }
															  ?>
														</select>
												 
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Area Zone:</label>
												  <select required="" name="form_zone_name" class="form-control">
															  <?php
																$strSQLA  = oci_parse($objConnect, "select distinct(AREA_ZONE) AS AREA_ZONE_NAME from RML_COLL_APPS_USER 
																										where ACCESS_APP='RML_COLL'
																										and is_active=1
																										 order by AREA_ZONE"); 
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
												<label for="title">Total Target(Not Editable):</label>
												<input type="text" class="form-control" id="title"  value= "<?php echo $row['TERGET_COLLECTION'];?>">
											</div>
										</div>
										<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Select Status:</label>
												  <select required="" name="from_user_status" class="form-control">
															  <?php
														        if($row['IS_ACTIVE']==1){
																	  ?> 
																	   <option selected value="1">Ative</option>
																	   <option  value="0">In-Ative</option>
																	  
																	  <?php
															           }else{
																		   ?> 
																		    <option selected value="0">In-Ative</option>
																			 <option  value="1">Ative</option>
																		   <?php
																	   }
															          
															  ?>
														</select>
												 
												</div>
											</div>
											
										</div>
								<div class="row">
								    <div class="col-sm-3">
										<div class="form-group">
											<label for="title">Self Target:</label>
											<input type="text" class="form-control" id="title" name="monthly_target"  value= "<?php echo $row['ZH_SELF_TARGET'];?>">
										</div>
								    </div>
									 <div class="col-sm-3">
										<div class="form-group">
											<label for="title">Zonal Head:</label>
											<input type="text" class="form-control" id="title" name="zonal_head"  value= "<?php echo $row['ZONAL_HEAD'];?>">
										</div>
								    </div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Area Head:</label>
											<input type="text" class="form-control" id="title" name="area_head"  value= "<?php echo $row['AREA_HEAD'];?>">
										</div>
								    </div>
									<div class="col-sm-3">
										<div class="form-group">
											<label for="title">Visit Unit:</label>
											<input type="text" class="form-control" id="title" name="visit_unit"  value= "<?php echo $row['VISIT_UNIT'];?>">
										</div>
								    </div>
								</div>
								
								<div class="row">
								<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">User Type:</label>
												  <select required="" name="user_type" class="form-control">
															  <?php
																$strSQLA  = oci_parse($objConnect, "select distinct(USER_TYPE) AS USER_TYPE 
																									from RML_COLL_APPS_USER 
																									where ACCESS_APP='RML_COLL'
																									and is_active=1
																									 order by USER_TYPE"); 
																oci_execute($strSQLA);
															   
															   while($rowdata=oci_fetch_assoc($strSQLA)){
																       
																       if($row['USER_TYPE']==$rowdata['USER_TYPE']){
																	  ?> 
																	   <option selected value="<?php echo $rowdata['USER_TYPE'];?>"><?php echo $rowdata['USER_TYPE'];?></option>
																	  
																	  <?php
															           }else{
																		   ?> 
																		    <option value="<?php echo $rowdata['USER_TYPE'];?>"><?php echo $rowdata['USER_TYPE'];?></option>
																		   <?php
																	   }
															           }
															  ?>
														</select>
												 
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

                          
						  if(isset($_POST['emp_form_name'])){
							 
						  @$form_rml_id = $_REQUEST['form_rml_id'];
						  @$emp_form_name = $_REQUEST['emp_form_name'];
                          @$emp_mobile_no = $_REQUEST['emp_mobile_no'];
                          @$form_iemi_no = $_REQUEST['form_iemi_no'];
                          @$user_role = $_REQUEST['user_role'];
                         
                          @$form_zone_name = $_REQUEST['form_zone_name'];
                          @$from_user_status = $_REQUEST['from_user_status'];
                          @$monthly_target = $_REQUEST['monthly_target'];
						  $emp_session_id=$_SESSION['emp_id'];
						  
						  @$v_zonal_head = $_REQUEST['zonal_head'];
                          @$v_area_head = $_REQUEST['area_head'];
                          @$v_visit_unit = $_REQUEST['visit_unit'];
                          @$v_user_type = $_REQUEST['user_type'];
							  
						$strSQL  = oci_parse($objConnect, "update RML_COLL_APPS_USER SET 
																		EMP_NAME='$emp_form_name',
																		MOBILE_NO='$emp_mobile_no',
																		IEMI_NO='$form_iemi_no',
																		LEASE_USER='$user_role',
																		AREA_ZONE='$form_zone_name',
																		UPDATED_BY='$emp_session_id',
																	    UPDATED_DATE=SYSDATE,
																		IS_ACTIVE='$from_user_status',
																		USER_TYPE='$v_user_type'
																	where ID='$emp_ref_id'
																	AND ACCESS_APP='RML_COLL'"); 
						  
						   if(oci_execute($strSQL)){
							   if($user_role=='CC' || $user_role=='ZH'){
								  $TargetSQL  = oci_parse($objConnect, "update MONTLY_COLLECTION set 
																	  TARGET='$monthly_target',
																	  TARGETSHOW='$monthly_target',
																	  ZONE='$form_zone_name',
																	  ZONAL_HEAD='$v_zonal_head',
																	  AREA_HEAD='$v_area_head',
																	  VISIT_UNIT='$v_visit_unit'
																where is_active=1
																and RML_ID='$form_rml_id'"); 
						              oci_execute($TargetSQL); 
							   }

							   echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/apps_user_edit.php?emp_ref_id=$emp_ref_id'</script>";
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
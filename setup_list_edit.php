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
	
	$v_set_up_id=$_REQUEST['set_up_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT 
													ZONE_NAME, ZONE_HEAD, 
													AREA_HEAD,IS_ACTIVE, 
													TOTAL_UNIT, 
													USER_TYPE
												FROM COLL_EMP_ZONE_SETUP 
												WHERE ID=$v_set_up_id"); 
						
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   <form action="" method="post"> 
								<div class="md-form mt-5">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You must be use valid information.
									</li>
								</ol>
								 <div class="resume-item d-flex flex-column flex-md-row">
						   
						   
							<div class="container">
							
							    <div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Zonal Head ID:</label>
												  <input type="text" required="" name="zonal_head_id" class="form-control" id="title" value= "<?php echo $row['ZONE_HEAD'];?>">
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">User Zone:</label>
												  <select required="" name="zone_name" class="form-control">
															  <?php
																$strSQLA  = oci_parse($objConnect, "select distinct(AREA_ZONE) AS AREA_ZONE 
																									from RML_COLL_APPS_USER 
																									where ACCESS_APP='RML_COLL'
																									and is_active=1
																									 order by AREA_ZONE"); 
																oci_execute($strSQLA);
															   
															   while($rowdata=oci_fetch_assoc($strSQLA)){
																       
																       if($row['ZONE_NAME']==$rowdata['AREA_ZONE']){
																	  ?> 
																	   <option selected value="<?php echo $rowdata['AREA_ZONE'];?>"><?php echo $rowdata['AREA_ZONE'];?></option>
																	  
																	  <?php
															           }else{
																		   ?> 
																		    <option value="<?php echo $rowdata['AREA_ZONE'];?>"><?php echo $rowdata['AREA_ZONE'];?></option>
																		   <?php
																	   }
															           }
															  ?>
														</select>
												 
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Area Head ID:</label>
												  <input type="text" required="" name="area_head_id"  class="form-control" id="title" value= "<?php echo $row['AREA_HEAD'];?>" >
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Total Unit:</label>
												  <input type="text" class="form-control" id="title" name="taltal_unit" value= "<?php echo $row['TOTAL_UNIT'];?>">
												</div>
											</div>
										</div>
								       <div class="row">
											
											
											
										
										<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Select Status:</label>
												  <select required="" name="user_status" class="form-control">
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

                         $emp_session_id=$_SESSION['emp_id']; 
						if(isset($_POST['zonal_head_id'])){
							 
						  $v_zonal_head_id = $_REQUEST['zonal_head_id'];
						  $v_zone_name = $_REQUEST['zone_name'];
                          $v_area_head_id = $_REQUEST['area_head_id'];
                          $v_taltal_unit = $_REQUEST['taltal_unit'];
                          $v_user_type= $_REQUEST['user_type'];
                          
                          $user_status = $_REQUEST['user_status'];
							  
						$strSQL  = oci_parse($objConnect, "UPDATE COLL_EMP_ZONE_SETUP
                                                          SET   
														   ZONE_NAME        = '$v_zone_name',
														   ZONE_HEAD        = '$v_zonal_head_id',
														   AREA_HEAD        = '$v_area_head_id',
														   IS_ACTIVE        = '$user_status',
														   TOTAL_UNIT       = '$v_taltal_unit',
														   USER_TYPE        = '$v_user_type',
														   UPDATE_BY='$emp_session_id',
														   UPDATE_DATE=SYSDATE
													    WHERE  ID= $v_set_up_id
													"); 
						  
						   if(oci_execute($strSQL)){
							  

							   echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/setup_list_edit.php?set_up_id=$v_set_up_id'</script>";
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
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
	
	$v_target_table_id=$_REQUEST['target_table_id'];
	
	
	
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT 
														RML_ID,TARGET,TARGETSHOW,ZONE,
														ZONAL_HEAD,AREA_HEAD,VISIT_UNIT,
														OVER_DUE,CURRENT_MONTH_DUE,  
														START_DATE,END_DATE,IS_ACTIVE
														FROM MONTLY_COLLECTION
														WHERE ID='$v_target_table_id'
														AND IS_ACTIVE=1"); 
						
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
												  <label for="title">RML ID:</label>
												  <input type="text" required="" name="rml_id" class="form-control" id="title" value= "<?php echo $row['RML_ID'];?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Zonal Head ID:</label>
												  <input type="text" required="" name="zonal_head_id" class="form-control" id="title" value= "<?php echo $row['ZONAL_HEAD'];?>">
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Area Head ID:</label>
												  <input type="text" required="" name="aria_head_id" class="form-control" id="title" value= "<?php echo $row['AREA_HEAD'];?>">
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
																       
																       if($row['ZONE']==$rowdata['AREA_ZONE']){
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
											
											
										</div>
								        <div class="row">
									        <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Target Amount:</label>
												  <input type="text" required="" name="target_amount"  class="form-control" id="title" value= "<?php echo $row['TARGET'];?>" >
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Display Target:</label>
												  <input type="text" class="form-control" id="title" name="display_amount" value= "<?php echo $row['TARGETSHOW'];?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Over Due:</label>
												  <input type="text" class="form-control" id="title" name="due_amount" value= "<?php echo $row['OVER_DUE'];?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Current Month Over Due:</label>
												  <input type="text" class="form-control" id="title" name="current_due_amount" value= "<?php echo $row['CURRENT_MONTH_DUE'];?>">
												</div>
											</div>
									    </div>
								        <div class="row">
									        <div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Visit Unit:</label>
												  <input type="text" class="form-control" id="title" name="visit_unit" value= "<?php echo $row['VISIT_UNIT'];?>">
												</div>
											</div>
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
							 
						  $v_rml_id = $_REQUEST['rml_id'];
						  $v_zonal_head_id = $_REQUEST['zonal_head_id'];
						  $v_aria_head_id = $_REQUEST['aria_head_id'];
						  $v_zone_name = $_REQUEST['zone_name'];
						  
						  $v_target_amount = $_REQUEST['target_amount'];
						  $v_display_amount = $_REQUEST['display_amount'];
						  $v_visit_unit = $_REQUEST['visit_unit'];
						  $v_due_amount = $_REQUEST['due_amount'];
						  $v_current_due_amount = $_REQUEST['current_due_amount'];
                          $user_status = $_REQUEST['user_status'];
						  
						  
							  
						$strSQL  = oci_parse($objConnect, "UPDATE MONTLY_COLLECTION
												SET    TARGET            = '$v_target_amount',
													   TARGETSHOW        = '$v_display_amount',
													   ZONE              = :'$v_zone_name',
													   OVER_DUE          = '$v_due_amount',
													   CURRENT_MONTH_DUE = '$v_current_due_amount',
													   IS_ACTIVE         = '$user_status',
													   VISIT_UNIT        = '$v_visit_unit',
													   ZONAL_HEAD        = '$v_zonal_head_id',
													   AREA_HEAD         = ' $v_aria_head_id'
													   WHERE  ID= '$v_target_table_id'
													"); 
						  
						   if(oci_execute($strSQL)){
							  

							   echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/target_list_edit.php?target_table_id=$v_target_table_id'</script>";
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
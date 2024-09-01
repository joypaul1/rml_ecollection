<?php 
	session_start();
	if($_SESSION['user_role_id']!= 2 && $_SESSION['user_role_id']!= 10)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 

	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	$ref_id=$_REQUEST['ref_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Seized Information Changed & Corfirmation</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-6">
								 <input required=""  type="text" class="form-control" id="title" placeholder="Ref-Code" name="ref_id" form="Form1">
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
						if(isset($_POST['ref_id'])){
					       
							$strSQL  = oci_parse($objConnect, "SELECT ID,
							                                          REF_ID,
																	  TEAM_MEMBER,
																	  DRIVER_NAME,
																      SEIZE_REASON,
																	  DEPOT_LOCATION,
																	  ENTRY_DATE,
																	  RUNNING_STATUS,
																	  TOTAL_EXPENSE,
																	  CHASSIS_CONDITION,
																	  BODY_CONDITION,
																	  ENGINE_CONDITION,
																	  BATTERY_CONDITION,
																	  NOC,
																	  ROPE,
																	  JACK,
																	  SPARE_TAYRE,
																	  BUCKET,
																	  DYNAMY,
																	  SELF,
																	  VEHICLE_PAPER,
																	  FRONT_GLASS,
																	  TOOLS_BOX,
																	  TRIPAL,
																	  KEY_STATUS,
																	  TO_CHAR(NVL(IS_CONFIRM,0)) AS IS_CONFIRM
																 FROM RML_COLL_SEIZE_DTLS
																WHERE REF_ID='$ref_id'
																and IS_CONFIRM=0"); 
						  
						    oci_execute($strSQL);	
							while($row=oci_fetch_assoc($strSQL)){	

                            ?>
						   <div class="col-lg-12">
								<div class="md-form mt-2">
								<hr>
								<div class="row" style="border:.5px; border-style:solid; border-color:#666666; padding: 1em;">
									<div class="col-lg-12">
										<div class="row">
										   <div class="col-sm-3" style="display: none;">
												<div class="form-group">
												  <label for="title">Ref-Code:</label>
												  <input type="text" name ="table_id" class="form-control" id="title" form="Form2" value= "<?php echo $row['ID'];?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Ref-Code:</label>
												  <input type="text" name ="ref_code_id" class="form-control" id="title" form="Form2" value= "<?php echo $row['REF_ID'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Entry Date:</label>
												  <input type="text"  class="form-control" id="title" value= "<?php echo $row['ENTRY_DATE'];?>" readonly >
												</div>
											</div>
										
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Team Member:</label>
												  <input type="text" class="form-control" id="title" name="team_member"   value= "<?php echo $row['TEAM_MEMBER'];?>" form="Form2">
												</div> 
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Driver Name:</label>
												  <input type="text" class="form-control" id="title" name="driver_name"  value= "<?php echo $row['DRIVER_NAME'];?>" form="Form2" >
												</div>
											</div>
										</div>
										
										
										
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Seized Reason:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['SEIZE_REASON'];?>" readonly>
												</div>
											</div>
																						
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Depot Location:</label>
												  <input type="text"  class="form-control" id="title" value= "<?php echo $row['DEPOT_LOCATION'];?>"  readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Total Expense:</label>
												  <input type="text" class="form-control" id="title" name="total_expense" value= "<?php echo $row['TOTAL_EXPENSE'];?>"  form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Running Status:</label>
												  <select required="" name="runnig_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['RUNNING_STATUS']=='Running'){
													?>
														   <option value="Running">Running</option>
														   <option value="Not Running">Not Running</option>
													<?php
													   }else if($row['RUNNING_STATUS']=='Not Running'){
													?>
														   <option value="Not Running">Not Running</option>
														   <option value="Running">Running</option>
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
												  <label for="title">Chasis Condition</label>
												  
												 <select required="" name="chasis_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['CHASSIS_CONDITION']=='Good'){
													?>
														   <option value="Good">Good</option>
														   <option value="Partial">Partial</option>
														   <option value="Bad">Bad</option>
													<?php
													   }else if($row['CHASSIS_CONDITION']=='Partial'){
													?>
														   <option value="Partial">Partial</option>
														   <option value="Good">Good</option>
														   <option value="Bad">Bad</option>
													<?php
														   }else if($row['CHASSIS_CONDITION']=='Bad'){
													?> 
															<option value="Bad">Bad</option>															
														    <option value="Good">Good</option>
															<option value="Partial">Partial</option>
														    	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												
												</div>
											</div>
																						
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Body Condition:</label>
												  <select required="" name="body_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['BODY_CONDITION']=='Good'){
													?>
														   <option value="Good">Good</option>
														   <option value="Partial">Partial</option>
														   <option value="Bad">Bad</option>
													<?php
													   }else if($row['BODY_CONDITION']=='Partial'){
													?>
														   <option value="Partial">Partial</option>
														   <option value="Good">Good</option>
														   <option value="Bad">Bad</option>
													<?php
														   }else if($row['BODY_CONDITION']=='Bad'){
													?> 
															<option value="Bad">Bad</option>															
														    <option value="Good">Good</option>
															<option value="Partial">Partial</option>
														    	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Engine Condition:</label> 
												  <select required="" name="eng_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['ENGINE_CONDITION']=='Good'){
													?>
														   <option value="Good">Good</option>
														   <option value="Partial">Partial</option>
														   <option value="Bad">Bad</option>
													<?php
													   }else if($row['ENGINE_CONDITION']=='Partial'){
													?>
														   <option value="Partial">Partial</option>
														   <option value="Good">Good</option>
														   <option value="Bad">Bad</option>
													<?php
														   }else if($row['ENGINE_CONDITION']=='Bad'){
													?> 
															<option value="Bad">Bad</option>															
														    <option value="Good">Good</option>
															<option value="Partial">Partial</option>
														    	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Bettery Condition:</label> 
												 
												  <select required="" name="bettery_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['BATTERY_CONDITION']=='Good'){
													?>
														   <option value="Good">Good</option>
														   <option value="Partial">Partial</option>
														   <option value="Bad">Bad</option>
													<?php
													   }else if($row['BATTERY_CONDITION']=='Partial'){
													?>
														   <option value="Partial">Partial</option>
														   <option value="Good">Good</option>
														   <option value="Bad">Bad</option>
													<?php
														   }else if($row['BATTERY_CONDITION']=='Bad'){
													?> 
															<option value="Bad">Bad</option>															
														    <option value="Good">Good</option>
															<option value="Partial">Partial</option>
														    	
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
												  <label for="title">NOC Complete?</label>  
												  
												 <select required="" name="noc_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['NOC']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['NOC']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												
												</div>
											</div>
																						
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Rope?</label>
												  <select required="" name="rope_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['ROPE']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['ROPE']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group"> 
												  <label for="title">Jack?</label>
												  <select required="" name="jack_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['JACK']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['JACK']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Spare Tyre</label>
												 
												  <select required="" name="spare_tyre" class="form-control" form="Form2">
								                    <?php
												       if($row['SPARE_TAYRE']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['SPARE_TAYRE']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
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
												  <label for="title">Bucket?</label>
												  
												 <select required="" name="bucket_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['BUCKET']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['BUCKET']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												
												</div>
											</div>
																						
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Dynamy?</label>
												  <select required="" name="dynamy_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['DYNAMY']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['DYNAMY']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Self?</label> 
												  <select required="" name="self_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['SELF']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['SELF']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Vehicle Paper?</label>
												 
												  <select required="" name="vehicle_papers" class="form-control" form="Form2">
								                    <?php
												       if($row['VEHICLE_PAPER']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['VEHICLE_PAPER']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
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
												  <label for="title">Front Glass?</label>
												  
												 <select required="" name="front_glass" class="form-control" form="Form2">
								                    <?php
												       if($row['FRONT_GLASS']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['FRONT_GLASS']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												
												</div>
											</div>
																						
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Tool Box?</label>
												  <select required="" name="tool_box" class="form-control" form="Form2">
								                    <?php
												       if($row['TOOLS_BOX']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['TOOLS_BOX']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Tripal?</label>
												  <select required="" name="tripal_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['TRIPAL']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['TRIPAL']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
													<?php															
													   }
		                                             ?>
													
							                     </select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Keys?</label>
												 
												  <select required="" name="keys_condition" class="form-control" form="Form2">
								                    <?php
												       if($row['KEY_STATUS']=='1'){
													?>
														   <option value="1">Yes</option>
														   <option value="0">No</option>
													<?php
													   }else if($row['KEY_STATUS']=='0'){
													?>
													        <option value="0">No</option>
														   <option value="1">Yes</option>
												 	
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
												  <label for="title"><b>Select Depot Location:</b><sup style="color:red;">*</sup></label>
														<select required="" name="depot_location" class="form-control" form="Form2">
														 <option selected value="">Select Location</option>
															  <?php
															   
																$strSQL  = oci_parse($objConnect, "select DEPORCODE,WAREDESC from V_ERP_DEPORT_LOCATION"); 
																oci_execute($strSQL);
															   while($row=oci_fetch_assoc($strSQL)){	
															  ?>
															  <option value="<?php echo $row['DEPORCODE'];?>"><?php echo $row['WAREDESC'];?></option>
															  <?php
															   }
															  ?>
														</select>
												</div>
											</div>
											<div class="col-sm-3">
												
											</div>
											<div class="col-sm-3">
												
											</div>
										</div>
										
										
										<div class="row">
											 <div class="col-lg-12">
												<div class="md-form mt-5">
												<button type="submit" name="submit" class="btn btn-info" form="Form2">Update Information</button>
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
                          @$table_id = $_REQUEST['table_id'];
						  @$v_ref_code=$_REQUEST['ref_code_id'];
                          @$depot_location = $_REQUEST['depot_location'];
						 

						  
						  @$team_member = $_REQUEST['team_member'];			
						  @$driver_name = $_REQUEST['driver_name'];			
						  @$total_expense = $_REQUEST['total_expense'];			
						  @$runnig_condition = $_REQUEST['runnig_condition'];					  
			
						  @$chasis_condition = $_REQUEST['chasis_condition'];					
						  @$body_condition = $_REQUEST['body_condition'];					
						  @$eng_condition = $_REQUEST['eng_condition'];					
						  @$bettery_condition = $_REQUEST['bettery_condition'];		

			
						  @$noc_condition = $_REQUEST['noc_condition'];					      
						  @$rope_condition = $_REQUEST['rope_condition'];					      
						  @$jack_condition = $_REQUEST['jack_condition'];					      
						  @$spare_tyre = $_REQUEST['spare_tyre'];					      
						  
						  @$bucket_condition = $_REQUEST['bucket_condition'];
					      @$dynamy_condition = $_REQUEST['dynamy_condition'];
					      @$self_condition = $_REQUEST['self_condition'];
					      @$vehicle_papers = $_REQUEST['vehicle_papers'];
						 
						  
                          @$front_glass = $_REQUEST['front_glass'];
                          @$tool_box = $_REQUEST['tool_box'];
                          @$tripal_condition = $_REQUEST['tripal_condition'];
                          @$keys_condition = $_REQUEST['keys_condition'];
                          
						  
						  
						  
						  
						  
						  if(isset($_POST['depot_location'])){
							  
							$strSQL  = oci_parse($objConnect, "UPDATE RML_COLL_SEIZE_DTLS SET 
							                                            DEPOT_LOCATION_CODE='$depot_location',
							                                            DEPOT_LOCATION=(select WAREDESC from V_ERP_DEPORT_LOCATION where DEPORCODE='$depot_location'),
																		DEPOT_LOCATION_UPDATED_DATE=SYSDATE,
																		DEPOT_LOCATION_UPDATED_BY='$emp_session_id',
																		TEAM_MEMBER='$team_member',
																		DRIVER_NAME='$driver_name',
																		TOTAL_EXPENSE='$total_expense',
																		RUNNING_STATUS='$runnig_condition',
																		CHASSIS_CONDITION='$chasis_condition',
																		BODY_CONDITION=	'$body_condition',
																		ENGINE_CONDITION='$eng_condition',
																		BATTERY_CONDITION='$bettery_condition',
																		NOC='$noc_condition',
																		ROPE='$rope_condition',
																		JACK='$jack_condition',
																		SPARE_TAYRE='$spare_tyre',
																		BUCKET='$bucket_condition',
																		DYNAMY='$dynamy_condition',
																		SELF='$self_condition',
																		VEHICLE_PAPER='$vehicle_papers',
																		FRONT_GLASS='$front_glass',
																		TOOLS_BOX='$tool_box',
																		TRIPAL='$tripal_condition',
																		KEY_STATUS='$keys_condition'
																		WHERE ID='$table_id'
																		"); 
							   
						  
									 
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
								?>
											 <div class="container-fluid">
											  <div class="md-form mt-5">
												<ol class="breadcrumb">
												<li class="breadcrumb-item">
												<?php
											      echo $error;
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
	
<?php require_once('layouts/footer.php'); ?>	
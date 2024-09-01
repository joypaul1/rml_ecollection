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
	
?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Seized To Release</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-6">
								 <input required="" class="form-control"  type='text' name='ref_id' placeholder="Ref-Code" form="Form1" value='<?php echo isset($_POST['ref_id']) ? $_POST['ref_id'] : ''; ?>' />
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
						@$ref_id=$_REQUEST['ref_id'];
						
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
																WHERE REF_ID='$ref_id' "); 
						  
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
												  <input type="text" name ="table_id" class="form-control" id="title" form="Form2" value= "<?php echo $row['ID'];?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Ref-Code:</label>
												  <input type="text" class="form-control" id="title" form="Form2" value= "<?php echo $row['REF_ID'];?>" readonly>
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
												  <input type="text" class="form-control" id="title" name="team_member"   value= "<?php echo $row['TEAM_MEMBER'];?>" form="Form2" readonly> 
												</div> 
											</div>
											
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Driver Name:</label>
												  <input type="text" class="form-control" id="title" name="driver_name"  value= "<?php echo $row['DRIVER_NAME'];?>" form="Form2" readonly>
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
												  <input type="text" class="form-control" id="title" name="total_expense" value= "<?php echo $row['TOTAL_EXPENSE'];?>"  form="Form2" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Running Status:</label>
												  <input type="text" class="form-control" id="title"  value= "<?php echo $row['RUNNING_STATUS'];?>"  form="Form2" readonly>
												</div>
											</div>
											
										</div>
										
										
										<div class="row">
										    <div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Chasis Condition:</label>
												  <input type="text" class="form-control" id="title"  value= "<?php echo $row['CHASSIS_CONDITION'];?>"  form="Form2" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Body Condition:</label>
												  <input type="text" class="form-control" id="title"  value= "<?php echo $row['BODY_CONDITION'];?>"  form="Form2" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Engine Condition:</label>
												  <input type="text" class="form-control" id="title"  value= "<?php echo $row['ENGINE_CONDITION'];?>"  form="Form2" readonly>
												</div>
											</div>											
											
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Bettery Condition:</label>
												  <input type="text" class="form-control" id="title"  value= "<?php echo $row['BATTERY_CONDITION'];?>"  form="Form2" readonly>
												</div>
											</div>	
											
										</div>
										
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">NOC Complete?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['NOC']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>	
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Rope?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['ROPE']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>	
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Jack?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['JACK']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												   <label for="title">Spare Tyre?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['SPARE_TAYRE']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>
										</div>
										<div class="row"> 
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Bucket?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['BUCKET']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Dynamy?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['DYNAMY']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>										
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Self?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['SELF']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>																						
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Vehicle Paper?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['VEHICLE_PAPER']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>											

										</div>
										<div class="row">
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Front Glass?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['FRONT_GLASS']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Tool Box?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['TOOLS_BOX']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>																				
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Tripal?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['TRIPAL']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>											
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Keys?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['KEY_STATUS']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>

										</div>
										<div class="row">
										    <div class="col-sm-3">
											    <div class="form-group">
												   <label for="title">Seized Confirm Status?</label>
												  <input type="text" class="form-control" id="title"  value= "<?php 
												   if($row['IS_CONFIRM']=='1'){
														echo 'Yes';
													}else{
														echo 'No';
													}
													?>"  form="Form2" readonly>
												</div>
											</div>
										</div>
										<?php 
										if($row['IS_CONFIRM']=='1'){
											?>
										<div class="row">
											 <div class="col-lg-12">
												<div class="md-form mt-5">
												<button type="submit" name="submit" class="btn btn-info" form="Form2">Submit For Release</button>
												</div>
										     </div>	
										</div>
										<?php
										}
										?>
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

						  
						  
						  if(isset($_POST['table_id'])){
							   
							   $strSQL  = oci_parse($objConnect, "BEGIN RML_COLL_RELEASE('$table_id','$emp_session_id');END;"); 
									 
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
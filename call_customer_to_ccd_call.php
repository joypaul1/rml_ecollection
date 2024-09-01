<?php 
	session_start();
	if($_SESSION['user_role_id']!= 13)
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
	  <div class="container-fluid">
			<div class="row">			
				<div class="col-lg-12">
					<form action="" method="post">
					<div class="md-form mt-3">
					<div class="resume-item d-flex flex-column flex-md-row">						   
	<div class="container">
	
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
				    <div class="col-sm-6">
						<div class="form-group">
						  <label for="title">Customer Mobile Numer:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="caller_number" required="" id="title">
						</div>
					</div>
					 <div class="col-sm-6">
						<div class="form-group">
						  <label for="title">Customer Name:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="caller_name" required="" id="title">
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-sm-6">
					<label for="title">Admin Remarks:</label>
						<textarea required="" name="admin_remarks" rows="2" style="width:100%;"></textarea>
					</div>
					<div class="col-sm-6">
					<label for="title">Customer Question:</label>
						<textarea  required="" name="customer_remarks" rows="2" style="width:100%;"></textarea>
					</div>
			    </div>
				<div class="row mt-3">
					<div class="col-sm-12">
					<label for="title">Responsible Person:</label>
						<textarea name="responsible_person" rows="1" style="width:100%;"></textarea>
					</div>
			    </div>

				
				
				
				
				<div class="row mt-3">
					<div class="col-sm-3">
						<label for="title">Select Call Category:</label>
						<select required="" name="call_category_id" class="form-control">
						<option selected value="">--</option>
						<?php
						$strSQL  = oci_parse($objConnect, "select ID,CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY");
						oci_execute($strSQL);
						while($row=oci_fetch_assoc($strSQL)){	
						?>
						<option value="<?php echo $row['ID'];?>"><?php echo $row['CALL_CATEGORY_TITLE'];?></option>
						<?php
						}
						?>
						</select>
					</div>
					<div class="col-sm-3">
						<label for="title">Select Status:</label>
						<select required="" name="status" class="form-control" onchange="showDiv(this)">
						<option selected value="">--</option>
						<option value="1">Closed</option>
						<option value="0">Continue</option>
						
						</select>
					</div>
					<div class="col-sm-3">
						<label for="title">Follow-Up Date:</label>
						<div class="input-group">
							<div class="input-group-addon">
							 <i class="fa fa-calendar">
							 </i>
							</div>
							<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
					   </div>
					</div>
					<div class="col-sm-3">
					 <label for="title">Select District:</label>
							<select required="" name="district_name" class="form-control">
								 <option selected value="">--</option>
								      <?php
									  $strSQL  = oci_parse($objConnect, "select DISTRICT_NAME from SALL_DISTRICT order by DISTRICT_NAME");
									  	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['DISTRICT_NAME'];?>"><?php echo $row['DISTRICT_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
					</div>
                </div>
				<div class="row mt-3">
					
					<div class="col-sm-3">
						<label for="title">Select Brand:</label>
						<select required="" name="brand_name" class="form-control">
						<option selected value="">--</option>
						<option value="EICHER">Eicher</option>
						<option value="MM">Mahindra</option>
						<option value="Others">Others</option>
						
						</select>
					</div>
				
                </div>
				
				
				<div class="row mt-3" id="hidden_div" style="display:none;">
					<div class="col-sm-12">
					<label for="title">Closing Remarks:</label>
						<textarea name="close_remarks" rows="2" style="width:100%;"></textarea>
					</div>
			    </div>
				<script type="text/javascript">
					function showDiv(select){
					   if(select.value==1){
						document.getElementById('hidden_div').style.display = "block";
					   } else{
						document.getElementById('hidden_div').style.display = "none";
					   }
					} 
			   </script>
			
				<div class="row">
					 <div class="col-lg-12">
						<div class="md-form mt-5">
						<button type="submit" name="submit" class="btn btn-info" >Create & Save</button>
						</div>
					 </div>	
				</div>
				
			</div>
		</div>
	</div>
					
	</div>
  </div>
  </form>
</div>

	 <?php                        
	  if(isset($_POST['caller_number'])){
		  
		  $emp_session_id=$_SESSION['emp_id'];
		  
		  $caller_number = $_REQUEST['caller_number'];
		  $admin_remarks = $_REQUEST['admin_remarks'];
		  $customer_remarks = $_REQUEST['customer_remarks'];
		  $close_remarks = $_REQUEST['close_remarks'];
		  $caller_name = $_REQUEST['caller_name'];
		  $status_lebel = $_REQUEST['status'];
		  $call_category_id = $_REQUEST['call_category_id'];
		  @$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
		  
		  $responsible_person = $_REQUEST['responsible_person'];
		  $district_name = $_REQUEST['district_name'];
		  
		  
		       if($status_lebel=="1"){
				  $strSQL  = oci_parse($objConnect, 
		               "INSERT INTO CCD_CALL (
                            CALLER_MOBILE,
							CALLER_NAME,
							ENTRY_REMARKS, 
                            CUSTOMER_REMARKS, 
							CALL_TYPE, 
							RML_COLL_CALL_CATEGORY_ID, 
                            CLOSE_STATUS,
                            CLOSED_DATE,							
							ENTRY_BY, 
							ENTRY_DATE,
							CLOSING_REMARKS,
							AREA_DISTRICT,
							RESPONSIBLE_PERON) 
					    VALUES (
						 '$caller_number',
						 '$caller_name',
						 '$admin_remarks',
						 '$customer_remarks',
						 'IN',
						 '$call_category_id',
						 '$status_lebel',
						  SYSDATE,
						 '$emp_session_id',
						  SYSDATE,
						 '$close_remarks',
						 '$district_name',
						 '$responsible_person')");   
			   }else{
				 $strSQL  = oci_parse($objConnect, 
		               "INSERT INTO CCD_CALL (
					        CALLER_MOBILE,
							CALLER_NAME,
							ENTRY_REMARKS, 
                            CUSTOMER_REMARKS, 
							CALL_TYPE, 
							RML_COLL_CALL_CATEGORY_ID, 
                            CLOSE_STATUS,							
							ENTRY_BY, 
							ENTRY_DATE,
							FOLLOW_UP_DATE,
							CLOSING_REMARKS,
							AREA_DISTRICT,
							RESPONSIBLE_PERON) 
					    VALUES (
						 '$caller_number',
						 '$caller_name',
						 '$admin_remarks',
						 '$customer_remarks',
						 'IN',
						 '$call_category_id',
						 '$status_lebel',
						 '$emp_session_id',
						  SYSDATE,
						  TO_DATE('$start_date','dd/mm/yyyy'),
						 '$close_remarks',
						 '$district_name',
						 '$responsible_person')");  

					  
			   }				  
						   if(oci_execute($strSQL)){
							  // echo '<script>alert("Information is Created successfully.")</script>';
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  
									  <?php
										echo $htmlHeader;
										while($stuff){
									    echo $stuff;
										}
										echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/call_customer_to_ccd.php'</script>";
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
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
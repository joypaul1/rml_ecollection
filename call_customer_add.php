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
	
	$chassis_no=$_REQUEST['chassis_no'];
	$ADD_SERVICE_NO=0;
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  $strSQL  = oci_parse($objConnect, 
						  "select CUSTOMER_NAME,
								CUSTOMER_MOBILE_NO,
								REF_CODE,
								INSTALLMENT_AMOUNT,
								CHASSIS_NO,
								TOTAL_RECEIVED_AMOUNT,
								TOTAL_EMI_AMT,
								NUMBER_OF_DUE,
								DUE_AMOUNT,
								ENG_NO,
								REG_NO,
								SALES_AMOUNT,
								DELIVERY_DATE,
								DP,
								LAST_PAYMENT_DATE,
								LAST_PAYMENT_AMOUNT,
								COLL_CONCERN_NAME,
								FEESRVNO AS FREE_SERVICE_NO,
								PRODUCT_TYPE,
								PRODUCT_CODE_NAME,
								PAMTMODE,
								DISTIC,
								ZONE,
								BRAND
								from lease_all_info_erp a 
						  where CHASSIS_NO='$chassis_no'"); 
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   <form action="" method="post">
								<div class="md-form mt-3">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you create anything here.
									</li>
								</ol>
								 <div class="resume-item d-flex flex-column flex-md-row">						   
	<div class="container">
	
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Ref Code:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="ref_code" required="" id="title" value= "<?php echo $row['REF_CODE'];?>" readonly>
						</div>
					</div>
					 <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Chassis No:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="chassis_no" required="" id="title" value= "<?php echo $row['CHASSIS_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Eng No:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name="eng_no" id="title"  value= "<?php echo $row['ENG_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Registration no:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name="reg_no" id="title"  value= "<?php echo $row['REG_NO'];?>" readonly>
						</div>
					</div>
				    
				</div>
				
				<div class="row d-none">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Product Type:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="product_type" required="" id="title" value= "<?php echo $row['PRODUCT_TYPE'];?>" readonly>
						</div>
					</div>
					 <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Product Name:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="product_name" required="" id="title" value= "<?php echo $row['PRODUCT_CODE_NAME'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Delivery Date:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name="delivery_date" id="title"  value= "<?php echo $row['DELIVERY_DATE'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Payment Type:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name="payment_type" id="title"  value= "<?php echo $row['PAMTMODE'];?>" readonly>
						</div>
					</div>
					 <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Brand:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="brand_name" required="" id="title" value= "<?php echo $row['BRAND'];?>" readonly>
						</div>
					</div>
					 <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Zone Name:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="zone_name" required="" id="title" value= "<?php echo $row['ZONE'];?>" readonly>
						</div>
					</div>
				    
				</div>
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Customer Mobile Number:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="caller_number" value= "<?php echo $row['CUSTOMER_MOBILE_NO'];?>" required="" id="title">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Customer Name:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="caller_name" value= "<?php echo $row['CUSTOMER_NAME'];?>" required="" id="title">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Collection Concern:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="collection_concern_name" value= "<?php echo $row['COLL_CONCERN_NAME'];?>" required="" id="title" readonly>
						</div>
					</div>
					
					<div class="col-sm-3">
					 <label for="title">District:</label>
					 <input type="text"class="form-control text-danger font-weight-bold" name ="district_name" value= "<?php echo $row['DISTIC'];?>" readonly>	
					</div>
				</div>
				
				<div class="row mt-3">
					<div class="col-sm-6">
					<label for="title">Admin Remarks:</label>
						<textarea required="" name="admin_remarks" rows="2" style="width:100%;"></textarea>
					</div>
					<div class="col-sm-6">
					<label for="title">Customer Remarks:</label>
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
						<select required="" name="call_category" class="form-control">
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
						<select required="" name="status" class="form-control"  id="test" onchange="showDiv(this)">
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
						<label for="title">Select Call Bound:</label>
						<select required="" name="call_bound" class="form-control">
						<option selected value="">--</option>
						<option value="IN">Inbound</option>
						<option value="OUT">Outbound</option>
						
						</select>
					</div>
					
                </div>
				<div class="row mt-3" id="hidden_div" style="display:none;"">
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
	 <?php
	  }
	 ?>					
	</div>
  </div>
  </form>
</div>

	 <?php                        
	  if(isset($_POST['chassis_no'])){
		  
		  $emp_session_id=$_SESSION['emp_id'];
		  
		  $admin_remarks = $_REQUEST['admin_remarks'];
		  $customer_remarks = $_REQUEST['customer_remarks'];
		  
		  $responsible_person = $_REQUEST['responsible_person'];
		  $collection_concern_name = $_REQUEST['collection_concern_name'];
		  $product_type = $_REQUEST['product_type'];
		  $product_name = $_REQUEST['product_name'];
		  
		  
		  $brand_name = $_REQUEST['brand_name'];
		  $zone_name = $_REQUEST['zone_name'];
		  $district_name = $_REQUEST['district_name'];
		  
		  
		  $call_category_id = $_REQUEST['call_category'];
		  $call_bound = $_REQUEST['call_bound'];
		  $status_lebel = $_REQUEST['status'];
		  
		  $caller_number = $_REQUEST['caller_number'];
		  $caller_name = $_REQUEST['caller_name'];
		  
		  
		  $chassis_no = $_REQUEST['chassis_no'];
		  $ref_code = $_REQUEST['ref_code'];
		  $eng_no = $_REQUEST['eng_no'];
		  $reg_no = $_REQUEST['reg_no'];
		  $v_close_remarks = $_REQUEST['close_remarks'];
		  
		   @$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
		  
		       if($status_lebel=="1"){
				  $strSQL  = oci_parse($objConnect, 
		               "INSERT INTO CCD_CALL (
                            CHASSIS_NO, 
							ENG_NO, 
                            REG_NO, 
							REF_CODE, 
							ENTRY_REMARKS, 
                            CUSTOMER_REMARKS, 
							CALL_TYPE, 
							RML_COLL_CALL_CATEGORY_ID, 
                            CLOSE_STATUS,
                            CLOSED_DATE,							
							ENTRY_BY, 
							ENTRY_DATE,
							CALLER_MOBILE,
							CALLER_NAME,
							RESPONSIBLE_PERON,
							AREA_DISTRICT,
							COLECTION_CONCERN,
							PRODUCT_TYPE,
							PRODUCT_NAME,
							BRAND_NAME,
							ZONE_NAME,
							CLOSING_REMARKS) 
					    VALUES (
						 '$chassis_no',
						 '$eng_no',
						 '$reg_no',
						 '$ref_code',
						 '$admin_remarks',
						 '$customer_remarks',
						 '$call_bound',
						 '$call_category_id',
						 '$status_lebel',
						  SYSDATE,
						 '$emp_session_id',
						  SYSDATE,
						  '$caller_number',
						  '$caller_name',
						  '$responsible_person',
						  '$district_name',
						  '$collection_concern_name',
						  '$product_type',
						  '$product_name',
						  '$brand_name',
						  '$zone_name',
						  '$v_close_remarks')");   
			   }else{
				 $strSQL  = oci_parse($objConnect, 
		               "INSERT INTO CCD_CALL (
                            CHASSIS_NO, 
							ENG_NO, 
                            REG_NO, 
							REF_CODE, 
							ENTRY_REMARKS, 
                            CUSTOMER_REMARKS, 
							CALL_TYPE, 
							RML_COLL_CALL_CATEGORY_ID, 
                            CLOSE_STATUS,							
							ENTRY_BY, 
							ENTRY_DATE,
							FOLLOW_UP_DATE,
							CALLER_MOBILE,
							CALLER_NAME,
							RESPONSIBLE_PERON,
							AREA_DISTRICT,
							COLECTION_CONCERN,
							PRODUCT_TYPE,
							PRODUCT_NAME,
							BRAND_NAME,
							ZONE_NAME,
							CLOSING_REMARKS) 
					    VALUES (
						 '$chassis_no',
						 '$eng_no',
						 '$reg_no',
						 '$ref_code',
						 '$admin_remarks',
						 '$customer_remarks',
						 '$call_bound',
						 '$call_category_id',
						 '$status_lebel',
						 '$emp_session_id',
						  SYSDATE,
						  TO_DATE('$start_date','dd/mm/yyyy'),
						  '$caller_number',
						  '$caller_name',
						  '$responsible_person',
						  '$district_name',
						  '$collection_concern_name',
						  '$product_type',
						  '$product_name',
						  '$brand_name',
						  '$zone_name',
						  '$v_close_remarks')");  
					}
			  
		
											  
						   if(oci_execute($strSQL)){
							 
										  echo $htmlHeader;
										  while($stuff){
											echo $stuff;
										  }
										if($call_bound=="OUT"){
										  echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/call_customer_report.php'</script>";
										}else{
										 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/call_customer_to_ccd.php'</script>";	
										}
										
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
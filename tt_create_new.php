<?php 
	session_start();
	if($_SESSION['user_role_id']== 4 || $_SESSION['user_role_id'] == 3)
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
          <a href="">Create New</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-4">
								 <input required=""  type="text" class="form-control" id="title" placeholder="REF-CODE" name="ref_code" form="Form1">
							</div>
							
							
							<div class="col-sm-4">
							<select required=""   name="software" class="form-control" form="Form1">
								 <option selected value="">Select Software</option>
									  <option value="LEASE">Lease and Credit</option>
									  <option value="ERP">ERP</option>
							</select>
							  
							</div>
							<div class="col-sm-4">
							  <input class="form-control btn btn-primary" type="submit" value="Search Code" form="Form1">
							</div>
						</div>	
						<hr>
				</div>

				
				
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						@$ref_code=$_REQUEST['ref_code'];
						@$software = $_REQUEST['software'];
						//$apiUrl='http://202.40.181.98:8090/rml/rml/lease/lease_api1/'.$ref_code;
						$apiUrl='http://202.40.181.98:7003/orbits/rml/lease/lease_api1/'.$ref_code;
                        $isFound=0;
						if(isset($_POST['ref_code'])){
					      require_once('inc/conlease.php');
						  
						    if($software=='ERP'){
								

                              // ERP API Call
								@$json = file($apiUrl);
								 @$data=json_decode($json[0], true);
								// Actual Data Variable
								 $isDataFoundERP=@$data[items][0]['api_status'];
								
								if($isDataFoundERP=='Y'){
									 $isFound=1;
									 $ref_code=@$data[items][0]['ref_code'];
									 $customer_name=@$data[items][0]['customer_name'];
									 $customer_mobile_no=@$data[items][0]['customer_mobile_no'];
									 
									 $eng_no=@$data[items][0]['eng_no'];
									 $chs_no=@$data[items][0]['chassis_no'];
									 $reg_no=@$data[items][0]['reg_no'];
									
									 $sales_amount=@$data[items][0]['sales_amount'];
									 $total_received_amount=@$data[items][0]['total_received_amount'];
									 $due_amount=@$data[items][0]['due_amount'];
									
									 $sales_person_name="";
									 $brand="";
									 $model="";
								}
								 
					           // ERP API Call END
							
							}else{
								$strSQL  = "select a.REF_NO,
										b.Customer,
										b.PHONE PHONE_NO,
										b.ENG_NO,
										b.CHS_NO,
										b.REG_NO,
										b.COST SALES_AMOUNT,
										a.ReceivedAmount,
										a.DueAmount,
										b.sales_person_name,
										C_NAME BRAND,
										b.NAME MODEL
								 from vHirePurchaseCollection_Open_Clear a,VSales_Info b
								 where a.REF_NO=b.REF_NO
								 and a.REF_NO='$ref_code'
								 and a.POST=2"; 
								 $stmt = sqlsrv_query( $objConnect, $strSQL );
								 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
									        // Actual Data Variable
											 $isFound=1;
											 $ref_code=$row['REF_NO'];
											 $customer_name=str_replace("?"," ",mb_convert_encoding($row['Customer'], 'UTF-8', 'UTF-8'));
											 $customer_mobile_no=$row['PHONE_NO'];
											 
											 $eng_no=$row['ENG_NO'];
											 $chs_no=$row['CHS_NO'];
											 $reg_no=$row['REG_NO'];
											
											$sales_amount=$row['SALES_AMOUNT'];
											$total_received_amount=$row['ReceivedAmount'];
											$due_amount=$row['DueAmount'];
											
											 $sales_person_name=$row['sales_person_name'];
											 $brand=$row['BRAND'];
											 $model=$row['MODEL'];
						                }
							}
							if($isFound==0){
								     $ref_code="";
									 $customer_name="";
									 $customer_mobile_no="";
									 
									 $eng_no="";
									 $chs_no="";
									 $reg_no="";
									
									 $sales_amount="";
									 $total_received_amount="";
									 $due_amount="";
									
									 $sales_person_name="";
									 $brand="";
									 $model="";
							}
							
                           ?>
						   <div class="col-lg-12">
								<div class="md-form mt-2">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you Entry anything here.
									</li>
								</ol>
							<div class="container">
							
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Ref-Code:</label>
												  <input type="text" name="ref_code" class="form-control" id="title" form="Form2" value= "<?php echo $ref_code;?>" readonly>
												</div>
											</div>
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Model Name:</label>
												  <input type="text" name="model_name" class="form-control" id="title"  value= "<?php echo $model;?>" readonly form="Form2">
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Brand Name:</label>
												  <input type="text" name ="brand_name" class="form-control" id="title" value= "<?php echo $brand;?>" readonly form="Form2">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Customer Name:</label>
												  <input type="text" name="cust_name" class="form-control" id="title" value= "<?php echo $customer_name;?>" readonly form="Form2">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Customer Mobile:</label>
												  <input type="text" name="cust_mobile" class="form-control" id="title" value= "<?php echo $customer_mobile_no;?>" readonly form="Form2">
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Sales Person:</label>
												  <input type="text" name="sales_person" class="form-control" id="title" value= "<?php echo $sales_person_name;?>" readonly form="Form2">
												</div>
											</div> 
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Sales Amount:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $sales_amount;?>" readonly>
												</div>
											</div>
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Received Amount:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $total_received_amount;?>" readonly>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Due Amount:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $due_amount;?>" readonly>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">TT Type:</label>
												  <select  name="attn_status" class="form-control">
												      <option selected value="">Select Type</option>
													  <option value="ONLINE">ONLINE</option>
													  <option value="BEFTN">BEFTN</option>
													  <option value="RTGS">RTGS</option>
											         </select>
												</div>
											</div>
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">TT Branch:</label>
												  <input type="text" class="form-control" id="title" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">TT Remarks:</label>
												  <input type="text" class="form-control" id="title">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">TT Installment Taka:</label>
												    <input type="text" class="form-control" id="title">
												</div>
											</div>
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">TT Total Taka:</label>
												  <input type="text" class="form-control" id="title" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">TT Due Taka:</label>
												  <input type="text" class="form-control" id="title">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
												  <label for="title">TT File Colosing Taka:</label>
												    <input type="text" class="form-control" id="title">
												</div>
											</div>
										
											<div class="col-sm-6">
												<div class="form-group">
												  <label for="title">TT Date:</label>
												  <input type="text" class="form-control" id="title" >
												</div>
											</div>
											
										</div>
										<div class="row">
											 <div class="col-lg-12">
												<div class="md-form mt-5">
												
												<button type="submit" name="submit" class="form-control btn btn-primary" form="Form2">Submit To Create</button>
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
				  
			
		
	
	              <?php
                          $emp_session_id=$_SESSION['emp_id'];
						  
						  
                          @$ref_code = $_REQUEST['ref_code'];
                          @$model_name = $_REQUEST['model_name'];
                          @$brand_name = $_REQUEST['brand_name'];
						  
						  @$chs_no = $_REQUEST['chs_no'];
                          @$eng_no = $_REQUEST['eng_no'];
                          @$reg_no = $_REQUEST['reg_no'];
						  
						
                          @$cust_name = $_REQUEST['cust_name'];
						  @$cust_mobile = $_REQUEST['cust_mobile'];
						  @$sales_person = $_REQUEST['sales_person'];
						  
						  
						  @$new_sms = $_REQUEST['new_sms'];
						  @$requester_name = $_REQUEST['requester_name'];
						  @$reqst_mobile = $_REQUEST['reqst_mobile'];
						  
						  
						 
						  
						  
						  
						  if(isset($_POST['requester_name'])){
							   
							   $strSQL  = oci_parse($objConnect, "INSERT INTO RML_COLL_SC (
																	   REF_CODE, 
																	   MODEL_NAME, 
																	   BRAND_NAME, 
																	   CUSTOMER_NAME, 
																	   CUSTOMER_MOBILE, 
																	   ENG_NO, 
																	   REG_NO, 
																	   CHS_NO, 
																	   SALES_PERSON, 
																	   REQUESTER_NAME, 
																	   REQUESTER_MOBILE, 
																	   ENTRY_BY_RML_ID, 
																	   ENTRY_DATE, 
																	   REQUEST_TYPE, 
																	   NEW_SMS, 
																	   STATUS,
																	   ROOT) 
																	VALUES ( 
																	   '$ref_code',
																	   '$model_name',
																	   '$brand_name',
																	   '$cust_name',
																	   '$cust_mobile',
																	   '$eng_no',
																	   '$reg_no',
																	   '$chs_no',
																	   '$sales_person',
																	   '$requester_name',
																	   '$reqst_mobile',
																	   '$emp_session_id',
																	    sysdate,
																	    'New',
																	    '$new_sms',
																	     0,
																		'WEB-PORTAL')
																	 "); 
									 
								 
						 
						   if(@oci_execute($strSQL)){

							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  New Entry is created successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						   }else{
							    $lastError = error_get_last();
				                $error=$lastError ? "".$lastError["message"]."":"";
							    if (strpos($error, 'RML_COLL_REF_CODE_UNIQUE') !== false) {
											?>
											 <div class="container-fluid">
											  <div class="md-form mt-5">
												<ol class="breadcrumb">
												<li class="breadcrumb-item">
												  This is already created. You can not create duplicate Entry.
												</li>
											   </ol>
											  </div>
											  </div>
											<?php
										}
						   }
						   
						  }
						?>
		 </div>
       </div>
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
	
<?php require_once('layouts/footer.php'); ?>	
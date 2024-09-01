<?php 
	session_start();
	if($_SESSION['user_role_id']!= 5)
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
          <a href="">Bank NOC and Disbursed Received</a>
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
							  <input class="form-control btn btn-primary" type="submit" value="Search Code" form="Form1">
							</div>
						</div>	
						<hr>
				</div>
            <?php
			$emp_session_id=$_SESSION['emp_id'];
			if(isset($_POST['ref_code'])){
				 $ref_code=$_REQUEST['ref_code'];
			     $strSQL  = oci_parse($objConnect, "select REF_CODE,STATUS,
															 CUSTOMER_NAME,
															 REG_NO,
															 ENG_NO,
															 CHASSIS_NO,
															 STATUS
													    from lease_all_info@ERP_LINK_LIVE 
													where REF_CODE='$ref_code'");
                 oci_execute($strSQL);	
                 while($row=oci_fetch_assoc($strSQL)){					
					 $ref_code=$row['REF_CODE'];
					 $customer_name=$row['CUSTOMER_NAME'];
					 
					 $reg_no=$row['REG_NO'];
					 $chs_no=$row['CHASSIS_NO'];
					 $status=$row['STATUS'];
					if($status=='Y')
						$status='Open Code';
					else 
                        $status='Closed Code';
						}
                           ?>
						   <div class="col-lg-12">
								<div class="md-form mt-2">

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
												  <label for="title">Bank Name:</label>
												 <select required=""  name="bank_name" class="form-control" form="Form2">
													 <option selected value="">--</option>
														  <option value="DBBL">DBBL</option>
														  <option value="Bank Asia">Bank Asia</option>
													 </select>
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Customer Name:</label>
												  <input type="text" name="cust_name" class="form-control" id="title" value= "<?php echo $customer_name;?>"  form="Form2">
												</div>
											</div>
										</div>
										
										
										
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">CHS_NO:</label>
												  <input type="text" name="chs_no" class="form-control" id="title" value= "<?php echo $chs_no;?>"  form="Form2">
												</div>
											</div>
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">REG_NO:</label>
												  <input type="text" name="reg_no" class="form-control" id="title" value= "<?php echo $reg_no;?>"  form="Form2">
												</div>
											</div>
											
											<div class="col-sm-4">
												<label for="title">Received Date:</label>
												<div class="input-group">
													<div class="input-group-addon">
													 <i class="fa fa-calendar"></i>
													</div>
													<input  required="" class="form-control"  name="received_date" type="date" form="Form2"/>
											   </div>
											</div>
											
										</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Bank Flag:</label>
												 <select required=""  name="bank_flag" class="form-control" form="Form2">
													 <option selected value="">--</option>
														  <option value="Bank NOC Received">Bank NOC Received</option>
														  <option value="Bank Disbursed">Bank Disbursed</option>
													 </select>
												</div>
											</div>
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Code Status:</label>
												  <input type="text" name="reg_no" class="form-control" id="title" value= "<?php echo $status;?>"  readonly>
												</div>
											</div>
											<?php		
									           if($status=='Closed Code'){
                                             ?>	
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title"> <br></label>
												  <input class="form-control btn btn-primary" type="submit" value="Create & Save" form="Form2">
												</div>
											</div>
											<?php		
												}
											?>
											
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

						  if(isset($_POST['bank_name'])){
							  
							 $ref_code = $_REQUEST['ref_code'];
                             $bank_name = $_REQUEST['bank_name'];
                             $cust_name = $_REQUEST['cust_name'];
						     $reg_no = $_REQUEST['reg_no'];
						     $chs_no = $_REQUEST['chs_no'];
						     $bank_flag = $_REQUEST['bank_flag'];
                             $received_date = date("d/m/Y", strtotime($_REQUEST['received_date']));  
							  
							   $strSQL  = oci_parse($objConnect, 
							                        "INSERT INTO RML_COLL_CCD_BNK_NOC_DISB (
								                        REF_CODE, 
														BANK_NAME, 
								                        CUSTOMER_NAME, 
														REG_NO, 
														CHASIS_NO, 
								                        RECEIVED_DATE, 
														CREATED_DATE,
														ENTRY_BY,
														BANK_FLAG) 
								                    VALUES ( 
								                       '$ref_code',
								                       '$bank_name',
								                       '$cust_name',
								                       '$reg_no',
								                       '$chs_no',
								                       TO_DATE('$received_date','dd/mm/yyyy'),
								                       SYSDATE,
                                                      '$emp_session_id',
													  '$bank_flag')"); 
									 
								 
						 
						   if(oci_execute($strSQL)){

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
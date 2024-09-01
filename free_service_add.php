<?php 
	session_start();
		if($_SESSION['user_role_id']!= 11)
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
						  $strSQL  = oci_parse($objConnect, "select CUSTOMER_NAME,
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
																	(CASE WHEN TRUNC(DELIVERY_DATE) < TO_DATE('01/06/2021','dd/mm/yyyy') THEN 1 ELSE 0 END) AS ADD_FLAG,
														            (select count(b.ID) from RML_COLL_FREE_SERVICE b where b.CHASSIS_NO=a.CHASSIS_NO) AS FREE_SERVICE_TAKEN
														from lease_all_info@ERP_LINK_LIVE a 
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
						  <input type="text"class="form-control" name ="ref_code" required="" id="title" value= "<?php echo $row['REF_CODE'];?>" readonly>
						</div>
					</div>
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Customer Name:</label>
						  <input type="text"class="form-control" name ="customer_name" required="" id="title" value= "<?php echo $row['CUSTOMER_NAME'];?>" readonly>
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Customer Mobile No:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['CUSTOMER_MOBILE_NO'];?>" readonly>
						</div>
					</div>
				   <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Sales Amount:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['SALES_AMOUNT'];?>" readonly>
						</div>
					</div>
				
				</div>
				<div class="row">
				    <div class="col-sm-3 border border-danger">
						<div class="form-group text-danger font-weight-bold">
						  <label for="title">Chassis no:</label>
						  <input type="text" class="form-control text-danger font-weight-bold" required="" id="title" name="chassis_no"  value= "<?php echo $row['CHASSIS_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Eng No:</label>
						  <input type="text"class="form-control" id="title"  value= "<?php echo $row['ENG_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Registration no:</label>
						  <input type="text"class="form-control" id="title"  value= "<?php echo $row['REG_NO'];?>" readonly>
						</div>
					</div>
						<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Installment Amount:</label>
						  <input type="text"class="form-control" id="title"  value= "<?php echo $row['INSTALLMENT_AMOUNT'];?>" readonly>
						</div>
					</div>
					
				</div>
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Total EMI Amount:</label>
						  <input type="text"class="form-control" id="title"  value= "<?php echo $row['TOTAL_EMI_AMT'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Total Received Amount:</label>
						  <input type="text"class="form-control"  id="title"   value= "<?php echo $row['TOTAL_RECEIVED_AMOUNT'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Number of Due:</label>
						  <input type="text"class="form-control" id="title"   value= "<?php echo $row['NUMBER_OF_DUE'];?>" readonly>
						</div>
					</div>
						<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Due Amount:</label>
						  <input type="text"class="form-control" id="title"  value= "<?php echo $row['DUE_AMOUNT'];?>" readonly>
						</div>
					</div>
					
				</div>
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Last Payment Amount:</label>
						  <input type="text"class="form-control" id="title"  value= "<?php echo $row['LAST_PAYMENT_AMOUNT'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Last Payment Date:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['LAST_PAYMENT_DATE'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">DP:</label>
						  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['DP'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Collection Concern:</label>
						  <input type="text"class="form-control" required="" id="title" value= "<?php echo $row['COLL_CONCERN_NAME'];?>" readonly>
						</div>
					</div>
				</div>
				<div class="row">
				    <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Free Service No:</label>
						  <input type="text"class="form-control" name="free_service_no" required="" id="title" value= "<?php echo $row['FREE_SERVICE_NO'];?>" readonly>
						</div>
				    </div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Free Service Taken No:</label>
						  <input type="text"class="form-control" name="free_service_taken" required="" id="title" value= "<?php echo $row['FREE_SERVICE_TAKEN'];?>" readonly>
						</div>
				    </div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Delivery Date:</label>
						  <input type="text"class="form-control" name="delivery_date" required="" id="title" value= "<?php echo $row['DELIVERY_DATE'];?>" readonly>
						</div>
				    </div>
					<div class="col-sm-3 border border-danger">
						<div class="form-group text-danger font-weight-bold">
						  <label for="title">Select Free Service Number:</label>
						  <select name="free_service_enable_no" class="form-control" required="">
						  <option value="">Select Free Service Number</option>
						  <?php 
						      $strSQL1  = oci_parse($objConnect, "select FREE_SERVICE_NO,FREE_SERVICE_TAKEN from RML_COLL_FREE_SERVICE where CHASSIS_NO= '$chassis_no'"); 
							  oci_execute($strSQL1);
							  $TAKEN_SERVICE = array();
							  $k=0;
							      while($row1=oci_fetch_assoc($strSQL1)){	
									  $TAKEN_SERVICE[$k++] = $row1['FREE_SERVICE_TAKEN'];  
									}
							        for ($x = 1; $x <= $row['FREE_SERVICE_NO']; $x++) {
											if (in_array($x, $TAKEN_SERVICE)){
												 ?> 
												 <option style="color:red;text-align:center;" disabled value="<?php echo $x; ?>">
												    <?php 
													  if($x==1){
														   echo $x.'<span style="color:red;text-align:center;">st FS Taken</span>';
													   }else if($x==2){
														     echo $x.'<span style="color:red;text-align:center;">nd FS Taken</span>';
													   }else if($x==3){
														   echo $x.'<span style="color:red;text-align:center;">rd FS Taken</span>'; 
													   }else if($x==4){
															echo $x.'<span style="color:red;text-align:center;">th FS Taken</span>';
													   }else if($x==5){
															echo $x.'<span style="color:red;text-align:center;">th FS Taken</span>';
													   }else if($x==6){
															echo $x.'<span style="color:red;text-align:center;">th FS Taken</span>';
													   }
													?>
												 </option>
												 <?php  
										}else {
											 ?> 
												 <option class="red" value="<?php echo $x; ?>">
												  <?php 
												     if($x==1){
														    echo $x.'st FS'; 
													   }else if($x==2){
														     echo $x.'nd FS'; 
													   }else if($x==3){
														   echo $x.'rd FS'; 
													   }else if($x==4){
															echo $x.'th FS';
													   }else if($x==5){
															echo $x.'th FS';
													   }else if($x==6){
															echo $x.'th FS';
													   }
												  ?>
												 </option>
											<?php
										}
									}
						  ?>	
							</select>
						</div>
				    </div>
					<!--
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Free Service Enable:</label>
						  <select name="free_service_enable_no" class="form-control" required="">
						  <?php 
				           if($row['ADD_FLAG']==0 && $row['FREE_SERVICE_TAKEN']==0 ){
				            ?>	
						  <option selected value="<?php echo $row['FREE_SERVICE_TAKEN']+1; ?>"><?php echo $row['FREE_SERVICE_TAKEN']+1; ?></option>
						  <?php 
				           }else if ($row['ADD_FLAG']==1 && $row['FREE_SERVICE_TAKEN']==0 ){
							   $ADD_SERVICE_NO=1;
							   for ($x = 1; $x <= $row['FREE_SERVICE_NO']; $x++) {
							   ?>
							    <option  value="<?php echo $x; ?>"><?php echo $x; ?></option>
							   <?php 
						   }
						   }else{
							    ?>
							 <option selected value="<?php echo $row['FREE_SERVICE_TAKEN']+1; ?>"><?php echo $row['FREE_SERVICE_TAKEN']+1; ?></option>  
						   <?php 
						   }
				           ?>	
							</select>
						</div>
				    </div>
					-->
					
					
                </div>
				<?php 
				  if($row['FREE_SERVICE_NO']>$row['FREE_SERVICE_TAKEN']){
				?>		    
							
				<div class="row">
					 <div class="col-lg-12">
						<div class="md-form mt-5">
						<button type="submit" name="submit" class="btn btn-info" >Create Free Service</button>
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
	  }
	 ?>					
	</div>
  </div>
  </form>
</div>

	 <?php                        
	  if(isset($_POST['chassis_no'])){
		  
		  $emp_session_id=$_SESSION['emp_id'];
		  $chassis_no = $_REQUEST['chassis_no'];
		  $free_service_no = $_REQUEST['free_service_no'];
		  $free_service_enable_no = $_REQUEST['free_service_enable_no'];
		  
	
		   $strSQL  = oci_parse($objConnect, "begin RML_COLL_FREE_SERVICE_CREATE('$chassis_no',$free_service_no,$free_service_enable_no,0,'$emp_session_id'); end;"); 
										  
						   if(oci_execute($strSQL)){
							   echo '<script>alert("Information is Created successfully.")</script>';
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
										  echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/service_report_free.php'</script>";
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
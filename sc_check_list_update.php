<?php 
	session_start();
	if($_SESSION['user_role_id']!= 5 && $_SESSION['user_role_id']!= 12)
	  {
		header('location:index.php?lmsg=true');
		exit;
	  } 
	  
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	$sc_id=$_REQUEST['sc_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	   <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Data Refresh</a>  
        </li>
      </ol>
	  <div class="container-fluid">
     <div class="row">			
		<?php
		
		$strSQL  = oci_parse($objConnect, 
								"SELECT 
									   ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   CURRENT_PARTY_ADDRS,
                                      (SELECT NVL(RE_SALE_RECEIVE_DP,0) FROM FILESUM_ERP WHERE RE_SALE_REFCODE=REF_CODE) CURRENT_PARTY_DP_RECEIVED,									   
									   MODEL_NAME, 
									   INSTALLMENT_RECEIVED, 
									   SALES_AMOUNT, 
									   DP, 
									   FIRST_PARTY_NAME, 
									   FIRST_PARTY_DP, 
									   FRIST_PARTY_INSTALLMENT_REC, 
									   RESOLED_DP, 
									   RESOLED_RECEIVED, 
									   RECEIVABLE, 
									   DISCOUNT, 
									   RECEIVED, 
									   CLOSING_DATE, 
									   RESALE_APPROVAL_DATE, 
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   CLOSING_FEE,
									   BRTA_LOCATION,
									   RESPONSIBLE_PERSON,
									   RESPONSIBLE_DESIGNATION,
									   CUSTOMER_SO,
									   BANK_ID,
									   FATHER_OR_HUSBAND_NAME,
									   CHASSIS_NO,
									   ENG_NO,
									   REG_NO
									FROM RML_COLL_SC_CCD
									where ID='$sc_id'"); 
						  
			oci_execute($strSQL);
			  while($row=oci_fetch_assoc($strSQL)){	
			   ?>
			   <div class="col-lg-12">
				<div class="container mt-3">
				
					<div class="row">
						<div class="col-lg-12">
						 <form action="" method="post">
							<div class="row">
							    <div class="col-sm-12 input-lg">
									<b>01. RML Code No:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input style="width:70%;" type="text" id="title" value= "<?php echo $row['REF_CODE'];?>" readonly>
								</div>
							    <div class="col-sm-12 mt-3 input-lg">
									 <b>02. Customer Name</b>(First Party):&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									 <input style="width:70%;" type="text" name="first_customer_name" value= "<?php echo $row['FIRST_PARTY_NAME'];?>" >
								</div>
								<div class="col-sm-12 mt-3 input-lg">
								    <b>03. Customer Name</b>(Current Party):&nbsp;&nbsp;&nbsp;&nbsp;
								    <input class="input-lg" style="width:70%;" type="text" name="current_customer_name" value= "<?php echo $row['CURRENT_PARTY_NAME'];?>" >
								</div>
								<div class="col-sm-12 mt-3 input-lg">
								    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								    <b> Customer S/O</b>(Current Party):&nbsp;&nbsp;&nbsp;&nbsp;
								    <input class="input-lg" style="width:70%;" type="text" name="current_customer_so" value= "<?php echo $row['CUSTOMER_SO'];?>" >
								</div>
								<div class="col-sm-12 mt-3 input-lg">
								    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								    <b> পিতা/স্বামী :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								    <input class="input-lg" style="width:70%;" type="text" name="father_husband_name" value= "<?php echo $row['FATHER_OR_HUSBAND_NAME'];?>" >
								</div>			
								<div class="col-sm-12 mt-3">
									  <b>04. Present & Permanent Address</b>:&nbsp;&nbsp;<br>
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp; &nbsp;
									 <textarea rows="3" style="width:70%;" name="current_customer_adds"><?php echo $row['CURRENT_PARTY_ADDRS'];?></textarea>
												
								</div>
							   <div class="col-sm-12 mt-3 input-lg">
									  <b>05. Contact No.</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:70%;" type="text" name="current_customer_mobile" value= "<?php echo $row['CURRENT_PARTY_MOBILE'];?>" >
								</div>
								<div class="col-sm-12 mt-3 input-lg">
									  <b>06. Product Procured</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:70%;" type="text" name="model_name" value= "<?php echo $row['MODEL_NAME'];?>" >
								</div>
								<div class="col-sm-12 mt-3">
									<b>07.Closing Amount:</b>
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>a) Chassis Price</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="chassis_price" value= "<?php echo $row['SALES_AMOUNT'];;?>" >
								</div>
								
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>b) 1st Party DP Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="first_party_dp" value= "<?php echo $row['FIRST_PARTY_DP'];?>" >
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>c) 1st Party EMI Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="first_total_received" value= "<?php echo $row['FRIST_PARTY_INSTALLMENT_REC'];?>" >
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>iv) Declare Down Payment</b>:&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="resold_dp" value= "<?php echo $row['RESOLED_DP'];?>" >
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>v) Received Down Payment</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" value= "<?php echo $row['CURRENT_PARTY_DP_RECEIVED'];?>" readonly>
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>vi) Received Amount</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;
									  <input style="width:50%;" type="text" name="resold_received" 
									  value= "<?php echo $row['RESOLED_RECEIVED'];?>" >
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>e) Total Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" 
									  value= "<?php echo $row['RESOLED_RECEIVED']+$row['FIRST_PARTY_DP']+
									                     $row['FRIST_PARTY_INSTALLMENT_REC']+
														 $row['CURRENT_PARTY_DP_RECEIVED']
									                                                  ;?>" >
								</div>
								<div class="col-sm-12 mt-3">
									  <b>08. Daily Interest(If Credit)</b>:
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>i) Receivable</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="receivable" value= "<?php echo $row['RECEIVABLE'];?>" >
								</div>
								
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>ii) Discount </b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="discount" value= "<?php echo $row['DISCOUNT']?>" >
								</div>

								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>iii) Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="received"  value= "<?php echo $row['RECEIVED'];?>" >
								</div>
									<div class="col-sm-12 mt-3 margin-left">
									  <b>09. Closing Fee:</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="closing_fee" value= "<?php echo $row['CLOSING_FEE'];?>" >
								</div>
							</div>
							
							
							
							<div class="row mt-3 mt-3">
								 <div class="col-sm-4">
									<div class="form-group">
									  <label for="title">Request Date:</label>
									  <input type="text" class="form-control" value= "<?php echo $row['REQUEST_DATE'];?>" readonly>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
									  <label for="title">Requester Name:</label>
									  <input type="text" class="form-control" id="title"  value= "<?php echo $row['REQUESTER_NAME'];?>" readonly>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
									  <label for="title">Requester Mobile:</label>
									  <input type="text" class="form-control" id="title" value= "<?php echo $row['REQUESTER_MOBILE'];?>" readonly>
									</div>
								</div>
								
							</div>
							<div class="row mt-3">
								 <div class="col-sm-4">
									<div class="form-group">
									  <label for="title">Chassis No:</label>
									  <input type="text" class="form-control" name="chassis_number" value= "<?php echo $row['CHASSIS_NO'];?>">
									</div>
								</div>
								<div class="col-sm-4"> 
									<div class="form-group">
									  <label for="title">Engine No:</label>
									  <input type="text" class="form-control" name="eng_no"  value= "<?php echo $row['ENG_NO'];?>">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
									  <label for="title">Registration no:</label>
									  <input type="text" class="form-control" name="reg_no" value= "<?php echo $row['REG_NO'];?>">
									</div>
								</div>
							</div>
							<div class="row mt-2">
								 <div class="col-sm-4">
									<div class="form-group">
									  <label for="title">BRTA Location:</label>
									  <input type="text" class="form-control" name="brta_location" value= "<?php echo $row['BRTA_LOCATION'];?>">
									</div>
								</div>
								
								<div class="col-sm-4">
								 <label for="title">Select Responsible Concern:</label>
									<select name="responsible_concern" class="form-control"> RESPONSIBLE_PERSON
									 <option value="Lt. Col. Shaikh Abidur Rahman">Lt. Col. Shaikh Abidur Rahman</option>
									 <option value="Golam M Sayeem">Golam M Sayeem</option>
									 <option value="Mirza Md. Ahsan Reza Kader Boksh">Mirza Md. Ahsan Reza Kader Boksh</option>
									 <option value="Md. Raihanul Islam">Md. Raihanul Islam</option>
									 <option value="Md. Faisal Hasan">Md. Faisal Hasan</option>
									 <option selected value="<?php echo $row['RESPONSIBLE_PERSON'];?>"><?php echo $row['RESPONSIBLE_PERSON'];?></option>
									</select> 
								</div>
								
								<div class="col-sm-4">
								 <label for="title">Select Responsible Concern Designation::</label>
									<select name="responsible_designation" class="form-control">
									 <option  value="General Manager">General Manager</option>
									 <option  value="Assistant General Manager">Assistant General Manager</option>
									 <option  value="Deputy General Manager">Deputy General Manager</option>
									 <option selected value="<?php echo $row['RESPONSIBLE_DESIGNATION'];?>"><?php echo $row['RESPONSIBLE_DESIGNATION'];?></option>
									</select> 
								</div>
								
								
							</div>
							
							<div class="row mt-2">
								<div class="col-sm-4">
									<div class="form-group">
									<label for="title">Select Bank:</label>
									 <select required="" name="bank_id" class="form-control">
								     <option selected value="">--</option>
								      <?php
									   $strSQL  = oci_parse($objConnect, "select ID,BANK_NAME from RML_COLL_CCD_BANK order by ID");    
						                oci_execute($strSQL);
									   while($row_bank=oci_fetch_assoc($strSQL)){
                                          if($row['BANK_ID']==$row_bank['ID']){										   
									     ?>
									     <option selected value="<?php echo $row_bank['ID'];?>"><?php echo $row_bank['BANK_NAME'];?></option>
									     <?php
									   }else{
										 ?> 
										 <option value="<?php echo $row_bank['ID'];?>"><?php echo $row_bank['BANK_NAME'];?></option>
										<?php
									   }
									   }
									  ?>
							       </select>
									</div>
								</div> 
								
								<div class="col-sm-4">
									<div class="form-group">
									<label for="title">Update Reason(If Re-Issues Select Reason):</label>
									 <select required="" name="reisse_reason" class="form-control">
								     <option selected value="Update">Information Update</option>
								   
							       </select>
									</div>
								</div>

							</div>
							
							<div class="row mt-3">
								 <div class="col-lg-12">
									<div class="md-form mt-5">
									<button type="submit" name="submit" class="btn btn-info"> Update</button>
									</div>
								 </div>	
							</div>
						</div>
						 </form>
					</div>
			
				</div>

			 <?php
			  }
			 ?>
				</div>	
	              <?php
                    $emp_session_id=$_SESSION['emp_id'];
					
				
					if(isset($_POST['first_customer_name'])){
							echo $emp_session_id;
						$first_customer_name = $_REQUEST['first_customer_name'];
						$current_customer_name = $_REQUEST['current_customer_name'];
						$current_customer_so = $_REQUEST['current_customer_so'];
						$current_customer_adds = $_REQUEST['current_customer_adds'];
						$current_customer_mobile = $_REQUEST['current_customer_mobile'];
						
						$current_customer_mobile = $_REQUEST['current_customer_mobile'];
						$model_name = $_REQUEST['model_name'];
						$chassis_price = $_REQUEST['chassis_price'];
						$first_party_dp = $_REQUEST['first_party_dp'];
						$first_total_received = $_REQUEST['first_total_received'];
						
						$resold_dp = $_REQUEST['resold_dp'];
						$resold_received = $_REQUEST['resold_received'];
						
						
						$receivable = $_REQUEST['receivable'];
						$discount = $_REQUEST['discount'];
						$received = $_REQUEST['received'];
						$closing_fee = $_REQUEST['closing_fee'];
						
						
						$chassis_number = $_REQUEST['chassis_number'];
						$eng_no = $_REQUEST['eng_no'];
						$reg_no = $_REQUEST['reg_no'];
						
						$brta_location = $_REQUEST['brta_location'];
						$responsible_concern = $_REQUEST['responsible_concern'];
						$responsible_designation = $_REQUEST['responsible_designation'];
						
						$bank_id = $_REQUEST['bank_id'];
						$father_husband_name = $_REQUEST['father_husband_name'];
						
						$reisse_reason = $_REQUEST['reisse_reason'];
						
						if($reisse_reason=='Update'){
							$strSQL  = oci_parse($objConnect, 
						           "update RML_COLL_SC_CCD SET
								       CURRENT_PARTY_NAME='$current_customer_name', 
									   CURRENT_PARTY_MOBILE='$current_customer_mobile', 
									   CURRENT_PARTY_ADDRS='$current_customer_adds',
									   FIRST_PARTY_NAME='$first_customer_name',
									   CUSTOMER_SO='$current_customer_so',
									   FIRST_PARTY_DP='$first_party_dp',
									   FRIST_PARTY_INSTALLMENT_REC='$first_total_received', 
									   MODEL_NAME='$model_name', 
									   SALES_AMOUNT='$chassis_price',
									   RESOLED_DP='$resold_dp',
									   RESOLED_RECEIVED='$resold_received', 
									   CLOSING_FEE='$closing_fee',
									   RECEIVABLE='$receivable',
									   DISCOUNT='$discount',
									   RECEIVED='$received',
									   CCD_INFO_UPDATE=SYSDATE,
									   CCD_INFO_UPDATE_BY='$emp_session_id',
									   BRTA_LOCATION='$brta_location',
									   RESPONSIBLE_PERSON='$responsible_concern',
									   RESPONSIBLE_DESIGNATION='$responsible_designation',
									   BANK_ID=$bank_id,
									   FATHER_OR_HUSBAND_NAME='$father_husband_name',
									   REG_NO='$reg_no',
									   ENG_NO='$eng_no',
									   CHASSIS_NO='$chassis_number'
								    where ID=$sc_id"); 
									
						}else{
							$strSQL  = oci_parse($objConnect, 
						           "update RML_COLL_SC_CCD SET
								       CURRENT_PARTY_NAME='$current_customer_name', 
									   CURRENT_PARTY_MOBILE='$current_customer_mobile', 
									   CURRENT_PARTY_ADDRS='$current_customer_adds',
									   FIRST_PARTY_NAME='$first_customer_name',
									   CUSTOMER_SO='$current_customer_so',
									   FIRST_PARTY_DP='$first_party_dp',
									   FRIST_PARTY_INSTALLMENT_REC='$first_total_received', 
									   MODEL_NAME='$model_name', 
									   SALES_AMOUNT='$chassis_price',
									   RESOLED_DP='$resold_dp',
									   RESOLED_RECEIVED='$resold_received', 
									   CLOSING_FEE='$closing_fee',
									   RECEIVABLE='$receivable',
									   DISCOUNT='$discount',
									   RECEIVED='$received',
									   CCD_INFO_UPDATE=SYSDATE,
									   CCD_INFO_UPDATE_BY='$emp_session_id',
									   BRTA_LOCATION='$brta_location',
									   RESPONSIBLE_PERSON='$responsible_concern',
									   RESPONSIBLE_DESIGNATION='$responsible_designation',
									   BANK_ID=$bank_id,
									   FATHER_OR_HUSBAND_NAME='$father_husband_name',
									   RE_ISSUES_STATUS=1,
									   RE_ISSUES_DATE=SYSDATE,
									   RE_ISSUES_BY='$emp_session_id',
									   RE_ISSUES_REASON='$reisse_reason',
									   REG_NO='$reg_no',
									   ENG_NO='$eng_no',
									   CHASSIS_NO='$chassis_number'
								    where ID=$sc_id"); 
						}
						
						  
						
						  
						   oci_execute($strSQL);
						   
							echo $htmlHeader;
							while($stuff)
							{
							 echo $stuff;
							}
							 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_check_list_update.php?sc_id=$sc_id'</script>";
						   
						  }
						?>
</div>

       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
	if($_SESSION['user_role_id']!= 2  && 
	   $_SESSION['user_role_id']!= 5  && 
	   $_SESSION['user_role_id']!= 12 && 
	   $_SESSION['user_role_id']!= 9  &&
	   $_SESSION['user_role_id']!= 14
	   )
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
						"SELECT ID, 
								REF_CODE, 
								CURRENT_PARTY_NAME, 
								CURRENT_PARTY_MOBILE, 
								CURRENT_PARTY_ADDRS, 
								(SELECT  NVL2(REGULAR_REFCODE,RE_SALE_DECLARE_DP,TOTAL_DP_RCV) FROM FILESUM_ERP WHERE RE_SALE_REFCODE=REF_CODE) CURRENT_PARTY_DP_RECEIVED,
								MODEL_NAME, 
								INSTALLMENT_RECEIVED, 
								SALES_AMOUNT, 
								FIRST_PARTY_NAME, 
								FIRST_PARTY_DP, 
							    (SELECT NVL2(REGULAR_REFCODE,TOTAL_DP_RCV,0) FROM FILESUM_ERP WHERE RE_SALE_REFCODE=REF_CODE) FIRST_PARTY_DP_RECEIVED,
								FRIST_PARTY_INSTALLMENT_REC, 
								RESOLED_DP,
                               --(select AA.TOTAL_RECEIVED_AMOUNT from LEASE_ALL_INFO_ERP AA WHERE AA.CHASSIS_NO= DD.CHASSIS_NO AND AA.PAMTMODE=DD.SALE_TYPE and aa.status='Y') RESOLED_RECEIVED,								
                              (select AA.TOTAL_RECEIVED_AMOUNT from LEASE_ALL_INFO_ERP AA WHERE AA.CHASSIS_NO= DD.CHASSIS_NO AND AA.PAMTMODE=DD.SALE_TYPE and rownum=1) RESOLED_RECEIVED,								
								--(select AA.TOTAL_RECEIVED_AMOUNT from LEASE_ALL_INFO_ERP AA WHERE AA.REF_CODE= DD.REF_CODE) RESOLED_RECEIVED,
								(select AA.TOTAL_DELAY_INTEREST from FILESUM_ERP AA WHERE AA.RE_SALE_REFCODE= DD.REF_CODE) RECEIVABLE, 
								DISCOUNT, 
								RECEIVED,
								TO_CHAR(CLOSING_DATE,'DD-MON-RRRR') CLOSING_DATE,
								TO_CHAR(RESALE_APPROVAL_DATE,'DD-MON-RRRR')RESALE_APPROVAL_DATE,
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
								FILE_CLEAR_DATE, 
								FILE_CLEAR_BY, 
								CLOSING_FEE,							
								CCD_INFO_UPDATE, 
								CCD_INFO_UPDATE_BY, 
								ENG_NO, 
								REG_NO, 
								CHASSIS_NO, 
								BRTA_LOCATION, 
								RESPONSIBLE_PERSON, 
								RESPONSIBLE_DESIGNATION, 
								CUSTOMER_SO,
								LEASE_REMARKS,
								ACCOUNTS_REMARKS
						FROM RML_COLL_SC_CCD DD
						WHERE ID='$sc_id'"); 			
						  
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
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:70%;" type="text" name="model_name" value= "<?php echo $row['MODEL_NAME'];?>" >
								</div>
								<div class="col-sm-12 mt-3">
									<b>07.Closing Amount:</b>
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>i) Chassis Price</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="chassis_price" value= "<?php echo $row['SALES_AMOUNT'];?>" >
								</div>
								
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>ii) 1st Party DP Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" name="first_party_dp" value= "<?php echo $row['FIRST_PARTY_DP_RECEIVED'];?>" >
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>iii) 1st Party EMI Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
									  <input style="width:50%;" type="text" name="resold_received" value= "<?php echo $row['RESOLED_RECEIVED'];?>" >
								</div>
								<div class="col-sm-12 mt-3 margin-left">
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <b>vii) Total Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input style="width:50%;" type="text" value= "<?php echo ($row['FIRST_PARTY_DP_RECEIVED']+
									                                                            $row['FRIST_PARTY_INSTALLMENT_REC']+
																								$row['CURRENT_PARTY_DP_RECEIVED']+
																								$row['RESOLED_RECEIVED']);?>" >
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
					 <div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Request Date:</label>
						  <input type="text" class="form-control" value= "<?php echo $row['REQUEST_DATE'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Requester Name:</label>
						  <input type="text" class="form-control" id="title"  value= "<?php echo $row['REQUESTER_NAME'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Requester Mobile:</label>
						  <input type="text" class="form-control" id="title" value= "<?php echo $row['REQUESTER_MOBILE'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Sale/Re-Sales Approval Date:</label>
						  <input class="form-control" type="text" value= "<?php echo $row['RESALE_APPROVAL_DATE'];?>" readonly/>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Chassis No:</label>
						  <input type="text" class="form-control" value= "<?php echo $row['CHASSIS_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Engine No:</label>
						  <input type="text" class="form-control" id="title"  value= "<?php echo $row['ENG_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Registration No:</label>
						  <input type="text" class="form-control" id="title" value= "<?php echo $row['REG_NO'];?>" readonly>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Closing Date:</label>
						  <input type="text" class="form-control" value="<?php echo $row['CLOSING_DATE'];?>" readonly> 
						</div>
					</div>
								
				</div>
				
				
							
				<div class="row">
					
					<!-- Only Lease can edit his remarks, Not Others -->			
					<?php
					if($_SESSION['user_role_id']== 2 || $_SESSION['user_role_id']== 9){
						?>
					<div class="col-sm-12">
						<div class="form-group">
						  <label for="title">Lease Remarks:</label>
						  <input type="text" class="form-control" id="title" name="lease_ramarks"  value= "<?php echo $row['LEASE_REMARKS'];?>">
						</div>
					</div>
					<?php 
					}else{
						?>
					  <div class="col-sm-12">
						<div class="form-group">
						  <label for="title">Lease Remarks:</label>
						  <input type="text" class="form-control" id="title" name="lease_ramarks"  value= "<?php echo $row['LEASE_REMARKS'];?>" readonly>
						</div>
					  </div>	
					<?php	
					}
					?>
					<!-- End Only Lease can edit his remarks, Not Others -->
					<!-- Only Accounts can edit his remarks, Not Others -->			
					<?php
					if($_SESSION['user_role_id']== 12){
						?>
					<div class="col-sm-12">
						<div class="form-group">
						  <label for="title">Accounts Remarks:</label>
						  <input type="text" class="form-control" id="title" name="accounts_ramarks"  value= "<?php echo $row['ACCOUNTS_REMARKS'];?>">
						</div>
					</div>
					<?php 
					}else{
						?>
					  <div class="col-sm-12">
						<div class="form-group">
						  <label for="title">Accounts Remarks:</label>
						  <input type="text" class="form-control" id="title" name="accounts_ramarks"  value= "<?php echo $row['ACCOUNTS_REMARKS'];?>" readonly>
						</div>
					  </div>	
					<?php	
					}
					?>
					<!-- End Only Accounts can edit his remarks, Not Others -->

					
				</div>
				
	
							
							<?php if($row['LEASE_APPROVAL_STATUS']!='1'){
								?>
							<div class="row">
								
								<div class="col-sm-4">
									<div class="form-group">
									  <label for="title">Approval Status(Mandatory):</label>
									      <select required="" name="sc_lease_approval_status" class="form-control">
										  <option value="">--</option>
										  <option value="1">Lease Clear</option>
										  <option value="0">In-Valid Request</option>
										  <option value="2">Information Update</option>
										  </select>
									 
									</div>
								 </div>
								 <div class="col-sm-4">
								    <label for="title">&nbsp;</label>
									<div class="form-group">
									<button type="submit" name="submit" class="form-control btn btn-primary"> Update</button>
									</div>
							      </div>
								  <div class="col-sm-4">
								  </div>
								 
							</div>
							
							<?php
							  }
							  if($row['ACC_APPROVAL_STATUS']!='1' && $_SESSION['user_role_id']== 12){
							 ?>
							 <div class="col-sm-4">
									<div class="form-group">
									  <label for="title">Approval Status(Mandatory):</label>
									      <select required="" name="sc_lease_approval_status" class="form-control">
										  <option value="">--</option>
										  <option value="2">Information Update</option>
										  </select>
									 
									</div>
								 </div>
							
							 <div class="col-sm-4">
								    <label for="title">&nbsp;</label>
									<div class="form-group">
									<button type="submit" name="submit" class="form-control btn btn-primary"> Update</button>
									</div>
							      </div>
							<?php
							  }
							 ?>
							
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
					if(isset($_POST['sc_lease_approval_status'])){
						$sc_lease_approval_status = $_REQUEST['sc_lease_approval_status'];
						
						$first_customer_name = str_replace("'","''",$_REQUEST['first_customer_name']);
						
						$current_customer_name = str_replace("'","''",$_REQUEST['current_customer_name']);
						$current_customer_adds= str_replace("'", '', $_REQUEST['current_customer_adds']);
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
						
						$lease_ramarks= str_replace("'", '', $_REQUEST['lease_ramarks']);
						$accounts_ramarks= str_replace("'", '', $_REQUEST['accounts_ramarks']);
						
						if($sc_lease_approval_status=='1'){
							$strSQL  = oci_parse($objConnect, 
						           "update RML_COLL_SC_CCD SET
								       CURRENT_PARTY_NAME='$current_customer_name', 
									   CURRENT_PARTY_MOBILE='$current_customer_mobile', 
									   CURRENT_PARTY_ADDRS='$current_customer_adds',
									   FIRST_PARTY_NAME='$first_customer_name',
									   FIRST_PARTY_DP='$first_party_dp',
									   FRIST_PARTY_INSTALLMENT_REC='$first_total_received', 
									   MODEL_NAME='$model_name', 
									   SALES_AMOUNT='$chassis_price',
									   RESOLED_DP='$resold_dp',
									   RESOLED_RECEIVED='$resold_received', 
							           LEASE_APPROVAL_STATUS='$sc_lease_approval_status',
									   LEASE_APPROVAL_DATE=SYSDATE, 
									   LEASE_APPROVAL_BY='$emp_session_id',
									   CLOSING_FEE='$closing_fee',
									   RECEIVABLE='$receivable',
									   DISCOUNT='$discount',
									   RECEIVED='$received',
									   LEASE_REMARKS='$lease_ramarks'
								    where ID='$sc_id'"); 
						}else if($sc_lease_approval_status=='0'){
							$strSQL  = oci_parse($objConnect, 
						           "DELETE RML_COLL_SC_CCD 
								    where ID=$sc_id");
						}else if($sc_lease_approval_status=='2'){
							$strSQL  = oci_parse($objConnect, 
						           "update RML_COLL_SC_CCD SET
								       CURRENT_PARTY_NAME='$current_customer_name', 
									   CURRENT_PARTY_MOBILE='$current_customer_mobile', 
									   CURRENT_PARTY_ADDRS='$current_customer_adds',
									   FIRST_PARTY_NAME='$first_customer_name',
									   FIRST_PARTY_DP='$first_party_dp',
									   FRIST_PARTY_INSTALLMENT_REC='$first_total_received', 
									   MODEL_NAME='$model_name', 
									   SALES_AMOUNT='$chassis_price',
									   RESOLED_DP='$resold_dp',
									   RESOLED_RECEIVED='$resold_received',  
									   --LEASE_APPROVAL_BY='$emp_session_id',
									   CLOSING_FEE='$closing_fee',
									   RECEIVABLE='$receivable',
									   DISCOUNT='$discount',
									   RECEIVED='$received',
									   LEASE_REMARKS='$lease_ramarks',
									   ACCOUNTS_REMARKS='$accounts_ramarks'
								    where ID='$sc_id'");
								
						}
						   if(oci_execute($strSQL)){
							        echo $htmlHeader;
									while($stuff)
									{echo $stuff;}
									 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_list_edit.php?sc_id=$sc_id'</script>"; 
						   } 
						  }
						?>
</div>

       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
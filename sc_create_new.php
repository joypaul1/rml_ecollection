<?php
session_start();
if ($_SESSION['user_role_id'] != 2 && $_SESSION['user_role_id'] != 9 && $_SESSION['user_role_id'] != 15) {
	header('location:index.php?lmsg=true');
	exit;
}

require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_sidebar.php');
require_once('inc/connoracle.php');

$chs_no = "";
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="">Create New Request</a>
			</li>
		</ol>

		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">

					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<div class="row">

						<div class="col-sm-4">
							<label for="title">Ref-Code:</label>
							<input name="ref_code" required="" form="Form1" class="form-control" type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
						</div>
						<div class="col-sm-4">
							<label for="title">Select Sales Type:</label>
							<select name="sales_type" class="form-control" form="Form1">
								<option selected value="CRT">Credit Sale</option>
							</select>
						</div>
						<div class="col-sm-4">
							<label for="title">&nbsp;</label>
							<input class="form-control btn btn-primary" type="submit" value="Search Code" form="Form1">
						</div>
					</div>
					<hr>
				</div>
				<?php
				$emp_session_id = $_SESSION['emp_id'];
				if (isset($_POST['ref_code'])) {
					$ref_code = $_REQUEST['ref_code'];
					$sales_type = trim($_REQUEST['sales_type']);
					$strSQL  = oci_parse($objConnect, "select REF_CODE,
				                                             STATUS,
															 CUSTOMER_NAME,
															 CUSTOMER_MOBILE_NO,
															 PARTY_ADDRESS,
															 REG_NO,
															 ENG_NO,
															 CHASSIS_NO,
															 SALES_AMOUNT,
															 TOTAL_RECEIVED_AMOUNT,
															 DUE_AMOUNT,
															 DP,
															 PAMTMODE,
															 LEASE_AMOUNT,
															 PRODUCT_TYPE,
															 INSTALLMENT_AMOUNT,
															 TO_CHAR(DELIVERY_DATE,'DD-MON-RRRR') DELIVERY_DATE,
															 COLL_CONCERN_NAME,
															 TO_CHAR(CLSDATE,'DD-MON-RRRR') CLSDATE,
															 PRODUCT_CODE_NAME,
															 (select TOTAL_DELAY_INTEREST from FILESUM_V@ERP_LINK_LIVE
                                                               where RE_SALE_REFCODE=REF_CODE
															   ) AS  
															   TOTAL_DELAY_INTEREST,
															 (select FILE_CLOSING_FEE from FILESUM_V@ERP_LINK_LIVE
                                                               where RE_SALE_REFCODE=REF_CODE
															   ) AS  
															   FILE_CLOSING_FEE ,
															 (select RECEIVE_DELAY_INTEREST from FILESUM_V@ERP_LINK_LIVE
                                                               where RE_SALE_REFCODE=REF_CODE
															   ) AS  
															   RECEIVE_DELAY_INTEREST  
													    from lease_all_info_erp
													where  (REF_CODE='$ref_code' OR CHASSIS_NO='$ref_code')
													and PAMTMODE='$sales_type'");

					// from lease_all_info@ERP_LINK_LIVE 
					oci_execute($strSQL);
					$ref_code = '';
					$customer_name = '';
					$customer_mobile_no = '';
					$delivery_no = '';

					$eng_no = '';
					$chs_no = '';
					$reg_no = '';

					$sales_amount = '';
					$total_received_amount = '';
					$due_amount = '';
					$product_type = '';
					$pament_type = '';


					$collection_concern = '';
					$code_satatus = 'NO';
					while ($row = oci_fetch_assoc($strSQL)) {
						$ref_code = $row['REF_CODE'];
						$customer_name = $row['CUSTOMER_NAME'];
						$customer_mobile_no = $row['CUSTOMER_MOBILE_NO'];
						$customer_address = $row['PARTY_ADDRESS'];
						$delivery_date = $row['DELIVERY_DATE'];
						$file_cloded_date = $row['CLSDATE'];

						$eng_no = $row['ENG_NO'];
						$chs_no = $row['CHASSIS_NO'];
						$reg_no = $row['REG_NO'];

						$sales_amount = $row['SALES_AMOUNT'];
						$total_received_amount = $row['TOTAL_RECEIVED_AMOUNT'];
						$due_amount = $row['DUE_AMOUNT'];
						$product_type = $row['PRODUCT_TYPE'];
						$modle_name = $row['PRODUCT_CODE_NAME'];


						$collection_concern = $row['COLL_CONCERN_NAME'];
						$code_satatus = $row['STATUS'];


						$TOTAL_DELAY_INTEREST = $row['TOTAL_DELAY_INTEREST'];
						$FILE_CLOSING_FEE = $row['FILE_CLOSING_FEE'];
						$RECEIVE_DELAY_INTEREST = $row['RECEIVE_DELAY_INTEREST'];
						$pament_type = $row['PAMTMODE'];
					}
				?>
					<div class="col-lg-12">
						<div class="md-form mt-2">


							<div class="row">
								<div class="col-lg-12">

									<div class="row">

										<div class="col-sm-12 input-lg text-danger">
											<b> Open-Close Status:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input class="text-danger" style="width:70%;" type="text" id="title" value="<?php
																														if ($code_satatus == 'N') {
																															echo 'Close File (' . $pament_type . ')';
																														} else if ($code_satatus == 'Y') {
																															echo 'Open File(' . $pament_type . ')';
																														} else if ($code_satatus == 'NO') {
																															echo 'Code not found';
																														}
																														?>
											  " readonly>

										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>01. RML Code No:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" form="Form2" type="text" id="title" name="ref_code_no" value="<?php echo $ref_code; ?>" readonly>
										</div>

										<div class="col-sm-12 mt-3 input-lg">
											<b>02. Customer Name</b>(Current Party):&nbsp;&nbsp;&nbsp;&nbsp;
											<input class="input-lg" style="width:70%;" type="text" name="cust_name" value="<?php echo $customer_name;; ?>" readonly>
										</div>

										<div class="col-sm-12 mt-3">
											<b>03. Present & Permanent Address</b>:&nbsp;&nbsp;<br>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp; &nbsp;
											<textarea rows="3" style="width:70%;"><?php echo $customer_address; ?></textarea>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>04. Contact No.</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" name="cust_mobile" type="text" value="<?php echo $customer_mobile_no; ?>">
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>05. Product Type</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $product_type; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>06. Product Procured</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $modle_name; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>07. Delivery Date</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $delivery_date; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>08. Cloded Date</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $file_cloded_date; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>9. Chassis No</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" name="chassis_number" value="<?php echo $chs_no; ?>" form="Form2" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>10. Engine No</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $eng_no; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>11. Reg No</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $reg_no; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>12. Collection Concern</b>:&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $collection_concern; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>13. Sales Amount</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $sales_amount; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>14. Received Amount</b>:&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $total_received_amount; ?>" readonly>
										</div>
										<div class="col-sm-12 mt-3 input-lg">
											<b>15. Due Amount</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:70%;" type="text" value="<?php echo $due_amount; ?>" readonly>
										</div>



										<div class="col-sm-12 mt-3">
											<b>16. Daily Interest(If Credit)</b>:
										</div>

										<div class="col-sm-12 mt-3 margin-left">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<b>i) Total Delay Interest</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;
											<input style="width:20%;" type="text" value="<?php echo $TOTAL_DELAY_INTEREST; ?>">
										</div>
										<div class="col-sm-12 mt-3 margin-left">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<b>ii) Total Delay Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:20%;" type="text" value="<?php echo $RECEIVE_DELAY_INTEREST; ?>">
										</div>
										<div class="col-sm-12 mt-3 margin-left">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<b>iii) Closing Fee</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:20%;" type="text" value="<?php echo $FILE_CLOSING_FEE; ?>">
										</div>

									</div>



									<?php
									if ($code_satatus == 'N' || $pament_type == 'CSH') {

									?>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Requester Name:</label>
													<input required="" type="text" name="requester_name" class="form-control" id="title" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Requester Mobile:</label>
													<input required="" type="tel" name="reqst_mobile" class="form-control" id="title" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title"> <br></label>
													<input class="form-control btn btn-primary" type="submit" value="Request Create" form="Form2">
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




			<?php
			$emp_session_id = $_SESSION['emp_id'];
			@$ref_code_no = $_REQUEST['ref_code_no'];
			@$requester_name = $_REQUEST['requester_name'];
			@$reqst_mobile = $_REQUEST['reqst_mobile'];
			@$chassish_number = $_REQUEST['chassis_number'];

			if (isset($_POST['requester_name'])) {
				$sql = "begin RML_COLL_SC_CREATE('$ref_code_no','$requester_name','$reqst_mobile','$emp_session_id','CRT');END;";
				// $sql ="begin RML_COLL_SC_CREATE('$chassish_number','$requester_name','$reqst_mobile','$emp_session_id','CRT');END;";
				// echo $sql;
				$strSQL  = oci_parse($objConnect, $sql);


				if (@oci_execute($strSQL)) {
					echo "New Request is created successfully.";
				} else {
					$lastError = error_get_last();
					$error = $lastError ? "" . $lastError["message"] . "" : "";
					if (strpos($error, 'REF_CODE_UNIQUE_CCD') !== false) {
						echo "This request is already created. You can not create duplicate request.";
					}
				}
			}
			?>
		</div>
	</div>



	<div style="height: 1000px;"></div>
</div>

<?php require_once('layouts/footer.php'); ?>
<?php
session_start();
// if ($_SESSION['user_role_id'] != 5) {
// 	header('location:index.php?lmsg=true');
// 	exit;
// }

require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_sidebar.php');
require_once('inc/connoracle.php');

?>

<div class="content-wrapper">
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="">SC Complited List</a>
			</li>
		</ol>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">

							<div class="col-sm-4">
								<div class="form-group">
									<label for="title">Ref-Code/File Number/Chassis:</label>
									<input name="ref_code" required="" class="form-control" type='text'
										value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>

							<div class="col-sm-4">
								<label for="title">Select Sales Type:</label>
								<select name="sales_type" class="form-control">
									<option value="CRT">Credit Sale</option>
									<option value="CSH">Cash Sale</option>
								</select>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label for="title"> <br></label>
									<input class="form-control btn btn-primary" type="submit" value="Search Data">
								</div>
							</div>

						</div>


					</form>
				</div>

				<div class="col-lg-12">
					<div class="md-form mt-5">
						<div class="resume-item d-flex flex-column flex-md-row">
							<table class="table table-bordered border-primary" id="admin_list" style="width:100%">
								<thead class="thead-dark">
									<tr>
										<th scope="col">Sl</th>
										<th scope="col">Customer Info</th>
										<th scope="col">Lease Approval Info</th>
										<th scope="col">Acc Approval Info</th>
										<th scope="col">CCD Accept Info</th>
										<th scope="col">CCD Clear Info</th>
										<th scope="col">Handover/Reissues Info</th>
										<th scope="col">
											<center>If Action Need</center>
										</th>
										<th scope="col">
											<center>Documents Report Print</center>
										</th>
										<th scope="col">
											<center>Approval Sheet Print</center>
										</th>
									</tr>
								</thead>

								<tbody>

									<?php
									$emp_session_id = $_SESSION['emp_id'];


									if (isset($_POST['ref_code'])) {

										$reference_code = trim($_REQUEST['ref_code']);
										$sales_type = trim($_REQUEST['sales_type']);


										$strSQL = oci_parse($objConnect, "SELECT 
																	   ID, 
																	   REF_CODE, 
																	   CURRENT_PARTY_NAME, 
																	   CURRENT_PARTY_MOBILE, 
																	   CURRENT_PARTY_ADDRS, 
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
																	   FILE_CLEAR_DATE,
																	   FILE_CLEAR_BY,SALE_TYPE,
																	   COLL_HANDOVER_STATUS(ID) AS HANDOVER_STATUS,
                                                                       COLL_REISSUES_STATUS(REF_CODE) AS REISSES_STATUS 																	   
																	FROM RML_COLL_SC_CCD
																WHERE ('$reference_code' IS NULL OR REF_CODE='$reference_code'  OR CHASSIS_NO ='$reference_code')
																AND FILE_CLEAR_STATUS =1
																AND ('$sales_type' IS NULL OR SALE_TYPE='$sales_type')");
										oci_execute($strSQL);
										$number = 0;

										while ($row = oci_fetch_assoc($strSQL)) {
											$number++;
											?>
											<tr>
												<td><?php echo $number; ?></td>
												<td>
													<?php
													echo '<i style="color:red;"><b>' . $row['REF_CODE'] . '</b></i> ';
													echo '<br>';
													echo $row['CURRENT_PARTY_NAME'];
													echo '<br>';
													echo $row['CURRENT_PARTY_MOBILE'];
													echo '<br>';
													echo '<i style="color:gray;"><b> Sale Type: ' . $row['SALE_TYPE'] . '</b></i> ';
													?>
												</td>
												<td>
													<?php if ($row['LEASE_APPROVAL_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i>';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													} else if ($row['LEASE_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php if ($row['ACC_APPROVAL_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['ACC_APPROVAL_DATE'];
														echo '<br>';
														echo $row['ACC_APPROVAL_BY'];
													} else if ($row['ACC_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['ACC_APPROVAL_DATE'];
														echo '<br>';
														echo $row['ACC_APPROVAL_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php if ($row['CCD_APPROVAL_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['CCD_APPROVAL_DATE'];
														echo '<br>';
														echo $row['CCD_APPROVAL_BY'];
													} else if ($row['CCD_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['CCD_APPROVAL_DATE'];
														echo '<br>';
														echo $row['CCD_APPROVAL_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php if ($row['FILE_CLEAR_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													} else if ($row['FILE_CLEAR_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php
													echo 'Handover Status : ' . $row['HANDOVER_STATUS'];
													echo '<br>';
													echo 'Reissue Status : ' . $row['REISSES_STATUS'];

													?>
												</td>
												<td align="center">
													<a href="sc_check_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
													   echo '<button class="btn btn-danger btn-sm">Check List &nbsp;&nbsp;</button>';
													   ?></a><br><br>
													<a href="sc_check_list_update.php?sc_id=<?php echo $row['ID'] ?>"><?php
													   echo '<button class="btn btn-danger btn-sm">Update Info</button>'; ?>
													</a>
												</td>

												<td align="center">

													<?php if ($row['HANDOVER_STATUS'] == 'YES' && $row['REISSES_STATUS'] == 'YES') {
														?>
														<a href="sc_global_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Minutes of Meeting">&nbsp;M.M &nbsp;</button>';
															?></a>
														<a href="sc_ownership_transfer_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Ownership Transfer">&nbsp;O.T&nbsp;</button>';
															?></a>
														<br><br>
														<a href="sc_form_tto_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Form-T.T.O">&nbsp;T.T.O&nbsp;</button>'; ?>
														</a>
														<a href="sc_form_to_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Form-T.O">&nbsp;T.O&nbsp;</button>'; ?>
														</a>
														<a href="sc_form_sales_received.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Form-Sales Receive">&nbsp;S.R&nbsp;</button>'; ?>
														</a>
														<?php
													} else if ($row['HANDOVER_STATUS'] == 'NO') {
														?>
															<a href="sc_global_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Minutes of Meeting">&nbsp;M.M &nbsp;</button>';
																?></a>
															<a href="sc_ownership_transfer_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Ownership Transfer">&nbsp;O.T&nbsp;</button>';
																?></a>
															<br><br>
															<a href="sc_form_tto_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Form-T.T.O">&nbsp;T.T.O&nbsp;</button>'; ?>
															</a>
															<a href="sc_form_to_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Form-T.O">&nbsp;T.O&nbsp;</button>'; ?>
															</a>
															<a href="sc_form_sales_received.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Form-Sales Receive">&nbsp;S.R&nbsp;</button>'; ?>
															</a>
														<?php
													}
													?>


												</td>
												<td align="center">

													<?php if ($row['HANDOVER_STATUS'] == 'YES' && $row['REISSES_STATUS'] == 'YES') {
														?>

														<a
															href="sc_closing_approval_sheet_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
															   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet">&nbsp;&nbsp;A.S &nbsp;&nbsp;</button>';
															   ?></a>
														<a
															href="sc_closing_approval_sheet_rsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
															   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(rsv)">&nbsp;RSV&nbsp;&nbsp;</button>';
															   ?></a>
														<br><br>
														<a
															href="sc_closing_approval_sheet_crsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
															   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(crsv)">&nbsp;CRSV&nbsp;</button>'; ?>
														</a>
														<!--<a  href="sc_form_to_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
														   echo '<button class="btn btn-danger btn-sm">&nbsp;&nbsp;DSC&nbsp;</button>'; ?>
								 </a> -->

														<?php
													} else if ($row['HANDOVER_STATUS'] == 'NO') {
														?>
															<a
																href="sc_closing_approval_sheet_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
																   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet">&nbsp;&nbsp;A.S &nbsp;&nbsp;</button>';
																   ?></a>
															<a
																href="sc_closing_approval_sheet_rsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
																   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(rsv)">&nbsp;RSV&nbsp;&nbsp;</button>';
																   ?></a>
															<br><br>
															<a
																href="sc_closing_approval_sheet_crsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
																   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(crsv)">&nbsp;CRSV&nbsp;</button>'; ?>
															</a>
															<!--<a  href="sc_form_to_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
															   echo '<button class="btn btn-danger btn-sm">&nbsp;&nbsp;DSC&nbsp;</button>'; ?>
								 </a> -->
														<?php
													}
													?>


												</td>
											</tr>
											<?php
										}
									} else {

										$allDataSQL = oci_parse($objConnect, "SELECT 
																	   ID, 
																	   REF_CODE, 
																	   CURRENT_PARTY_NAME, 
																	   CURRENT_PARTY_MOBILE, 
																	   CURRENT_PARTY_ADDRS, 
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
																	   FILE_CLEAR_DATE,
																	   FILE_CLEAR_BY,
																	   SALE_TYPE,
																	   COLL_HANDOVER_STATUS(ID) AS HANDOVER_STATUS,
                                                                       COLL_REISSUES_STATUS(REF_CODE) AS REISSES_STATUS																	   
																	FROM RML_COLL_SC_CCD
																	where CCD_APPROVAL_STATUS=1
																	AND FILE_CLEAR_STATUS=1
																	AND ROWNUM<=20");

										oci_execute($allDataSQL);
										$number = 0;

										while ($row = oci_fetch_assoc($allDataSQL)) {
											$number++;
											?>
											<tr>
												<td><?php echo $number; ?></td>
												<td>
													<?php
													echo '<i style="color:red;"><b>' . $row['REF_CODE'] . '</b></i> ';
													echo '<br>';
													echo $row['CURRENT_PARTY_NAME'];
													echo '<br>';
													echo $row['CURRENT_PARTY_MOBILE'];
													echo '<br>';
													echo '<i style="color:gray;"><b> Sale Type: ' . $row['SALE_TYPE'] . '</b></i> ';
													?>
												</td>


												<td>
													<?php if ($row['LEASE_APPROVAL_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i>';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													} else if ($row['LEASE_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php if ($row['ACC_APPROVAL_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['ACC_APPROVAL_DATE'];
														echo '<br>';
														echo $row['ACC_APPROVAL_BY'];
													} else if ($row['ACC_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['ACC_APPROVAL_DATE'];
														echo '<br>';
														echo $row['ACC_APPROVAL_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php if ($row['CCD_APPROVAL_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['CCD_APPROVAL_DATE'];
														echo '<br>';
														echo $row['CCD_APPROVAL_BY'];
													} else if ($row['CCD_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['CCD_APPROVAL_DATE'];
														echo '<br>';
														echo $row['CCD_APPROVAL_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php if ($row['FILE_CLEAR_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													} else if ($row['FILE_CLEAR_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													} else {

													}
													?>
												</td>
												<td>
													<?php
													echo 'Handover Status : ' . $row['HANDOVER_STATUS'];
													echo '<br>';
													echo 'Reissue Status : ' . $row['REISSES_STATUS'];

													?>
												</td>
												<td align="center">
													<a href="sc_check_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
													   echo '<button class="btn btn-danger btn-sm">Check List &nbsp;&nbsp;</button>';
													   ?></a><br><br>
													<a href="sc_check_list_update.php?sc_id=<?php echo $row['ID'] ?>"><?php
													   echo '<button class="btn btn-danger btn-sm">Update Info</button>'; ?>
													</a>
												</td>

												<td align="center">

													<?php if ($row['HANDOVER_STATUS'] == 'YES' && $row['REISSES_STATUS'] == 'YES') {
														?>
														<a href="sc_global_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Minutes of Meeting">&nbsp;M.M &nbsp;</button>';
															?></a>
														<a href="sc_ownership_transfer_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Ownership Transfer">&nbsp;O.T&nbsp;</button>';
															?></a>
														<br><br>
														<a href="sc_form_tto_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Form-T.T.O">&nbsp;T.T.O&nbsp;</button>'; ?>
														</a>
														<a href="sc_form_to_report.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Form-T.O">&nbsp;T.O&nbsp;</button>'; ?>
														</a>
														<a href="sc_form_sales_received.php?sc_id=<?php echo $row['ID'] ?>"
															target="_blank"><?php
															echo '<button class="btn btn-success btn-sm" title="Form-Sales Receive">&nbsp;S.R&nbsp;</button>'; ?>
														</a>
														<?php
													} else if ($row['HANDOVER_STATUS'] == 'NO') {
														?>
															<a href="sc_global_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Minutes of Meeting">&nbsp;M.M &nbsp;</button>';
																?></a>
															<a href="sc_ownership_transfer_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Ownership Transfer">&nbsp;O.T&nbsp;</button>';
																?></a>
															<br><br>
															<a href="sc_form_tto_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Form-T.T.O">&nbsp;T.T.O&nbsp;</button>'; ?>
															</a>
															<a href="sc_form_to_report.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Form-T.O">&nbsp;T.O&nbsp;</button>'; ?>
															</a>
															<a href="sc_form_sales_received.php?sc_id=<?php echo $row['ID'] ?>"
																target="_blank"><?php
																echo '<button class="btn btn-success btn-sm" title="Form-Sales Receive">&nbsp;S.R&nbsp;</button>'; ?>
															</a>
														<?php
													}
													?>
												</td>
												<td align="center">
													<a
														href="sc_closing_approval_sheet_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
														   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet">&nbsp;&nbsp;A.S &nbsp;&nbsp;</button>';
														   ?></a>
													<a
														href="sc_closing_approval_sheet_rsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
														   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(rsv)">&nbsp;RSV&nbsp;&nbsp;</button>';
														   ?></a>
													<br><br>
													<a
														href="sc_closing_approval_sheet_crsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
														   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(crsv)">&nbsp;CRSV&nbsp;</button>'; ?>
													</a>
													<?php if ($row['HANDOVER_STATUS'] == 'YES' && $row['REISSES_STATUS'] == 'YES') {
														?>
														<a
															href="sc_closing_approval_sheet_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
															   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet">&nbsp;&nbsp;A.S &nbsp;&nbsp;</button>';
															   ?></a>
														<a
															href="sc_closing_approval_sheet_rsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
															   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(rsv)">&nbsp;RSV&nbsp;&nbsp;</button>';
															   ?></a>
														<br><br>
														<a
															href="sc_closing_approval_sheet_crsv_report.php?sc_id=<?php echo $row['ID'] ?>"><?php
															   echo '<button class="btn btn-danger btn-sm" title="Closing Approval Sheet(crsv)">&nbsp;CRSV&nbsp;</button>'; ?>
														</a>
														<?php
													}
													?>
												</td>

											</tr>
											<?php
										}
									}
									?>
								</tbody>

							</table>
						</div>

					</div>
				</div>


			</div>
		</div>


		<div style="height: 1000px;"></div>
	</div>
	<!-- /.container-fluid-->

	<?php require_once('layouts/footer.php'); ?>
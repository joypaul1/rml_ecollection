<?php
session_start();
if ($_SESSION['user_role_id'] != 14) {
	header('location:index.php?lmsg=true');
	exit;
}

require_once ('inc/config.php');
require_once ('layouts/header.php');
require_once ('layouts/left_sidebar.php');
require_once ('inc/connoracle.php');

?>

<div class="content-wrapper">
	<div class="container-fluid">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="">List</a>
			</li>
		</ol>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">

							<div class="col-sm-4">
								<div class="form-group">
									<label for="title">Chassis No/Buyers No::</label>
									<input name="ref_code" class="form-control" type='text'
										value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-4">
								<label for="title">Select Sales Type:</label>
								<select name="sales_type" class="form-control">
									<option selected value="CSH">Cash Sale</option>
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
							<table class="table table-bordered piechart-key" id="admin_list" style="width:100%">
								<thead class="thead-dark">
									<tr>
										<th scope="col">Sl</th>
										<th scope="col">
											<center>Customer Info</center>
										</th>
										<th scope="col">
											<center>Lease Approval Info</center>
										</th>
										<th scope="col">
											<center>Acc Approval Date</center>
										</th>
										<th scope="col">
											<center>CCD Accept Date</center>
										</th>
										<th scope="col">
											<center>SC Status</center>
										</th>
										<th scope="col">
											<center>Requester Info</center>
										</th>
										<th scope="col">
											<center>Action</center>
										</th>
									</tr>
								</thead>

								<tbody>

									<?php
									$emp_session_id = $_SESSION['emp_id'];


									if (isset($_POST['ref_code'])) {

										$reference_code = trim($_REQUEST['ref_code']);
										$sales_type     = trim($_REQUEST['sales_type']);
										$strSQL         = oci_parse($objConnect, "SELECT 
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
															   SALE_TYPE
															FROM RML_COLL_SC_CCD
															WHERE (CHASSIS_NO='$reference_code' OR REF_CODE='$reference_code') 
															and SALE_TYPE='CSH'
															");
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
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													}
													else if ($row['LEASE_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													}
													else {

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
													}
													else if ($row['LEASE_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['ACC_APPROVAL_DATE'];
														echo '<br>';
														echo $row['ACC_APPROVAL_BY'];
													}
													else {

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
													}
													else if ($row['CCD_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['CCD_APPROVAL_DATE'];
														echo '<br>';
														echo $row['CCD_APPROVAL_BY'];
													}
													else {

													}
													?>
												</td>
												<td>
													<?php if ($row['FILE_CLEAR_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>SC Done</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													}
													else if ($row['FILE_CLEAR_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Re-Issues</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													}
													else {

													}
													?>
												</td>
												<td><?php echo $row['REQUESTER_NAME'] . '<br>' . $row['REQUESTER_MOBILE'] . '<br>' . $row['REQUEST_DATE'] . '<br>' . $row['REQUEST_BY']; ?>
												</td>

												<td align="center">
													<a href="sc_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
													   echo '<button class="branch_edit">Information</button>';
													   ?>
													</a>
												</td>
											</tr>
											<?php
										}
									}
									else {

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
																	   SALE_TYPE
																	FROM RML_COLL_SC_CCD
																	WHERE rownum<=10
																	and SALE_TYPE='CSH'
																	");

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
														echo '<i style="color:blue;"><b>Approved</b></i> ';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													}
													else if ($row['LEASE_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['LEASE_APPROVAL_DATE'];
														echo '<br>';
														echo $row['LEASE_APPROVAL_BY'];
													}
													else {

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
													}
													else if ($row['LEASE_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['ACC_APPROVAL_DATE'];
														echo '<br>';
														echo $row['ACC_APPROVAL_BY'];
													}
													else {

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
													}
													else if ($row['CCD_APPROVAL_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Denied</b></i> ';
														echo '<br>';
														echo $row['CCD_APPROVAL_DATE'];
														echo '<br>';
														echo $row['CCD_APPROVAL_BY'];
													}
													else {

													}
													?>
												</td>
												<td>
													<?php if ($row['FILE_CLEAR_STATUS'] == '1') {
														echo '<i style="color:blue;"><b>SC Done</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													}
													else if ($row['FILE_CLEAR_STATUS'] == '0') {
														echo '<i style="color:red;"><b>Re-Issues</b></i> ';
														echo '<br>';
														echo $row['FILE_CLEAR_DATE'];
														echo '<br>';
														echo $row['FILE_CLEAR_BY'];
													}
													else {

													}
													?>
												</td>

												<td><?php echo $row['REQUESTER_NAME'] . '<br>' . $row['REQUESTER_MOBILE'] . '<br>' . $row['REQUEST_DATE'] . '<br>' . $row['REQUEST_BY']; ?>
												</td>
												<td align="center">
													<a href="sc_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
													   echo '<button class="branch_edit">Information</button>';
													   ?>
													</a>
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

	<?php require_once ('layouts/footer.php'); ?>
<?php
session_start();
if ($_SESSION['user_role_id'] != 2 && $_SESSION['user_role_id'] != 1) {
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
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="">List</a> &nbsp;&nbsp; <a target="_blank" href="new_emp_create.php">New</a>
			</li>
		</ol>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="title">User ID:</label>
									<input name="r_rml_id" class="form-control" type='text' value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-3">
								<label for="title">Select User Role</label>
								<select required="" name="r_concern" class="form-control">
									<option <?php echo isset($_POST['r_concern']) ? $_REQUEST['r_concern'] == 'AH' ? 'selected' : ''  : '' ?> value="AH">Area Head</option>
									<option <?php echo isset($_POST['r_concern']) ? $_REQUEST['r_concern'] == 'ZH' ? 'selected' : ''  : '' ?> value="ZH">Zonal Head</option>
									<option <?php echo isset($_POST['r_concern']) ? $_REQUEST['r_concern'] == 'CC' ? 'selected' : ''  : '' ?> value="CC">Collection Concern</option>
								</select>

							</div>
							<div class="col-sm-3">
								<label for="title">Select User Status</label>
								<select required="" name="user_status" class="form-control">
									<option <?php echo isset($_POST['user_status']) ? $_REQUEST['user_status'] == '1' ? 'selected' : ''  : '' ?> value="1">Active</option>
									<option <?php echo isset($_POST['user_status']) ? $_REQUEST['user_status'] == '0' ? 'selected' : ''  : '' ?> value="0">In-Active</option>
								</select>
							</div>

							<div class="col-sm-3">
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
								<thead class="table-success">
									<tr>
										<th scope="col">
											<center>Sl<br>Number</center>
										</th>
										<th scope="col">User <br>Information</th>
										<th scope="col">Authentication <br>Information</th>
										<th scope="col">
											<center>Action<br> Type</center>
										</th>
									</tr>
								</thead>

								<tbody>

									<?php
									$emp_session_id = $_SESSION['emp_id'];


									if (isset($_POST['r_concern'])) {
										$r_concern = $_REQUEST['r_concern'];
										$r_rml_id = $_REQUEST['r_rml_id'];
										$v_user_status = $_REQUEST['user_status'];
										$strSQL  = oci_parse($objConnect, "select ID,
							                         EMP_NAME,
													 RML_ID,
													 MOBILE_NO,
													 LEASE_USER,
													 AREA_ZONE,USER_TYPE,IS_ACTIVE
										    FROM RML_COLL_APPS_USER
												WHERE ACCESS_APP='RML_COLL'
												AND ('$r_rml_id' is null OR RML_ID='$r_rml_id')
												AND ('$r_concern' is null OR LEASE_USER='$r_concern')
												AND IS_ACTIVE='$v_user_status'
													 ");

										oci_execute($strSQL);
										$number = 0;

										while ($row = oci_fetch_assoc($strSQL)) {
											$number++;
									?>
											<tr>
												<td align="center"><?php echo $number; ?></td>
												<td>
													<?php
													echo 'Name: ' . $row['EMP_NAME'];
													echo '<br>';
													echo 'Login ID: ' . $row['RML_ID'];
													echo '<br>';
													echo 'Mobile: ' . $row['MOBILE_NO'];
													?>
												</td>
												<td>
													<?php
													echo 'Role: ' . $row['LEASE_USER'];
													echo '<br>';
													echo 'Zone: ' . $row['AREA_ZONE'];
													echo '<br>';
													echo 'User Type: ' . $row['USER_TYPE'];
													echo '<br>';
													if ($row['IS_ACTIVE'] == '1')
														echo 'User Status Active';
													else
														echo 'User Status In-Active';
													?>
												</td>


												<td align="center">

													<a href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>"><?php
																														echo '<button class="edit-user">update</button>';
																														?>
													</a>
												</td>

											</tr>
										<?php
										}
									} else {
										$allDataSQL  = oci_parse(
											$objConnect,
											"select ID,
							                         EMP_NAME,
													 RML_ID,
													 MOBILE_NO,
													 LEASE_USER,
													 AREA_ZONE,USER_TYPE ,IS_ACTIVE
										    FROM RML_COLL_APPS_USER
												WHERE ACCESS_APP='RML_COLL'
												AND LEASE_USER='AH'
												AND IS_ACTIVE=1"
										);

										oci_execute($allDataSQL);
										$number = 0;

										while ($row = oci_fetch_assoc($allDataSQL)) {
											$number++;
										?>
											<tr>
												<td align="center"><?php echo $number; ?></td>
												<td>
													<?php
													echo 'Name: ' . $row['EMP_NAME'];
													echo '<br>';
													echo 'Login ID: ' . $row['RML_ID'];
													echo '<br>';
													echo 'Mobile: ' . $row['MOBILE_NO'];
													?>
												</td>
												<td>
													<?php
													echo 'Role: ' . $row['LEASE_USER'];
													echo '<br>';
													echo 'Zone: ' . $row['AREA_ZONE'];
													echo '<br>';
													echo 'User Type: ' . $row['USER_TYPE'];
													echo '<br>';
													if ($row['IS_ACTIVE'] == '1')
														echo 'User Status Active';
													else
														echo 'User Status In-Active';
													?>
												</td>


												<td align="center">

													<a href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>"><?php
																														echo '<button class="edit-user">update</button>';
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

	<?php require_once('layouts/footer.php'); ?>
<?php
session_start();
if ($_SESSION['user_role_id'] == 4 || $_SESSION['user_role_id'] == 3) {
	header('location:index.php?lmsg=true');
	exit;
}

if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
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
				<a href="">You will be respondible if you create any user. </a>
			</li>
		</ol>

		<div class="container-fluid">
			<form action="" method="post">
				<div class="row">

					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">

									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">Write Emp ID:</label>
											<input type="text" class="form-control" id="title" name="form_rml_id" required="">
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">Full Name:</label>
											<input type="text" class="form-control" id="title" name="emp_form_name" required="">
										</div>
									</div>



								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">Office Mobile No:</label>
											<input type="text" class="form-control" id="title" name="emp_mobile" required="">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">IEMI No:</label>
											<input type="text" class="form-control" id="title" name="emp_iemi">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">Zone Name:</label>
											<select required="" name="zone_name" class="form-control">
												<option selected value="">Select Zone Name</option>
												<?php
												require_once('inc/connoracle.php');
												$strSQL  = oci_parse($objConnect, "select distinct(ZONE)as AREA_NAME from MONTLY_COLLECTION
																										where is_active=1
																										order by ZONE");
												oci_execute($strSQL);
												while ($row = oci_fetch_assoc($strSQL)) {
												?>
													<option value="<?php echo $row['AREA_NAME']; ?>"><?php echo $row['AREA_NAME']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label for="title">User Role:</label>
											<select name="user_role" class="form-control" required="">
												<option selected value="">Select User Type</option>
												<option value="CC">Normal User</option>
												<option value="ZH">Zonal Head</option>
												<option value="AH">Area Head</option>
											</select>
										</div>
									</div>



								</div>
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group">
											<label for="title">Remarks:</label>
											<input type="text" class="form-control" id="title" name="remarks">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="md-form mt-5">
											<button type="submit" name="submit" class="btn btn-info">Create & Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>



					<?php
					$emp_session_id = $_SESSION['emp_id'];



					if (isset($_POST['form_rml_id']) && isset($_POST['emp_form_name']) && isset($_POST['user_role'])) {

						$form_rml_id = $_REQUEST['form_rml_id'];
						$emp_form_name = $_REQUEST['emp_form_name'];
						$emp_mobile = $_REQUEST['emp_mobile'];
						$emp_iemi = $_REQUEST['emp_iemi'];
						$zone_name = $_REQUEST['zone_name'];
						$user_role = $_REQUEST['user_role'];
						$remarks = $_REQUEST['remarks'];


						$strSQL  = oci_parse($objConnect, "INSERT INTO RML_COLL_APPS_USER (
                                                           EMP_NAME, 
                                                           PASS_MD5, 
                                                           IS_ACTIVE, 
                                                           RML_ID, 
                                                           MOBILE_NO, 
                                                           CREATED_DATE, 
                                                           IEMI_NO, 
                                                           LEASE_USER, 
                                                           USER_FOR,  
                                                           ACCESS_APP, 
                                                           AREA_ZONE, 
                                                           REMARKS, 
                                                           UPDATED_BY) 
                                    VALUES (
                                      '$emp_form_name' ,
                                      '202CB962AC59075B964B07152D234B70' ,
                                      1 ,
                                      '$form_rml_id' ,
                                      '$emp_mobile' ,
                                      SYSDATE ,
                                      '$emp_iemi' ,
                                      '$user_role' ,
                                      '' ,
                                     'RML_COLL' ,
                                      '$zone_name' ,
                                     '$remarks' ,
                                     '$emp_session_id' )");

						if (oci_execute($strSQL)) {
					?>

							<div class="container-fluid">
								<div class="md-form mt-5">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											User is Created successfully.
										</li>
									</ol>
								</div>
							</div>
					<?php
						}
					}
					?>
				</div>
				</from>
		</div>
		<div style="height: 1000px;"></div>
	</div>
	<!-- /.container-fluid-->


	<?php require_once('layouts/footer.php'); ?>
<?php
session_start();
if ($_SESSION['user_role_id'] != 2 && $_SESSION['user_role_id'] != 10 && $_SESSION['user_role_id']!= 15) {
	header('location:index.php?lmsg=true');
	exit;
}

require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_sidebar.php');
require_once('inc/connoracle.php');
$ref_id = $_REQUEST['ref_id'];
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="">Seized Information Changed & Corfirmation</a>
			</li>
		</ol>

		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">

					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<div class="row">
						<div class="col-sm-6">
							<input required="" type="text" class="form-control" id="title" placeholder="Ref-Code"
								name="ref_id" form="Form1">
						</div>
						<div class="col-sm-6">
							<div class="md-form mt-0">
								<input class="form-control btn btn-primary btn pull-right" type="submit"
									value="Search Code" form="Form1">
							</div>
						</div>
					</div>
					<hr>
				</div>



				<?php
				$emp_session_id = $_SESSION['emp_id'];
				if (isset($_POST['ref_id'])) {

					$strSQL = oci_parse($objConnect, "SELECT ID,DEPOT_LOCATION_CODE,
							                                          REF_ID,
																	  TEAM_MEMBER,
																	  DRIVER_NAME,
																      SEIZE_REASON,
																	  DEPOT_LOCATION,
																	  ENTRY_DATE,
																	  RUNNING_STATUS,
																	  TOTAL_EXPENSE,
																	  CHASSIS_CONDITION,
																	  BODY_CONDITION,
																	  ENGINE_CONDITION,
																	  BATTERY_CONDITION,
																	  NOC,
																	  ROPE,
																	  JACK,
																	  SPARE_TAYRE,
																	  BUCKET,
																	  DYNAMY,
																	  SELF,
																	  VEHICLE_PAPER,
																	  FRONT_GLASS,
																	  TOOLS_BOX,
																	  TRIPAL,
																	  KEY_STATUS,
																	  TO_CHAR(NVL(IS_CONFIRM,0)) AS IS_CONFIRM
																 FROM RML_COLL_SEIZE_DTLS
																WHERE REF_ID='$ref_id'
																and IS_CONFIRM=0");

					oci_execute($strSQL);
					while ($row = oci_fetch_assoc($strSQL)) {

						?>
						<div class="col-lg-12">
							<div class="md-form mt-2">
								<hr>
								<div class="row" style="border:.5px; border-style:solid; border-color:#666666; padding: 1em;">
									<div class="col-lg-12">
										<div class="row">

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Entry Date:</label>
													<input type="text" class="form-control" id="title"
														value="<?php echo $row['ENTRY_DATE']; ?>" readonly>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Team Member:</label>
													<input type="text" class="form-control" id="title" name="team_member"
														value="<?php echo $row['TEAM_MEMBER']; ?>" form="Form2">
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Driver Name:</label>
													<input type="text" class="form-control" id="title" name="driver_name"
														value="<?php echo $row['DRIVER_NAME']; ?>" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Seized Reason:</label>
													<input type="text" class="form-control" id="title"
														value="<?php echo $row['SEIZE_REASON']; ?>" readonly>
												</div>
											</div>
										</div>



										<div class="row">



											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Total Expense:</label>
													<input type="text" class="form-control" id="title" name="total_expense"
														value="<?php echo $row['TOTAL_EXPENSE']; ?>" form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Running Status:</label>
													<select required="" name="runnig_condition" class="form-control"
														form="Form2">
														<?php
														if ($row['RUNNING_STATUS'] == 'Running') {
															?>
															<option value="Running">Running</option>
															<option value="Not Running">Not Running</option>
															<?php
														} else if ($row['RUNNING_STATUS'] == 'Not Running') {
															?>
																<option value="Not Running">Not Running</option>
																<option value="Running">Running</option>
															<?php
														}
														?>

													</select>


												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Chasis Condition</label>

													<select required="" name="chasis_condition" class="form-control"
														form="Form2">
														<?php
														if ($row['CHASSIS_CONDITION'] == 'Good') {
															?>
															<option value="Good">Good</option>
															<option value="Partial">Partial</option>
															<option value="Bad">Bad</option>
															<?php
														} else if ($row['CHASSIS_CONDITION'] == 'Partial') {
															?>
																<option value="Partial">Partial</option>
																<option value="Good">Good</option>
																<option value="Bad">Bad</option>
															<?php
														} else if ($row['CHASSIS_CONDITION'] == 'Bad') {
															?>
																	<option value="Bad">Bad</option>
																	<option value="Good">Good</option>
																	<option value="Partial">Partial</option>

														<?php
														}
														?>

													</select>

												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Body Condition:</label>
													<select required="" name="body_condition" class="form-control" form="Form2">
														<?php
														if ($row['BODY_CONDITION'] == 'Good') {
															?>
															<option value="Good">Good</option>
															<option value="Partial">Partial</option>
															<option value="Bad">Bad</option>
															<?php
														} else if ($row['BODY_CONDITION'] == 'Partial') {
															?>
																<option value="Partial">Partial</option>
																<option value="Good">Good</option>
																<option value="Bad">Bad</option>
															<?php
														} else if ($row['BODY_CONDITION'] == 'Bad') {
															?>
																	<option value="Bad">Bad</option>
																	<option value="Good">Good</option>
																	<option value="Partial">Partial</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Engine Condition:</label>
													<select required="" name="eng_condition" class="form-control" form="Form2">
														<?php
														if ($row['ENGINE_CONDITION'] == 'Good') {
															?>
															<option value="Good">Good</option>
															<option value="Partial">Partial</option>
															<option value="Bad">Bad</option>
															<?php
														} else if ($row['ENGINE_CONDITION'] == 'Partial') {
															?>
																<option value="Partial">Partial</option>
																<option value="Good">Good</option>
																<option value="Bad">Bad</option>
															<?php
														} else if ($row['ENGINE_CONDITION'] == 'Bad') {
															?>
																	<option value="Bad">Bad</option>
																	<option value="Good">Good</option>
																	<option value="Partial">Partial</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Bettery Condition:</label>

													<select required="" name="bettery_condition" class="form-control"
														form="Form2">
														<?php
														if ($row['BATTERY_CONDITION'] == 'Good') {
															?>
															<option value="Good">Good</option>
															<option value="Partial">Partial</option>
															<option value="Bad">Bad</option>
															<?php
														} else if ($row['BATTERY_CONDITION'] == 'Partial') {
															?>
																<option value="Partial">Partial</option>
																<option value="Good">Good</option>
																<option value="Bad">Bad</option>
															<?php
														} else if ($row['BATTERY_CONDITION'] == 'Bad') {
															?>
																	<option value="Bad">Bad</option>
																	<option value="Good">Good</option>
																	<option value="Partial">Partial</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">NOC Complete?</label>

													<select required="" name="noc_condition" class="form-control" form="Form2">
														<?php
														if ($row['NOC'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['NOC'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>

												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Rope?</label>
													<select required="" name="rope_condition" class="form-control" form="Form2">
														<?php
														if ($row['ROPE'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['ROPE'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Jack?</label>
													<select required="" name="jack_condition" class="form-control" form="Form2">
														<?php
														if ($row['JACK'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['JACK'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Spare Tyre</label>

													<select required="" name="spare_tyre" class="form-control" form="Form2">
														<?php
														if ($row['SPARE_TAYRE'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['SPARE_TAYRE'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Bucket?</label>

													<select required="" name="bucket_condition" class="form-control"
														form="Form2">
														<?php
														if ($row['BUCKET'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['BUCKET'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>

												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Dynamy?</label>
													<select required="" name="dynamy_condition" class="form-control"
														form="Form2">
														<?php
														if ($row['DYNAMY'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['DYNAMY'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Self?</label>
													<select required="" name="self_condition" class="form-control" form="Form2">
														<?php
														if ($row['SELF'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['SELF'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Vehicle Paper?</label>

													<select required="" name="vehicle_papers" class="form-control" form="Form2">
														<?php
														if ($row['VEHICLE_PAPER'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['VEHICLE_PAPER'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Front Glass?</label>

													<select required="" name="front_glass" class="form-control" form="Form2">
														<?php
														if ($row['FRONT_GLASS'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['FRONT_GLASS'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>

												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Tool Box?</label>
													<select required="" name="tool_box" class="form-control" form="Form2">
														<?php
														if ($row['TOOLS_BOX'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['TOOLS_BOX'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Tripal?</label>
													<select required="" name="tripal_condition" class="form-control"
														form="Form2">
														<?php
														if ($row['TRIPAL'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['TRIPAL'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>

											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Keys?</label>

													<select required="" name="keys_condition" class="form-control" form="Form2">
														<?php
														if ($row['KEY_STATUS'] == '1') {
															?>
															<option value="1">Yes</option>
															<option value="0">No</option>
															<?php
														} else if ($row['KEY_STATUS'] == '0') {
															?>
																<option value="0">No</option>
																<option value="1">Yes</option>

														<?php
														}
														?>

													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Seized ID:</label>
													<input type="text" name="table_id" class="form-control" id="title"
														form="Form2" value="<?php echo $row['ID']; ?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Ref-Code:</label>
													<input type="text" name="ref_code_id" class="form-control" id="title"
														form="Form2" value="<?php echo $row['REF_ID']; ?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Depot Location Code:</label>
													<input type="text" required="" name="deoprt_location_code"
														class="form-control" form="Form2" id="title"
														value="<?php echo $row['DEPOT_LOCATION_CODE']; ?>" readonly>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label for="title">Depot Location:</label>
													<input type="text" required="" name="deoprt_location_details"
														class="form-control" form="Form2" id="title"
														value="<?php echo $row['DEPOT_LOCATION']; ?>" readonly>
												</div>
											</div>




										</div>


										<div class="row">
											<div class="col-lg-12">
												<div class="md-form mt-5">
													<button type="submit" name="submit" class="btn btn-info" form="Form2">Sized
														Confirm</button>
												</div>
											</div>
										</div>

									</div>
								</div>

							</div>
							<?php
					}
				}
				?>



				</div>

			</div>




			<?php
			$emp_session_id = $_SESSION['emp_id'];
			@$table_id = $_REQUEST['table_id'];
			@$v_ref_code = $_REQUEST['ref_code_id'];

			@$deoprt_location_code = $_REQUEST['deoprt_location_code'];
			@$deoprt_location_details = $_REQUEST['deoprt_location_details'];


			if (
				isset($_POST['table_id']) &&
				isset($_POST['ref_code_id']) &&
				isset($_POST['deoprt_location_details'])
			) {
				if (strlen($deoprt_location_code) > 2) {
					$strSQL = oci_parse(
						$objConnect,
						"begin update RML_COLL_SEIZE_DTLS set IS_CONFIRM=1,CONFIRM_DATE=SYSDATE where ref_id='$v_ref_code';APPS_TO_ERP_DATA($table_id,'$v_ref_code','$deoprt_location_code','$deoprt_location_details');end;"
					);
					if (@oci_execute($strSQL))
						echo 'Data Updated successfully.';
				} else {
					echo 'Sorry! You must be update deport location';
				}


			}
			?>
		</div>
	</div>



	<div style="height: 1000px;"></div>
</div>

<?php require_once('layouts/footer.php'); ?>
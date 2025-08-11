<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';

include_once('../../_helper/2step_com_conn.php');
$v_start_date = date('01/m/Y');
$v_end_date   = date('t/m/Y');
if (isset($_POST['start_date'])) {
	$v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
}
if (isset($_POST['end_date'])) {
	$v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
}

?>

<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">


		<div class="row">
			<div class="card rounded-4">
				<div class="card-body">

					<button class="accordion-button" style="color:#0dcaf0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
						aria-expanded="true" aria-controls="collapseOne">
						<strong><i class='bx bx-filter-alt'></i>Filter Data</strong>
					</button>
					<!-- <h5 class="card-title">Accordion Example</h5> -->
					<!-- <hr> -->
					<div class="accordion" id="accordionExample">
						<div class="accordion-item">

							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
								data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
										<div class="row justify-content-center align-items-center">
											<div class="col-sm-3">
												<label for="title">Select User Type:</label>
												<select required="" name="user_type" class="form-control">
													<option <?php echo isset($_POST['user_type']) && $_POST['user_type'] == '' ? 'selected' : ''; ?>
														value=""><-- Select Type --></option>
													<option <?php echo isset($_POST['user_type']) && $_POST['user_type'] == 'C-C' ? 'selected' : ''; ?>
														value="C-C">Collection - Collection</option>
													<option <?php echo isset($_POST['user_type']) && $_POST['user_type'] == 'S-C' ? 'selected' : ''; ?>
														value="S-C">Sales - Collection</option>

												</select>
											</div>
											<div class="col-sm-3">
												<label>Collection Start Date: </label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar">
														</i>
													</div>
													<input required="" class="form-control datepicker" name="start_date" type="text"
														value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('01-m-Y'); ?>' />
												</div>

											</div>
											<div class="col-sm-3">
												<label>Collection End Date: </label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar">
														</i>
													</div>
													<input required="" class="form-control datepicker" name="end_date" type="text"
														value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('t-m-Y'); ?>' />
												</div>

											</div>

											<div class="col-sm-2">
												<button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">Search Data<i
														class='bx bx-file-find'></i></button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="card rounded-4">
				<?php

				$headerType   = 'List';
				$leftSideName = 'Master Report';
				include('../../_includes/com_header.php');
				?>
				<div class="card-body">
					<?php
					if (isset($_POST['start_date'])) {
						$v_user_type  = trim($_REQUEST['user_type']);
						$v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
						$v_end_date   = date("d/m/Y", strtotime($_REQUEST['end_date']));
					?>
						<div class="row mt-3">
							<div class="col-sm-6 mt-3">
								<div class="md-form">
									<div class="resume-item d-flex flex-column flex-md-row">
										<table id="mainTable" class="small table-bordered">
											<thead class="bg-light">
												<tr style="width:100%" align="center">
													<th class="table-primary" colspan="6">==MAHINDRA & DONGFENG==<br>Collection Summary</th>
												</tr>
												<tr style="width:100%" class="table-danger">
													<th scope="col">
														<center>SL</center>
													</th>
													<th scope="col">
														<center>Zone</center>
													</th>
													<th scope="col">Zonal Head</th>
													<th scope="col">
														<center>Collection[MM]</center>
													</th>
													<th scope="col">
														<center>Collection[DF]</center>
													</th>
													<th scope="col">
														<center>Target(Current Month)</center>
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$mainQuary = "SELECT K.ZONE_NAME,RML_COLL_SUMOF_TARGET(K.ZONE_HEAD,'$v_start_date','$v_end_date') TARGET_AMOUNT,
												(SELECT P.EMP_NAME FROM RML_COLL_APPS_USER P WHERE P.RML_ID = K.ZONE_HEAD)ZH_NAME,
													(SELECT SUM (AMOUNT) TOTAL_AMOUNT
														FROM RML_COLL_MONEY_COLLECTION A, RML_COLL_APPS_USER B
														WHERE  A.RML_COLL_APPS_USER_ID = B.ID
														AND B.AREA_ZONE = K.ZONE_NAME
														AND TRUNC (A.CREATED_DATE) BETWEEN TO_DATE('$v_start_date','dd/mm/yyyy') AND TO_DATE('$v_end_date','dd/mm/yyyy')
														AND A.BRAND = 'MAHINDRA'
														AND B.USER_TYPE='$v_user_type'
													)MM_TOTAL,
													(SELECT SUM (AMOUNT) TOTAL_AMOUNT
														FROM RML_COLL_MONEY_COLLECTION A, RML_COLL_APPS_USER B
														WHERE  A.RML_COLL_APPS_USER_ID = B.ID
														AND B.AREA_ZONE = K.ZONE_NAME
														AND TRUNC (A.CREATED_DATE) BETWEEN TO_DATE('$v_start_date','dd/mm/yyyy') AND TO_DATE('$v_end_date','dd/mm/yyyy')
														AND A.BRAND = 'DONGFENG'
														AND B.USER_TYPE='$v_user_type'
													)DONG_TOTAL
													FROM COLL_EMP_ZONE_SETUP K
													WHERE K.IS_ACTIVE = 1
													AND K.USER_TYPE='$v_user_type'
													ORDER BY K.ZONE_NAME";
												// echo $mainQuary;
												$strSQL    = @oci_parse($objConnect, $mainQuary);

												@oci_execute($strSQL);
												$number             = 0;
												$MM_TOTAL           = 0;
												$DONG_TOTAL         = 0;
												$MM_TARGET_TOTAL    = 0;
												$V_INTERESTED_BRAND = 'MAHINDRA';

												while ($row = @oci_fetch_assoc($strSQL)) {
													$number++;

												?>
													<tr>
														<td align="center">
															<?php echo $number; ?>
														</td>
														<td align="center">
															<a target="_blank"
																href="collection_dtls.php?<?php echo '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&brand=' . $V_INTERESTED_BRAND . '&user_type=' . $v_user_type . '&zone=' . $row['ZONE_NAME']; ?>">
																<?php echo $row['ZONE_NAME']; ?>
															</a>
														</td>
														<td>
															<?php echo $row['ZH_NAME']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['MM_TOTAL']);
															$MM_TOTAL = $MM_TOTAL + $row['MM_TOTAL']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['DONG_TOTAL']);
															$DONG_TOTAL = $DONG_TOTAL + $row['DONG_TOTAL']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['TARGET_AMOUNT']);
															$MM_TARGET_TOTAL = $MM_TARGET_TOTAL + $row['TARGET_AMOUNT']; ?>
														</td>
													</tr>
												<?php
												}
												?>
												<tr class="p-3 mb-2 bg-success text-white">
													<td align="center"></td>
													<td align="center">
														<a target="_blank"
															href="collection_dtls.php?<?php echo '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&brand=' . $V_INTERESTED_BRAND . '&user_type=' . $v_user_type . '&zone=All'; ?>">
															<?php echo 'All'; ?>
														</a>
													</td>
													<td align="center">Total=</td>
													<td align="right">
														<?php echo number_format($MM_TOTAL); ?>
													</td>
													<td align="right">
														<?php echo number_format($DONG_TOTAL); ?>
													</td>
													<td align="right">
														<?php echo number_format($MM_TARGET_TOTAL); ?>
													</td>
												</tr>
											</tbody>

										</table>
									</div>
								</div>
							</div>
							<div class="col-sm-6 mt-3">
								<div class="md-form">
									<div class="resume-item d-flex flex-column flex-md-row">
										<table id="mainTable" class="small table-bordered">
											<thead class="bg-light">
												<tr style="width:100%" align="center">
													<th class="table-primary" colspan="7">=EICHER=</br>Collection Summary</th>
												</tr>
												<tr class="table-danger" style="width:100%">
													<th scope="col">
														<center>SL</center>
													</th>
													<th scope="col">Zone</th>
													<th scope="col">ZH</th>
													<th scope="col">
														<center>Total Collection</center>
													</th>
													<th scope="col">
														<center>Truck Total</center>
													</th>
													<th scope="col">
														<center>Bus Total</center>
													</th>
													<th scope="col">
														<center>Others Total</center>
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$SQL = "SELECT 
												K.ZONE_NAME,
												(SELECT EMP_NAME from RML_COLL_APPS_USER WHERE RML_ID=K.ZONE_HEAD) ZH_NAME,
												(
												SELECT sum(AMOUNT) TOTAL_AMOUNT 
													FROM RML_COLL_MONEY_COLLECTION A,RML_COLL_APPS_USER B
														WHERE A.RML_COLL_APPS_USER_ID=B.ID
														AND B.AREA_ZONE=K.ZONE_NAME
														AND trunc(A.CREATED_DATE) between to_date('$v_start_date','dd/mm/yyyy') 
																						and to_date('$v_end_date','dd/mm/yyyy')
														AND A.BRAND='EICHER'
														AND B.USER_TYPE='$v_user_type'
												) EICHER_TOTAL,
												(
												SELECT sum(AMOUNT) TOTAL_AMOUNT 
													FROM RML_COLL_MONEY_COLLECTION A,RML_COLL_APPS_USER B
														WHERE A.RML_COLL_APPS_USER_ID=B.ID
														AND B.AREA_ZONE=K.ZONE_NAME
														AND trunc(A.CREATED_DATE) between to_date('$v_start_date','dd/mm/yyyy') 
																						and to_date('$v_end_date','dd/mm/yyyy')
														AND A.BRAND='EICHER'
														AND B.USER_TYPE='$v_user_type'
														AND PRODUCT_TYPE in ('Truck')
												) TRUCK_TOTAL,
												(
												SELECT sum(AMOUNT) TOTAL_AMOUNT 
													FROM RML_COLL_MONEY_COLLECTION A,RML_COLL_APPS_USER B
														WHERE A.RML_COLL_APPS_USER_ID=B.ID
														AND B.AREA_ZONE=K.ZONE_NAME
														AND trunc(A.CREATED_DATE) between to_date('$v_start_date','dd/mm/yyyy') 
																						and to_date('$v_end_date','dd/mm/yyyy')
														AND A.BRAND='EICHER'
														AND B.USER_TYPE='$v_user_type'
														AND A.PRODUCT_TYPE in ('LCB','HCB','BUS')
												) BUS_TOTAL,
												(
												SELECT sum(AMOUNT) TOTAL_AMOUNT 
													FROM RML_COLL_MONEY_COLLECTION A,RML_COLL_APPS_USER B
														WHERE A.RML_COLL_APPS_USER_ID=B.ID
														AND B.AREA_ZONE=K.ZONE_NAME
														AND trunc(A.CREATED_DATE) between to_date('$v_start_date','dd/mm/yyyy') and to_date('$v_end_date','dd/mm/yyyy')
														AND A.BRAND='EICHER'
														AND B.USER_TYPE='$v_user_type'
														AND A.PRODUCT_TYPE in ('Others')
												) OTHERS_TOTAL
												FROM COLL_EMP_ZONE_SETUP K
													WHERE K.IS_ACTIVE=1
													AND K.USER_TYPE='$v_user_type'
												ORDER BY K.ZONE_NAME";
												$strSQL = oci_parse(
													$objConnect,
													$SQL
												);


												oci_execute($strSQL);
												$number       = 0;
												$EICHER_TOTAL = 0;
												$TRUCK_TOTAL  = 0;
												$BUS_TOTAL    = 0;
												$OTHERS_TOTAL = 0;

												while ($row = oci_fetch_assoc($strSQL)) {
													$number++;

												?>
													<tr>
														<td align="center">
															<?php echo $number; ?>
														</td>
														<td align="center">
															<a target="_blank"
																href="collection_dtls.php?<?php echo '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&brand=EICHER&user_type=' . $v_user_type . '&zone=' . $row['ZONE_NAME']; ?>">
																<?php echo $row['ZONE_NAME']; ?>
															</a>
														</td>
														<td>
															<?php echo $row['ZH_NAME']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['EICHER_TOTAL'], 0);
															$EICHER_TOTAL = $EICHER_TOTAL + $row['EICHER_TOTAL']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['TRUCK_TOTAL']);
															$TRUCK_TOTAL = $TRUCK_TOTAL + $row['TRUCK_TOTAL']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['BUS_TOTAL']);
															$BUS_TOTAL = $BUS_TOTAL + $row['BUS_TOTAL']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['OTHERS_TOTAL']);
															$OTHERS_TOTAL = $OTHERS_TOTAL + $row['OTHERS_TOTAL']; ?>
														</td>
													</tr>
												<?php
												}
												?>
												<tr class="p-3 mb-2 bg-success text-white">
													<td align="center"></td>
													<td align="center">
														<a target="_blank"
															href="collection_dtls.php?<?php echo '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&brand=EICHER&user_type=' . $v_user_type . '&zone=All'; ?>">
															<?php echo 'All'; ?>
														</a>
													</td>
													<td align="center">Total=</td>
													<td align="right">
														<?php echo number_format($EICHER_TOTAL); ?>
													</td>
													<td align="right">
														<?php echo number_format($TRUCK_TOTAL); ?>
													</td>
													<td align="right">
														<?php echo number_format($BUS_TOTAL); ?>
													</td>
													<td align="right">
														<?php echo number_format($OTHERS_TOTAL); ?>
													</td>
												</tr>
											</tbody>

										</table>
									</div>
								</div>
							</div>
							<div class="col-sm-6 mt-3">
								<div class="md-form">
									<div class="resume-item d-flex flex-column flex-md-row">
										<table id="mainTable" class="small table-bordered">
											<thead class="bg-light">
												<tr style="width:100%" align="center">
													<th class="table-primary" colspan="5">==DONGFENG==<br>Collection Summary</th>
												</tr>
												<tr style="width:100%" class="table-danger">
													<th scope="col">
														<center>SL</center>
													</th>
													<th scope="col">
														<center>Zone</center>
													</th>
													<th scope="col">Zonal Head</th>
													<th scope="col">
														<center>Collection</center>
													</th>
													<th scope="col">
														<center>Target(Current Month)</center>
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$mainQuary = "SELECT K.ZONE_NAME,RML_COLL_SUMOF_TARGET(K.ZONE_HEAD,'$v_start_date','$v_end_date') TARGET_AMOUNT,
												(SELECT P.EMP_NAME FROM RML_COLL_APPS_USER P WHERE P.RML_ID = K.ZONE_HEAD)ZH_NAME,
													(SELECT SUM (AMOUNT) TOTAL_AMOUNT
														FROM RML_COLL_MONEY_COLLECTION A, RML_COLL_APPS_USER B
														WHERE  A.RML_COLL_APPS_USER_ID = B.ID
														AND B.AREA_ZONE = K.ZONE_NAME
														AND TRUNC (A.CREATED_DATE) BETWEEN TO_DATE('$v_start_date','dd/mm/yyyy') AND TO_DATE('$v_end_date','dd/mm/yyyy')
														AND A.BRAND = 'DONGFENG'
														AND B.USER_TYPE='$v_user_type'
													)MM_TOTAL
													FROM COLL_EMP_ZONE_SETUP K
													WHERE K.IS_ACTIVE = 1
													AND K.USER_TYPE='$v_user_type'
													ORDER BY K.ZONE_NAME";
												// echo $mainQuary;
												$strSQL    = @oci_parse($objConnect, $mainQuary);

												@oci_execute($strSQL);
												$number             = 0;
												$MM_TOTAL           = 0;
												$MM_TARGET_TOTAL    = 0;
												$V_INTERESTED_BRAND = 'DONGFENG';

												while ($row = @oci_fetch_assoc($strSQL)) {
													$number++;

												?>
													<tr>
														<td align="center">
															<?php echo $number; ?>
														</td>
														<td align="center">
															<a target="_blank"
																href="collection_dtls.php?<?php echo '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&brand=' . $V_INTERESTED_BRAND . '&user_type=' . $v_user_type . '&zone=' . $row['ZONE_NAME']; ?>">
																<?php echo $row['ZONE_NAME']; ?>
															</a>
														</td>
														<td>
															<?php echo $row['ZH_NAME']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['MM_TOTAL']);
															$MM_TOTAL = $MM_TOTAL + $row['MM_TOTAL']; ?>
														</td>
														<td align="right">
															<?php echo number_format($row['TARGET_AMOUNT']);
															$MM_TARGET_TOTAL = $MM_TARGET_TOTAL + $row['TARGET_AMOUNT']; ?>
														</td>
													</tr>
												<?php
												}
												?>
												<tr class="p-3 mb-2 bg-success text-white">
													<td align="center"></td>
													<td align="center">
														<a target="_blank"
															href="collection_dtls.php?<?php echo '&start_date=' . $v_start_date . '&end_date=' . $v_end_date . '&brand=' . $V_INTERESTED_BRAND . '&user_type=' . $v_user_type . '&zone=All'; ?>">
															<?php echo 'All'; ?>
														</a>
													</td>
													<td align="center">Total=</td>
													<td align="right">
														<?php echo number_format($MM_TOTAL); ?>
													</td>
													<td align="right">
														<?php echo number_format($MM_TARGET_TOTAL); ?>
													</td>
												</tr>
											</tbody>

										</table>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>

				</div>
			</div>
		</div><!--end row-->

	</div>
</div>
<!--end page wrapper -->
<?php
include_once('../../_includes/footer_info.php');
include_once('../../_includes/footer.php');
?>
<script>
	//delete data processing

	$('.single-select').select2({
		theme: 'bootstrap4',
		width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
		placeholder: $(this).data('placeholder'),
		allowClear: Boolean($(this).data('allow-clear')),
	});

	$('.datepicker').pickadate({
		selectMonths: true,
		selectYears: true,
		format: 'dd-mm-yyyy' // Specify your desired date format
	});
</script>
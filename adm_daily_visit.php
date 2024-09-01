<?php
session_start();
$exit_status = 0;
if ($_SESSION['user_role_id'] == 2 || $_SESSION['user_role_id'] == 8 || $_SESSION['user_role_id'] == 3) {
	$exit_status = 1;
}
require_once ('inc/config.php');
require_once ('layouts/header.php');
require_once ('layouts/left_sidebar.php');
require_once ('inc/connoracle.php');

?>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="">DAILY VISIT MONITORING REPORT</a>
			</li>
		</ol>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
							<div class="col-sm-3">
								<label for="title">Select Concern:</label>
								<select name="created_id" id="created_id" class="form-control">
									<option selected value="">--ALL--</option>
									<?php
									$strSQL = oci_parse(
										$objConnect,
										"SELECT unique CREATED_BY,
									   (SELECT B.EMP_NAME FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) EMP_NAME
										from RML_COLL_VISIT_ASSIGN BB
										order by CREATED_BY"
									);

									oci_execute($strSQL);
									while ($row = oci_fetch_assoc($strSQL)) {

										?>

										<option value="<?php echo $row['CREATED_BY']; ?>"><?php echo $row['EMP_NAME']; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="title">Select Zone:</label>
								<select name="area_zone" class="form-control">
									<option selected value="">--ALL--</option>
									<?php
									$strSQL = oci_parse(
										$objConnect,
										"SELECT unique AREA_ZONE FROM
									(select (SELECT B.AREA_ZONE FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) AREA_ZONE
									from RML_COLL_VISIT_ASSIGN BB)
									order by AREA_ZONE"
									);

									oci_execute($strSQL);
									while ($row = oci_fetch_assoc($strSQL)) {

										?>

										<option value="<?php echo $row['AREA_ZONE']; ?>"><?php echo $row['AREA_ZONE']; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="title">Visit Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar">
										</i>
									</div>
									<input required="" class="form-control" name="start_date" type="date" />
								</div>
							</div>
							<div class="col-sm-3">
								<label for="title">&nbsp;</label>
								<input class="form-control btn btn-primary" type="submit" placeholder="Search" aria-label="Search" value="Search">
							</div>

						</div>

					</form>
				</div>

				<div class="col-lg-12">
					<div class="md-form mt-5">
						<div class="resume-item d-flex flex-column flex-md-row">
							<table class="table table-striped table-bordered table-sm table-responsive" id="table" cellspacing="0" width="100%">
								<thead class="thead-dark">
									<tr>
										<th scope="col">Sl</th>
										<th scope="col">
											<center>Visit Date</center>
										</th>
										<th scope="col">
											<center>Ref-Code</center>
										</th>
										<th scope="col">
											<center>Collection Concern</center>
										</th>
										<th scope="col">
											<center>Zone Name</center>
										</th>
										<th scope="col">
											<center>Target Place</center>
										</th>
										<th scope="col">
											<center>Visited Place</center>
										</th>
										<th scope="col">
											<center>Customer Name</center>
										</th>
										<th scope="col">
											<center>Monthly EMI</center>
										</th>
										<th scope="col">
											<center>Collected Amount</center>
										</th>
										<th scope="col">
											<center>Customer Feedback</center>
										</th>
										<th scope="col">
											<center>Next Followup Date</center>
										</th>
									</tr>
								</thead>

								<tbody>

									<?php
									$LOGIN_ID = $_SESSION['emp_id'];


									if (isset($_POST['start_date'])) {
										$emp_id          = (int) (explode("RML-", $LOGIN_ID)[1]);
										$v_created_id    = $_REQUEST['created_id'];
										$v_area_zone     = $_REQUEST['area_zone'];
										$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));

										if (($_SESSION['user_role_id'] == 3)) {
											$strSQL = oci_parse(
												$objConnect,
												"SELECT 
										         bb.REF_ID,
										         bb.CREATED_BY,
												(select AREA_ZONE from RML_COLL_APPS_USER where RML_ID=bb.CREATED_BY) AREA_ZONE,
											    (SELECT B.EMP_NAME FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) CONCERN_NAME,
												bb.ASSIGN_DATE,
											   COLL_VISIT_STATU(bb.CREATED_BY,bb.REF_ID,TO_DATE('$attn_start_date','dd/mm/yyyy')) VISIT_STATUS,
											   bb.CUSTOMER_REMARKS,
											   RML_COLL_FAIL_TO_ASSIGN_VISIT(bb.REF_ID,bb.ASSIGN_DATE) NEXT_ASSIGN_INFO,
											   bb.VISIT_LOCATION,
											   COLL_VISIT_LAT(bb.CREATED_BY,bb.REF_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),'LAT') VISITED_LOCATION_LAT,
											   COLL_VISIT_LAT(bb.CREATED_BY,bb.REF_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),'LANG') VISITED_LOCATION_LANG,
											   BB.CUSTOMER_NAME,
											   (SELECT  NVL(SUM(C.AMOUNT),0) FROM RML_COLL_MONEY_COLLECTION C
                                                                  WHERE C.REF_ID=bb.REF_ID
                                                                    AND TRUNC(C.CREATED_DATE)=TO_DATE('$attn_start_date','dd/mm/yyyy')) COLLECTION_AMOUNT,
											   BB.INSTALLMENT_AMOUNT
									FROM RML_COLL_VISIT_ASSIGN bb
										 WHERE bb.ASSIGN_DATE=TO_DATE('$attn_start_date','dd/mm/yyyy')
										 AND bb.IS_ACTIVE=1
										 AND ('$v_created_id' IS NULL OR bb.CREATED_BY='$v_created_id')
										 order by bb.CREATED_BY"
											);

										}
										else {
											$strSQL = oci_parse(
												$objConnect,
												"SELECT 
										        BB.REF_ID,
										        BB.CREATED_BY,
												AA.AREA_ZONE,
											    AA.EMP_NAME CONCERN_NAME,
												BB.ASSIGN_DATE,
											    COLL_VISIT_STATU(bb.CREATED_BY,bb.REF_ID,TO_DATE('$attn_start_date','dd/mm/yyyy')) VISIT_STATUS,
											    BB.CUSTOMER_REMARKS,
											    RML_COLL_FAIL_TO_ASSIGN_VISIT(bb.REF_ID,bb.ASSIGN_DATE) NEXT_ASSIGN_INFO,
											    BB.VISIT_LOCATION,
											    COLL_VISIT_LAT(bb.CREATED_BY,bb.REF_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),'LAT') VISITED_LOCATION_LAT,
											    COLL_VISIT_LAT(bb.CREATED_BY,bb.REF_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),'LANG') VISITED_LOCATION_LANG,
											    BB.CUSTOMER_NAME,
											    (SELECT  NVL(SUM(C.AMOUNT),0) FROM RML_COLL_MONEY_COLLECTION C
                                                                  WHERE C.REF_ID=bb.REF_ID
                                                                    AND TRUNC(C.CREATED_DATE)=TO_DATE('$attn_start_date','dd/mm/yyyy')) COLLECTION_AMOUNT,
											   BB.INSTALLMENT_AMOUNT
									FROM RML_COLL_VISIT_ASSIGN bb,RML_COLL_APPS_USER aa
										 WHERE BB.CREATED_BY=AA.RML_ID
										 AND bb.ASSIGN_DATE=TO_DATE('$attn_start_date','dd/mm/yyyy')
										 AND bb.IS_ACTIVE=1
										 AND ('$v_created_id' IS NULL OR bb.CREATED_BY='$v_created_id')
										 AND ('$v_area_zone' IS NULL OR AA.AREA_ZONE='$v_area_zone')
										 order by bb.CREATED_BY"
											);

										}
										oci_execute($strSQL);
										$number = 0;

										while ($row = oci_fetch_assoc($strSQL)) {
											$number++;
											?>
											<tr>
												<td><?php echo $number; ?></td>
												<td align="center"><?php echo $row['ASSIGN_DATE']; ?></td>
												<td><?php echo $row['REF_ID']; ?></td>
												<td><?php echo $row['CONCERN_NAME']; ?></td>
												<td><?php echo $row['AREA_ZONE']; ?></td>
												<td><?php echo $row['VISIT_LOCATION']; ?></td>
												<td><?php //echo $row['VISITED_LOCATION_LAT'];
														$lat  = $row['VISITED_LOCATION_LAT'];
														$long = $row['VISITED_LOCATION_LANG'];
														if ($number == 1) {
															$golbalLat_1  = $lat;
															$golbalLang_1 = $long;

														}
														else if ($number == 2) {
															$golbalLat_2  = $lat;
															$golbalLang_2 = $long;
														}


														$geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=AIzaSyBDQDOeUoFxB8GptvYRk9f_lR1UFRawVO0";
														$ch      = curl_init();
														curl_setopt($ch, CURLOPT_URL, $geocode);
														curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
														curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
														curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
														curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
														$response = curl_exec($ch);
														curl_close($ch);
														$output    = json_decode($response);
														$dataarray = get_object_vars($output);
														if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
															if (isset($dataarray['results'][0]->formatted_address)) {

																$address = $dataarray['results'][0]->formatted_address;
															}
															else {
																$address = '';

															}
														}
														else {
															$address = '';
														}
														echo $address;
														if ($number == 1) {
															$firstLocationAddress = $address;
														}
														else if ($number == 2) {
															$secondLocationAddress = $address;
														}

														?>
												</td>

												<td><?php echo $row['CUSTOMER_NAME']; ?></td>
												<td><?php echo $row['INSTALLMENT_AMOUNT']; ?></td>
												<td><?php echo $row['COLLECTION_AMOUNT']; ?></td>
												<td><?php echo @explode("@@@", $row['NEXT_ASSIGN_INFO'])[1]; ?></td>
												<td><?php echo @explode("@@@", $row['NEXT_ASSIGN_INFO'])[0]; ?></td>


											</tr>
											<?php
										}
									}
									?>

								</tbody>

							</table>
						</div>
						<div>


							<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div style="height: 1000px;"></div>
	</div>
	<!-- /.container-fluid-->

	<script>
		$('#created_id').select2({
			selectOnClose: true
		});



		function exportF(elem) {
			var table = document.getElementById("table");
			var html = table.outerHTML;
			var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
			elem.setAttribute("href", url);
			elem.setAttribute("download", "Visit Assign Report.xls"); // Choose the file name
			return false;
		}
	</script>
	<?php require_once ('layouts/footer.php'); ?>
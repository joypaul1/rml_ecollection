<?php
session_start();

if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
	header('location:index.php?lmsg=true');
	exit;
}
require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_sidebar.php');


require_once('inc/connoracle.php');

$USER_ID   = (int) preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
$USER_ROLE = getUserAccessRoleByID($_SESSION['user_role_id']);


?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="content-wrapper">
	<div class="container-fluid">
		<div class="row p-3">
			<div class="col-lg-12">
				<form action="" method="post">
					<div class="row">
						<div class="col-sm-3">
							<label for="title">Select User Type:</label>
							<select required="" name="user_type" class="form-control">
								<option <?php echo isset($_POST['user_type']) ? $_REQUEST['user_type'] == '' ? 'selected' : '' : '' ?> value="">-----
								</option>
								<option <?php echo isset($_POST['user_type']) ? $_REQUEST['user_type'] == 'C-C' ? 'selected' : '' : '' ?> value="C-C">
									Collection - Collection</option>
								<option <?php echo isset($_POST['user_type']) ? $_REQUEST['user_type'] == 'S-C' ? 'selected' : '' : '' ?> value="S-C">
									Sales -
									Collection</option>
							</select>

						</div>
						<div class="col-sm-3">
							<label for="title">Entry From:</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<input required="" class="form-control" type='date' name='start_date'
									value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01'); ?>' />
							</div>
						</div>
						<div class="col-sm-3">
							<label for="title">Entry To:</label>
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-calendar"> </i></div>
								<input required="" class="form-control" type='date' name='end_date'
									value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t'); ?>' />
							</div>
						</div>
						<div class="col-sm-3">
							<label for="title"> &nbsp; </label>
							<input class="form-control btn btn-primary" type="submit" value="Load Data">
						</div>
					</div>

				</form>
			</div>
		</div>


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
										<th class="table-primary" colspan="5">==MAHINDRA==<br>Collection Summary</th>
									</tr>
									<tr style="width:100%" class="table-danger">
										<th scope="col">
											<center>SL</center>
										</th>
										<th scope="col">
											<center>Zone Name</center>
										</th>
										<th scope="col">Zonal Head</th>
										<th scope="col">
											<center>Collection[MM]</center>
										</th>
										<th scope="col">
											<center>Target(Current Month)</center>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$mainQuary = "SELECT K.ZONE_NAME,RML_COLL_SUMOF_TARGET(K.ZONE_HEAD,'$v_start_date','$v_end_date') TARTET_AMOUNT,
										 (SELECT P.EMP_NAME FROM RML_COLL_APPS_USER P WHERE P.RML_ID = K.ZONE_HEAD)ZH_NAME,
										 (
										 SELECT SUM (AMOUNT) TOTAL_AMOUNT
											FROM RML_COLL_MONEY_COLLECTION A, RML_COLL_APPS_USER B
										   WHERE     A.RML_COLL_APPS_USER_ID = B.ID
												 AND B.AREA_ZONE = K.ZONE_NAME
												 AND TRUNC (A.CREATED_DATE) BETWEEN TO_DATE ('$v_start_date','dd/mm/yyyy') AND TO_DATE ('$v_end_date','dd/mm/yyyy')
												 AND A.BRAND = 'MAHINDRA'
												 AND B.USER_TYPE='$v_user_type'
										 )
											MM_TOTAL
									FROM COLL_EMP_ZONE_SETUP K
								   WHERE K.IS_ACTIVE = 1
								   AND K.USER_TYPE='$v_user_type'
								ORDER BY K.ZONE_NAME";
									//echo $mainQuary;								
									$strSQL = oci_parse($objConnect, $mainQuary);


									oci_execute($strSQL);
									$number             = 0;
									$MM_TOTAL           = 0;
									$MM_TARGET_TOTAL    = 0;
									$V_INTERESTED_BRAND = 'MAHINDRA';

									while ($row = oci_fetch_assoc($strSQL)) {
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
												<?php echo number_format($row['MM_TOTAL'], 2);
												$MM_TOTAL = $MM_TOTAL + $row['MM_TOTAL']; ?>
											</td>
											<td align="right">
												<?php echo number_format($row['TARTET_AMOUNT'], 2);
												$MM_TARGET_TOTAL = $MM_TARGET_TOTAL + $row['TARTET_AMOUNT']; ?>
											</td>
										</tr>
										<?php
									}
									?>
									<tr class="p-3 mb-2 bg-success text-white">
										<td align="center"></td>
										<td align="center"></td>
										<td align="center">Total=</td>
										<td align="center">
											<?php echo number_format($MM_TOTAL, 2); ?>
										</td>
										<td align="center">
											<?php echo number_format($MM_TARGET_TOTAL, 2); ?>
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
										<th scope="col">Zone Name</th>
										<th scope="col">Zonal Head</th>
										<th scope="col">
											<center>Collection Total</center>
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
									$strSQL = oci_parse($objConnect,
										"SELECT 
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
								    ORDER BY K.ZONE_NAME");


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
											<td align="center">
												<?php echo $row['EICHER_TOTAL'];
												$EICHER_TOTAL = $EICHER_TOTAL + $row['EICHER_TOTAL']; ?>
											</td>
											<td align="center">
												<?php echo $row['TRUCK_TOTAL'];
												$TRUCK_TOTAL = $TRUCK_TOTAL + $row['TRUCK_TOTAL']; ?>
											</td>
											<td align="center">
												<?php echo $row['BUS_TOTAL'];
												$BUS_TOTAL = $BUS_TOTAL + $row['BUS_TOTAL']; ?>
											</td>
											<td align="center">
												<?php echo $row['OTHERS_TOTAL'];
												$OTHERS_TOTAL = $OTHERS_TOTAL + $row['OTHERS_TOTAL']; ?>
											</td>
										</tr>
										<?php
									}
									?>
									<tr class="p-3 mb-2 bg-success text-white">
										<td align="center"></td>
										<td align="center"></td>
										<td align="center">Total=</td>
										<td align="center">
											<?php echo $EICHER_TOTAL; ?>
										</td>
										<td align="center">
											<?php echo $TRUCK_TOTAL; ?>
										</td>
										<td align="center">
											<?php echo $BUS_TOTAL; ?>
										</td>
										<td align="center">
											<?php echo $OTHERS_TOTAL; ?>
										</td>
									</tr>
								</tbody>

							</table>
						</div>
					</div>
				</div>





				<?php
		}
		?>
		</div>




	</div>
</div>


<hr>
<!-- /.container-fluid-->
<!-- <div style="height: 1000px;"></div> -->

<?php require_once('layouts/footer.php'); ?>
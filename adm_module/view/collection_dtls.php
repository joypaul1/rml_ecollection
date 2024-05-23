<?php
include_once ('../../_helper/2step_com_conn.php');


$v_rml_id = $_REQUEST['login_id'];


$v_brand         = $_REQUEST['brand'];
$v_user_type     = $_REQUEST['user_type'];
$v_zone          = $_REQUEST['zone'];
$start_date = $_REQUEST['start_date'];
$end_date   = $_REQUEST['end_date'];

?>

<!--start page wrapper -->
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="page-content">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="">Collection=><?php echo $v_brand . '=>' . $v_user_type; ?></a>
				</li>
			</ol>

			<div class="row">
				<div class="col-lg-12">
					<div class="md-form">
						<div class="resume-item d-flex flex-column flex-md-row">
							<table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%">
								<thead class="bg-light">
									<tr>
										<th scope="col">Sl</th>
										<th scope="col">
											<center>DSE Name</center>
										</th>
										<th scope="col">
											<center>Ref-Code</center>
										</th>
										<th scope="col">
											<center>Amnt</center>
										</th>
										<th scope="col">
											<center>Product</center>
										</th>
										<th scope="col">
											<center>Date</center>
										</th>
										<th scope="col">
											<center>Time</center>
										</th>
										<th scope="col">
											<center>Zone</center>
										</th>
										<th scope="col">
											<center>Pay Type</center>
										</th>
										<th scope="col">
											<center>Bank</center>
										</th>
									</tr>
								</thead>

								<tbody>

									<?php

									if ($v_zone == 'All') {
										$strSQL = oci_parse(
											$objConnect,
											"select b.RML_ID,
							           b.EMP_NAME,
									   a.REF_ID,
									   AMOUNT,
									   a.PRODUCT_TYPE,
									   PAY_TYPE,
									   BANK,
									   MEMO_NO,
									   INSTALLMENT_AMOUNT,
									   TO_CHAR(a.CREATED_DATE,'DD/MM/YYYY') CREATED_DATE,
									   TO_CHAR(a.CREATED_DATE,'hh:mi:ssam') CREATED_TIME,
									   B.AREA_ZONE
                                FROM RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER B 
                                    where a.RML_COLL_APPS_USER_ID=b.ID
									AND BRAND='$v_brand'
									AND B.USER_TYPE='$v_user_type'
                                    AND trunc(a.CREATED_DATE) between to_date('$start_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')"
										);
									}
									else {
										$strSQL = oci_parse(
											$objConnect,
											"select b.RML_ID,
							           b.EMP_NAME,
									   a.REF_ID,
									   AMOUNT,
									   a.PRODUCT_TYPE,
									   PAY_TYPE,
									   BANK,
									   MEMO_NO,
									   INSTALLMENT_AMOUNT,
									   TO_CHAR(a.CREATED_DATE,'DD/MM/YYYY') CREATED_DATE,
									   TO_CHAR(a.CREATED_DATE,'hh:mi:ssam') CREATED_TIME,
									   B.AREA_ZONE
                                FROM RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER B 
                                    where a.RML_COLL_APPS_USER_ID=b.ID
									AND BRAND='$v_brand'
									AND B.AREA_ZONE='$v_zone'
									AND B.USER_TYPE='$v_user_type'
                                    AND trunc(a.CREATED_DATE) between to_date('$start_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')"
										);
									}


									oci_execute($strSQL);
									$number = 0;

									while ($row = oci_fetch_assoc($strSQL)) {
										$number++;
										?>
										<tr>
											<td><?php echo $number; ?></td>
											<td><?php echo $row['EMP_NAME']; ?></td>
											<td><?php echo $row['REF_ID']; ?></td>
											<td><?php echo number_format($row['AMOUNT']); ?></td>
											<td><?php echo $row['PRODUCT_TYPE']; ?></td>
											<td><?php echo $row['CREATED_DATE']; ?></td>
											<td><?php echo $row['CREATED_TIME']; ?></td>
											<td align="center"><?php echo $row['AREA_ZONE']; ?></td>
											<td><?php echo $row['PAY_TYPE']; ?></td>
											<td><?php echo $row['BANK']; ?></td>
										</tr>
										<?php
									}
									?>

								</tbody>

							</table>
						</div>
						<div class="d-block text-end">
							<a class="btn btn-sm btn-success" onclick="exportF(this)">Export To Excel  <i class='bx bxs-cloud-download'></i></a>
						</div>
					</div>
				</div>


			</div><!--end row-->

		</div>
	</div>
</div>

<script>
	function exportF(elem) {
		var table = document.getElementById("table");
		var html = table.outerHTML;
		var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		elem.setAttribute("href", url);
		elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
		return false;
	}
</script>
<!--end page wrapper -->
<?php
include_once ('../../_includes/footer_info.php');
include_once ('../../_includes/footer.php');
?>
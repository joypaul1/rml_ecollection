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

include_once ('../../_helper/2step_com_conn.php');


?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">
            <div class="card rounded-4">
                <div class="card-body">

                    <button class="accordion-button" style="color:#0dcaf0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <strong><i class='bx bx-filter-alt'></i> Filter Data</strong>
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
                                            <div class="col-sm-4">
                                                <label>Select Your Concern :</label>
                                                <select name="created_id" id="created_id" class="form-control single-select">
                                                    <option selected value="">--ALL--</option>
                                                    <?php
                                                    $strSQL = @oci_parse(
                                                        $objConnect,
                                                        "SELECT unique CREATED_BY,
                                                        (SELECT B.EMP_NAME FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) EMP_NAME
                                                        from RML_COLL_VISIT_ASSIGN BB
                                                        order by CREATED_BY"
                                                    );
                                                    @oci_execute($strSQL);
                                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                                        ?>
                                                        <option value="<?php echo $row['CREATED_BY']; ?>"><?php echo $row['EMP_NAME']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="col-sm-3">
                                                <label>Visit Start Date: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" name="start_date" type="text"
                                                        value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('d-m-Y'); ?>' />
                                                </div>

                                            </div>
                                            <div class="col-sm-3">
                                                <label>Visit End Date: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" name="end_date" type="text"
                                                        value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('t-m-Y'); ?>' />
                                                </div>

                                            </div>
                                            <!--  -->

                                            <div class="col-sm-2">
                                                <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">Search Data <i
                                                        class='bx bx-file-find'></i>
                                                </button>
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
                $leftSideName = 'CONCERN VISIT MONITORING REPORT';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
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
                                        <center>Last Target Place</center>
                                    </th>
                                    <th scope="col">
                                        <center>Last Visited Place</center>
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
                                        <center>Target Units</center>
                                    </th>
                                    <th scope="col">
                                        <center>No. Of Visit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Brand</center>
                                    </th>
                                    <th scope="col">
                                        <center>Last Reason Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>Last Customer Feedback</center>
                                    </th>
                                    <!-- <th scope="col"><center>Next Followup Date</center></th>  -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $LOGIN_ID = $_SESSION['ECOL_USER_INFO']['emp_id'];


                                if (isset($_POST['start_date'])) {
                                    $emp_id       = (int) (explode("RML-", $LOGIN_ID)[1]);
                                    $v_created_id = $_REQUEST['created_id'];
                                    $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                    $v_end_date   = date("d/m/Y", strtotime($_REQUEST['end_date']));

                                    $start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));


                                    $sqlQuery = "SELECT A.REF_CODE,
										    LAST_REASON_CODE(A.REF_CODE) LAST_REASON_CODE,
											LAST_VISIT_LOCATION(A.REF_CODE,B.COLL_CONCERN_ID,'$v_start_date','$v_end_date') LAST_LOCATION,
                                            B.BRAND,
										    B.INSTALLMENT_AMOUNT,
										    B.COLL_CONCERN_NAME,
										    B.COLL_CONCERN_ID,
										    B.CUSTOMER_NAME,
										    A.TARGET_UNIT,
										   (SELECT SUM(VISIT_STATUS) FROM RML_COLL_VISIT_ASSIGN 
											  WHERE REF_ID=A.REF_CODE
											  AND TRUNC(ASSIGN_DATE) BETWEEN TO_DATE ('$v_start_date', 'dd/mm/yyyy') AND TO_DATE ('$v_end_date', 'dd/mm/yyyy')
											) NUMBER_OF_VISIT,
											(SELECT AREA_ZONE FROM RML_COLL_APPS_USER WHERE ACCESS_APP='RML_COLL' AND RML_ID= TO_NUMBER (B.COLL_CONCERN_ID)) CONCERN_ZONE,
											(SELECT (CUSTOMER_REMARKS ||'##'|| VISIT_LOCATION)  FROM RML_COLL_VISIT_ASSIGN 
													WHERE  ID=(
														   SELECT MAX(ID) FROM RML_COLL_VISIT_ASSIGN 
															WHERE REF_ID=A.REF_CODE 
															AND ASSIGN_DATE BETWEEN TO_DATE ('$v_start_date', 'dd/mm/yyyy') AND TO_DATE ('$v_end_date', 'dd/mm/yyyy')
														)) INFORMATION,
														 (SELECT  NVL(SUM(C.AMOUNT),0) FROM RML_COLL_MONEY_COLLECTION C
															WHERE C.REF_ID=A.REF_CODE 
															AND TRUNC(C.CREATED_DATE) BETWEEN TO_DATE('$v_start_date','dd/mm/yyyy') AND TO_DATE('$v_end_date','dd/mm/yyyy')) COLLECTED_AMOUNT
											FROM 
											(
											SELECT BB.REF_ID REF_CODE,
												 COUNT(BB.REF_ID) TARGET_UNIT
												FROM RML_COLL_VISIT_ASSIGN bb
												WHERE TRUNC(bb.ASSIGN_DATE) BETWEEN TO_DATE ('$v_start_date', 'dd/mm/yyyy') AND TO_DATE ('$v_end_date', 'dd/mm/yyyy')
												AND ('$v_created_id' IS NULL OR bb.CREATED_BY='$v_created_id')
												 GROUP BY BB.REF_ID
												 ) A,LEASE_ALL_INFO_ERP B
											WHERE A.REF_CODE=B.REF_CODE
											--AND B.STATUS='Y'
											";
                                    $strSQL   = oci_parse($objConnect, $sqlQuery);


                                    oci_execute($strSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo $row['REF_CODE']; ?></td>
                                            <td><?php echo $row['COLL_CONCERN_NAME'] . "[" . $row['COLL_CONCERN_ID'] . ']'; ?></td>
                                            <td><?php echo $row['CONCERN_ZONE']; ?></td>
                                            <td><?php echo explode("##", $row['INFORMATION'])[1]; ?></td>

                                            <td><?php
                                            if ($row['LAST_LOCATION'] == "NO LOCATON FOUND") {

                                            }
                                            else {
                                                $latitu = explode("##", $row['LAST_LOCATION'])[0];
                                                $lng    = explode("##", $row['LAST_LOCATION'])[1];
                                                $url    = "http://www.google.com/maps/place/" . $latitu . "," . $lng;
                                                echo '<br>';


                                                ?>
                                                    <a id="myLink" href="<?php echo $url; ?>" target="_blank">View Location</a>
                                                    <?php
                                            }
                                            ?>
                                            </td>

                                            <td><?php echo $row['CUSTOMER_NAME']; ?></td>
                                            <td><?php echo $row['INSTALLMENT_AMOUNT']; ?></td>
                                            <td><?php echo $row['COLLECTED_AMOUNT']; ?></td>
                                            <td><?php echo $row['TARGET_UNIT']; ?></td>
                                            <td><?php echo $row['NUMBER_OF_VISIT']; ?></td>
                                            <td><?php echo $row['BRAND']; ?></td>
                                            <td><?php echo $row['LAST_REASON_CODE']; ?></td>
                                            <td><?php echo explode("##", $row['INFORMATION'])[0]; ?></td>


                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-end">
                        <a class="btn btn-sm  btn-gradient-info" onclick="exportF(this)">Export To Excel <i class='bx bxs-cloud-download'></i></a>
                    </div>
                </div>
            </div>
        </div><!--end row-->

    </div>
</div>
<!--end page wrapper -->
<?php
include_once ('../../_includes/footer_info.php');
include_once ('../../_includes/footer.php');
?>
<script>
    function exportF(elem) {
        var table = document.getElementById("tbl");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Daily_visit.xls"); // Choose the file name
        return false;
    }

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
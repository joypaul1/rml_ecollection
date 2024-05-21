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
                   
                   
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-4">
                                                <label>Select Your Concern:</label>
                                                <select name="created_id" class="form-control single-select">
                                                    <option value="" hidden> <--Select Concern--> </option>
                                                    <?php
                                                    $strSQL = @oci_parse($objConnect, "SELECT unique CREATED_BY,
                                                    (SELECT B.EMP_NAME FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) EMP_NAME from RML_COLL_VISIT_ASSIGN BB
                                                    order by CREATED_BY");
                                                    @oci_execute($strSQL);

                                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                                        $selected = (isset($_POST['created_id']) && $_POST['created_id'] == $row['CREATED_BY']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $row['CREATED_BY']; ?>" <?php echo $selected; ?>>
                                                            <?php echo $row['EMP_NAME']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Select Zone :</label>
                                                <select name="area_zone" class="form-control single-select">
                                                    <option value="<?php echo null ?>" hidden><--Select Zone --></option>
                                                    <?php
                                                    $strSQL = @oci_parse($objConnect, "SELECT unique AREA_ZONE FROM
                                                    (select (SELECT B.AREA_ZONE FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) AREA_ZONE from RML_COLL_VISIT_ASSIGN BB)
                                                    order by AREA_ZONE");
                                                    @oci_execute($strSQL);

                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                        $selected = (isset($_POST['area_zone']) && $_POST['area_zone'] == $row['AREA_ZONE']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $row['AREA_ZONE']; ?>" <?php echo $selected; ?>>
                                                            <?php echo $row['AREA_ZONE']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>



                                            <div class="col-sm-3">
                                                <label>Visit Date: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" name="start_date" type="text"
                                                        value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('d-m-Y'); ?>' />
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
                $leftSideName = 'Daily Visit Monitor Report List';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0">
                            <thead class="table-cust text-uppercase">
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
                                $LOGIN_ID = $_SESSION['ECOL_USER_INFO']['emp_id'];
                                                    // ECHO $_SESSION['ECOL_USER_INFO']['user_role_id'];

                                if (isset($_POST['start_date'])) {
                                    $emp_id          = (int) (explode("RML-", $LOGIN_ID)[1]);
                                    $v_created_id    = $_REQUEST['created_id'];
                                    $v_area_zone     = $_REQUEST['area_zone'];
                                    $start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));

                                    if (($_SESSION['ECOL_USER_INFO']['user_role_id'] == 3)) {
                                        $strSQL = @oci_parse(
                                            $objConnect,
                                            "SELECT
                                            bb.REF_ID,
                                            bb.CREATED_BY,
                                            (SELECT AREA_ZONE FROM RML_COLL_APPS_USER WHERE RML_ID = bb.CREATED_BY) AS AREA_ZONE,
                                            (SELECT B.EMP_NAME FROM RML_COLL_APPS_USER B WHERE B.RML_ID = BB.CREATED_BY) AS CONCERN_NAME,
                                            bb.ASSIGN_DATE,
                                            COLL_VISIT_STATU(bb.CREATED_BY, bb.REF_ID, TO_DATE('$start_date', 'dd/mm/yyyy')) AS VISIT_STATUS,
                                            bb.CUSTOMER_REMARKS,
                                            RML_COLL_FAIL_TO_ASSIGN_VISIT(bb.REF_ID, bb.ASSIGN_DATE) AS NEXT_ASSIGN_INFO,
                                            bb.VISIT_LOCATION,
                                            COLL_VISIT_LAT(bb.CREATED_BY, bb.REF_ID, TO_DATE('$start_date', 'dd/mm/yyyy'), 'LAT') AS VISITED_LOCATION_LAT,
                                            COLL_VISIT_LAT(bb.CREATED_BY, bb.REF_ID, TO_DATE('$start_date', 'dd/mm/yyyy'), 'LANG') AS VISITED_LOCATION_LANG,
                                            bb.CUSTOMER_NAME,
                                            (SELECT NVL(SUM(C.AMOUNT), 0) FROM RML_COLL_MONEY_COLLECTION C
                                            WHERE C.REF_ID = bb.REF_ID
                                            AND TRUNC(C.CREATED_DATE) = TO_DATE('$start_date', 'dd/mm/yyyy')) AS COLLECTION_AMOUNT,
                                            bb.INSTALLMENT_AMOUNT
                                        FROM
                                            RML_COLL_VISIT_ASSIGN bb
                                        WHERE
                                            bb.ASSIGN_DATE = TO_DATE('$start_date', 'dd/mm/yyyy')
                                            AND bb.IS_ACTIVE = 1
                                            AND ('$v_created_id' IS NULL OR bb.CREATED_BY = '$v_created_id')
                                        ORDER BY
                                            bb.CREATED_BY"
                                        );

                                    }
                                    else {
                                        $strSQL = @oci_parse(
                                            $objConnect,
                                            "SELECT
                                            BB.REF_ID,
                                            BB.CREATED_BY,
                                            AA.AREA_ZONE,
                                            AA.EMP_NAME AS CONCERN_NAME,
                                            BB.ASSIGN_DATE,
                                            COLL_VISIT_STATU(bb.CREATED_BY, bb.REF_ID, TO_DATE('$start_date', 'dd/mm/yyyy')) AS VISIT_STATUS,
                                            BB.CUSTOMER_REMARKS,
                                            RML_COLL_FAIL_TO_ASSIGN_VISIT(bb.REF_ID, bb.ASSIGN_DATE) AS NEXT_ASSIGN_INFO,
                                            BB.VISIT_LOCATION,
                                            COLL_VISIT_LAT(bb.CREATED_BY, bb.REF_ID, TO_DATE('$start_date', 'dd/mm/yyyy'), 'LAT') AS VISITED_LOCATION_LAT,
                                            COLL_VISIT_LAT(bb.CREATED_BY, bb.REF_ID, TO_DATE('$start_date', 'dd/mm/yyyy'), 'LANG') AS VISITED_LOCATION_LANG,
                                            BB.CUSTOMER_NAME,
                                            (SELECT NVL(SUM(C.AMOUNT), 0) FROM RML_COLL_MONEY_COLLECTION C
                                            WHERE C.REF_ID = bb.REF_ID
                                            AND TRUNC(C.CREATED_DATE) = TO_DATE('$start_date', 'dd/mm/yyyy')) AS COLLECTION_AMOUNT,
                                            BB.INSTALLMENT_AMOUNT
                                        FROM
                                            RML_COLL_VISIT_ASSIGN bb,
                                            RML_COLL_APPS_USER aa
                                        WHERE
                                            BB.CREATED_BY = AA.RML_ID
                                            AND bb.ASSIGN_DATE = TO_DATE('$start_date', 'dd/mm/yyyy')
                                            AND bb.IS_ACTIVE = 1
                                            AND ('$v_created_id' IS NULL OR bb.CREATED_BY = '$v_created_id')
                                            AND ('$v_area_zone' IS NULL OR AA.AREA_ZONE = '$v_area_zone')
                                        ORDER BY
                                            bb.CREATED_BY"
                                        );

                                    }
                                    @oci_execute($strSQL);
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
                                            <td><?php
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
                    <div class="d-block text-end">
                        <a class="btn btn-sm  btn-gradient-info" onclick="exportF(this)">Export to excel</a>
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
        var table = document.getElementById("table");
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
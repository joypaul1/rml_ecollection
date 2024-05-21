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
include_once ('../../_config/sqlConfig.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <?PHP
        $user_brand_name = $_SESSION['ECOL_USER_INFO']['user_brand'];
        $USER_ID         = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);
        $USER_ROLE       = getUserAccessRoleByID($_SESSION['ECOL_USER_INFO']['user_role_id']);
        ?>
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
                                            <div class="col-sm-3">
                                                <label for="title">Select Zone:</label>
                                                <SELECT required="" name="emp_zone" class="form-control single-select">
                                                    <option value="All">ALL</option>
                                                    <?php
                                                    if ($USER_ROLE == "ADM") {
                                                        $strSQL = @oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");
                                                    }
                                                    else if ($USER_ROLE == "AH") {
                                                        $strSQL = @oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD='$USER_ID' order by ZONE");
                                                    }
                                                    else if ($USER_ROLE == "ALL") {
                                                        $strSQL = @oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");
                                                    }
                                                    else if ($USER_ROLE == "AUDIT") {
                                                        $strSQL = @oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");
                                                    }
                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                        ?>

                                                        <option value="<?php echo $row['ZONE_NAME']; ?>"><?php echo $row['ZONE_NAME']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </SELECT>

                                            </div>
                                            <div class="col-sm-3">
                                                <label>Start Date: </label>
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
                                                <label>End Date: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" name="end_date" type="text"
                                                        value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('t-m-Y'); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="title">Select Concern:</label>
                                                <SELECT name="emp_concern" required="" class="form-control single-select">
                                                    <?php
                                                    $USER_ROLE = getUserAccessRoleByID($_SESSION['ECOL_USER_INFO']['user_role_id']);
                                                    if ($USER_ROLE == "ADM") { ?>
                                                        <option value="CC">Collection Concern</option>
                                                        <option value="ZH">Zonal Head</option>
                                                        <option value="AH">Area Head</option>
                                                    <?php }
                                                    else if ($USER_ROLE == "AH") { ?>
                                                            <option value="CC">Collection Concern</option>
                                                            <option value="ZH">Zonal Head</option>
                                                    <?php }
                                                    else if ($USER_ROLE == "ALL") { ?>
                                                                <option value="CC">Collection Concern</option>
                                                                <option value="ZH">Zonal Head</option>
                                                                <option value="AH">Area Head</option>
                                                    <?php }
                                                    else if ($USER_ROLE == "AUDIT") { ?>
                                                                    <option value="CC">Collection Concern</option>
                                                                    <option value="ZH">Zonal Head</option>
                                                                    <option value="AH">Area Head</option>
                                                    <?php } ?>
                                                </SELECT>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">
                                                    Search Data <i class='bx bx-file-find'></i>
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
                $leftSideName = 'Zone Wise Collection Summary';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">Concern Name</th>
                                    <th scope="col">Concern Zone</th>
                                    <th scope="col">
                                        <center>Start Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>End Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Target(Current Month)</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection(%)</center>
                                    </th>
                                    <th scope="col">
                                        <center>User Role</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $USER_ROLE = getUserAccessRoleByID($_SESSION['ECOL_USER_INFO']['user_role_id']);
                                $USER_ID   = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);

                                @$emp_zone = $_REQUEST['emp_zone'];
                                @$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                @$emp_concern = $_REQUEST['emp_concern'];



                                if (isset($_POST['emp_zone'])) {

                                    if ($USER_ROLE == "ADM" || $USER_ROLE == "AUDIT") {

                                        if ($emp_zone == 'All') {

                                            if ($emp_concern == 'CC') {
                                                $strSQL = @oci_parse(
                                                    $objConnect,
                                                    "SELECT a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
                                                    RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,b.LEASE_USER,
                                                    COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                                    FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
                                                    where A.RML_ID=B.RML_ID
                                                    and B.IS_ACTIVE=1
                                                    AND  a.IS_ACTIVE=1
                                                    AND ACCESS_APP='RML_COLL'
                                                    and b.LEASE_USER='CC'
                                                    ORDER BY a.CONCERN"
                                                );


                                            }
                                            else if ($emp_concern == 'ZH') {
                                                $strSQL = @oci_parse(
                                                    $objConnect,
                                                    "SELECT a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,b.LEASE_USER,
                                                    COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                                    FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
                                                    where A.RML_ID=B.RML_ID
                                                    and B.IS_ACTIVE=1
                                                    AND  a.IS_ACTIVE=1
                                                    AND ACCESS_APP='RML_COLL'
                                                    and b.LEASE_USER='ZH'
                                                    ORDER BY a.CONCERN"
                                                );

                                            }
                                            else if ($emp_concern == 'AH') {
                                                $strSQL = @oci_parse(
                                                    $objConnect,
                                                    "SELECT b.RML_ID,b.EMP_NAME,b.ACTUAL_DEALER_ID,b.AREA_ZONE,
                                                    RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,
                                                    b.LEASE_USER,
                                                    COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                                    FROM RML_COLL_APPS_USER b
                                                    where B.IS_ACTIVE=1
                                                    and b.LEASE_USER='AH'
                                                    AND ACCESS_APP='RML_COLL'
                                                    ORDER BY b.EMP_NAME"
                                                );

                                            }
                                        }
                                        else {
                                            if ($emp_concern == 'CC') {
                                                $strSQL = @oci_parse(
                                                    $objConnect,
                                                    "SELECT a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
                                                    RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,b.LEASE_USER,
                                                    COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                                    FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
                                                    where A.RML_ID=B.RML_ID
                                                    and B.IS_ACTIVE=1
                                                    AND  a.IS_ACTIVE=1
                                                    and b.LEASE_USER='CC'
                                                    AND ACCESS_APP='RML_COLL'
                                                    AND a.ZONE='$emp_zone'
                                                    ORDER BY a.CONCERN"
                                                );
                                            }
                                            else if ($emp_concern == 'ZH') {
                                                $strSQL = @oci_parse(
                                                    $objConnect,
                                                    "SELECT a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
                                                    RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,b.LEASE_USER,
                                                    COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                                    FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
                                                    where A.RML_ID=B.RML_ID
                                                    and B.IS_ACTIVE=1
                                                    AND  a.IS_ACTIVE=1
                                                    AND ACCESS_APP='RML_COLL'
                                                    and b.LEASE_USER='ZH'
                                                    AND a.ZONE='$emp_zone'
                                                    ORDER BY a.CONCERN"
                                                );
                                            }
                                            else if ($emp_concern == 'AH') {
                                                $strSQL = @oci_parse(
                                                    $objConnect,
                                                    "SELECT b.RML_ID,b.EMP_NAME,b.ACTUAL_DEALER_ID ,b.AREA_ZONE,
                                                    RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,b.LEASE_USER,
                                                    COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                                    FROM RML_COLL_APPS_USER b
                                                    where B.IS_ACTIVE=1
                                                    AND ACCESS_APP='RML_COLL'
                                                    and b.LEASE_USER='AH'
                                                    AND b.AREA_ZONE='$emp_zone'
                                                    ORDER BY b.EMP_NAME"
                                                );
                                            }
                                        }

                                    }
                                    else if ($USER_ROLE == "AH") {
                                        if ($emp_zone == 'All') {
                                            $sqlQuary = "SELECT a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
                                            RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,b.LEASE_USER,
                                            COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                            FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
                                            where A.RML_ID=B.RML_ID
                                            and B.IS_ACTIVE=1
                                            AND  a.IS_ACTIVE=1
                                            AND ACCESS_APP='RML_COLL'
                                            and ('$emp_concern' is null OR b.LEASE_USER='$emp_concern')
                                            AND a.AREA_HEAD='$USER_ID'
                                            ORDER BY a.CONCERN";
                                            $strSQL   = @oci_parse($objConnect, $sqlQuary);


                                        }
                                        else {
                                            $strSQL = @oci_parse(
                                                $objConnect,
                                                "SELECT a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
                                                RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$attn_end_date') TARGET_AMNT,b.LEASE_USER,
                                                COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT
                                                FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
                                                where A.RML_ID=B.RML_ID
                                                and B.IS_ACTIVE=1
                                                AND  a.IS_ACTIVE=1
                                                AND ACCESS_APP='RML_COLL'
                                                and ('$emp_concern' is null OR b.LEASE_USER='$emp_concern')
                                                AND a.AREA_HEAD='$USER_ID'
                                                AND a.ZONE='$emp_zone'
                                                ORDER BY a.CONCERN"
                                            );
                                        }
                                    }
                                    else if ($USER_ROLE == "ALL") {
                                        if ($emp_zone == 'All') {
                                            $strSQL = @oci_parse(
                                                $objConnect,
                                                "SELECT RML_ID,EMP_NAME,ACTUAL_DEALER_ID,AREA_ZONE,LEASE_USER,
                                                COLL_SUMOF_TARGET(ACTUAL_DEALER_ID) TARGET_AMNT,
                                                COLL_SUMOF_RECEIVED_AMOUNT(RML_ID,LEASE_USER,USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT,
                                                COLL_SUMOF_LEASE(RML_ID,TO_DATE('$start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy')) LEASE_CONFIRM,
                                                COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),1) OTP_YES_AMNT,
                                                COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),0) OTP_NO_AMNT
                                                    FROM RML_COLL_APPS_USER
                                                where ACCESS_APP='RML_COLL'
                                                and ('$emp_concern' is null OR LEASE_USER='$emp_concern')
                                                and RML_ID NOT IN('001','002','956','955','986','713')
                                                and IS_ACTIVE=1
                                                    ORDER BY AREA_ZONE"
                                            );

                                        }
                                        else {
                                            $strSQL = @oci_parse(
                                                $objConnect,
                                                "SELECT RML_ID,EMP_NAME,ACTUAL_DEALER_ID,AREA_ZONE,
                                                COLL_SUMOF_TARGET_AMOUNT(RML_ID,LEASE_USER,USER_FOR) TARGET_AMNT ,
                                                COLL_SUMOF_RECEIVED_AMOUNT(RML_ID,LEASE_USER,USER_FOR,'$start_date','$attn_end_date') COLLECTION_AMNT,
                                                COLL_SUMOF_LEASE(RML_ID,TO_DATE('$start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy')) LEASE_CONFIRM,
                                                COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),1) OTP_YES_AMNT,
                                                COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),0) OTP_NO_AMNT
                                                    FROM RML_COLL_APPS_USER
                                                where ACCESS_APP='RML_COLL'
                                                and AREA_ZONE='$emp_zone'
                                                and RML_ID NOT IN('001','002','956','955','986','713')
                                                and IS_ACTIVE=1 ORDER BY AREA_ZONE"
                                            );
                                        }
                                    }
                                    @oci_execute(@$strSQL);
                                    $number                 = 0;
                                    $GRANT_TOTAL_TARGET     = 0;
                                    $GRANT_TOTAL_COLLECTION = 0;

                                    while ($row = @oci_fetch_assoc(@$strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo $row['EMP_NAME'] . '[' . $row['RML_ID'] . ']'; ?></td>
                                            <td><?php echo $row['AREA_ZONE']; ?></td>
                                            <td align="center"><?php echo $start_date; ?></td>
                                            <td align="center"><?php echo $attn_end_date; ?></td>
                                            <td align="center">
                                                <?php echo $row['TARGET_AMNT'];
                                                $GRANT_TOTAL_TARGET = $GRANT_TOTAL_TARGET + $row['TARGET_AMNT']; ?>
                                            </td>
                                            < td align="center">
                                                <?php echo $row['COLLECTION_AMNT'];
                                                $GRANT_TOTAL_COLLECTION = $GRANT_TOTAL_COLLECTION + $row['COLLECTION_AMNT'] ?>
                                            </>
                                            <td align="center"><?php
                                            if ($row['COLLECTION_AMNT'] == 0 || $row['TARGET_AMNT'] == 0) {
                                                echo "0";
                                            }
                                            else {
                                                echo ceil(($row['COLLECTION_AMNT'] * 100) / $row['TARGET_AMNT']);
                                            }
                                            ?>
                                                %</td>

                                            <td><?php echo $row['LEASE_USER']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center">Grand Total:</td>
                                        <td align="center"><?php echo $GRANT_TOTAL_TARGET; ?></td>
                                        <td align="center"><?php echo $GRANT_TOTAL_COLLECTION; ?></td>
                                        <td align="center">
                                            <?php
                                            if ($GRANT_TOTAL_TARGET > 0 || $GRANT_TOTAL_COLLECTION > 0) {
                                                echo ceil(($GRANT_TOTAL_COLLECTION * 100) / $GRANT_TOTAL_TARGET);
                                            }
                                            else {
                                                echo "0";
                                            }
                                            ?>
                                            %
                                        </td>
                                        <td align="center"></td>
                                    </tr>
                                    <?php
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
        elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
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
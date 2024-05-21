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
                                                        $strSQL = @@oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");
                                                    }
                                                    else if ($USER_ROLE == "AH") {
                                                        $strSQL = @@oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD='$USER_ID' order by ZONE");
                                                    }
                                                    else if ($USER_ROLE == "ALL") {
                                                        $strSQL = @@oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");
                                                    }
                                                    else if ($USER_ROLE == "AUDIT") {
                                                        $strSQL = @@oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");
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
                                                <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">Search Data <i
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
                $leftSideName = 'Zone Wise Seized Summary';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">
                                        <center>Sl</center>
                                    </th>
                                    <th scope="col">
                                        <center>Concern ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Seized By</center>
                                    </th>
                                    <th scope="col">
                                        <center>Start Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>End Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>ZH_ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Zone</center>
                                    </th>
                                    <th scope="col">
                                        <center>REF_ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Seized Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Seized Date</center>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $USER_ROLE = getUserAccessRoleByID($_SESSION['ECOL_USER_INFO']['user_role_id']);
                                $USER_ID   = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);

                                @$emp_zone = $_REQUEST['emp_zone'];
                                @$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                @$emp_concern = $_REQUEST['emp_concern'];



                                if (isset($_POST['emp_zone'])) {

                                    if ($USER_ROLE == "ADM" || $USER_ROLE == "AUDIT") {
                                        if ($emp_zone == 'All') {
                                            $strSQL = oci_parse(
                                                $objConnect,
                                                "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
                                                UT.ACTUAL_DEALER_ID DEALER_ID,
                                                UT.EMP_NAME RML_NAME,
                                                UT.AREA_ZONE ZONE_NAME,
                                                (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
                                                    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)
                                                )ZH_ID,
                                                1 TOTAL_SEIZED
                                                FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
                                                WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
                                                AND UT.LEASE_USER='CC'
                                                AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$start_date','dd/mm/yyyy') AND TO_DATE('$end_date','dd/mm/yyyy')
                                                AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
                                                ORDER BY ENTRY_BY_RML_ID"
                                            );


                                        }
                                        else {
                                            $strSQL = oci_parse(
                                                $objConnect,
                                                "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
                                                UT.ACTUAL_DEALER_ID DEALER_ID,
                                                UT.EMP_NAME RML_NAME,
                                                UT.AREA_ZONE ZONE_NAME,
                                                (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
                                                    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)) 
                                                ZH_ID,
                                                1 TOTAL_SEIZED
                                                    FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
                                                WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
                                                AND UT.LEASE_USER='CC'
                                                AND UT.AREA_ZONE='$emp_zone'
                                                AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$start_date','dd/mm/yyyy') AND TO_DATE('$end_date','dd/mm/yyyy')
                                                AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
                                                    ORDER BY ENTRY_BY_RML_ID"
                                            );

                                        }
                                    }
                                    else if ($USER_ROLE == "AH") {
                                        if ($emp_zone == 'All') {
                                            $strSQL = oci_parse(
                                                $objConnect,
                                                "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
                                                UT.ACTUAL_DEALER_ID DEALER_ID,UT.LEASE_USER,
                                                UT.EMP_NAME RML_NAME,
                                                UT.AREA_ZONE ZONE_NAME,
                                                (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
                                                    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)
                                                )ZH_ID,
                                                1 TOTAL_SEIZED
                                                    FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
                                                WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
                                                and ('$emp_concern' is null OR UT.LEASE_USER='$emp_concern')
                                                AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$start_date','dd/mm/yyyy') AND TO_DATE('$end_date','dd/mm/yyyy')
                                                AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
                                                AND AREA_ZONE IN (select distinct(ZONE_NAME) ZONE_NAME from COLL_EMP_ZONE_SETUP where IS_ACTIVE=1 and AREA_HEAD='$USER_ID')
                                                ORDER BY ENTRY_BY_RML_ID"
                                            );

                                        }
                                        else {
                                            $strSQL = oci_parse(
                                                $objConnect,
                                                "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
                                            UT.ACTUAL_DEALER_ID DEALER_ID,
                                            UT.EMP_NAME RML_NAME,
                                            UT.AREA_ZONE ZONE_NAME,UT.LEASE_USER,
                                            (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
                                                WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)) 
                                            ZH_ID,
                                            1 TOTAL_SEIZED
                                                FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
                                            WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
                                            and ('$emp_concern' is null OR UT.LEASE_USER='$emp_concern')
                                            AND UT.AREA_ZONE='$emp_zone'
                                            AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$start_date','dd/mm/yyyy') AND TO_DATE('$end_date','dd/mm/yyyy')
                                            AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
                                                ORDER BY ENTRY_BY_RML_ID"
                                            );

                                        }
                                    }
                                    else if ($USER_ROLE == "ALL") {
                                        if ($emp_zone == 'All') {
                                            $strSQL = oci_parse(
                                                $objConnect,
                                                "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
                                                UT.ACTUAL_DEALER_ID DEALER_ID,
                                                UT.EMP_NAME RML_NAME,
                                                UT.AREA_ZONE ZONE_NAME,
                                                (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
                                                    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)
                                                )ZH_ID,
                                                1 TOTAL_SEIZED
                                                    FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
                                                WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
                                                AND UT.LEASE_USER='CC'
                                                AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$start_date','dd/mm/yyyy') AND TO_DATE('$end_date','dd/mm/yyyy')
                                                AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
                                                ORDER BY ENTRY_BY_RML_ID"
                                            );

                                        }
                                        else {
                                            $strSQL = oci_parse(
                                                $objConnect,
                                                "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
                                                UT.ACTUAL_DEALER_ID DEALER_ID,
                                                UT.EMP_NAME RML_NAME,
                                                UT.AREA_ZONE ZONE_NAME,
                                                (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
                                                    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)) 
                                                ZH_ID,
                                                1 TOTAL_SEIZED
                                                    FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
                                                WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
                                                AND UT.LEASE_USER='CC'
                                                AND UT.AREA_ZONE='$emp_zone'
                                                AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$start_date','dd/mm/yyyy') AND TO_DATE('$end_date','dd/mm/yyyy')
                                                AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
                                                    ORDER BY ENTRY_BY_RML_ID"
                                            );

                                        }
                                    }

                                    @oci_execute(@$strSQL);
                                    $number = 0;


                                    while ($row = @oci_fetch_assoc(@$strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td align="center"><?php echo $row['RML_ID']; ?></td>
                                            <td><?php echo $row['RML_NAME']; ?></td>

                                            <td align="center"><?php echo $start_date; ?></td>
                                            <td align="center"><?php echo $end_date; ?></td>
                                            <td align="center"><?php echo $row['ZH_ID']; ?></td>
                                            <td align="center"><?php echo $row['ZONE_NAME']; ?></td>
                                            <td align="center"><?php echo $row['REF_ID']; ?></td>
                                            <td align="center"><?php echo $row['TOTAL_SEIZED']; ?></td>
                                            <td align="center"><?php echo $row['ENTRY_DATE']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center">Grand Total:</td>
                                        <td align="center"><?php echo $number; ?></td>
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
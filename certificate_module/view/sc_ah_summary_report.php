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
                                                <label for="title">SELECT Zone:</label>
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
                                                    @oci_execute($strSQL);
                                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                                        ?>

                                                        <option value="<?php echo $row['ZONE_NAME']; ?>"><?php echo $row['ZONE_NAME']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </SELECT>

                                            </div>
                                            <div class="col-sm-3">
                                                <label> Start Date: </label>
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
                                                <label> End Date: </label>
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
                                                <label for="title">SELECT Concern:</label>
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
                                                <button class="form-control btn btn-sm btn-gradient-primary mt-4" type="submit">Search Data
                                                    <i class='bx bx-file-find'></i>
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
                $leftSideName = 'Zone Wise Sales Certificate Summary';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>Zone Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Request Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Complete Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Pending Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Pending %</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $USER_ID = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);
                                $strSQL  = @oci_parse(
                                    $objConnect,
                                    "SELECT AREA_ZONE,REQUESTED_UNIT,COMPLETED_UNIT,PENDING_UNIT from
                                    (select  b.AREA_ZONE,a.REQUEST_TYPE
                                    from RML_COLL_SC a,RML_COLL_APPS_USER b
                                    where A.ENTRY_BY_RML_ID=B.RML_ID and b.AREA_ZONE IN (select distinct(ZONE)
                                    from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD=$USER_ID)
                                    )
                                    PIVOT
                                    (COUNT(REQUEST_TYPE)
                                    FOR REQUEST_TYPE IN ('New' REQUESTED_UNIT, 'Closed' COMPLETED_UNIT,'Updated' PENDING_UNIT)
                                    )ORDER BY AREA_ZONE"
                                );




                                @oci_execute($strSQL);
                                $number = 0;

                                $R_UNIT = 0;
                                $C_UNIT = 0;
                                $P_UNIT = 0;

                                while ($row = @oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    $reqUnit  = ($row['REQUESTED_UNIT'] + $row['PENDING_UNIT'] + $row['COMPLETED_UNIT']);
                                    $compUnit = $row['COMPLETED_UNIT'];
                                    $pendUnit = $reqUnit - $compUnit;

                                    $R_UNIT = $R_UNIT + $reqUnit;
                                    $C_UNIT = $C_UNIT + $compUnit;
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $number; ?></td>
                                        <td align="center"><?php echo $row['AREA_ZONE']; ?></td>
                                        <td align="center"><?php echo $reqUnit; ?></td>
                                        <td align="center"><?php echo $compUnit; ?></td>
                                        <td align="center"><?php echo $pendUnit; ?></td>
                                        <td align="center"><?php echo round(($pendUnit / $reqUnit) * 100); ?> %</td>
                                    </tr>
                                    <?php
                                } ?>
                                <tr>

                                    <td></td>
                                    <td></td>
                                    <td align="center">Grand Total: <?php echo $R_UNIT; ?></td>
                                    <td align="center">Grand Total: <?php echo $C_UNIT; ?></td>
                                    <td align="center">Grand Total: <?php echo $R_UNIT - $C_UNIT; ?></td>
                                    <td align="center">Grand Total:
                                        <?php
                                        if ($R_UNIT == 0) {
                                            echo "0";
                                        }
                                        else {
                                            echo round((($R_UNIT - $C_UNIT) / $R_UNIT) * 100);
                                        }
                                        ?>%
                                    </td>

                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <div class="d-block text-end">
                        <a class="btn btn-gradient-info" onclick="exportF(this)">Export To Excel  <i class='bx bxs-cloud-download'></i></a>
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
                elem.setAttribute("download", "SC_Summary_Report.xls"); // Choose the file name
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
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
                                                <label for="title">Select Zonal Head:</label>
                                                <select name="emp_ah_id" class="form-control single-select">
                                                    <option selected value="">Select Zonal Head</option>
                                                    <?php

                                                    $strSQL = @oci_parse($objConnect, "SELECT (SELECT B.EMP_NAME FROM RML_COLL_APPS_USER B WHERE B.RML_ID= A.ZONE_HEAD) USER_NAME,
													USER_TYPE,ZONE_HEAD FROM COLL_EMP_ZONE_SETUP A WHERE A.IS_ACTIVE=1");

                                                    @oci_execute($strSQL);
                                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                                        ?>
                                                        <option value="<?php echo $row['ZONE_HEAD']; ?>">
                                                            <?php echo $row['USER_NAME'] . '[' . $row['USER_TYPE'] . ']'; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="form-control btn btn-sm btn-gradient-primary mt-4" type="submit">
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
                $leftSideName = 'ZONAL HEAD COLLECTION';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>Emp ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Emp Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Target Month</center>
                                    </th>
                                    <th scope="col">
                                        <center>Target</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection Start Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection End Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection(%)</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                if (isset($_POST['start_date'])) {
                                    $start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                    $end_date   = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                    $emp_ah_id  = $_REQUEST['emp_ah_id'];
                                    $strSQL     = @oci_parse(
                                        $objConnect,
                                        "SELECT b.RML_ID,b.EMP_NAME,
                                        RML_COLL_SUMOF_TARGET(b.RML_ID,'$start_date','$end_date') TARGET_AMNT,
                                        COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$start_date','$end_date') COLLECTION_AMNT 
                                        FROM RML_COLL_APPS_USER b 
                                        where  b.ACCESS_APP='RML_COLL'
                                        and B.IS_ACTIVE=1  
                                        and b.LEASE_USER='ZH' 
                                        and ('$emp_ah_id' is null OR b.RML_ID='$emp_ah_id')"
                                    );
                                    @oci_execute($strSQL);
                                    $number                 = 0;
                                    $GRANT_TOTAL_TARGET     = 0;
                                    $GRANT_TOTAL_COLLECTION = 0;

                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        if ($row['TARGET_AMNT'] >= 0) {
                                            ?>
                                            <tr>
                                                <td><?php echo $number; ?></td>
                                                <td align="center"><?php echo $row['RML_ID']; ?></td>
                                                <td><?php echo $row['EMP_NAME']; ?></td>
                                                <td align="center"><?php echo $start_date; ?></td>
                                                <td align="center">
                                                    <?php echo $row['TARGET_AMNT'];
                                                    $GRANT_TOTAL_TARGET = $GRANT_TOTAL_TARGET + $row['TARGET_AMNT']; ?>
                                                </td>
                                                <td align="center"><?php echo $start_date; ?></td>
                                                <td align="center"><?php echo $end_date; ?></td>
                                                <td align="center">
                                                    <?php echo $row['COLLECTION_AMNT'];
                                                    $GRANT_TOTAL_COLLECTION = $GRANT_TOTAL_COLLECTION + $row['COLLECTION_AMNT'] ?>
                                                </td>
                                                <td align="center"><?php
                                                if ($row['COLLECTION_AMNT'] == 0 || $row['TARGET_AMNT'] == 0) {
                                                    echo "0";
                                                }
                                                else {
                                                    echo ceil(($row['COLLECTION_AMNT'] * 100) / $row['TARGET_AMNT']);
                                                }
                                                ?>
                                                    %</td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center">Grand Total:</td>
                                        <td align="center"><?php echo $GRANT_TOTAL_TARGET; ?></td>
                                        <td align="center"></td>
                                        <td align="center">Grand Total:</td>
                                        <td align="center"><?php echo $GRANT_TOTAL_COLLECTION; ?></td>
                                        <td align="center">
                                            <?php

                                            if (is_array($row) && isset($row['COLLECTION_AMNT'], $row['TARGET_AMNT'])) {
                                                if ($row['COLLECTION_AMNT'] == 0 || $row['TARGET_AMNT'] == 0) {
                                                    echo "0";
                                                }
                                                else {
                                                    echo ceil(($GRANT_TOTAL_COLLECTION * 100) / $GRANT_TOTAL_TARGET);
                                                }
                                            }
                                            else {
                                                echo "0";
                                                // Handle the case where $row is not an array or the expected keys are not set
                                                // echo "Data not available";
                                            }
                                            ?>%
                                        </td>
                                    </tr>
                                    <?php
                                }

                                ?>
                            </tbody>


                        </table>
                    </div>
                    <div class="d-block text-end">
                        <a class="btn btn-sm  btn-gradient-info" onclick="exportF(this)">Export To Excel <i class='bx bxs-cloud-download'></i></a>
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
            elem.setAttribute("download", "zonal_head_collection.xls"); // Choose the file name
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
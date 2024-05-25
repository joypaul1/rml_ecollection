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
                                                <select name="emp_zone" class="form-control single-select">
                                                    <option hidden value="">Select Zone</option>
                                                    <?php
                                                    $strSQL = oci_parse($objConnect, "SELECT distinct AREA_ZONE AS ZONE_NAME from RML_COLL_APPS_USER where ACCESS_APP='RML_COLL' AND IS_ACTIVE=1  order by AREA_ZONE");
                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                        ?>

                                                        <option value="<?php echo $row['ZONE_NAME']; ?>"><?php echo $row['ZONE_NAME']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
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
                                                <label for="title">Select Status:</label>
                                                <select name="seized_status" class="form-control single-select">
                                                    <option hidden value=""><-- Status --></option>
                                                    <option value="1">Approved</option>
                                                    <option value="0">Pending</option>
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
                $leftSideName = 'Zone Wise Seized Summary';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">
                                        <center>Sl</center>
                                    </th>
                                    <th scope="col">
                                        <center>Seized/Entry By</center>
                                    </th>
                                    <th scope="col">
                                        <center>Entry Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>REF-ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Driver Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Others Driver Name(Mobile)</center>
                                    </th>
                                    <th scope="col">
                                        <center>Depot Location</center>
                                    </th>
                                    <th scope="col">
                                        <center>Area Zone</center>
                                    </th>
                                    <th scope="col">
                                        <center>Total Expence</center>
                                    </th>
                                    <th scope="col">
                                        <center>Status</center>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                @$emp_zone = $_REQUEST['emp_zone'];
                                @$seized_status = $_REQUEST['seized_status'];
                                @$seized_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$seized_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                if (isset($_POST['emp_zone'])) {
                                    $strSQL = @oci_parse(
                                        $objConnect,
                                        "SELECT B.RML_ID,
                                            A.RENT_DRIVER_NAME,
                                            A.RENT_DRIVER_MOBILE,
                                            B.EMP_NAME,
                                            A.REF_ID,
                                            A.ENTRY_DATE,
                                            B.AREA_ZONE,
                                            A.DRIVER_NAME,
                                            A.DEPOT_LOCATION,
                                            A.IS_CONFIRM,
                                            A.TOTAL_EXPENSE
                                        FROM RML_COLL_SEIZE_DTLS a,RML_COLL_APPS_USER b
                                        where A.ENTRY_BY_RML_ID=b.RML_ID
                                        and ('$emp_zone' is null OR B.AREA_ZONE='$emp_zone')
                                        and ('$seized_status' is null OR A.IS_CONFIRM='$seized_status')
                                        and trunc(a.ENTRY_DATE) between to_date('$seized_start_date','dd/mm/yyyy') and  to_date('$seized_end_date','dd/mm/yyyy')"
                                    );

                                    @oci_execute($strSQL);
                                    $number = 0;

                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td><?php echo $row['EMP_NAME']; ?></td>
                                            <td align="center"><?php echo $row['ENTRY_DATE']; ?></td>
                                            <td align="center"><?php echo $row['REF_ID']; ?></td>
                                            <td align="center"><?php echo $row['DRIVER_NAME']; ?></td>
                                            <td align="center"><?php
                                            if (strlen($row['RENT_DRIVER_NAME']) > 0)
                                                if (strlen($row['RENT_DRIVER_MOBILE']) > 0)
                                                    echo $row['RENT_DRIVER_NAME'] . "[" . $row['RENT_DRIVER_MOBILE'] . "]";
                                                else
                                                    echo $row['RENT_DRIVER_NAME'];

                                            ?></td>
                                            <td align="center"><?php echo $row['DEPOT_LOCATION']; ?></td>
                                            <td align="center"><?php echo $row['AREA_ZONE']; ?></td>
                                            <td align="center"><?php echo $row['TOTAL_EXPENSE']; ?></td>
                                            <td align="center"><?php
                                            if ($row['IS_CONFIRM'] == 1) {
                                                echo '<button class="btn btn-sm btn-gradient-success"> Confirm
                                                </button>';
                                            }
                                            else
                                                echo '<button class="btn btn-sm btn-gradient-danger"> Pending
                                            </button>'; ?>
                                            </td>
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
            elem.setAttribute("download", "seized_report.xls"); // Choose the file name
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
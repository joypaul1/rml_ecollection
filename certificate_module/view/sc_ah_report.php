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
                                                <label for="exampleInputEmail1">Select Zone:</label>
                                                <SELECT name="emp_zone" class="form-control single-select">
                                                    <option selected value="ALL">All</option>
                                                    <?php
                                                    $strSQL = @oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD=$USER_ID order by ZONE");
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
                                                <label for="title">Select Status :</label>
                                                <select name="sc_status" class="form-control single-select">
                                                    <option selected value="">Select Status</option>
                                                    <option value="New">New</option>
                                                    <option value="Updated">Updated</option>
                                                    <option value="Closed">Closed</option>
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
                $leftSideName = 'Zone Wise Sales Certificate';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>Customer Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Customer Mobile</center>
                                    </th>
                                    <th scope="col">
                                        <center>Created Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Day Pass</center>
                                    </th>
                                    <th scope="col">
                                        <center>Created By</center>
                                    </th>
                                    <th scope="col">
                                        <center>Concern Zone</center>
                                    </th>
                                    <th scope="col">
                                        <center>Requester Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Requester Mobile</center>
                                    </th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $USER_ROLE = getUserAccessRoleByID($_SESSION['ECOL_USER_INFO']['user_role_id']);
                                $USER_ID   = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);

                                @$sc_status     = $_REQUEST['sc_status'];
                                @$emp_zone      = $_REQUEST['emp_zone'];
                                @$start_date    = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$end_date      = date("d/m/Y", strtotime($_REQUEST['end_date']));



                                if (isset($_POST['sc_status'])) {

                                    if ($emp_zone == "ALL") {
                                        $strSQL = oci_parse(
                                            $objConnect,
                                            "SELECT a.REF_CODE,
                                            a.CUSTOMER_NAME,
                                            a.CUSTOMER_MOBILE,
                                            B.EMP_NAME,
                                            a.REQUESTER_NAME,
                                            a.REQUESTER_MOBILE,
                                            a.ENTRY_DATE,
                                            TRUNC (SYSDATE-a.ENTRY_DATE) DAY_PASS,
                                            a.STATUS,
                                            a.REQUEST_TYPE,
                                            b.AREA_ZONE
                                            from RML_COLL_SC a,RML_COLL_APPS_USER b
                                            where A.ENTRY_BY_RML_ID=B.RML_ID
                                            and ('$sc_status' is null OR a.REQUEST_TYPE='$sc_status')
                                            and b.AREA_ZONE IN (SELECT distinct(ZONE) from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD=$USER_ID)
                                            and trunc(a.ENTRY_DATE) between to_date('$start_date ','dd/mm/yyyy') and to_date('$end_date ','dd/mm/yyyy')"
                                        );

                                    }
                                    else {
                                        $strSQL = oci_parse(
                                            $objConnect,
                                            "SELECT a.REF_CODE,
                                            a.CUSTOMER_NAME,
                                            a.CUSTOMER_MOBILE,
                                            B.EMP_NAME,
                                            a.REQUESTER_NAME,
                                            a.REQUESTER_MOBILE,
                                            a.ENTRY_DATE,
                                            TRUNC (SYSDATE-a.ENTRY_DATE) DAY_PASS,
                                            a.STATUS,
                                            a.REQUEST_TYPE,
                                            b.AREA_ZONE
                                            from RML_COLL_SC a,RML_COLL_APPS_USER b
                                            where A.ENTRY_BY_RML_ID=B.RML_ID
                                            and ('$sc_status' is null OR a.REQUEST_TYPE='$sc_status')
                                            and b.AREA_ZONE='$emp_zone'
                                            and trunc(a.ENTRY_DATE) between to_date('$start_date ','dd/mm/yyyy') and to_date('$end_date ','dd/mm/yyyy')"
                                        );
                                    }


                                    oci_execute($strSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td align="center"><?php echo $row['REF_CODE']; ?></td>
                                            <td><?php echo $row['CUSTOMER_NAME']; ?></td>
                                            <td><?php echo $row['CUSTOMER_MOBILE']; ?></td>
                                            <td align="center"><?php echo $row['ENTRY_DATE']; ?></td>
                                            <td align="center"><?php echo $row['DAY_PASS']; ?></td>
                                            <td align="center"><?php echo $row['EMP_NAME']; ?></td>
                                            <td align="center"><?php echo $row['AREA_ZONE']; ?></td>
                                            <td align="center"><?php echo $row['REQUESTER_NAME']; ?></td>
                                            <td align="center"><?php echo $row['REQUESTER_MOBILE']; ?></td>
                                            <td><?php echo $row['REQUEST_TYPE']; ?></td>


                                        </tr>
                                        <?php
                                    }
                                }

                                ?>
                            </tbody>

                        </table>

                    </div>
                    <div class="d-block text-end">
                        <a class="btn btn-sm  btn-gradient-info" onclick="exportF(this)">Export To Excel  <i class='bx bxs-cloud-download'></i></a>
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
    //delete data processing

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
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
                                                <label for="title">Select Concern:</label>
                                                <select name="emp_ah_id" class="form-control single-select">
                                                    <option selected value=""><-- Select Concern --></option>
                                                    <?php
                                                    $strSQL = oci_parse(
                                                        $objConnect,
                                                        "SELECT EMP_NAME,RML_ID from RML_COLL_APPS_USER
                                                        where IS_ACTIVE=1
                                                        and LEASE_USER in('CC')
                                                        and ACCESS_APP='RML_COLL'
                                                        and is_active=1
                                                        and RML_ID not in ('955','956')
                                                        order by EMP_NAME"
                                                    );

                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {

                                                        ?>

                                                        <option value="<?php echo $row['RML_ID']; ?>"><?php echo $row['EMP_NAME']; ?></option>
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
                $leftSideName = 'COLLECTION CONCERN';
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
                                        <center>Ref-Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection Amnt</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Collection Time</center>
                                    </th>

                                    <th scope="col">
                                        <center>Bank</center>
                                    </th>
                                    <th scope="col">
                                        <center>Pay Type</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                @$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                @$emp_ah_id = $_REQUEST['emp_ah_id'];



                                if (isset($_POST['emp_ah_id'])) {

                                    $strSQL = oci_parse(
                                        $objConnect,
                                        "SELECT B.RML_ID,
							           b.EMP_NAME,
									   a.REF_ID,
									   AMOUNT,
									   PAY_TYPE,
									   BANK,
									   MEMO_NO,
									   INSTALLMENT_AMOUNT,
									   a.CREATED_DATE,
									   TO_CHAR(a.CREATED_DATE,'hh:mi:ssam') CREATED_TIME,
									   B.AREA_ZONE
                                from RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER b 
                                                           where a.RML_COLL_APPS_USER_ID=b.ID
                               AND trunc(a.CREATED_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
							   and ('$emp_ah_id' is null OR b.RML_ID='$emp_ah_id')"
                                    );


                                    oci_execute($strSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td align="center"><?php echo $row['RML_ID']; ?></td>
                                            <td><?php echo $row['EMP_NAME']; ?></td>
                                            <td><?php echo $row['REF_ID']; ?></td>
                                            <td><?php echo $row['AMOUNT']; ?></td>
                                            <td><?php echo $row['CREATED_DATE']; ?></td>
                                            <td><?php echo $row['CREATED_TIME']; ?></td>
                                            <td><?php echo $row['BANK']; ?></td>
                                            <td><?php echo $row['PAY_TYPE']; ?></td>

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
            elem.setAttribute("download", "Images_Uploaded_History.xls"); // Choose the file name
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
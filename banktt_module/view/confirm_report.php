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
                $leftSideName = 'Date Wise Confirm TT  Confirm Report';
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
                                        <center>TT ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Entry Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Ref-Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>TT Type</center>
                                    </th>
                                    <th scope="col">
                                        <center>TT Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>TT Amount</center>
                                    </th>
                                    <th scope="col">
                                        <center>Total TT Amount</center>
                                    </th>
                                    <th scope="col">
                                        <center>Branch</center>
                                    </th>
                                    <th scope="col">
                                        <center>Concern Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Concern Zone</center>
                                    </th>
                                    <th scope="col">
                                        <center>TT Remarks</center>
                                    </th>
                                    <th scope="col">
                                        <center>Confirm Date</center>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                @$visit_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$visit_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));



                                if (isset($_POST['start_date'])) {

                                    $query = "SELECT 
										TO_CHAR(CREATED_DATE, 'dd/mm/yyyy') AS CREATED_DATE,
										ID,
										REF_ID,
										TT_TYPE,
										TO_CHAR(TT_DATE, 'dd/mm/yyyy') AS TT_DATE,
										AMOUNT,
										TT_TOTAL_TAKA,
										UPPER(TT_BRANCH) AS TT_BRANCH,
										UPPER(TT_REMARKS) AS TT_REMARKS,
										(SELECT EMP_NAME
										FROM RML_COLL_APPS_USER
										WHERE ID = RML_COLL_APPS_USER_ID
										AND ACCESS_APP = 'RML_COLL') AS CONCERN_NAME,
										(SELECT MOBILE_NO
										FROM RML_COLL_APPS_USER
										WHERE ID = RML_COLL_APPS_USER_ID
										AND ACCESS_APP = 'RML_COLL') AS MOBILE_NO,
										(SELECT AREA_ZONE
										FROM RML_COLL_APPS_USER
										WHERE ID = RML_COLL_APPS_USER_ID
										AND ACCESS_APP = 'RML_COLL') AS CONCERN_ZONE,
										TO_CHAR(TT_CONFIRM_DATE, 'dd/mm/yyyy') AS TT_CONFIRM_DATE,
										TT_CHECK
									FROM
										RML_COLL_MONEY_COLLECTION
									WHERE
										PAY_TYPE = 'Bank TT'
										AND BANK = 'Sonali Bank'
										AND TT_TYPE IS NOT NULL
										AND TRUNC(TT_CONFIRM_DATE) BETWEEN TO_DATE('$visit_start_date', 'dd/mm/yyyy') AND TO_DATE('$visit_end_date', 'dd/mm/yyyy')
										AND TRUNC(CREATED_DATE) >= TO_DATE('12/12/2019', 'dd/mm/yyyy')";

                                    $strSQL = oci_parse($objConnect, $query);

                                    oci_execute($strSQL);
                                    $number            = 0;
                                    $EMI_TOTAL         = 0;
                                    $EMI_TT_TOTAL_TAKA = 0;
                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;

                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td align="center"><?php echo $row['ID']; ?></td>
                                            <td align="center"><?php echo $row['CREATED_DATE']; ?></td>
                                            <td><?php echo $row['REF_ID']; ?></td>
                                            <td align="center"><?php echo $row['TT_TYPE']; ?></td>
                                            <td align="center"><?php echo $row['TT_DATE']; ?></td>
                                            <td align="center">
                                                <?php echo number_format($row['AMOUNT']);
                                                $EMI_TOTAL = $EMI_TOTAL + $row['AMOUNT'];
                                                ?>
                                            </td>
                                            </td>
                                            <td align="center">
                                                <?php echo number_format($row['TT_TOTAL_TAKA']);
                                                $EMI_TT_TOTAL_TAKA = $EMI_TT_TOTAL_TAKA + $row['TT_TOTAL_TAKA'];
                                                ?>

                                            </td>
                                            <td align="center"><?php echo $row['TT_BRANCH']; ?></td>
                                            <td align="center"><?php echo $row['CONCERN_NAME']; ?></td>
                                            <td align="center"><?php echo $row['CONCERN_ZONE']; ?></td>
                                            <td align="center"><?php echo $row['TT_REMARKS']; ?></td>
                                            <td align="center"><?php echo $row['TT_CONFIRM_DATE']; ?></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>TOTAL:</td>
                                        <td align="center"><?php echo number_format($EMI_TOTAL); ?></td>
                                        <td align="center"><?php echo number_format($EMI_TT_TOTAL_TAKA); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <!-- <td></td> -->
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
            elem.setAttribute("download", "TT_Confirm_Report.xls"); // Choose the file name
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
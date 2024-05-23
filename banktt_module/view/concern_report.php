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
                                                <label for="title">Select Concern:</label>
                                                <select name="concern_name" class="form-control single-select">
                                                    <option selected value=""><-- Select Concern --></option>
                                                    <?php
                                                    $strSQL = oci_parse($objConnect, "SELECT DISTINCT(EMP_NAME) EMP_NAME,RML_ID,ID from RML_COLL_APPS_USER where ACCESS_APP='RML_COLL' AND LEASE_USER='CC' AND IS_ACTIVE=1 AND RML_ID NOT IN ('955','956') ORDER BY EMP_NAME");
                                                    @oci_execute($strSQL);
                                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                                        ?>
                                                        <option value="<?php echo $row['EMP_NAME']; ?>"><?php echo $row['EMP_NAME']; ?></option>
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
                                                <label for="title">Select Status :</label>
                                                <select name="tt_status" required class="form-control single-select">
                                                    <option hidden value=""><-- Status --></option>
                                                    <option value="1">Confirm</option>
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
                $leftSideName = 'Bank TT Zone Wise Report Panel';
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
                                        <center>From Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>To Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Concern Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>EMI TT Amount</center>
                                    </th>
                                    <th scope="col">
                                        <center>Total TT Amount</center>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                @$concern_name = $_REQUEST['concern_name'];
                                @$tt_from_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$tt_to_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                                @$tt_status = $_REQUEST['tt_status'];


                                if (isset($_POST['start_date'])) {

                                    $strSQL = oci_parse(
                                        $objConnect,
                                        "SELECT DISTINCT(B.EMP_NAME),SUM(A.AMOUNT) TT_AMOUNT,SUM(TT_TOTAL_TAKA) TT_TOTAL_TAKA FROM RML_COLL_MONEY_COLLECTION A,RML_COLL_APPS_USER B
                                        WHERE A.RML_COLL_APPS_USER_ID=B.ID
                                        and ('$concern_name' is null OR B.EMP_NAME='$concern_name')
                                        AND A.PAY_TYPE='Bank TT'
                                        AND A.BANK='Sonali Bank'
                                        AND B.IS_ACTIVE='$tt_status'
                                        AND TRUNC(A.CREATED_DATE) BETWEEN TO_DATE('$tt_from_date','dd/mm/yyyy') AND TO_DATE('$tt_to_date','dd/mm/yyyy')
                                        GROUP BY B.EMP_NAME
                                        ORDER BY  B.EMP_NAME"
                                    );

                                    oci_execute($strSQL);
                                    $number = 0;
                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        $emi_tt_amount   = $row['TT_AMOUNT'];
                                        $total_tt_amount = $row['TT_TOTAL_TAKA'];
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td align="center"><?php echo $tt_from_date; ?></td>
                                            <td align="center"><?php echo $tt_to_date; ?></td>
                                            <td align="center"><?php echo $row['EMP_NAME']; ?></td>
                                            <td align="center"><?php
                                            if ($emi_tt_amount == $total_tt_amount)
                                                echo $row['TT_AMOUNT'];
                                            else {
                                                echo '<span style="color:red;text-align:center;">';
                                                echo $row['TT_AMOUNT'];
                                                echo '</span>';
                                            }
                                            ?>
                                            </td>
                                            <td align="center"><?php echo $row['TT_TOTAL_TAKA']; ?></td>

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
            elem.setAttribute("download", "concern_wise_tt.xls"); // Choose the file name
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
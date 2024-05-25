<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';

include_once ('../../_helper/2step_com_conn.php');

$months      = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];
$currentYear = date('Y');
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
                                                <label>Please Select Month:</label>
                                                <select name="month_name" class="form-control single-select">
                                                    <option value="" hidden><--Select Month--></option>
                                                    <?php foreach ($months as $month) { ?>
                                                        <option value="<?= $month ?>"><?= $month ?>     <?= $currentYear ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

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
                $leftSideName = 'Concern Visit Summary List';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>Collection Concern</center>
                                    </th>
                                    <th scope="col">
                                        <center>Total Visited Target</center>
                                    </th>
                                    <th scope="col">
                                        <center>Total Visited</center>
                                    </th>
                                    <th scope="col">
                                        <center>Unique Visited</center>
                                    </th>
                                    <th scope="col">
                                        <center>%</center>
                                    </th>
                                    <th scope="col">
                                        <center>Monthly Target</center>
                                    </th>
                                    <th scope="col">
                                        <center>Monthly Collected</center>
                                    </th>
                                    <th scope="col">
                                        <center>%</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $LOGIN_ID = $_SESSION['ECOL_USER_INFO']['emp_id'];
                                $emp_id   = (int) (explode("RML-", $LOGIN_ID)[1]);

                                if (isset($_POST['month_name'])) {
                                    $month_name = $_REQUEST['month_name'];
                                    // if ($month_name == 'January') {
                                    //     $start_date = date("d/m/Y", strtotime('01/01/Y'));
                                    //     $end_date   = date("d/m/Y", strtotime('01/31/2023'));
                                    // }
                                    // else if ($month_name == 'February') {
                                    //     $start_date = date("d/m/Y", strtotime('02/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('02/28/2023'));
                                    // }
                                    // else if ($month_name == 'March') {
                                    //     $start_date = date("d/m/Y", strtotime('03/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('03/31/2023'));
                                    // }
                                    // else if ($month_name == 'April') {
                                    //     $start_date = date("d/m/Y", strtotime('04/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('04/30/2023'));
                                    // }
                                    // else if ($month_name == 'May') {
                                    //     $start_date = date("d/m/Y", strtotime('05/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('05/31/2023'));
                                    // }
                                    // else if ($month_name == 'June') {
                                    //     $start_date = date("d/m/Y", strtotime('06/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('06/30/2023'));
                                    // }
                                    // else if ($month_name == 'July') {
                                    //     $start_date = date("d/m/Y", strtotime('07/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('07/31/2023'));
                                    // }
                                    // else if ($month_name == 'August') {
                                    //     $start_date = date("d/m/Y", strtotime('08/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('08/31/2023'));
                                    // }
                                    // else if ($month_name == 'September') {
                                    //     $start_date = date("d/m/Y", strtotime('09/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('09/30/2023'));
                                    // }
                                    // else if ($month_name == 'October') {
                                    //     $start_date = date("d/m/Y", strtotime('10/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('10/31/2023'));
                                    // }
                                    // else if ($month_name == 'November') {
                                    //     $start_date = date("d/m/Y", strtotime('11/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('11/30/2023'));
                                    // }
                                    // else if ($month_name == 'December') {
                                    //     $start_date = date("d/m/Y", strtotime('12/01/2023'));
                                    //     $end_date   = date("d/m/Y", strtotime('12/31/2023'));
                                    // }
                                    $months = [
                                        'January'   => [ 'start' => '01/01', 'end' => '01/31' ],
                                        'February'  => [ 'start' => '02/01', 'end' => date('Y') % 4 === 0 ? '02/29' : '02/28' ], // Leap year check
                                        'March'     => [ 'start' => '03/01', 'end' => '03/31' ],
                                        'April'     => [ 'start' => '04/01', 'end' => '04/30' ],
                                        'May'       => [ 'start' => '05/01', 'end' => '05/31' ],
                                        'June'      => [ 'start' => '06/01', 'end' => '06/30' ],
                                        'July'      => [ 'start' => '07/01', 'end' => '07/31' ],
                                        'August'    => [ 'start' => '08/01', 'end' => '08/31' ],
                                        'September' => [ 'start' => '09/01', 'end' => '09/30' ],
                                        'October'   => [ 'start' => '10/01', 'end' => '10/31' ],
                                        'November'  => [ 'start' => '11/01', 'end' => '11/30' ],
                                        'December'  => [ 'start' => '12/01', 'end' => '12/31' ]
                                    ];
                                    if (array_key_exists($month_name, $months)) {
                                        $start_date    = date("d/m/Y", strtotime($months[$month_name]['start'] . "/$currentYear"));
                                        $end_date = date("d/m/Y", strtotime($months[$month_name]['end'] . "/$currentYear"));
                                    }
                                    else {
                                        $start_date = $end_date = 'Invalid month';
                                    }
                                    if (($_SESSION['ECOL_USER_INFO']['user_role_id'] == 3)) {
                                        $strSQL = @oci_parse(
                                            $objConnect,
                                            "SELECT A.RML_ID,
										    A.TARGET,
										    A.CONCERN,
											VISIT_UNIT,
											COLL_VISIT_TOTAL(B.ID,TO_DATE('$start_date','DD/MM/YYYY'),TO_DATE('$end_date','DD/MM/YYYY')) TOTAL_VISITED,
											COLL_VISIT_UNIQUE_TOTAL(B.ID,TO_DATE ('$start_date', 'DD/MM/YYYY'),TO_DATE ('$end_date', 'DD/MM/YYYY'))VISIT_UNIQUE_TOTAL,
											COLL_SUMOF_COLLECTION(B.RML_ID,TO_DATE('$start_date','DD/MM/YYYY'),TO_DATE('$end_date','DD/MM/YYYY')) COLLECTION_AMNT
                                            FROM MONTLY_COLLECTION A, RML_COLL_APPS_USER B
                                            WHERE A.RML_ID=B.RML_ID
                                            AND TRUNC(START_DATE)=TO_DATE('$start_date','DD/MM/YYYY')
                                            AND TRUNC(END_DATE)=TO_DATE('$end_date','DD/MM/YYYY')
                                            AND B.ACCESS_APP='RML_COLL'
                                            AND B.AREA_ZONE IN (select ZONE_NAME from COLL_EMP_ZONE_SETUP where AREA_HEAD='$emp_id')"
                                        );
                                    }
                                    else {
                                        $strSQL = @oci_parse(
                                            $objConnect,
                                            "SELECT A.RML_ID,A.TARGET,A.CONCERN,
											VISIT_UNIT,COLL_VISIT_TOTAL(B.ID,TO_DATE('$start_date','DD/MM/YYYY'),TO_DATE('$end_date','DD/MM/YYYY')) TOTAL_VISITED,
											COLL_VISIT_UNIQUE_TOTAL(B.ID,TO_DATE ('$start_date', 'DD/MM/YYYY'),TO_DATE ('$end_date', 'DD/MM/YYYY'))VISIT_UNIQUE_TOTAL,
											COLL_SUMOF_COLLECTION(B.RML_ID,TO_DATE('$start_date','DD/MM/YYYY'),TO_DATE('$end_date','DD/MM/YYYY')) COLLECTION_AMNT
                                            FROM MONTLY_COLLECTION A, RML_COLL_APPS_USER B
                                            WHERE A.RML_ID=B.RML_ID
                                            AND TRUNC(START_DATE)=TO_DATE('$start_date','DD/MM/YYYY')
                                            AND TRUNC(END_DATE)=TO_DATE('$end_date','DD/MM/YYYY')
                                            AND B.ACCESS_APP='RML_COLL'"
                                        );
                                    }
                                    @oci_execute(@$strSQL);
                                    $number = 0;

                                    while ($row = @oci_fetch_assoc(@$strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td><?php echo $row['CONCERN']; ?></td>
                                            <td align="center"><?php echo $row['VISIT_UNIT']; ?></td>
                                            <td align="center"><?php echo $row['TOTAL_VISITED']; ?></td>
                                            <td align="center"><?php echo $row['VISIT_UNIQUE_TOTAL']; ?></td>
                                            <td align="center">
                                                <?php
                                                if ($row['VISIT_UNIT'] != 0) {
                                                    echo round((($row['TOTAL_VISITED'] * 100) / $row['VISIT_UNIT']), 2);
                                                }
                                                else {
                                                    echo '0'; // Or any other appropriate message or handling
                                                }
                                                ?>

                                            </td>

                                            <td align="center"><?php echo $row['TARGET']; ?></td>
                                            <td align="center"><?php echo $row['COLLECTION_AMNT']; ?></td>
                                            <td align="center">
                                                <?php
                                                if ($row['TARGET'] != 0) {
                                                    echo round((($row['COLLECTION_AMNT'] * 100) / $row['TARGET']), 2);
                                                }
                                                else {
                                                    echo '0'; // Or any other appropriate message or handling
                                                }
                                                ?>
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
    function exportF(elem) {
        var table = document.getElementById("tbl");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Concern_visit_summary.xls"); // Choose the file name
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
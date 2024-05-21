<?php
include_once ('../_helper/com_conn.php');


$DATE_INFO_QUARRY = "SELECT START_DATE,END_DATE FROM COLL_TARGET_DATE_SETUP WHERE STATUS=1";
$strSQLDATE       = @oci_parse($objConnect, $DATE_INFO_QUARRY);
@oci_execute($strSQLDATE);
$dataforDate  = @oci_fetch_assoc($strSQLDATE);
$v_start_date = date("d/m/Y", strtotime($dataforDate['START_DATE']));
$v_end_date   = date("d/m/Y", strtotime($dataforDate['END_DATE']));

$V_MONTH_START_DAY  = date('t/m/Y');
$V_MONTH_END_DAY    = date('01/m/Y');
$ZONE_WISECOLL_DATA = []; // Initialize the array to store fetched data

// Assuming $objConnect is your Oracle connection object and $ZONEWISECOLL_INFO_QUARRY is the SQL query


?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <?php
        $barchart_quary = "SELECT K.ZONE_NAME,
							(
							SELECT NVL(SUM(AMOUNT),0) TOTAL_AMOUNT
								FROM RML_COLL_MONEY_COLLECTION A, RML_COLL_APPS_USER B
									WHERE A.RML_COLL_APPS_USER_ID = B.ID
									AND B.AREA_ZONE = K.ZONE_NAME
										AND TRUNC (A.CREATED_DATE) BETWEEN TO_DATE ('$v_start_date','dd/mm/yyyy') AND TO_DATE ('$v_end_date','dd/mm/yyyy')
										AND A.BRAND = 'MAHINDRA'
										AND B.USER_TYPE='C-C'
							)MM_TOTAL
							FROM COLL_EMP_ZONE_SETUP K
							WHERE K.IS_ACTIVE = 1
							AND K.USER_TYPE='C-C'
							ORDER BY MM_TOTAL DESC";

        $ZONEWISECOLLSQL = @oci_parse($objConnect, $barchart_quary);
        @oci_execute($ZONEWISECOLLSQL);

        while ($data = @oci_fetch_assoc($ZONEWISECOLLSQL)) {
            $ZONE_WISECOLL_DATA[] = array(
                'ZONE_NAME' => $data['ZONE_NAME'],
                'MM_TOTAL'  => $data['MM_TOTAL']
            );
        }
        ?>
        <div class="row">
            <div class="col-12 col-lg-12 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                            <b> <h5 class="mb-0 text-primary">Zone Wise Collection[C-C]</h5> <span class="badge bg-success">
                                    [<?php echo $v_start_date . '-To-' . $v_end_date; ?>
                                    ]</span> </b>
                            </div>

                        </div>
                        <div id="zone_collection"></div>
                    </div>
                </div>
            </div>
        </div><!--end row-->


        <?php
        // Target vs Collection	
        $TargetVsCollectionSQL   = null;
        $TargetVsCollectionquery = "SELECT 
									B.RML_ID,
									B.EMP_NAME,
									RML_COLL_SUMOF_TARGET(b.RML_ID,'$V_MONTH_START_DAY','$V_MONTH_END_DAY') TARGET_AMNT,
									COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$v_start_date','$v_end_date') COLLECTION_AMNT 
								FROM RML_COLL_APPS_USER b 
									where  b.ACCESS_APP='RML_COLL'
									and B.IS_ACTIVE=1  
									AND b.USER_TYPE='C-C'
									and b.LEASE_USER='AH'";
        $TargetVsCollectionSQL   = @oci_parse($objConnect, $TargetVsCollectionquery);
        @oci_execute($TargetVsCollectionSQL);
        $v_total_target    = 0;
        $v_total_colletion = 0;
        while ($row = @oci_fetch_assoc($TargetVsCollectionSQL)) {
            $v_total_target    = $v_total_target + $row['TARGET_AMNT'];
            $v_total_colletion = $v_total_colletion + $row['COLLECTION_AMNT'];
        }
        ?>
        <div class="row">
            <div class="col-12 col-lg-12 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-primary"><b>Area Head Collection Progress[ <span
                                            class="badge bg-success"><?php echo $v_start_date . '-To-' . $v_end_date; ?>
                                            ] [C-C]</span> ]</b></h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="categories-list">

                            <?php

                            @oci_execute($TargetVsCollectionSQL);
                            while ($row_t = @oci_fetch_assoc($TargetVsCollectionSQL)) {
                                ?>

                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <img src="/ecollection/assets/images/avatars/default_user.png" class="rounded-circle" width="45" height="45"
                                            alt="user img">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-2"><b><?php echo $row_t['EMP_NAME'] . '[' . $row_t['RML_ID'] . ']'; ?></b>
                                        <p class="mb-2"><?php echo 'Target : ' . round($row_t['TARGET_AMNT'])
                                            . ', Collection : ' . round($row_t['COLLECTION_AMNT']); ?>
                                            <span class="float-end">
                                                <?php
                                                if ($row_t['COLLECTION_AMNT'] > 0 && $row_t['TARGET_AMNT'] > 0)
                                                    echo round(($row_t['COLLECTION_AMNT'] * 100) / $row_t['TARGET_AMNT']) . '%';
                                                else
                                                    echo '%';
                                                ?></span>
                                        </p>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-gradient-cosmic" role="progressbar" style="width: 
                                        <?php
                                        if ($row_t['COLLECTION_AMNT'] > 0 && $row_t['TARGET_AMNT'] > 0)
                                            echo round(($row_t['COLLECTION_AMNT'] * 100) / $row_t['TARGET_AMNT']) . '%';
                                        ?>"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>


        </div><!--end row-->














        <?php
        // Target vs Collection	
        $TargetVsCollectionSQL   = null;
        $TargetVsCollectionquery = "SELECT 
									B.RML_ID,
									B.EMP_NAME,
									RML_COLL_SUMOF_TARGET(b.RML_ID,'$V_MONTH_START_DAY','$V_MONTH_END_DAY') TARGET_AMNT,
									COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$v_start_date','$v_end_date') COLLECTION_AMNT 
								FROM RML_COLL_APPS_USER b 
									where  b.ACCESS_APP='RML_COLL'
									and B.IS_ACTIVE=1  
									AND b.USER_TYPE='S-C'
									and b.LEASE_USER='AH'";
        $TargetVsCollectionSQL   = @oci_parse($objConnect, $TargetVsCollectionquery);
        @oci_execute($TargetVsCollectionSQL);
        $v_total_target    = 0;
        $v_total_colletion = 0;
        while ($row = @oci_fetch_assoc($TargetVsCollectionSQL)) {
            $v_total_target    = $v_total_target + $row['TARGET_AMNT'];
            $v_total_colletion = $v_total_colletion + $row['COLLECTION_AMNT'];
        }
        ?>
        <div class="row">
            <div class="col-12 col-lg-12 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-primary"><b>Area Head Collection Progress[ <span class="badge bg-success">
                                            <?php echo $v_start_date . '-To-' . $v_end_date; ?>
                                            ] [S-C]</span></b></h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="categories-list">

                            <?php

                            @oci_execute($TargetVsCollectionSQL);
                            while ($row_t = @oci_fetch_assoc($TargetVsCollectionSQL)) {
                                ?>

                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div class="">
                                        <img src="/ecollection/assets/images/avatars/default_user.png" class="rounded-circle" width="45" height="45"
                                            alt="user img">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-2"><b><?php echo $row_t['EMP_NAME'] . '[' . $row_t['RML_ID'] . ']'; ?></b>
                                        <p class="mb-2"><?php echo 'Target : ' . round($row_t['TARGET_AMNT'])
                                            . ', Collection : ' . round($row_t['COLLECTION_AMNT']); ?>
                                            <span class="float-end">
                                                <?php
                                                if ($row_t['COLLECTION_AMNT'] > 0 && $row_t['TARGET_AMNT'] > 0)
                                                    echo round(($row_t['COLLECTION_AMNT'] * 100) / $row_t['TARGET_AMNT']) . '%';
                                                else
                                                    echo '%';
                                                ?></span>
                                        </p>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-gradient-cosmic" role="progressbar" style="width: 
                                        <?php
                                        if ($row_t['COLLECTION_AMNT'] > 0 && $row_t['TARGET_AMNT'] > 0)
                                            echo round(($row_t['COLLECTION_AMNT'] * 100) / $row_t['TARGET_AMNT']) . '%';
                                        ?>"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>


        </div><!--end row-->

    </div>
</div>
<!--end page wrapper -->

<?php

include_once ('../_includes/footer_info.php');
include_once ('../_includes/footer.php');
?>

<script>
    var ZONE_WISECOLL_DATA = <?php echo json_encode($ZONE_WISECOLL_DATA); ?>;

    var options = {
        series: [{
            data: ZONE_WISECOLL_DATA.map(function (entry) {
                return entry.MM_TOTAL;
            })
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        tooltip: {
            custom: function ({
                series,
                seriesIndex,
                dataPointIndex
            }) {
                return '<div class="text-success fw-bold p-2">' +
                    '<u>' + (series[seriesIndex][dataPointIndex]).toFixed(2) + ' Tk</u>' +
                    '</div>'
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + "";
            },
            offsetY: 15, // play with this value
            style: {
                fontSize: "12px",
                colors: ["#fff"],
                transform: "rotate(900deg)",

            },
        },

        fill: {
            type: "gradient",
            gradient: {
                shade: "light",
                gradientToColors: [
                    "#8f50ff",
                ],
                shadeIntensity: 1,
                type: "vertical",
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100, 100, 100],
            },
        },
        colors: [
            "#d13adf"
        ],
        plotOptions: {
            bar: {
                borderRadius: 25,
                dataLabels: {
                    orientation: 'vertical',
                    position: 'bottom' // bottom/center/top
                }
            }
        },
        xaxis: {
            categories: ZONE_WISECOLL_DATA.map(function (entry) {
                return entry.ZONE_NAME;
            }),
        }
    };
    var chart = new ApexCharts(document.querySelector("#zone_collection"), options);

    chart.render();
</script>
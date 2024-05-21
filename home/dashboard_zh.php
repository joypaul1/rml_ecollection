<?php
include_once ('../_helper/com_conn.php');

$v_sesstion_id = $emp_session_id;
if (isset($_GET['area_heade_id'])) {
    $v_sesstion_id = $_GET['area_heade_id'];
}

$DATE_INFO_QUARRY = "SELECT START_DATE,END_DATE FROM COLL_TARGET_DATE_SETUP WHERE STATUS=1";
$strSQLDATE       = @oci_parse($objConnect, $DATE_INFO_QUARRY);
@oci_execute($strSQLDATE);
$dataforDate  = @oci_fetch_assoc($strSQLDATE);
$v_start_date = date("d/m/Y", strtotime($dataforDate['START_DATE']));
$v_end_date   = date("d/m/Y", strtotime($dataforDate['END_DATE']));


//=======Concern List=======================
$query  = "SELECT COUNT(RML_ID) TOTAL_CONCERN,
                'Total Concern' MIDDLE_TITLE,
                'As Of Admin Setup' FOOTER_TITLE
        FROM MONTLY_COLLECTION
        WHERE IS_ACTIVE=1
        AND ZONAL_HEAD='$v_sesstion_id'";
$strSQL = @oci_parse($objConnect, $query);
@oci_execute($strSQL);
$dataRowConcern = @oci_fetch_assoc($strSQL);
//=======End Concern List==================
$TargetVsCollectionSQL = null;
// Target vs Collection
$TargetVsCollectionquery = "SELECT  CONCERN,
            ZONE,
            ROUND(TARGET_AMNT) TARGET_AMNT,
            COLLECTION_AMNT,
            round((COLLECTION_AMNT*100)/TARGET_AMNT) PROGRESS
    FROM
        (SELECT CONCERN,ZONE,TARGET TARGET_AMNT,
                COLL_SUMOF_RECEIVED_AMOUNT(RML_ID,'CC','','$v_start_date','$v_end_date') 
                COLLECTION_AMNT 
                FROM MONTLY_COLLECTION
                WHERE IS_ACTIVE=1
                AND ZONAL_HEAD='$v_sesstion_id'
        )
        ORDER BY PROGRESS DESC";
$TargetVsCollectionSQL   = @oci_parse($objConnect, $TargetVsCollectionquery);
@oci_execute($TargetVsCollectionSQL);
$v_total_target    = 0;
$v_total_colletion = 0;
while ($row = @oci_fetch_assoc($TargetVsCollectionSQL)) {
    $v_total_target    = $v_total_target + $row['TARGET_AMNT'];
    $v_total_colletion = $v_total_colletion + $row['COLLECTION_AMNT'];
}


?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            <div class="col">
                <div class="card rounded-4 bg-gradient-rainbow">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white"><?php echo $dataRowConcern['MIDDLE_TITLE']; ?></p>
                                <h4 class="my-1 text-white"><?php echo $dataRowConcern['TOTAL_CONCERN']; ?></h4>
                                <p class="mb-0 font-13 text-white"><?php echo $dataRowConcern['FOOTER_TITLE']; ?></p>
                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-group'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 bg-gradient-worldcup">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white">Total Target</p>
                                <h4 class="my-1 text-white"><?php echo number_format($v_total_target); ?></h4>
                                <p class="mb-0 font-13 text-white">Month of <?php echo date('F Y') ?></p>
                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-cart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 bg-gradient-smile">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white">Total Collection</p>
                                <h4 class="my-1 text-white"><?php echo number_format($v_total_colletion); ?></h4>
                                <p class="mb-0 font-13 text-white"><?php echo $v_start_date . '-To-' . $v_end_date; ?></p>
                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-wallet'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card rounded-4 bg-gradient-pinki">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-white">Growth Rate</p>
                                <h4 class="my-1 text-white"><?php
                                if ($v_total_target > 0) {
                                    echo round((($v_total_colletion * 100) / $v_total_target), 2);
                                }
                                else {
                                    echo "0";
                                }

                                ?> %</h4>
                                <p class="mb-0 font-13 text-white"><?php echo $v_start_date . '-To-' . $v_end_date; ?></p>
                            </div>
                            <div class="fs-1 text-white"><i class='bx bxs-bar-chart-alt-2'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->

        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header border-success">
                        <div class="d-flex align-items-center justify-content-left">
                            <div class="">
                                <h6 class="mb-0 border-success">
                                    <strong class="text-primary">
                                        <i class="bx bx-flag text-primary"></i>
                                        Concern Dashboard Summary of
                                        <span class="badge bg-success">
                                            <?php echo $v_start_date . '-To-' . $v_end_date; ?>
                                        </span>
                                    </strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <style>
                        .tbPink {
                            background-color: #d115db38 !important;
                            text-align: center;
                            font-weight: bold;
                        }

                        table.concerntList {
                            font-size: 14px;
                        }

                        .table-sm>:not(caption)>*>* {
                            padding: 0.1rem 0.1rem;
                        }
                    </style>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0 concerntList table-hover">
                                <thead class="bg-gradient-smile text-center text-white fw-bold">
                                    <tr>
                                        <th>SL</th>
                                        <th>Concern Name</th>
                                        <th> </th>
                                        <th>Total Code <br> Units</th>
                                        <th>Total Visit <br> Assign Units</th>
                                        <th>Total Visited <br> Units</th>
                                        <th>Unique Visit <br> Assign Units</th>
                                        <th>Unique Visited <br>Units</th>
                                        <th>Not Touching <br>Units</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $query  = "SELECT 
                                    ZONE,
                                    RML_ID,
                                    CONCERN,
                                    CODE_ASSIGN_INFO(RML_ID,'TOTAL_CODE')                        TOTAL_CODE,
									CODE_ASSIGN_INFO(RML_ID,'TOTAL_CODE_ON_ROAD')                TOTAL_CODE_ON_ROAD,
									CODE_ASSIGN_INFO(RML_ID,'TOTAL_VISIT_ASSIGN')                TOTAL_VISIT_ASSIGN,
									CODE_ASSIGN_INFO(RML_ID,'TOTAL_VISIT_ASSIGN_ON_ROAD')        TOTAL_VISIT_ASSIGN_ON_ROAD,
									CODE_ASSIGN_INFO(RML_ID,'UNIQUE_VISIT_ASSIGN')               UNIQUE_VISIT_ASSIGN,
									CODE_ASSIGN_INFO(RML_ID,'UNIQUE_VISIT_ASSIGN_ON_ROAD')       UNIQUE_VISIT_ASSIGN_ON_ROAD,
									CODE_ASSIGN_INFO(RML_ID,'TOTAL_VISITED')                     TOTAL_VISITED,
									CODE_ASSIGN_INFO(RML_ID,'TOTAL_VISITED_ON_ROAD')             TOTAL_VISITED_ON_ROAD,
									CODE_ASSIGN_INFO(RML_ID,'UNIQUE_VISITED')                    UNIQUE_VISITED,
								    CODE_ASSIGN_INFO(RML_ID,'UNIQUE_VISITED_ON_ROAD')            UNIQUE_VISITED_ON_ROAD
                                FROM MONTLY_COLLECTION A
                                WHERE IS_ACTIVE=1
								--AND RML_ID='802'
                                AND ZONAL_HEAD='$v_sesstion_id'";
                                    $strSQL = @oci_parse($objConnect, $query);
                                    @oci_execute($strSQL);
                                    $sl = 0;
                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        $sl++;
                                        ?>

                                        <tr>
                                            <td rowspan="3" class="text-center"><?php echo $sl; ?></td>
                                            <td rowspan="3"><?php echo $row['CONCERN']; ?>
                                                <br>
                                                Zone: <strong class="text-danger"><?php echo $row['ZONE']; ?></strong>
                                            </td>

                                            <td class="bg-warning fw-bold text-end">
                                                On Road :
                                            </td>
                                            <td class="tbPink table-success">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                            <?php echo
                                                '&concern_id=' . $row['RML_ID']
                                                . '&start_date=' . $v_start_date
                                                . '&end_date=' . $v_end_date
                                                . '&want=TOTAL_CODE_ON_ROAD'
                                            ;
                                            ?>">
                                                        <?php echo $row['TOTAL_CODE_ON_ROAD']; ?>
                                                    </a>
                                                </u>
                                            </td>
                                            <td class="tbPink table-success">
                                                <u><a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=TOTAL_VISIT_ASSIGN_ON_ROAD'
                                                ;
                                                ?>">
                                                        <?php echo $row['TOTAL_VISIT_ASSIGN_ON_ROAD']; ?>
                                                    </a></u>
                                            </td>

                                            <td class="tbPink table-success">
                                                <u><a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=TOTAL_VISITED_ON_ROAD'
                                                ;
                                                ?>">
                                                        <?php echo $row['TOTAL_VISITED_ON_ROAD']; ?>
                                                    </a></u>
                                            </td>


                                            <td class="tbPink table-success">
                                                <u><a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISIT_ASSIGN_ON_ROAD'
                                                ;
                                                ?>">
                                                        <?php echo $row['UNIQUE_VISIT_ASSIGN_ON_ROAD']; ?>
                                                    </a></u>
                                            </td>

                                            <td class="tbPink table-success">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISITED_ON_ROAD';
                                                ?>">
                                                        <?php echo $row['UNIQUE_VISITED_ON_ROAD']; ?>
                                                    </a>
                                                </u>
                                            </td>


                                            <td class="tbPink table-success">
                                                <u><a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISIT_NOT_TOACHING_ON_ROAD'
                                                ;
                                                ?>">
                                                        <?php echo ($row['TOTAL_CODE_ON_ROAD'] - $row['UNIQUE_VISIT_ASSIGN_ON_ROAD']); ?>
                                                    </a></u>
                                            </td>


                                        </tr>
                                        <tr>

                                            <td class="bg-warning fw-bold text-end">
                                                Others :
                                            </td>
                                            <td class="tbPink table-warning">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                            <?php echo
                                                '&concern_id=' . $row['RML_ID']
                                                . '&start_date=' . $v_start_date
                                                . '&end_date=' . $v_end_date
                                                . '&want=TOTAL_CODE_OTHERS'
                                            ;
                                            ?>">
                                                        <?php echo ($row['TOTAL_CODE'] - $row['TOTAL_CODE_ON_ROAD']); ?>
                                                    </a>
                                                </u>

                                            </td>
                                            <td class="tbPink table-warning">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=TOTAL_VISIT_ASSIGN_OTHERS'
                                                ;
                                                ?>">
                                                        <?php echo ($row['TOTAL_VISIT_ASSIGN'] - $row['TOTAL_VISIT_ASSIGN_ON_ROAD']); ?>
                                                    </a>
                                                </u>
                                            </td>

                                            <td class="tbPink table-warning">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=TOTAL_VISITED_OTHERS'
                                                ;
                                                ?>">
                                                        <?php echo ($row['TOTAL_VISITED'] - $row['TOTAL_VISITED_ON_ROAD']); ?>
                                                    </a>
                                                </u>
                                            </td>
                                            <td class="tbPink table-warning">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISIT_ASSIGN_OTHERS'
                                                ;
                                                ?>">
                                                        <?php echo ($row['UNIQUE_VISIT_ASSIGN'] - $row['UNIQUE_VISIT_ASSIGN_ON_ROAD']); ?>
                                                    </a>
                                                </u>
                                            </td>

                                            <td class="tbPink table-warning">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISITED_OTHERS'
                                                ;
                                                ?>">
                                                        <?php echo ($row['UNIQUE_VISITED'] - $row['UNIQUE_VISITED_ON_ROAD']); ?>
                                                    </a>
                                                </u>
                                            </td>



                                            <td class="tbPink table-warning">
                                                <u><a class="text-black" href="cc_visit_code.php?
                                                <?php
                                                $TOTAL_NOT_TOUCHING         = ($row['TOTAL_CODE'] - $row['UNIQUE_VISIT_ASSIGN']);
                                                $TOTAL_NOT_TOUCHING_ON_ROAD = ($row['TOTAL_CODE_ON_ROAD'] - $row['UNIQUE_VISIT_ASSIGN_ON_ROAD']);
                                                echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISIT_NOT_TOACHING_OTHERS'
                                                ;
                                                ?>">
                                                        <?php echo $TOTAL_NOT_TOUCHING - $TOTAL_NOT_TOUCHING_ON_ROAD; ?>
                                                    </a></u>
                                            </td>



                                        </tr>




                                        <!--Total Row-->
                                        <tr style="border-bottom: 2px solid black">
                                            <td class="bg-gradient-smile fw-bold text-end">Total :</td>
                                            <td class="tbPink bg-gradient-smile">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=TOTAL_CODE';
                                                ?>">
                                                        <?php echo $row['TOTAL_CODE']; ?>
                                                    </a>
                                                </u>
                                            </td>
                                            <td class="tbPink bg-gradient-smile">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=TOTAL_VISIT_ASSIGN'
                                                ;
                                                ?>">
                                                        <?php echo $row['TOTAL_VISIT_ASSIGN']; ?>
                                                    </a>
                                                </u>
                                            </td>
                                            <td class="tbPink bg-gradient-smile">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=TOTAL_VISITED';
                                                ?>">
                                                        <?php echo $row['TOTAL_VISITED']; ?>
                                                    </a>
                                                </u>
                                            </td>
                                            <td class="tbPink bg-gradient-smile">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISIT_ASSIGN';
                                                ?>">
                                                        <?php echo $row['UNIQUE_VISIT_ASSIGN']; ?>
                                                    </a>
                                                </u>
                                            </td>
                                            <td class="tbPink bg-gradient-smile">
                                                <u><a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_VISITED';
                                                ?>">
                                                        <?php echo $row['UNIQUE_VISITED']; ?>
                                                    </a></u>
                                            </td>
                                            <td class="tbPink bg-gradient-smile">
                                                <u>
                                                    <a class="text-black" href="cc_visit_code.php?
                                                <?php echo
                                                    '&concern_id=' . $row['RML_ID']
                                                    . '&start_date=' . $v_start_date
                                                    . '&end_date=' . $v_end_date
                                                    . '&want=UNIQUE_CODE_NOT_TOUCHING';
                                                ?>">
                                                        <?php echo ($row['TOTAL_CODE'] - $row['UNIQUE_VISIT_ASSIGN']); ?>
                                                    </a>
                                                </u>
                                            </td>


                                        </tr>
                                        <!--Total Row-->

                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->



        <div class="row">
            <div class="col-12 col-lg-12 d-flex">
                <div class="card rounded-4 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-primary"><b>Collection Progress[ <span class="badge bg-success">
                                            <?php echo $v_start_date . '-To-' . $v_end_date; ?>
                                        </span>]</b></h6>
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
                                        <p class="mb-2"><b><?php echo $row_t['CONCERN'] . '[' . $row_t['ZONE'] . ']'; ?></b>
                                        <p class="mb-2"><?php echo 'Target : ' . round($row_t['TARGET_AMNT'])
                                            . ', Collection : ' . round($row_t['COLLECTION_AMNT']); ?>
                                            <span class="float-end">
                                                <?php
                                                echo $row_t['PROGRESS'] . '%';
                                                ?></span>
                                        </p>
                                        <div class="progress" style="height: 4px;">
                                            <div class="progress-bar bg-gradient-cosmic" role="progressbar" style="width: 
                                        <?php
                                        echo $row_t['PROGRESS'] . '%';
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
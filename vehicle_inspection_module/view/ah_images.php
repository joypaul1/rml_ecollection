<?php

include_once('../../_helper/2step_com_conn.php');
// include_once('../../_config/sqlConfig.php');

$P_AREA_HEAD = $_SESSION['ECOL_USER_INFO']['emp_id'];
$P_AREA_HEAD = (int) substr($P_AREA_HEAD, strrpos($P_AREA_HEAD, '-') + 1);
if (isset($_GET['area_head']) && !empty($_GET['area_head'])) {
    $P_AREA_HEAD = $_GET['area_head'];
}
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <?PHP
        // $emp_session_id = $_SESSION['ECOL_USER_INFO']['emp_id'];
        // $COL_ID = (int) substr($emp_session_id, strrpos($emp_session_id, '-') + 1);
        // if (isset($_GET['area_head']) && !empty($_GET['area_head'])) {
        //     $COL_ID = (int) substr($_GET['area_head'], strrpos($_GET['area_head'], '-') + 1);
        // }
        $strSQL = @oci_parse(
            $objConnect,
            "WITH ZH AS (
                    SELECT
                        Z.ZONE_NAME,
                        Z.ZONE_HEAD,
                        Z.AREA_HEAD,
                        ZU.EMP_NAME AS CONCERN_NAME,
                        AU.EMP_NAME AS AREA_HEAD_NAME
                    FROM COLL_EMP_ZONE_SETUP Z
                    LEFT JOIN RML_COLL_APPS_USER ZU ON ZU.RML_ID = Z.ZONE_HEAD
                    LEFT JOIN RML_COLL_APPS_USER AU ON AU.RML_ID = Z.AREA_HEAD
                    WHERE Z.IS_ACTIVE = 1
                    AND Z.AREA_HEAD = '$P_AREA_HEAD'
                ),
                CC AS (
                    SELECT
                        ZH.ZONE_NAME,
                        ZH.ZONE_HEAD,
                        ZH.AREA_HEAD,
                        ZH.CONCERN_NAME,
                        ZH.AREA_HEAD_NAME,
                        C.RML_ID AS COLL_RML_ID,
                        'RML-' || LPAD(C.RML_ID, 5, '0') AS HR_RML_ID,
                        LPAD(C.RML_ID, 6, '0') AS ERP_RML_ID
                    FROM ZH
                    JOIN RML_COLL_APPS_USER C
                    ON TRIM(UPPER(C.AREA_ZONE)) = TRIM(UPPER(ZH.ZONE_NAME))
                    WHERE C.IS_ACTIVE = 1
                    AND C.USER_TYPE = 'C-C'
                ),
                ERP_CODES AS (
                    SELECT DISTINCT COLL_CONCERN_ID AS ERP_RML_ID, REF_CODE
                    FROM LEASE_ALL_INFO_ERP
                    WHERE PAMTMODE = 'CRT' AND STATUS = 'Y' AND REF_CODE IS NOT NULL
                ),
                VI_CODES AS (
                    SELECT DISTINCT CREATED_BY AS HR_RML_ID, REF_CODE
                    FROM VEHICLE_INSPECTION
                    WHERE REF_CODE IS NOT NULL
                ),
                MATCHED AS (
                    SELECT CC.COLL_RML_ID, E.REF_CODE
                    FROM CC
                    JOIN ERP_CODES E ON E.ERP_RML_ID = CC.ERP_RML_ID
                    JOIN VI_CODES  V ON V.HR_RML_ID  = CC.HR_RML_ID
                                AND V.REF_CODE    = E.REF_CODE
                ),
                ASSIGNED AS (
                    SELECT CC.COLL_RML_ID, COUNT(DISTINCT E.REF_CODE) AS ASSIGNED_COUNT
                    FROM CC
                    LEFT JOIN ERP_CODES E ON E.ERP_RML_ID = CC.ERP_RML_ID
                    GROUP BY CC.COLL_RML_ID
                ),
                INSPECTED_ASSIGNED AS (
                    SELECT COLL_RML_ID, COUNT(DISTINCT REF_CODE) AS INSPECTED_ASSIGNED_COUNT
                    FROM MATCHED
                    GROUP BY COLL_RML_ID
                ),
                VI_TOTAL AS (
                    SELECT HR_RML_ID, COUNT(DISTINCT REF_CODE) AS TOTAL_VI_REF_CODE
                    FROM VI_CODES
                    GROUP BY HR_RML_ID
                ),
                EXTRA_INSPECTION AS (
                    SELECT CC.COLL_RML_ID, COUNT(DISTINCT V.REF_CODE) AS EXTRA_INSPECTION_COUNT
                    FROM CC
                    JOIN VI_CODES V ON V.HR_RML_ID = CC.HR_RML_ID
                    LEFT JOIN ERP_CODES E ON E.ERP_RML_ID = CC.ERP_RML_ID
                                        AND E.REF_CODE   = V.REF_CODE
                    WHERE E.REF_CODE IS NULL
                    GROUP BY CC.COLL_RML_ID
                ),
                DETAIL AS (
                    SELECT
                        CC.AREA_HEAD, CC.AREA_HEAD_NAME,
                        CC.ZONE_HEAD, CC.CONCERN_NAME,
                        CC.COLL_RML_ID,
                        NVL(A.ASSIGNED_COUNT, 0)            AS ASSIGNED_COUNT,
                        NVL(IA.INSPECTED_ASSIGNED_COUNT, 0) AS INSPECTED_ASSIGNED_COUNT,
                        NVL(VT.TOTAL_VI_REF_CODE, 0)        AS TOTAL_VI_REF_CODE,
                        NVL(EX.EXTRA_INSPECTION_COUNT, 0)   AS EXTRA_INSPECTION_COUNT
                    FROM CC
                    LEFT JOIN ASSIGNED A            ON A.COLL_RML_ID = CC.COLL_RML_ID
                    LEFT JOIN INSPECTED_ASSIGNED IA ON IA.COLL_RML_ID = CC.COLL_RML_ID
                    LEFT JOIN VI_TOTAL VT           ON VT.HR_RML_ID = CC.HR_RML_ID
                    LEFT JOIN EXTRA_INSPECTION EX   ON EX.COLL_RML_ID = CC.COLL_RML_ID
                ),
                DETAIL_DISTINCT AS (
                    SELECT DISTINCT
                        AREA_HEAD, AREA_HEAD_NAME,
                        ZONE_HEAD, CONCERN_NAME, COLL_RML_ID,
                        ASSIGNED_COUNT, INSPECTED_ASSIGNED_COUNT, TOTAL_VI_REF_CODE, EXTRA_INSPECTION_COUNT
                    FROM DETAIL
                )
                SELECT
                    AREA_HEAD,
                    AREA_HEAD_NAME,
                    ZONE_HEAD,
                    CONCERN_NAME,
                    LISTAGG(COLL_RML_ID, ',') WITHIN GROUP (ORDER BY COLL_RML_ID) AS COLL_RML_ID_LIST,

                    SUM(ASSIGNED_COUNT)           AS ASSIGNED_COUNT,
                    SUM(INSPECTED_ASSIGNED_COUNT) AS INSPECTED_ASSIGNED_COUNT,
                    SUM(TOTAL_VI_REF_CODE)        AS TOTAL_VI_REF_CODE,
                    SUM(EXTRA_INSPECTION_COUNT)   AS EXTRA_INSPECTION_COUNT
                FROM DETAIL_DISTINCT
                GROUP BY AREA_HEAD, AREA_HEAD_NAME, ZONE_HEAD, CONCERN_NAME
                ORDER BY ZONE_HEAD"
        );
        ?>
        <div class="row">

            <div class="card rounded-4">
                <?php

                $headerType = 'List';
                $leftSideName = 'Zonal Head Wise Summary';
                include('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-cust text-uppercase">
                                <tr class="text-center">
                                    <th scope="col">Sl</th>
                                    <th scope="col">ZONE NAME</th>
                                    <th scope="col">View Details</th>
                                    <th scope="col">CONCERN NAME</th>
                                    <!-- <th scope="col">COLL_RML_ID</th>
                                    <th scope="col">HR_RML_ID</th>
                                    <th scope="col">ERP_RML_ID</th> -->

                                    <th scope="col">ERP ASSIGNED COUNT</th>
                                    <th scope="col">INSPECTED ASSIGNED COUNT</th>
                                    <th scope="col">TOTAL VI REF CODE</th>
                                    <th scope="col">EXTRA INSPECTION COUNT</th>

                                    <th scope="col">PENDING COUNT</th>
                                    <th scope="col">COMPLETION PERCENT</th>
                                    <th scope="col">DIFFERENCE PERCENT</th>
                                    <th scope="col">EXTRA INSPECTION PERCENT</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                // EXECUTE (NO @)
                                $ok = oci_execute($strSQL);
                                if (!$ok) {
                                    $e = oci_error($strSQL);
                                    echo '<tr><td colspan="15" class="text-center text-danger">'
                                        . htmlspecialchars($e['message'] ?? 'QUERY EXECUTE FAILED')
                                        . '</td></tr>';
                                } else {

                                    $number = 0;
                                    $hasRow = false;

                                    // Grand totals (counts only)
                                    $GT_ASSIGNED = 0;
                                    $GT_INSPECTED_ASSIGNED = 0;
                                    $GT_TOTAL_VI = 0;
                                    $GT_EXTRA = 0;
                                    $GT_PENDING = 0;

                                    while (($row = oci_fetch_assoc($strSQL)) !== false) {
                                        $hasRow = true;
                                        $number++;

                                        // text fields
                                        $concernName = $row['CONCERN_NAME'] ? $row['CONCERN_NAME'] : '';
                                        // $zoneHead = $row['ZONE_HEAD'] ?? '';
                                        $ZONE_HEAD = $row['ZONE_HEAD'] ? $row['ZONE_HEAD'] : '';
                                        // $collRmlId = $row['COLL_RML_ID'] ?? '';
                                        // $hrRmlId = $row['HR_RML_ID'] ?? '';
                                        // $erpRmlId = $row['ERP_RML_ID'] ?? '';
                                
                                        // numeric fields
                                        $assigned = (int) ($row['ASSIGNED_COUNT'] ?? 0);
                                        $insAssigned = (int) ($row['INSPECTED_ASSIGNED_COUNT'] ?? 0);
                                        $totalVi = (int) ($row['TOTAL_VI_REF_CODE'] ?? 0);
                                        $extra = (int) ($row['EXTRA_INSPECTION_COUNT'] ?? 0);
                                        $pending = (int) ($row['PENDING_COUNT'] ?? 0);

                                        // percents can be NULL from SQL
                                        $completionPct = is_numeric($row['COMPLETION_PERCENT'] ?? null) ? (float) $row['COMPLETION_PERCENT'] : null;
                                        $diffPct = is_numeric($row['DIFFERENCE_PERCENT'] ?? null) ? (float) $row['DIFFERENCE_PERCENT'] : null;
                                        $extraPct = is_numeric($row['EXTRA_INSPECTION_PERCENT'] ?? null) ? (float) $row['EXTRA_INSPECTION_PERCENT'] : null;

                                        // accumulate grand totals
                                        $GT_ASSIGNED += $assigned;
                                        $GT_INSPECTED_ASSIGNED += $insAssigned;
                                        $GT_TOTAL_VI += $totalVi;
                                        $GT_EXTRA += $extra;
                                        $GT_PENDING += $pending;
                                        ?>
                                        <tr class="text-center">
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo htmlspecialchars($concernName); ?></td>
                                            <td><a target="_blank"
                                                    href="zh_images.php?rml_id=<?= htmlspecialchars($ZONE_HEAD) ?>"
                                                    class="btn btn-sm  btn-gradient-success">View Details<i
                                                        class='bx bxs-right-arrow-square'></i></a></td>
                                            <td><?php echo htmlspecialchars($concernName); ?></td>
                                            <!-- <td><?php echo htmlspecialchars($collRmlId); ?></td>
                                            <td><?php echo htmlspecialchars($hrRmlId); ?></td>
                                            <td><?php echo htmlspecialchars($erpRmlId); ?></td> -->

                                            <td><?php echo $assigned; ?></td>
                                            <td><?php echo $insAssigned; ?></td>
                                            <td><?php echo $totalVi; ?></td>
                                            <td><?php echo $extra; ?></td>

                                            <td><?php echo $pending; ?></td>
                                            <td>
                                                <?php echo ($completionPct === null) ? '-' : number_format($completionPct, 2) . ' %'; ?>
                                            </td>
                                            <td>
                                                <?php echo ($diffPct === null) ? '-' : number_format($diffPct, 2) . ' %'; ?>
                                            </td>
                                            <td>
                                                <?php echo ($extraPct === null) ? '-' : number_format($extraPct, 2) . ' %'; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }

                                    if (!$hasRow) {
                                        echo '<tr><td colspan="15" class="text-center">NO DATA FOUND</td></tr>';
                                    } else {
                                        // Grand percent calculations (overall ভিত্তিতে)
                                        $GT_completionPct = ($GT_ASSIGNED == 0) ? null : round(($GT_INSPECTED_ASSIGNED / $GT_ASSIGNED) * 100, 2);
                                        $GT_diffPct = ($GT_ASSIGNED == 0) ? null : round((($GT_INSPECTED_ASSIGNED - $GT_ASSIGNED) / $GT_ASSIGNED) * 100, 2);
                                        $GT_extraPct = ($GT_TOTAL_VI == 0) ? null : round(($GT_EXTRA / $GT_TOTAL_VI) * 100, 2);
                                        ?>
                                        <tr class="table-primary text-center" style="font-weight:bold">
                                            <td></td>
                                            <td class="text-end" colspan="3">Grand Total:</td>

                                            <td><?php echo $GT_ASSIGNED; ?></td>
                                            <td><?php echo $GT_INSPECTED_ASSIGNED; ?></td>
                                            <td><?php echo $GT_TOTAL_VI; ?></td>
                                            <td><?php echo $GT_EXTRA; ?></td>

                                            <td><?php echo $GT_PENDING; ?></td>
                                            <td><?php echo ($GT_completionPct === null) ? '-' : number_format($GT_completionPct, 2) . ' %'; ?>
                                            </td>
                                            <td><?php echo ($GT_diffPct === null) ? '-' : number_format($GT_diffPct, 2) . ' %'; ?>
                                            </td>
                                            <td><?php echo ($GT_extraPct === null) ? '-' : number_format($GT_extraPct, 2) . ' %'; ?>
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
                        <a class="btn btn-sm  btn-gradient-info" onclick="exportF(this)">Export To Excel <i
                                class='bx bxs-cloud-download'></i></a>
                    </div>
                </div>
            </div>
        </div><!--end row-->

    </div>
</div>
<!--end page wrapper -->
<?php
include_once('../../_includes/footer_info.php');
include_once('../../_includes/footer.php');
?>
<script>
    function exportF(elem) {
        var table = document.getElementById("tbl");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "vehicle_inspection_report.xls"); // Choose the file name
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
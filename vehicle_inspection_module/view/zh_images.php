<?php
include_once('../../_helper/2step_com_conn.php');

$P_ZONAL_HEAD = $_SESSION['ECOL_USER_INFO']['emp_id'];
$P_ZONAL_HEAD = (int) substr($P_ZONAL_HEAD, strrpos($P_ZONAL_HEAD, '-') + 1);

if (isset($_GET['rml_id']) && $_GET['rml_id'] !== '') {
    $P_ZONAL_HEAD = (int) $_GET['rml_id'];
}

/* ===========================
   SQL (COLL_RML_ID wise % + PENDING_COUNT)
   =========================== */
$sql = "WITH ZH AS (
    SELECT
        Z.ZONE_NAME,
        Z.ZONE_HEAD,
        Z.AREA_HEAD,
        ZU.EMP_NAME AS ZONE_HEAD_NAME,
        AU.EMP_NAME AS AREA_HEAD_NAME
    FROM COLL_EMP_ZONE_SETUP Z
    LEFT JOIN RML_COLL_APPS_USER ZU ON ZU.RML_ID = Z.ZONE_HEAD
    LEFT JOIN RML_COLL_APPS_USER AU ON AU.RML_ID = Z.AREA_HEAD
    WHERE Z.IS_ACTIVE = 1
      AND Z.ZONE_HEAD = :P_ZONE_HEAD
),
CC AS (
    SELECT
        ZH.ZONE_NAME,
        ZH.ZONE_HEAD,
        ZH.ZONE_HEAD_NAME,
        C.RML_ID   AS COLL_RML_ID,
        C.EMP_NAME AS COLL_NAME,
        'RML-' || LPAD(C.RML_ID, 5, '0') AS HR_RML_ID,
        LPAD(C.RML_ID, 6, '0')           AS ERP_RML_ID
    FROM ZH
    JOIN RML_COLL_APPS_USER C
      ON TRIM(UPPER(C.AREA_ZONE)) = TRIM(UPPER(ZH.ZONE_NAME))
    WHERE C.IS_ACTIVE = 1
      AND C.USER_TYPE = 'C-C'
),
ERP_CODES AS (
    SELECT DISTINCT COLL_CONCERN_ID AS ERP_RML_ID, REF_CODE
    FROM LEASE_ALL_INFO_ERP
    WHERE PAMTMODE = 'CRT'
      AND STATUS = 'Y'
      AND REF_CODE IS NOT NULL
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
                    AND V.REF_CODE   = E.REF_CODE
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
        CC.ZONE_NAME,
        CC.ZONE_HEAD,
        CC.ZONE_HEAD_NAME,
        CC.COLL_RML_ID,
        CC.COLL_NAME,
        NVL(A.ASSIGNED_COUNT, 0)            AS ASSIGNED_COUNT,
        NVL(IA.INSPECTED_ASSIGNED_COUNT, 0) AS INSPECTED_ASSIGNED_COUNT,
        NVL(VT.TOTAL_VI_REF_CODE, 0)        AS TOTAL_VI_REF_CODE,
        NVL(EX.EXTRA_INSPECTION_COUNT, 0)   AS EXTRA_INSPECTION_COUNT
    FROM CC
    LEFT JOIN ASSIGNED A             ON A.COLL_RML_ID = CC.COLL_RML_ID
    LEFT JOIN INSPECTED_ASSIGNED IA  ON IA.COLL_RML_ID = CC.COLL_RML_ID
    LEFT JOIN VI_TOTAL VT            ON VT.HR_RML_ID = CC.HR_RML_ID
    LEFT JOIN EXTRA_INSPECTION EX    ON EX.COLL_RML_ID = CC.COLL_RML_ID
),
DETAIL_DISTINCT AS (
    SELECT DISTINCT
        ZONE_NAME, ZONE_HEAD, ZONE_HEAD_NAME,
        COLL_RML_ID, COLL_NAME,
        ASSIGNED_COUNT, INSPECTED_ASSIGNED_COUNT, TOTAL_VI_REF_CODE, EXTRA_INSPECTION_COUNT
    FROM DETAIL
),
ZONE_LIST AS (
    SELECT
        ZONE_NAME,
        ZONE_HEAD,
        ZONE_HEAD_NAME,
        LISTAGG(COLL_RML_ID, ',') WITHIN GROUP (ORDER BY COLL_RML_ID) AS COLL_RML_ID_LIST
    FROM DETAIL_DISTINCT
    GROUP BY ZONE_NAME, ZONE_HEAD, ZONE_HEAD_NAME
)
SELECT
    D.ZONE_NAME,
    D.ZONE_HEAD,
    D.ZONE_HEAD_NAME,

    /* list only once (first row) */
    CASE
        WHEN ROW_NUMBER() OVER (PARTITION BY D.ZONE_HEAD ORDER BY D.COLL_RML_ID) = 1
        THEN ZL.COLL_RML_ID_LIST
    END AS COLL_RML_ID_LIST,

    D.COLL_RML_ID,
    D.COLL_NAME,
    D.ASSIGNED_COUNT,
    D.INSPECTED_ASSIGNED_COUNT,
    D.TOTAL_VI_REF_CODE,
    D.EXTRA_INSPECTION_COUNT,

    (D.ASSIGNED_COUNT - D.INSPECTED_ASSIGNED_COUNT) AS PENDING_COUNT,

    ROUND(NVL((D.INSPECTED_ASSIGNED_COUNT * 100) / NULLIF(D.ASSIGNED_COUNT, 0), 0), 2) AS COMPLETION_PERCENT,
    ROUND(NVL(((D.ASSIGNED_COUNT - D.INSPECTED_ASSIGNED_COUNT) * 100) / NULLIF(D.ASSIGNED_COUNT, 0), 0), 2) AS DIFFERENCE_PERCENT,
    ROUND(NVL((D.EXTRA_INSPECTION_COUNT * 100) / NULLIF(D.TOTAL_VI_REF_CODE, 0), 0), 2) AS EXTRA_INSPECTION_PERCENT

FROM DETAIL_DISTINCT D
JOIN ZONE_LIST ZL
  ON ZL.ZONE_NAME = D.ZONE_NAME
 AND ZL.ZONE_HEAD = D.ZONE_HEAD
ORDER BY D.COLL_RML_ID
";

$strSQL = oci_parse($objConnect, $sql);
oci_bind_by_name($strSQL, ':P_ZONE_HEAD', $P_ZONAL_HEAD);
?>

<style>
    /* Bootstrap 5 sticky table header */
    .tableFixHead {
        max-height: 70vh;
        overflow: auto;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #791fe1;
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
    }
</style>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card rounded-4">
                <?php
                $headerType = 'List';
                $leftSideName = 'Zonal Head wise Concern Summary';
                include('../../_includes/com_header.php');
                ?>

                <div class="card-body">
                    <div class="tableFixHead">

                        <?php
                        $ok = oci_execute($strSQL);
                        if (!$ok) {
                            $e = oci_error($strSQL);
                            echo '<div class="text-center text-danger">'
                                . htmlspecialchars($e['message'] ? $e['message'] : 'QUERY EXECUTE FAILED')
                                . '</div>';
                        } else {

                            // Fetch all rows first (so we can show COLL_RML_ID_LIST once)
                            $rows = [];
                            while (($r = oci_fetch_assoc($strSQL)) !== false) {
                                $rows[] = $r;
                            }

                            $collList = '';
                            $zoneNameTop = '';
                            $zoneHeadNameTop = '';

                            foreach ($rows as $r) {
                                if ($zoneNameTop === '' && !empty($r['ZONE_NAME']))
                                    $zoneNameTop = $r['ZONE_NAME'];
                                if ($zoneHeadNameTop === '' && !empty($r['ZONE_HEAD_NAME']))
                                    $zoneHeadNameTop = $r['ZONE_HEAD_NAME'];
                                if ($collList === '' && !empty($r['COLL_RML_ID_LIST']))
                                    $collList = $r['COLL_RML_ID_LIST'];
                            }

                            if ($zoneNameTop !== '' || $zoneHeadNameTop !== '') {
                                echo '<div class="mb-2"><b>ZONE:</b> ' . htmlspecialchars($zoneNameTop)
                                    . ' &nbsp; | &nbsp; <b>ZONAL HEAD:</b> ' . htmlspecialchars($zoneHeadNameTop)
                                    . '</div>';
                            }

                            // if ($collList !== '') {
                            //     echo '<div class="mb-3"><b>COLL_RML_ID_LIST:</b> '
                            //         . htmlspecialchars($collList)
                            //         . '</div>';
                            // }
                            ?>

                            <table id="tbl" class="table table-bordered align-middle mb-0">
                                <thead class="table-cust text-uppercase">
                                    <tr class="text-center">
                                        <th scope="col">Sl</th>
                                        <th scope="col">COLL RML ID</th>
                                        <th scope="col">COLL NAME</th>
                                        <th scope="col">ACTION</th>

                                        <th scope="col">ERP ASSIGNED</th>
                                        <th scope="col">INSPECTED ASSIGNED</th>
                                        <th scope="col">TOTAL VI</th>
                                        <th scope="col">EXTRA INSPECTION</th>

                                        <th scope="col">PENDING</th>
                                        <th scope="col">COMPLETION %</th>
                                        <th scope="col">DIFFERENCE %</th>
                                        <th scope="col">EXTRA INSPECTION %</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if (empty($rows)) {
                                        echo '<tr><td colspan="12" class="text-center">NO DATA FOUND</td></tr>';
                                    } else {

                                        $number = 0;

                                        // Grand totals
                                        $GT_ASSIGNED = 0;
                                        $GT_INSPECTED_ASSIGNED = 0;
                                        $GT_TOTAL_VI = 0;
                                        $GT_EXTRA = 0;
                                        $GT_PENDING = 0;

                                        foreach ($rows as $row) {
                                            $number++;

                                            $collRmlId = $row['COLL_RML_ID'] ? $row['COLL_RML_ID'] : '';
                                            $collName = $row['COLL_NAME'] ? $row['COLL_NAME'] : '';

                                            $assigned = (int) ($row['ASSIGNED_COUNT'] ? $row['ASSIGNED_COUNT'] : 0);
                                            $insAssigned = (int) ($row['INSPECTED_ASSIGNED_COUNT'] ? $row['INSPECTED_ASSIGNED_COUNT'] : 0);
                                            $totalVi = (int) ($row['TOTAL_VI_REF_CODE'] ? $row['TOTAL_VI_REF_CODE'] : 0);
                                            $extra = (int) ($row['EXTRA_INSPECTION_COUNT'] ? $row['EXTRA_INSPECTION_COUNT'] : 0);
                                            $pending = (int) ($row['PENDING_COUNT'] ? $row['PENDING_COUNT'] : ($assigned - $insAssigned));
                                            $completionPct = is_numeric($row['COMPLETION_PERCENT'] ? $row['COMPLETION_PERCENT'] : null) ? (float) $row['COMPLETION_PERCENT'] : null;
                                            $diffPct = is_numeric($row['DIFFERENCE_PERCENT'] ? $row['DIFFERENCE_PERCENT'] : null) ? (float) $row['DIFFERENCE_PERCENT'] : null;
                                            $extraPct = is_numeric($row['EXTRA_INSPECTION_PERCENT'] ? $row['EXTRA_INSPECTION_PERCENT'] : null) ? (float) $row['EXTRA_INSPECTION_PERCENT'] : null;

                                            $GT_ASSIGNED += $assigned;
                                            $GT_INSPECTED_ASSIGNED += $insAssigned;
                                            $GT_TOTAL_VI += $totalVi;
                                            $GT_EXTRA += $extra;
                                            $GT_PENDING += $pending;
                                            ?>
                                            <tr class="text-center">
                                                <td><?= $number ?></td>
                                                <td><?= htmlspecialchars($collRmlId) ?></td>
                                                <td><?= htmlspecialchars($collName) ?></td>
                                                <td>
                                                    <a target="_blank"
                                                        href="concern_wise_report.php?rml_id=<?= htmlspecialchars($collRmlId) ?>"
                                                        class="btn btn-sm btn-gradient-success">
                                                        Details <i class='bx bxs-right-arrow-square'></i>
                                                    </a>
                                                </td>

                                                <td><?= $assigned ?></td>
                                                <td><?= $insAssigned ?></td>
                                                <td><?= $totalVi ?></td>
                                                <td><?= $extra ?></td>

                                                <td><?= $pending ?></td>
                                                <td><?= ($completionPct === null) ? '-' : number_format($completionPct, 2) . ' %' ?>
                                                </td>
                                                <td><?= ($diffPct === null) ? '-' : number_format($diffPct, 2) . ' %' ?></td>
                                                <td><?= ($extraPct === null) ? '-' : number_format($extraPct, 2) . ' %' ?></td>
                                            </tr>
                                            <?php
                                        }

                                        // Grand percent (overall)
                                        $GT_completionPct = ($GT_ASSIGNED == 0) ? null : round(($GT_INSPECTED_ASSIGNED / $GT_ASSIGNED) * 100, 2);
                                        $GT_diffPct = ($GT_ASSIGNED == 0) ? null : round((($GT_ASSIGNED - $GT_INSPECTED_ASSIGNED) / $GT_ASSIGNED) * 100, 2);
                                        $GT_extraPct = ($GT_TOTAL_VI == 0) ? null : round(($GT_EXTRA / $GT_TOTAL_VI) * 100, 2);
                                        ?>
                                        <tr class="table-primary text-center" style="font-weight:bold">
                                            <td></td>
                                            <td class="text-end" colspan="3">Grand Total:</td>

                                            <td><?= $GT_ASSIGNED ?></td>
                                            <td><?= $GT_INSPECTED_ASSIGNED ?></td>
                                            <td><?= $GT_TOTAL_VI ?></td>
                                            <td><?= $GT_EXTRA ?></td>

                                            <td><?= $GT_PENDING ?></td>
                                            <td><?= ($GT_completionPct === null) ? '-' : number_format($GT_completionPct, 2) . ' %' ?>
                                            </td>
                                            <td><?= ($GT_diffPct === null) ? '-' : number_format($GT_diffPct, 2) . ' %' ?></td>
                                            <td><?= ($GT_extraPct === null) ? '-' : number_format($GT_extraPct, 2) . ' %' ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        <?php } // end ok else ?>
                    </div>

                    <div class="d-block text-end mt-2">
                        <a href="#" class="btn btn-sm btn-gradient-info" onclick="return exportF(this);">
                            Export To Excel <i class='bx bxs-cloud-download'></i>
                        </a>
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
        if (!table) return false;

        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);

        elem.setAttribute("href", url);
        elem.setAttribute("download", "vehicle_inspection_report.xls");
        return true;
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
        format: 'dd-mm-yyyy'
    });
</script>
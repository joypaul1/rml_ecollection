<?php

include_once('../../_helper/2step_com_conn.php');
// include_once('../../_config/sqlConfig.php');

$v_rml_id = isset($_GET['rml_id']) ? $_GET['rml_id'] : '';

// Main query
$quary = "WITH 
GET_CONCERN_ID AS (
    SELECT RML_ID,
           'RML-' || LPAD(RML_ID, 5, '0') AS HR_RML_ID
    FROM DEVELOPERS.RML_COLL_APPS_USER
    WHERE USER_TYPE = 'C-C'
      AND IS_ACTIVE = 1
      AND RML_ID IN ($v_rml_id)
)
SELECT INS.REF_CODE,
       INS.MILEAGE_DATA,
       INS.CONDITION,
       INS.COMMENTS,
       INS.FRONT_SIDE_IMG,
       INS.REAR_SIDE_IMG,
       INS.LEFT_SIDE_IMG,
       INS.RIGHT_SIDE_IMG,
       INS.FLOOR_CARGO_BODY_IMG,
       INS.DRIVER_CABIN_IMG,
       INS.CREATED_BY,
       INS.CREATED_AT,
       ERP.BRAND             AS BRAND_NAME,
       ERP.PRODUCT_CODE_NAME AS PRODUCT_CODE_NAME,
       ERP.ZONE              AS ZONE_NAME,
       ERP.DISTIC            AS DISTRIC_NAME,
       HR.EMP_NAME
FROM DEVELOPERS.VEHICLE_INSPECTION INS
JOIN GET_CONCERN_ID G
  ON G.HR_RML_ID = INS.CREATED_BY
LEFT JOIN LEASE_ALL_INFO_ERP ERP
  ON ERP.REF_CODE = INS.REF_CODE
LEFT JOIN RML_HR_APPS_USER HR
  ON HR.RML_ID = INS.CREATED_BY";
// ECHO $quary;

// date range handling
if (!empty($_REQUEST['start_date']) && !empty($_REQUEST['end_date'])) {
    // user jokhon date select korbe, oitar range wise data
    $start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
    $end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
} else {
    // ajker din + ager 6 din
    $start_date = date("d/m/Y", strtotime("-6 days"));
    $end_date = date("d/m/Y");
}

// ekbar-e condition add korlam
$quary .= " AND TRUNC(CREATED_AT) BETWEEN TO_DATE('$start_date','DD/MM/YYYY')
                            AND TO_DATE('$end_date','DD/MM/YYYY')";

$quary .= " ORDER BY CREATED_AT DESC";
// echo $quary ;
$strSQL = oci_parse($objConnect, $quary);
oci_execute($strSQL);
$number = 0;
?>
<style>
    .tableFixHead {
        max-height: 75vh;
        /* ইচ্ছামত adjust */
        overflow: auto;
        /* scroll এখানেই হবে */
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #791fe1;
        /* header transparent থাকলে overlap weird হয় */
    }

    /* optional: Bootstrap bordered এর সাথে line clean */
    .tableFixHead thead th {
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
    }


    .img-modal-title {
        color: #fff;
        text-align: center;
        font-size: 18px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .img-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .img-modal-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 80vh;
        transition: transform 0.2s ease;
        cursor: grab;
    }

    .img-modal-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .img-modal-close:hover,
    .img-modal-close:focus {
        color: #ccc;
        text-decoration: none;
        cursor: pointer;
    }

    h5>.card-header {
        padding-top: 0 !;
    }
</style>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">

            <div class="card rounded-4">
                <?php

                $headerType = 'List';
                $leftSideName = 'Concern Wise Vehicle Inspection Report';
                include('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="tableFixHead">
                        <table class="table table-bordered align-middle mb-0" id="table">
                            <thead class="table-cust text-uppercase">
                                <tr class="text-center">
                                    <th>SL</th>
                                    <th scope="col">REF CODE</th>
                                    <th scope="col">PRODUCT NAME</th>
                                    <th scope="col">BRAND</th>
                                    <th scope="col">ZONE</th>
                                    <th scope="col">DISTRICT</th>
                                    <th scope="col">MILEAGE</th>
                                    <th scope="col">CONDITION</th>
                                    <th scope="col">COMMENTS</th>
                                    <th scope="col">CREATED BY</th>
                                    <th scope="col">CREATED AT</th>
                                    <th scope="col">FRONT SIDE IMG</th>
                                    <th scope="col">REAR SIDE IMG</th>
                                    <th scope="col">LEFT SIDE IMG</th>
                                    <th scope="col">RIGHT SIDE IMG</th>
                                    <th scope="col">FLOOR CARGO BODY IMG</th>
                                    <th scope="col">DRIVER CABIN IMG</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    ?>
                                    <tr class="text-left">
                                        <td><strong><?php echo $number; ?></strong></td>
                                        <td><?php echo htmlspecialchars($row['REF_CODE']); ?></td>
                                        <td><?php echo htmlspecialchars($row['PRODUCT_CODE_NAME']); ?></td>
                                        <td><?php echo htmlspecialchars($row['BRAND_NAME']); ?></td>
                                        <td><?php echo htmlspecialchars($row['ZONE_NAME']); ?></td>
                                        <td><?php echo htmlspecialchars($row['DISTRIC_NAME']); ?></td>
                                        <td><?php echo htmlspecialchars($row['MILEAGE_DATA']); ?></td>
                                        <td><?php echo htmlspecialchars($row['CONDITION']); ?></td>
                                        <td><?php echo htmlspecialchars($row['COMMENTS']); ?></td>
                                        <td><?php echo htmlspecialchars($row['CREATED_BY']); ?></td>
                                        <td><?php echo htmlspecialchars($row['CREATED_AT']); ?></td>
                                        <td class="text-center">
                                            <?php if (!empty($row['FRONT_SIDE_IMG'])): ?>
                                                <img src="<?php echo htmlspecialchars($row['FRONT_SIDE_IMG']); ?>" alt="Front"
                                                    height="50" width="50">
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($row['REAR_SIDE_IMG'])): ?>
                                                <img src="<?php echo htmlspecialchars($row['REAR_SIDE_IMG']); ?>" alt="Rear"
                                                    height="50" width="50">
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($row['LEFT_SIDE_IMG'])): ?>
                                                <img src="<?php echo htmlspecialchars($row['LEFT_SIDE_IMG']); ?>" alt="Left"
                                                    height="50" width="50">
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($row['RIGHT_SIDE_IMG'])): ?>
                                                <img src="<?php echo htmlspecialchars($row['RIGHT_SIDE_IMG']); ?>" alt="Right"
                                                    height="50" width="50">
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($row['FLOOR_CARGO_BODY_IMG'])): ?>
                                                <img src="<?php echo htmlspecialchars($row['FLOOR_CARGO_BODY_IMG']); ?>"
                                                    alt="Floor" height="50" width="50">
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($row['DRIVER_CABIN_IMG'])): ?>
                                                <img src="<?php echo htmlspecialchars($row['DRIVER_CABIN_IMG']); ?>" alt="Cabin"
                                                    height="50" width="50">
                                            <?php endif; ?>
                                        </td>


                                    </tr>
                                <?php } ?>
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
<div id="imgModal" class="img-modal">
    <span class="img-modal-close">&times;</span>
    <div class="img-modal-title" id="imgModalTitle"></div>
    <img class="img-modal-content" id="imgModalImg">
</div>

<!--end page wrapper -->
<?php
include_once('../../_includes/footer_info.php');
include_once('../../_includes/footer.php');
?>
<script>
    //  Only-text Excel download (image chara)
    function exportF(elem) {
        var table = document.getElementById("table");

        // clone kore nichi, jate original table change na hoy
        var clone = table.cloneNode(true);

        // sob cell er HTML theke shudhu text rakhlam
        var cells = clone.querySelectorAll('th, td');
        cells.forEach(function (cell) {
            cell.innerHTML = cell.innerText || cell.textContent;
        });

        var html = clone.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);

        var a = document.createElement('a');
        a.href = url;
        a.download = "vehicle_inspection.xls";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        return false;
    }

    // ✅ Image zoom + header title
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById("imgModal");
        var modalImg = document.getElementById("imgModalImg");
        var closeBtn = document.querySelector(".img-modal-close");
        var modalTitle = document.getElementById("imgModalTitle");
        var scale = 1;

        // table header cells (th) gula
        var headerCells = document.querySelectorAll('#table thead th');

        // table er sob image clickable
        var imgs = document.querySelectorAll("#table img");
        imgs.forEach(function (img) {
            img.style.cursor = 'zoom-in';

            img.addEventListener('click', function () {
                if (!this.src) return;

                // ei image ta jei <td> er vitore, oi column index ber korbo
                var td = this.parentElement;        // <td> jekhane <img> ache
                var tr = td.parentElement;          // oi row
                var cells = tr.children;            // row er sob cell
                var colIndex = Array.prototype.indexOf.call(cells, td); // 0-based index

                // header theke oi column er title nicchi
                var titleText = '';
                if (headerCells[colIndex]) {
                    titleText = headerCells[colIndex].innerText || headerCells[colIndex].textContent;
                }

                modalTitle.textContent = titleText; // modal er header e set

                modal.style.display = "block";
                modalImg.src = this.src;
                scale = 1;
                modalImg.style.transform = "scale(1)";
            });
        });

        // Close button
        closeBtn.onclick = function () {
            modal.style.display = "none";
            modalTitle.textContent = '';
        }

        // background e click korleo close
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = "none";
                modalTitle.textContent = '';
            }
        });

        // ESC key dile close
        document.addEventListener('keydown', function (e) {
            if (e.key === "Escape") {
                modal.style.display = "none";
                modalTitle.textContent = '';
            }
        });

        // wheel diye zoom in/out
        modalImg.addEventListener('wheel', function (e) {
            e.preventDefault();
            if (e.deltaY < 0) {
                scale += 0.1; // zoom in
            } else {
                scale -= 0.1; // zoom out
            }
            if (scale < 0.2) scale = 0.2;
            if (scale > 5) scale = 5;
            modalImg.style.transform = "scale(" + scale + ")";
        });

        // double-click e zoom reset
        modalImg.addEventListener('dblclick', function () {
            scale = 1;
            modalImg.style.transform = "scale(1)";
        });
    });
</script>
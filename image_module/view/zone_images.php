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
                <?php

                $headerType   = 'List';
                $leftSideName = 'Zone Base Images Summary';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle  mb-0">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>Zone</center>
                                    </th>
                                    <th scope="col">
                                        <center>Total Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Upload Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Pending Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>Pending %</center>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php


                                $strSQL = @oci_parse(
                                    $objConnect,
                                    "SELECT ZONE_NAME,
                                    TOTAL_UNIT,
                                    COLL_ZONE_WISE_IMGAGE_UNIT(ZONE_NAME) AS UPLOADED_UNIT
                                    from COLL_EMP_ZONE_SETUP where is_active=1
                                    order by zone_name"
                                );


                                @oci_execute($strSQL);
                                $number                    = 0;
                                $GRAND_TOTAL_UNIT          = 0;
                                $GRAND_TOTAL_UPLOADED_UNIT = 0;
                                $GRAND_TOTAL_PENDING_UNIT  = 0;
                                $B1_TOTAL                  = 0;
                                $B2_TOTAL                  = 0;

                                while ($row = @oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td align="center"><?php echo $row['ZONE_NAME']; ?></td>
                                        <td align="center">
                                            <?php echo $row['TOTAL_UNIT'];
                                            $GRAND_TOTAL_UNIT = $GRAND_TOTAL_UNIT + $row['TOTAL_UNIT']; ?>
                                        </td>
                                        <td align="center">
                                            <?php echo $row['UPLOADED_UNIT'];
                                            $GRAND_TOTAL_UPLOADED_UNIT = $GRAND_TOTAL_UPLOADED_UNIT + $row['UPLOADED_UNIT']; ?>
                                        </td>
                                        <td align="center"><?php echo $row['TOTAL_UNIT'] - $row['UPLOADED_UNIT']; ?></td>
                                        <td align="center">
                                            <?php echo floor((($row['TOTAL_UNIT'] - $row['UPLOADED_UNIT']) * 100) / ($row['TOTAL_UNIT'])); ?>
                                            %
                                        </td>

                                    </tr>
                                    <?php
                                } ?>
                                <tr class="table-primary" style="font-weight:bold">

                                    <td></td>
                                    <td align="right">Grand Total:</td>
                                    <td align="center"><?php echo $GRAND_TOTAL_UNIT; ?></td>
                                    <td align="center"><?php echo $GRAND_TOTAL_UPLOADED_UNIT; ?></td>
                                    <td align="center"><?php echo $GRAND_TOTAL_UNIT - $GRAND_TOTAL_UPLOADED_UNIT; ?></td>
                                    <td align="center">
                                        <?php echo floor((($GRAND_TOTAL_UNIT - $GRAND_TOTAL_UPLOADED_UNIT) * 100 / $GRAND_TOTAL_UNIT)); ?>
                                        %
                                    </td>

                                </tr>

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
        var table = document.getElementById("table");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Images_Zone_Report.xls"); // Choose the file name
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
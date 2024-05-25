<?php


include_once ('../../_helper/2step_com_conn.php');
include_once ('../../_config/sqlConfig.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="row">


            <div class="card rounded-4">
                <?php

                $headerType   = 'List';
                $leftSideName = 'Depo Location';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">Depot Location</th>
                                    <th scope="col">System Keyword</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php

                                $strSQL = @oci_parse($objConnect, "SELECT DEPORCODE AS KEY_WORD,WAREDESC AS TITLE from V_ERP_DEPORT_LOCATION");

                                @oci_execute($strSQL);
                                $number = 0;
                                while ($row = @oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td><?php echo $row['TITLE']; ?></td>
                                        <td><?php echo $row['KEY_WORD']; ?></td>
                                    </tr>
                                    <?php

                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                    <div class="d-block text-end">
                        <a class="btn btn-sm  btn-gradient-info" onclick="exportF(this)">Export To Excel  <i class='bx bxs-cloud-download'></i></a>
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
            elem.setAttribute("download", "depo_list.xls"); // Choose the file name
            return false;
        }
    </script>
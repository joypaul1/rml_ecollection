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
                $leftSideName = 'Driver List';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">Reason Code</th>
                                    <th scope="col">System Keyword</th>
                                    <th scope="col">Create Date</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                @$attn_status = $_REQUEST['attn_status'];
                                @$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));



                                $strSQL = oci_parse($objConnect, "SELECT TITLE,KEY_WORD,CREATED_DATE,REMARKS from RML_COLL_ALKP where is_active=1 and PAREN_ID=2 ORDER BY TITLE");
                                oci_execute($strSQL);
                                $number = 0;


                                while ($row = oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td><?php echo $row['TITLE']; ?></td>
                                        <td><?php echo $row['KEY_WORD']; ?></td>
                                        <td><?php echo $row['CREATED_DATE']; ?></td>
                                        <td><?php echo $row['REMARKS']; ?></td>

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
            elem.setAttribute("download", "driver_list.xls"); // Choose the file name
            return false;
        }
    </script>
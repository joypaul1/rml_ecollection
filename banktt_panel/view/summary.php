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
                $leftSideName = 'Zone Base Reason Code Summary';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>Reason Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>A1</center>
                                    </th>
                                    <th scope="col">
                                        <center>A2</center>
                                    </th>
                                    <th scope="col">
                                        <center>B1</center>
                                    </th>
                                    <th scope="col">
                                        <center>B2</center>
                                    </th>
                                    <th scope="col">
                                        <center>B3</center>
                                    </th>
                                    <th scope="col">
                                        <center>C1</center>
                                    </th>
                                    <th scope="col">
                                        <center>C2</center>
                                    </th>
                                    <th scope="col">
                                        <center>D1</center>
                                    </th>
                                    <th scope="col">
                                        <center>D2</center>
                                    </th>
                                    <th scope="col">
                                        <center>D3</center>
                                    </th>
                                    <th scope="col">
                                        <center>X2</center>
                                    </th>
                                    <th scope="col">
                                        <center>X1N</center>
                                    </th>
                                    <th scope="col">
                                        <center>X1S</center>
                                    </th>
                                    <th scope="col">
                                        <center>X_Truck</center>
                                    </th>
                                    <th scope="col">
                                        <center>X1_Bus</center>
                                    </th>
                                    <th scope="col">
                                        <center>X2_Bus</center>
                                    </th>
                                    <th scope="col">
                                        <center>X3_Bus</center>
                                    </th>
                                    <th scope="col">
                                        <center>X4_Bus</center>
                                    </th>
                                    <th scope="col">
                                        <center>Grand Total</center>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php


                                $strSQL = @oci_parse(
                                    $objConnect,
                                    "SELECT
                                    REASON_CODE,
                                    A1,
                                    A2,
                                    B1,
                                    B2,
                                    B3,
                                    C1,
                                    C2,
                                    D1,
                                    D2,
                                    D3,
                                    X2,
                                    X1N,
                                    X1S,
                                    X_Truck,
                                    X1_Bus,
                                    X2_Bus,
                                    X3_Bus,
                                    X4_Bus
                                FROM (
                                    SELECT
                                        CASE
                                            WHEN LENGTH(UPDATED_REASON_CODE) > 0 THEN UPDATED_REASON_CODE
                                            ELSE REASON_CODE
                                        END AS REASON_CODE,
                                        ZONE
                                    FROM RML_COLL_REASON_CODE_SETUP
                                )
                                PIVOT (
                                    COUNT(ZONE)
                                    FOR ZONE IN (
                                        'A1' AS A1,
                                        'A2' AS A2,
                                        'B1' AS B1,
                                        'B2' AS B2,
                                        'B3' AS B3,
                                        'C1' AS C1,
                                        'C2' AS C2,
                                        'D1' AS D1,
                                        'D2' AS D2,
                                        'D3' AS D3,
                                        'X2' AS X2, 
                                        'X1N' AS X1N,
                                        'X1S' AS X1S,
                                        'X- Truck' AS X_Truck,
                                        'X1- Bus' AS X1_Bus,
                                        'X2- Bus' AS X2_Bus,
                                        'X3- Bus' AS X3_Bus,
                                        'X4- Bus' AS X4_Bus
                                    )
                                )
                                ORDER BY REASON_CODE"
                                );


                                @oci_execute($strSQL);
                                $number = 0;

                                $A1_TOTAL      = 0;
                                $A2_TOTAL      = 0;
                                $B1_TOTAL      = 0;
                                $B2_TOTAL      = 0;
                                $B3_TOTAL      = 0;
                                $C1_TOTAL      = 0;
                                $C2_TOTAL      = 0;
                                $D1_TOTAL      = 0;
                                $D2_TOTAL      = 0;
                                $D3_TOTAL      = 0;
                                $X2_TOTAL      = 0;
                                $X1N_TOTAL     = 0;
                                $X1S_TOTAL     = 0;
                                $X_TRUCK_TOTAL = 0;
                                $X1_BUS_TOTAL  = 0;
                                $X2_BUS_TOTAL  = 0;
                                $X3_BUS_TOTAL  = 0;
                                $X4_BUS_TOTAL  = 0;

                                while ($row = @oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td align="left"><?php echo $row['REASON_CODE']; ?></td>
                                        <td align="center"><?php echo $row['A1'];
                                        $A1_TOTAL = $A1_TOTAL + $row['A1']; ?></td>
                                        <td align="center"><?php echo $row['A2'];
                                        $A2_TOTAL = $A2_TOTAL + $row['A2']; ?></td>
                                        <td align="center"><?php echo $row['B1'];
                                        $B1_TOTAL = $B1_TOTAL + $row['B1']; ?></td>
                                        <td align="center"><?php echo $row['B2'];
                                        $B2_TOTAL = $B2_TOTAL + $row['B2']; ?></td>
                                        <td align="center"><?php echo $row['B3'];
                                        $B3_TOTAL = $B3_TOTAL + $row['B3']; ?></td>
                                        <td align="center"><?php echo $row['C1'];
                                        $C1_TOTAL = $C1_TOTAL + $row['C1']; ?></td>
                                        <td align="center"><?php echo $row['C2'];
                                        $C2_TOTAL = $C2_TOTAL + $row['C2']; ?></td>
                                        <td align="center"><?php echo $row['D1'];
                                        $D1_TOTAL = $D1_TOTAL + $row['D1']; ?></td>
                                        <td align="center"><?php echo $row['D2'];
                                        $D2_TOTAL = $D2_TOTAL + $row['D2']; ?></td>
                                        <td align="center"><?php echo $row['D3'];
                                        $D3_TOTAL = $D3_TOTAL + $row['D3']; ?></td>
                                        <td align="center"><?php echo $row['X2'];
                                        $X2_TOTAL = $X2_TOTAL + $row['X2']; ?></td>
                                        <td align="center"><?php echo $row['X1N'];
                                        $X1N_TOTAL = $X1N_TOTAL + $row['X1N']; ?></td>
                                        <td align="center"><?php echo $row['X1S'];
                                        $X1S_TOTAL = $X1S_TOTAL + $row['X1S']; ?></td>
                                        <td align="center"><?php echo $row['X_TRUCK'];
                                        $X_TRUCK_TOTAL = $X_TRUCK_TOTAL + $row['X_TRUCK']; ?>
                                        </td>
                                        <td align="center"><?php echo $row['X1_BUS'];
                                        $X1_BUS_TOTAL = $X1_BUS_TOTAL + $row['X1_BUS']; ?></td>
                                        <td align="center"><?php echo $row['X2_BUS'];
                                        $X2_BUS_TOTAL = $X2_BUS_TOTAL + $row['X2_BUS']; ?></td>
                                        <td align="center"><?php echo $row['X3_BUS'];
                                        $X3_BUS_TOTAL = $X3_BUS_TOTAL + $row['X3_BUS']; ?></td>
                                        <td align="center"><?php echo $row['X4_BUS'];
                                        $X4_BUS_TOTAL = $X4_BUS_TOTAL + $row['X4_BUS']; ?></td>
                                        <td class="table-primary" align="center"><?php echo $row['A1'] + $row['A2'] + $row['B1'] + $row['B2'] + $row['B3'] +
                                            $row['C1'] + $row['C2'] +
                                            $row['D1'] + $row['D2'] + $row['D3'] +
                                            $row['X2'] + $row['X1N'] + $row['X1S'] +
                                            $row['X1_BUS'] + $row['X2_BUS'] + $row['X3_BUS'] + $row['X4_BUS'] +
                                            $row['X_TRUCK']; ?></td>
                                    </tr>
                                    <?php
                                } ?>
                                <tr class="table-primary">

                                    <td></td>
                                    <td align="right">Grand Total:</td>
                                    <td align="center"><?php echo $A1_TOTAL; ?></td>
                                    <td align="center"><?php echo $A2_TOTAL; ?></td>
                                    <td align="center"><?php echo $B1_TOTAL; ?></td>
                                    <td align="center"><?php echo $B2_TOTAL; ?></td>
                                    <td align="center"><?php echo $B3_TOTAL; ?></td>
                                    <td align="center"><?php echo $C1_TOTAL; ?></td>
                                    <td align="center"><?php echo $C2_TOTAL; ?></td>
                                    <td align="center"><?php echo $D1_TOTAL; ?></td>
                                    <td align="center"><?php echo $D2_TOTAL; ?></td>
                                    <td align="center"><?php echo $D3_TOTAL; ?></td>
                                    <td align="center"><?php echo $X2_TOTAL; ?></td>
                                    <td align="center"><?php echo $X1N_TOTAL; ?></td>
                                    <td align="center"><?php echo $X1S_TOTAL; ?></td>
                                    <td align="center"><?php echo $X_TRUCK_TOTAL; ?></td>
                                    <td align="center"><?php echo $X1_BUS_TOTAL; ?></td>
                                    <td align="center"><?php echo $X2_BUS_TOTAL; ?></td>
                                    <td align="center"><?php echo $X3_BUS_TOTAL; ?></td>
                                    <td align="center"><?php echo $X4_BUS_TOTAL; ?></td>

                                    <td align="center"><b><?php echo $A1_TOTAL + $A2_TOTAL +
                                        $B1_TOTAL + $B2_TOTAL + $B3_TOTAL +
                                        $C1_TOTAL + $C2_TOTAL +
                                        $D1_TOTAL + $D2_TOTAL + $D3_TOTAL +
                                        $X2_TOTAL + $X1N_TOTAL + $X1S_TOTAL +
                                        $X_TRUCK_TOTAL +
                                        $X1_BUS_TOTAL + $X2_BUS_TOTAL + $X3_BUS_TOTAL + $X4_BUS_TOTAL; ?></b></td>


                                </tr>

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
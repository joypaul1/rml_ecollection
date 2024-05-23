<?php

include_once ('../../_helper/2step_com_conn.php');
include_once ('../../_config/sqlConfig.php');
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
                                        <div class="row justify-content-start align-items-center">
                                            <div class="col-sm-3">
                                                <label for="title">Select Collection Concern :</label>
                                                <select name="emp_concern" class="form-control single-select">
                                                    <option selected value=""><-- Select Concern --></option>
                                                    <?php

                                                    $strSQL = oci_parse(
                                                        $objConnect,
                                                        "SELECT RML_ID,EMP_NAME from RML_COLL_APPS_USER
                                                        where is_active=1
													    and ACCESS_APP='RML_COLL'
													    and LEASE_USER='CC'
													    and RML_ID  NOT IN('955','713')
													    order by EMP_NAME"
                                                    );

                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                        ?>
                                                        <option value="<?php echo $row['RML_ID']; ?>" <?php echo (isset($_POST['emp_concern']) && $_POST['emp_concern'] == $row['RML_ID']) ? 'selected="selected"' : ''; ?>>
                                                            <?php echo $row['EMP_NAME']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="title">Select Zone:</label>
                                                <select name="emp_zone" class="form-control single-select">
                                                    <option selected value=""><-- Select Zone --></option>
                                                    <?php

                                                    $strSQL = oci_parse($objConnect, "SELECT distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");

                                                    oci_execute($strSQL);
                                                    while ($row = oci_fetch_assoc($strSQL)) {
                                                        ?>
                                                        <option value="<?php echo $row['ZONE_NAME']; ?>"><?php echo $row['ZONE_NAME']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="title">Select Reason Code :</label>
                                                <select name="reason_code" class="form-control single-select">
                                                    <option selected value=""><-- Select Code --></option>
                                                    <?php
                                                    $reasonSQL = oci_parse($objConnect, "SELECT TITLE from RML_COLL_ALKP where PAREN_ID=1 and is_active=1 order by SORT_ORDER");

                                                    oci_execute($reasonSQL);
                                                    while ($row = oci_fetch_assoc($reasonSQL)) {
                                                        ?>
                                                        <option value="<?php echo $row['TITLE']; ?>"><?php echo $row['TITLE']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label> Start Date: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" name="start_date" type="text"
                                                        value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('01-m-Y'); ?>' />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label> End Date: </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar">
                                                        </i>
                                                    </div>
                                                    <input required="" class="form-control datepicker" name="end_date" type="text"
                                                        value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('t-m-Y'); ?>' />
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <button class="form-control btn btn-sm btn-gradient-primary mt-4" type="submit">
                                                    Search Data <i class='bx bx-file-find'></i>
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
                $leftSideName = 'Last Reason Code Wise report';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-bordered align-middle mb-0" id="tbl">
                            <thead class="table-cust text-uppercase">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">
                                        <center>Concern ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Concern Name</center>
                                    </th>
                                    <th scope="col">
                                        <center>Ref-Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>Reason Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>Last Reason Code</center>
                                    </th>
                                    <th scope="col">
                                        <center>Updated Date</center>
                                    </th>
                                    <th scope="col">
                                        <center>Zone Name</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['emp_zone'])) {
                                    $emp_concern  = $_REQUEST['emp_concern'];
                                    $emp_zone     = $_REQUEST['emp_zone'];
                                    $reason_code  = $_REQUEST['reason_code'];
                                    $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                                    $v_end_date   = date("d/m/Y", strtotime($_REQUEST['end_date']));

                                    $strSQL = oci_parse(
                                        $objConnect,
                                        "SELECT b.RML_ID,B.EMP_NAME,A.REF_CODE,A.REASON_CODE,A.UPDATED_REASON_CODE,B.AREA_ZONE,UPDATED_DAY
											from RML_COLL_REASON_CODE_SETUP a,RML_COLL_APPS_USER b
											where A.CC_ID=B.RML_ID
											and ('$emp_concern' is null OR b.RML_ID='$emp_concern')
											and ('$emp_zone' is null OR b.AREA_ZONE='$emp_zone')
											and ('$reason_code' is null OR a.REASON_CODE='$reason_code')
											AND TRUNC(UPDATED_DAY) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
											"
                                    );



                                    oci_execute($strSQL);
                                    $number                 = 0;
                                    $GRANT_TOTAL_TARGET     = 0;
                                    $GRANT_TOTAL_COLLECTION = 0;

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td><?php echo $number; ?></td>
                                            <td><?php echo $row['RML_ID']; ?></td>
                                            <td><?php echo $row['EMP_NAME']; ?></td>
                                            <td><?php echo $row['REF_CODE']; ?></td>
                                            <td><?php echo $row['REASON_CODE']; ?></td>
                                            <td><?php echo $row['UPDATED_REASON_CODE']; ?></td>
                                            <td><?php echo $row['UPDATED_DAY']; ?></td>
                                            <td><?php echo $row['AREA_ZONE']; ?></td>
                                        </tr>
                                        <?php
                                    }
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
            elem.setAttribute("download", "last_reason_code_list.xls"); // Choose the file name
            return false;
        }
    </script>
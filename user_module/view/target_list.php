<?php
include_once ('../../_helper/2step_com_conn.php');
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
// $dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
// $dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
// $dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
// $dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
// $dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
// $dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">
            <div class="card rounded-4">
                <div class="card-body">

                    <button class="accordion-button" style="color:#0dcaf0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <strong><i class='bx bx-filter-alt'></i>Filter Data</strong>
                    </button>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-3">
                                                <label for="title">User ID:</label>
                                                <input name="r_rml_id" class="form-control" type='text' placeholder="User id here..."
                                                    value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />

                                            </div>
                                            <div class="col-3">
                                                <label for="title">Select User Zone :</label>
                                                <select required="" name="zone_name" class="form-control single-select">
                                                    <option hidden value=""> <-- Select Zone --> </option>

                                                    <?php
                                                    $strSQLA = @oci_parse($objConnect, "SELECT  unique ZONE ZONE_NAME
																			FROM MONTLY_COLLECTION
																			where IS_ACTIVE=1
																			order by ZONE");
                                                    @oci_execute($strSQLA);

                                                    while ($rowdata = @oci_fetch_assoc($strSQLA)) {
                                                        ?>
                                                        <option value="<?php echo $rowdata['ZONE_NAME']; ?>" <?php
                                                           if (isset($_POST['zone_name']) && $_POST['zone_name'] == $rowdata['ZONE_NAME']) {
                                                               echo 'selected';
                                                           }
                                                           ?>>
                                                            <?php echo $rowdata['ZONE_NAME']; ?>
                                                        </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="">Select Data Admin :</label>
                                                <select name="data_admin" class="form-control single-select">
                                                    <option hidden value=""> <-- Select Admin --> </option>
                                                    <?php
                                                    $strSQLA = @oci_parse($objConnect, "SELECT  unique DATA_ADMIN DATA_ADMIN
																			FROM MONTLY_COLLECTION
																			where IS_ACTIVE=1
																			order by DATA_ADMIN");
                                                    @oci_execute($strSQLA);

                                                    while ($rowdata = @oci_fetch_assoc($strSQLA)) {
                                                        ?>
                                                        <option value="<?php echo $rowdata['DATA_ADMIN']; ?>" <?php
                                                           if (isset($_POST['data_admin']) && $_REQUEST['data_admin'] == $rowdata['DATA_ADMIN']) {
                                                               echo 'selected';
                                                           }
                                                           ?>>
                                                            <?php echo $rowdata['DATA_ADMIN']; ?>
                                                        </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>



                                            <div class="col-sm-2">
                                                <button class="form-control btn btn-sm btn-gradient-primary mt-4" type="submit">Search Data<i
                                                        class='bx bx-file-find'></i></button>
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
                $leftSideName = 'User Target List';
                // $rightSideName = 'User Setup Create';
                // $routePath     = 'user_module/view/create.php';
                include ('../../_includes/com_header.php');

                ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead class="table-cust text-uppercase text-center">
                                <tr>
                                    <th scope="col">
                                        <center>Sl</center>
                                    </th>
                                    <th scope="col">Target<br>Info</th>
                                    <th scope="col">
                                        <center>Others<br>Info</center>
                                    </th>
                                    <th scope="col">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (isset($_POST['data_admin'])) {
                                    $v_data_admin = $_REQUEST['data_admin'];
                                    $v_zone_name  = $_REQUEST['zone_name'];
                                    $r_rml_id     = $_REQUEST['r_rml_id'];
                                    $strSQL       = oci_parse($objConnect, "SELECT ID,
                                        DEALER_ID,
                                        TARGET,
                                        TARGETSHOW,
                                        ZONE, RML_ID, CONCERN,
                                        OVER_DUE, CURRENT_MONTH_DUE,
                                        START_DATE,
                                        END_DATE,
                                        IS_ACTIVE,
                                        ENTRY_DATE,
                                        BRAND_NAME,
                                        VISIT_UNIT,
                                        ZONAL_HEAD,
                                        AREA_HEAD,
                                        DATA_ADMIN
                                        FROM MONTLY_COLLECTION
                                        where IS_ACTIVE=1
                                        and ('$r_rml_id' IS NULL OR RML_ID='$r_rml_id')
                                        and ('$v_zone_name' IS NULL OR ZONE='$v_zone_name')
                                        and ('$v_data_admin' IS NULL OR DATA_ADMIN='$v_data_admin')
                                        ");

                                    @oci_execute(@$strSQL);
                                    $number = 0;

                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td><?php
                                            echo 'Login ID: ' . $row['RML_ID'] . ' [' . $row['ZONE'] . ']';
                                            echo '<br>';
                                            echo 'Name: ' . $row['CONCERN'];
                                            echo '<br>';
                                            echo 'Target: ' . $row['TARGET'];
                                            echo '<br>';
                                            echo 'Display Target: ' . $row['TARGETSHOW'];
                                            echo '<br>';
                                            echo 'Data From: ' . $row['DATA_ADMIN'];
                                            echo '<br>';
                                            echo 'Start Date: ' . $row['START_DATE'];
                                            echo '<br>';
                                            echo 'End Date: ' . $row['END_DATE'];

                                            ?>
                                            </td>


                                            <td><?php
                                            echo 'Over Due: ' . $row['OVER_DUE'];
                                            echo '<br>';
                                            echo 'Current Month Due: ' . $row['CURRENT_MONTH_DUE'];
                                            echo '<br>';
                                            echo 'Zonal Head: ' . $row['ZONAL_HEAD'];
                                            echo '<br>';
                                            echo 'Area Head: ' . $row['AREA_HEAD'];
                                            echo '<br>';
                                            echo 'Visit Unit: ' . $row['VISIT_UNIT'];
                                            echo '<br>';
                                            echo 'Dealer ID: ' . $row['DEALER_ID'];

                                            ?></td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-gradient-info" href="target_edit.php?target_table_id=<?php echo $row['ID'] ?>">
                                                    Edit <i class="bx bx-edit-alt"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                }
                                else {
                                    $allDataSQL = oci_parse(
                                        $objConnect,
                                        "SELECT ID,
                                        DEALER_ID,
                                        TARGET,
                                        TARGETSHOW,
                                        ZONE, RML_ID, CONCERN,
                                        OVER_DUE, CURRENT_MONTH_DUE,
                                        START_DATE,
                                        END_DATE,
                                        IS_ACTIVE,
                                        ENTRY_DATE,
                                        BRAND_NAME,
                                        VISIT_UNIT,
                                        ZONAL_HEAD,
                                        AREA_HEAD,
                                        DATA_ADMIN
                                        FROM MONTLY_COLLECTION
                                        where IS_ACTIVE=1"
                                    );

                                    oci_execute($allDataSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($allDataSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td><?php
                                            echo 'Login ID: ' . $row['RML_ID'] . ' [' . $row['ZONE'] . ']';
                                            echo '<br>';
                                            echo 'Name: ' . $row['CONCERN'];
                                            echo '<br>';
                                            echo 'Target: ' . $row['TARGET'];
                                            echo '<br>';
                                            echo 'Display Target: ' . $row['TARGETSHOW'];
                                            echo '<br>';
                                            echo 'Data From: ' . $row['DATA_ADMIN'];
                                            echo '<br>';
                                            echo 'Start Date: ' . $row['START_DATE'];
                                            echo '<br>';
                                            echo 'End Date: ' . $row['END_DATE'];

                                            ?>
                                            </td>

                                            <td><?php
                                            echo 'Over Due: ' . $row['OVER_DUE'];
                                            echo '<br>';
                                            echo 'Current Month Due: ' . $row['CURRENT_MONTH_DUE'];
                                            echo '<br>';
                                            echo 'Zonal Head: ' . $row['ZONAL_HEAD'];
                                            echo '<br>';
                                            echo 'Area Head: ' . $row['AREA_HEAD'];
                                            echo '<br>';
                                            echo 'Visit Unit: ' . $row['VISIT_UNIT'];
                                            echo '<br>';
                                            echo 'Dealer ID: ' . $row['DEALER_ID'];

                                            ?></td>
                                            <td align="center">

                                                <a class="btn btn-sm btn-gradient-info" href="target_edit.php?target_table_id=<?php echo $row['ID'] ?>">
                                                    Edit <i class="bx bx-edit-alt"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
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
    $('.single-select2').each(function () {
        $(this).select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear'))
        });
    });

</script>
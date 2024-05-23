<?php
include_once ('../../_helper/2step_com_conn.php');
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';


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
                                                <label for="title">Zonal Head ID:</label>
                                                <input name="r_rml_id" class="form-control" type='text' placeholder="Zonal Head id here..."
                                                    value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />

                                            </div>
                                            <div class="col-3">
                                                <label for="title">Select User Role :</label>
                                                <select required="" name="user_type" class="form-control ">
                                                    <option value="" <?php echo isset($_POST['user_type']) && $_POST['user_type'] == '' ? 'selected' : ''; ?>>
                                                        <-- Select Role -->
                                                    </option>
                                                    <option value="C-C" <?php echo isset($_POST['user_type']) && $_POST['user_type'] == 'C-C' ? 'selected' : ''; ?>>
                                                        Collection - Collection
                                                    </option>
                                                    <option value="S-C" <?php echo isset($_POST['user_type']) && $_POST['user_type'] == 'S-C' ? 'selected' : ''; ?>>
                                                        Sales - Collection
                                                    </option>

                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="">Select User Zone :</label>
                                                <select name="zone_name" class="form-control single-select2">
                                                    <option hidden value=""> <-- Select Zone --> </option>
                                                    <?php
                                                    $strSQL = @oci_parse($objConnect, "SELECT unique ZONE_NAME from COLL_EMP_ZONE_SETUP order by ZONE_NAME");
                                                    @oci_execute($strSQL);
                                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                                        ?>
                                                        <option value="<?php echo $row['ZONE_NAME'] ?>"
                                                        <?php
                                                            if (isset($_POST['zone_name']) &&
                                                                $_POST['zone_name'] == $row['ZONE_NAME']
                                                            ) {
                                                                echo 'selected';
                                                            }
                                                        ?>>
                                                        <?php echo $row['ZONE_NAME']; ?>
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
                $leftSideName = 'User Setup List';
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
                                        <center>Sl<br>Number</center>
                                    </th>
                                    <th scope="col">User <br>Zone</th>
                                    <th scope="col">Zonal Head<br>ID</th>
                                    <th scope="col">
                                        <center>Area Head<br>ID</center>
                                    </th>
                                    <th scope="col">
                                        <center>Status</center>
                                    </th>
                                    <th scope="col">
                                        <center>Total Unit</center>
                                    </th>
                                    <th scope="col">
                                        <center>User Type</center>
                                    </th>
                                    <th scope="col">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php


                                if (isset($_POST['user_type'])) {
                                    $v_user_type = $_REQUEST['user_type'];
                                    $r_rml_id    = $_REQUEST['r_rml_id'];
                                    $r_zone_name = $_REQUEST['zone_name'];
                                    $strSQL      = oci_parse($objConnect, "SELECT
                                                        ID, 
                                                        ZONE_NAME, ZONE_HEAD,
                                                        (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=ZONE_HEAD) ZONE_HEAD_NAME,
                                                        AREA_HEAD,
                                                        (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=AREA_HEAD)AREA_HEAD_NAME,
                                                        IS_ACTIVE, TOTAL_UNIT,
                                                        USER_TYPE
                                                        FROM COLL_EMP_ZONE_SETUP
                                                where USER_TYPE='$v_user_type'
                                                        AND ('$r_zone_name' IS NULL OR ZONE_NAME='$r_zone_name')
                                                        AND ('$r_rml_id' IS NULL OR ZONE_HEAD='$r_rml_id')
                                        order by ZONE_NAME");

                                    oci_execute($strSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td><?php echo $row['ZONE_NAME']; ?></td>
                                            <td><?php echo $row['ZONE_HEAD_NAME'] . '[' . $row['ZONE_HEAD'] . ']'; ?></td>
                                            <td><?php echo $row['AREA_HEAD_NAME'] . '[' . $row['AREA_HEAD'] . ']'; ?></td>
                                            <td><?php
                                            if ($row['IS_ACTIVE'] == '1')
                                                echo 'Active';
                                            else
                                                echo 'In-Active';
                                            ?></td>
                                            <td><?php echo $row['TOTAL_UNIT']; ?></td>
                                            <td><?php echo $row['USER_TYPE']; ?></td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-gradient-info" href="setup_edit.php?set_up_id=<?php echo $row['ID'] ?>">
                                                    Edit <i class='bx bx-edit-alt'></i>
                                                </a>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                }
                                else {
                                    $allDataSQL = oci_parse(
                                        $objConnect,
                                        "SELECT
                                            ID,
                                            ZONE_NAME, ZONE_HEAD,
                                            (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=ZONE_HEAD) ZONE_HEAD_NAME,AREA_HEAD,
                                            (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=AREA_HEAD) AREA_HEAD_NAME,
                                            BRAND_NAME, IS_ACTIVE, TOTAL_UNIT,
                                            USER_TYPE
                                            FROM COLL_EMP_ZONE_SETUP
                                        order by ZONE_NAME,USER_TYPE"
                                    );

                                    oci_execute($allDataSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($allDataSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td><?php echo $row['ZONE_NAME']; ?></td>
                                            <td><?php echo $row['ZONE_HEAD_NAME'] . '[' . $row['ZONE_HEAD'] . ']'; ?></td>
                                            <td><?php echo $row['AREA_HEAD_NAME'] . '[' . $row['AREA_HEAD'] . ']'; ?></td>
                                            <td><?php
                                            if ($row['IS_ACTIVE'] == '1')
                                                echo 'Active';
                                            else
                                                echo 'In-Active';
                                            ?></td>
                                            <td><?php echo $row['TOTAL_UNIT']; ?></td>
                                            <td><?php echo $row['USER_TYPE']; ?></td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-gradient-info" href="setup_edit.php?set_up_id=<?php echo $row['ID'] ?>">
                                                    Edit <i class='bx bx-edit-alt'></i>
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
   $('.single-select').each(function() {
    $(this).select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear'))
    });
});

</script>
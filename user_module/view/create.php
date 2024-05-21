<?php
include_once ('../../_helper/2step_com_conn.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <?php
                    $headerType    = 'Create';
                    $leftSideName  = 'User Create';
                    $rightSideName = 'User List';
                    $routePath     = 'user_module/view/index.php';
                    include ('../../_includes/com_header.php');

                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>"
                                class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="create">
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01" class="form-label">Emp ID <span class="text-danger">*</span></label>
                                    <input type="text" autocomplete="off" name="form_rml_id" class="form-control" id="validationCustom01" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom08" class="form-label">User Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="emp_form_name" autocomplete="off" id="validationCustom08"
                                        required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom02" class="form-label">User Offical Mobile No.<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        autocomplete="off" autocomplete="off" name="emp_mobile" id="validationCustom02" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom09" class="form-label">IEMI No. </label>
                                    <input type="text" class="form-control" name="emp_iemi" autocomplete="off" id="validationCustom09">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>


                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom06" class="form-label">Zone Name <span class="text-danger">*</span></label>
                                    <select required="" id="validationCustom06" name="zone_name" class="form-control">
                                        <option selected value="">Select Zone Name</option>
                                        <?php
                                        $strSQL = oci_parse($objConnect, "SELECT distinct(ZONE)as AREA_NAME from MONTLY_COLLECTION where is_active=1 order by ZONE");
                                        oci_execute($strSQL);
                                        while ($row = oci_fetch_assoc($strSQL)) {
                                            ?>
                                            <option value="<?php echo $row['AREA_NAME']; ?>"><?php echo $row['AREA_NAME']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Please select Zone Name.</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom04" class="form-label">User Role <span class="text-danger">*</span> </label>
                                    <select name="user_role" id="validationCustom04" class="form-control" required="">
                                        <option selected value="">Select User Type</option>
                                        <option value="CC">Normal User</option>
                                        <option value="ZH">Zonal Head</option>
                                        <option value="AH">Area Head</option>
                                    </select>
                                    <div class="invalid-feedback">Please select User Role.</div>
                                </div>
                                <div class="col-12">
                                    <label for="validationCustom90" class="form-label">Remarks </label>
                                    <input type="text" class="form-control" name="remarks" autocomplete="off" id="validationCustom90">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" type="submit">Save & Create User</button>
                                </div>
                            </form>
                        </div>
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
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
                    $emp_ref_id = $_REQUEST['emp_ref_id'];
                    $query      = "SELECT ID,
                    b.EMP_NAME,
                    b.RML_ID,
                    b.MOBILE_NO,
                    b.LEASE_USER,
                    b.AREA_ZONE ,USER_TYPE,
                    b.USER_FOR,b.IEMI_NO,b.IS_ACTIVE,
                    COLL_SUMOF_TARGET_AMOUNT(RML_ID,LEASE_USER,USER_FOR) TERGET_COLLECTION,
                    (select NVL(a.TARGET,0) from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) ZH_SELF_TARGET,
                    (select ZONAL_HEAD from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) ZONAL_HEAD,
                    (select AREA_HEAD from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) AREA_HEAD,
                    (select VISIT_UNIT from MONTLY_COLLECTION a where a.RML_ID=b.RML_ID and a.IS_ACTIVE=1) VISIT_UNIT
                    FROM RML_COLL_APPS_USER b
                    WHERE ACCESS_APP='RML_COLL'
                    and id='$emp_ref_id'";
                    $strSQL     = @oci_parse($objConnect, $query);
                    @oci_execute($strSQL);
                    $data          = @oci_fetch_assoc($strSQL);
                    $headerType    = 'Edit';
                    $leftSideName  = 'User Edit';
                    $rightSideName = 'User List';
                    $routePath     = 'user_module/view/index.php';
                    include ('../../_includes/com_header.php');
                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>"
                                class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="edit">
                                <input type="hidden" name="editId" value="<?php echo trim($_GET["emp_ref_id"]) ?>">
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01" class="form-label">Emp ID <span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $data['RML_ID']; ?>" autocomplete="off" name="form_rml_id"
                                        class="form-control" id="validationCustom01" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom08" class="form-label">User Full Name <span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $data['EMP_NAME']; ?>" class="form-control" name="emp_form_name"
                                        autocomplete="off" id="validationCustom08" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom02" class="form-label">User Offical Mobile No.<span
                                            class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $data['MOBILE_NO']; ?>" class="form-control"
                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57' autocomplete="off" autocomplete="off"
                                        name="emp_mobile_no" id="validationCustom02" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom09" class="form-label">IEMI No. </label>
                                    <input type="text" class="form-control" name="form_iemi_no" autocomplete="off" id="validationCustom09">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>


                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom06" class="form-label">Zone Name <span class="text-danger">*</span></label>
                                    <select required="" id="validationCustom06" name="form_zone_name" class="form-control">
                                        <?php
                                        $strSQLA = oci_parse($objConnect, "SELECT distinct(AREA_ZONE) AS AREA_ZONE_NAME from RML_COLL_APPS_USER where ACCESS_APP='RML_COLL'
										and is_active=1 order by AREA_ZONE");
                                        oci_execute($strSQLA);

                                        while ($rowdata = oci_fetch_assoc($strSQLA)) {
                                            if ($data['AREA_ZONE'] == $rowdata['AREA_ZONE_NAME']) {
                                                ?>
                                                <option selected value="<?php echo $rowdata['AREA_ZONE_NAME']; ?>"><?php echo $rowdata['AREA_ZONE_NAME']; ?>
                                                </option>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <option value="<?php echo $rowdata['AREA_ZONE_NAME']; ?>"><?php echo $rowdata['AREA_ZONE_NAME']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Please select Zone Name.</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom04" class="form-label">User Role <span class="text-danger">*</span> </label>
                                    <select name="user_role" id="validationCustom04" class="form-control" required="">
                                        <?php
                                        $strSQLA = oci_parse($objConnect, "SELECT distinct(LEASE_USER) AS LEASE_USER  from RML_COLL_APPS_USER  where ACCESS_APP='RML_COLL'
										and is_active=1 order by LEASE_USER");
                                        oci_execute($strSQLA);
                                        while ($rowdata = oci_fetch_assoc($strSQLA)) {
                                            if ($data['LEASE_USER'] == $rowdata['LEASE_USER']) {
                                                ?>
                                                <option selected value="<?php echo $rowdata['LEASE_USER']; ?>"><?php echo $rowdata['LEASE_USER']; ?></option>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <option value="<?php echo $rowdata['LEASE_USER']; ?>"><?php echo $rowdata['LEASE_USER']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Please select User Role.</div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="validCust7">Total Target(Not Editable):</label>
                                    <input type="text" id="validCust7" class="form-control" id="title"
                                        value="<?php echo $data['TERGET_COLLECTION']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="validCust8">Select User Status </label>
                                    <select required="" name="from_user_status" class="form-control">
                                        <?php
                                        if ($data['IS_ACTIVE'] == 1) {
                                            ?>
                                            <option selected value="1">Active</option>
                                            <option value="0">In-Active</option>

                                            <?php
                                        }
                                        else {
                                            ?>
                                            <option selected value="0">In-Active</option>
                                            <option value="1">Active</option>
                                            <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="title">Self Target:</label>
                                    <input type="text" class="form-control" id="title" name="monthly_target"
                                        value="<?php echo $data['ZH_SELF_TARGET']; ?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="title">Zonal Head:</label>
                                    <input type="text" class="form-control" id="title" name="zonal_head" value="<?php echo $data['ZONAL_HEAD']; ?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="title">Area Head:</label>
                                    <input type="text" class="form-control" id="title" name="area_head" value="<?php echo $data['AREA_HEAD']; ?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="title">Visit Unit:</label>
                                    <input type="text" class="form-control" id="title" name="visit_unit" value="<?php echo $data['VISIT_UNIT']; ?>">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="title">User Type:</label>
                                    <select required="" name="user_type" class="form-control">
                                        <?php
                                        $strSQLA = oci_parse($objConnect, "select distinct(USER_TYPE) AS USER_TYPE 
																									from RML_COLL_APPS_USER 
																									where ACCESS_APP='RML_COLL'
																									and is_active=1
																									 order by USER_TYPE");
                                        oci_execute($strSQLA);

                                        while ($rowdata = oci_fetch_assoc($strSQLA)) {

                                            if ($data['USER_TYPE'] == $rowdata['USER_TYPE']) {
                                                ?>
                                                <option selected value="<?php echo $rowdata['USER_TYPE']; ?>"><?php echo $rowdata['USER_TYPE']; ?></option>

                                                <?php
                                            }
                                            else {
                                                ?>
                                                <option value="<?php echo $rowdata['USER_TYPE']; ?>"><?php echo $rowdata['USER_TYPE']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" type="submit">Save & Update </button>
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
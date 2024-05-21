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
                    $v_target_table_id = $_REQUEST['target_table_id'];
                    $query             = "SELECT
                    RML_ID,TARGET,TARGETSHOW,ZONE,
                    ZONAL_HEAD,AREA_HEAD,VISIT_UNIT,
                    OVER_DUE,CURRENT_MONTH_DUE,
                    START_DATE,END_DATE,IS_ACTIVE
                    FROM MONTLY_COLLECTION
                    WHERE ID='$v_target_table_id'
                    AND IS_ACTIVE=1";
                    $strSQL            = @oci_parse($objConnect, $query);
                    @oci_execute($strSQL);
                    $data          = @oci_fetch_assoc($strSQL);
                    $headerType    = 'Edit';
                    $leftSideName  = 'User Setup Edit';
                    $rightSideName = 'User Setup List';
                    $routePath     = 'user_module/view/setup_list.php';
                    include ('../../_includes/com_header.php');
                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>"
                                class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="setup_edit">
                                <input type="hidden" name="editId" value="<?php echo trim($_GET["set_up_id"]) ?>">

                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01">Zonal Head ID:</label>
                                    <input type="text" id="validationCustom01" required="" name="zonal_head_id" class="form-control" id="title"
                                        value="<?php echo $data['ZONE_HEAD']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="validationCustom06" class="form-label">User Zone <span class="text-danger">*</span></label>
                                    <select required="" id="validationCustom06" name="form_zone_name" class="form-control">
                                        <?php
                                        $strSQLA = oci_parse($objConnect, "SELECT distinct(AREA_ZONE) AS AREA_ZONE
                                        from RML_COLL_APPS_USER where ACCESS_APP='RML_COLL' and is_active=1
                                        order by AREA_ZONE");
                                        oci_execute($strSQLA);

                                        while ($rowdata = oci_fetch_assoc($strSQLA)) {
                                            if ($data['ZONE_NAME'] == $rowdata['AREA_ZONE']) {
                                                ?>
                                                <option selected value="<?php echo $rowdata['AREA_ZONE']; ?>"><?php echo $rowdata['AREA_ZONE']; ?>
                                                </option>

                                                <?php
                                            }
                                            else {
                                                ?>
                                                <option value="<?php echo $rowdata['AREA_ZONE']; ?>"><?php echo $rowdata['AREA_ZONE']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Please select Zone Name.</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="title">Area Head ID:</label>
                                    <input type="text" required="" name="area_head_id" class="form-control" id="title"
                                        value="<?php echo $data['AREA_HEAD']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="title">Total Unit:</label>
                                    <input type="text" class="form-control" id="title" name="taltal_unit" value="<?php echo $data['TOTAL_UNIT']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <label for="validCust8">Select User Status </label>
                                    <select required="" name="user_status" class="form-control">
                                        <?php
                                        if ($data['IS_ACTIVE'] == 1) {
                                            ?>
                                            <option selected value="1">Ative</option>
                                            <option value="0">In-Ative</option>
                                            <?php
                                        }
                                        else {
                                            ?>
                                            <option selected value="0">In-Ative</option>
                                            <option value="1">Ative</option>
                                            <?php
                                        }

                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Please select Status.</div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="title">User Type:</label>
                                    <select required="" name="user_type" class="form-control">
                                        <?php
                                        $strSQLA = oci_parse($objConnect, "SELECT distinct(USER_TYPE) AS USER_TYPE 
										from RML_COLL_APPS_USER where ACCESS_APP='RML_COLL'and is_active=1
										order by USER_TYPE");
                                        oci_execute($strSQLA);

                                        while ($rowdata = oci_fetch_assoc($strSQLA)) {

                                            if ($data['USER_TYPE'] == $rowdata['USER_TYPE']) {
                                                ?>
                                                <option selected value="<?php echo $rowdata['USER_TYPE']; ?>"><?php echo $rowdata['USER_TYPE']; ?>
                                                </option>

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
                                    <div class="invalid-feedback">Please select Type.</div>

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
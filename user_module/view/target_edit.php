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
                    $row           = @oci_fetch_assoc($strSQL);
                    $headerType    = 'Edit';
                    $leftSideName  = 'User Target Edit';
                    $rightSideName = 'User Target List';
                    $routePath     = 'user_module/view/setup_list.php';
                    include ('../../_includes/com_header.php');
                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>"
                                class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="target_edit">
                                <input type="hidden" name="editId" value="<?php echo trim($_GET["target_table_id"]) ?>">

                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01">Zonal Head ID:</label>
                                    <label for="title">RML ID:</label>
                                    <input type="text" required="" name="rml_id" class="form-control" id="title"
                                        value="<?php echo $row['RML_ID']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="col-sm-12  col-md-4">
                                    <label for="title">Zonal Head ID:</label>
                                    <input type="text" required="" name="zonal_head_id" class="form-control" id="title"
                                        value="<?php echo $row['ZONAL_HEAD']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <div class="form-group">
                                        <label for="title">Area Head ID:</label>
                                        <input type="text" required="" name="aria_head_id" class="form-control" id="title"
                                            value="<?php echo $row['AREA_HEAD']; ?>">
                                    </div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="title">User Zone:</label>
                                    <select required="" name="zone_name" class="form-control single-select">
                                        <?php
                                        $strSQLA = oci_parse($objConnect, "SELECT distinct(AREA_ZONE) AS AREA_ZONE 
																									from RML_COLL_APPS_USER 
																									where ACCESS_APP='RML_COLL'
																									and is_active=1
																									 order by AREA_ZONE");
                                        oci_execute($strSQLA);

                                        while ($rowdata = oci_fetch_assoc($strSQLA)) {

                                            if ($row['ZONE'] == $rowdata['AREA_ZONE']) {
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

                                </div>

                                <div class="col-sm-12  col-md-4">

                                    <label for="title">Target Amount:</label>
                                    <input type="text" required="" name="target_amount" class="form-control" id="title"
                                        value="<?php echo $row['TARGET']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="title">Display Target:</label>
                                    <input type="text" class="form-control" id="title" name="display_amount"
                                        value="<?php echo $row['TARGETSHOW']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="title">Over Due:</label>
                                    <input type="text" class="form-control" id="title" name="due_amount" value="<?php echo $row['OVER_DUE']; ?>">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="title">Current Month Over Due:</label>
                                    <input type="text" class="form-control" id="title" name="current_due_amount"
                                        value="<?php echo $row['CURRENT_MONTH_DUE']; ?>">
                                </div>
                                <div class="col-sm-12  col-md-4">
                                    <label for="title">Visit Unit:</label>
                                    <input type="text" class="form-control" id="title" name="visit_unit" value="<?php echo $row['VISIT_UNIT']; ?>">
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <label for="validCust8">Select User Status </label>
                                    <select required="" name="user_status" class="form-control">
                                        <?php
                                        if ($row['IS_ACTIVE'] == 1) {
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
                                    <div class="invalid-feedback">Please select Status.</div>
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
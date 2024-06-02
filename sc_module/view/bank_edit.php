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
                    $bank_id = $_REQUEST['bank_id'];
                    $query   = "SELECT
                                    BANK_NAME,
                                    BANK_ADDRESS,
                                    CREATED_DATE,
                                    ENTRY_BY,
                                    UPDATED_BY,
                                    UPDATE_DATE
                                FROM RML_COLL_CCD_BANK where id='$bank_id'";
                    $strSQL  = @oci_parse($objConnect, $query);
                    @oci_execute($strSQL);
                    $row           = @oci_fetch_assoc($strSQL);
                    $headerType    = 'Edit';
                    $leftSideName  = 'User Edit';
                    $rightSideName = 'User List';
                    $routePath     = 'sc_module/view/bank_list.php';
                    include ('../../_includes/com_header.php');
                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>"
                                class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom01" class="form-label"> Bank Name : <span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $row['BANK_NAME']; ?>" autocomplete="off" name="bank_name" class="form-control" id="validationCustom01" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="validationCustom02" class="form-label"> Bank Address : <span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $row['BANK_ADDRESS']; ?>" autocomplete="off" name="bank_address"
                                        class="form-control" id="validationCustom02" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="" class="form-label"> Created Date : </label>
                                    <input type="text" class="form-control" required="" id="title" value="<?php echo $row['CREATED_DATE']; ?>" disabled>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="" class="form-label">Created By : </label>
                                    <input type="text" class="form-control" required="" id="title" value="<?php echo $row['ENTRY_BY']; ?>" disabled>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label for="" class="form-label"> Last Updated Date : </label>
                                    <input type="text" class="form-control" required="" id="title" value="<?php echo $row['UPDATE_DATE']; ?>" disabled>
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
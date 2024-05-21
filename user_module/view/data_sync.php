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
                    $headerType   = 'Edit';
                    $leftSideName = 'Data Synchronization Panel';
                    include ('../../_includes/com_header.php');
                    ?>
                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form method="post" action="<?php echo ($basePath . '/user_module/action/self_panel.php') ?>"
                                class="row g-3 needs-validation" enctype="multipart/form-data" novalidate="">
                                <input type="hidden" name="actionType" value="data_sync">

                                <div class="col-12 text-center">
                                    <button class="btn btn-primary" type="submit">
                                        <i class='bx bx-right-arrow'></i> Click & Data Sync Here <i class='bx bxs-data'></i>
                                    </button>
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
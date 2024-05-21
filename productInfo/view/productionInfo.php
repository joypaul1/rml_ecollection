<?php
include_once('../../_helper/2step_com_conn.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-body">
                        You Search Data : <?= $_GET['searchData']?> 
                    </div>
                </div>
            </div>
        </div><!--end row-->

    </div>
</div>
<!--end page wrapper -->
<?php
include_once('../../_includes/footer_info.php');
include_once('../../_includes/footer.php');
?>

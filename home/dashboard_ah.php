<?php
include_once ('../_helper/com_conn.php');
$v_sesstion_id = $emp_session_id;
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header border-success">
                        <div class="d-flex align-items-center justify-content-left">
                            <div class="">
                                <h6 class="mb-0 border-success">
                                    <strong class="text-primary">
                                        <i class="bx bx-flag text-primary"></i>
                                        My Zonal Head Concern List
                                    </strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0 concerntList table-hover">
                                <thead class="bg-gradient-smile text-center text-white fw-bold">
                                    <tr>
                                        <th scope="col">Sl</th>
                                        <th scope="col">
                                            <center>Zone</center>
                                        </th>
                                        <th scope="col">Zonal Head</th>
                                        <th scope="col">
                                            <center>Area Head</center>
                                        </th>
                                        <th scope="col">
                                            <center>Status</center>
                                        </th>
                                        <th scope="col">
                                            <center>User Type</center>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $USER_ID = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);
                                    $number  = 0;
                                    $strSQL  = @oci_parse(
                                        $objConnect,
                                        "SELECT ZONE_NAME,
                                        ZONE_HEAD,
                                        (SELECT EMP_NAME from RML_COLL_APPS_USER WHERE RML_ID=ZONE_HEAD)CONCERN_NAME,
                                        AREA_HEAD,
                                        IS_ACTIVE,
                                        USER_TYPE
                                        FROM COLL_EMP_ZONE_SETUP
                                        WHERE IS_ACTIVE = 1 AND AREA_HEAD=$USER_ID"
                                    );
                                    @oci_execute($strSQL);
                                    while ($row = @oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td align="center"><?php echo $row['ZONE_NAME']; ?></td>
                                            <td><?php echo $row['CONCERN_NAME']; ?></td>
                                            <td align="center"><?php echo $row['AREA_HEAD']; ?></td>
                                            <td align="center"><i class='bx bx-check-shield fw-bold text-danger'></i></td>
                                            <td align="center"><?php echo $row['USER_TYPE']; ?></td>
                                            <td align="center">
                                                <a target="_blank" href="dashboard_zh.php?area_heade_id=<?php echo $row['ZONE_HEAD'] ?>"
                                                    class="btn btn-sm btn-gradient-primary">
                                                    See Details <i class="bx bx-file-find"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>
<!--end page wrapper -->
<?php
include_once ('../_includes/footer_info.php');
include_once ('../_includes/footer.php');
?>
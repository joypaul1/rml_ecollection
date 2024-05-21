<?php
include_once ('../../_helper/2step_com_conn.php');
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
                                                <input name="r_rml_id" class="form-control" type='text'
                                                    value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />

                                            </div>
                                            <div class="col-3">
                                                <label for="title">Select User Role :</label>
                                                <select required="" name="r_concern" class="form-control">
                                                    <option <?php echo isset($_POST['r_concern']) ? $_REQUEST['r_concern'] == 'AH' ? 'selected' : '' : '' ?> value="AH">Area Head</option>
                                                    <option <?php echo isset($_POST['r_concern']) ? $_REQUEST['r_concern'] == 'ZH' ? 'selected' : '' : '' ?> value="ZH">Zonal Head</option>
                                                    <option <?php echo isset($_POST['r_concern']) ? $_REQUEST['r_concern'] == 'CC' ? 'selected' : '' : '' ?> value="CC">Collection Concern</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="">Select User Status :</label>
                                                <select required="" name="user_status" class="form-control">
                                                    <option <?php echo isset($_POST['user_status']) ? $_REQUEST['user_status'] == '1' ? 'selected' : '' : '' ?> value="1">Active</option>
                                                    <option <?php echo isset($_POST['user_status']) ? $_REQUEST['user_status'] == '0' ? 'selected' : '' : '' ?> value="0">In-Active</option>
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
                $headerType    = 'List';
                $leftSideName  = 'User List';
                $rightSideName = 'User Create';
                $routePath     = 'user_module/view/create.php';
                include ('../../_includes/com_header.php');

                ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover mb-0">
                            <thead class="table-cust text-uppercase text-center">
                                <tr>
                                    <th scope="col">
                                        <center>Sl.</center>
                                    </th>
                                    <th scope="col">User Info.</th>
                                    <th scope="col">Authentication Info.</th>
                                    <th scope="col">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['r_concern'])) {
                                    $r_concern     = $_REQUEST['r_concern'];
                                    $r_rml_id      = $_REQUEST['r_rml_id'];
                                    $v_user_status = $_REQUEST['user_status'];
                                    $strSQL        = oci_parse(
                                        $objConnect,
                                        "SELECT ID,
                                        EMP_NAME,
                                        RML_ID,
                                        MOBILE_NO,
                                        LEASE_USER,
                                        AREA_ZONE,USER_TYPE,IS_ACTIVE
                                        FROM RML_COLL_APPS_USER
                                        WHERE ACCESS_APP='RML_COLL'
                                        AND ('$r_rml_id' is null OR RML_ID='$r_rml_id')
                                        AND ('$r_concern' is null OR LEASE_USER='$r_concern')
                                        AND IS_ACTIVE='$v_user_status'"
                                    );

                                    oci_execute($strSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($strSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td>
                                                <?php
                                                echo 'Name: ' . $row['EMP_NAME'];
                                                echo '<br>';
                                                echo 'Login ID: ' . $row['RML_ID'];
                                                echo '<br>';
                                                echo 'Mobile: ' . $row['MOBILE_NO'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo 'Role: ' . $row['LEASE_USER'];
                                                echo '<br>';
                                                echo 'Zone: ' . $row['AREA_ZONE'];
                                                echo '<br>';
                                                echo 'User Type: ' . $row['USER_TYPE'];
                                                echo '<br>';
                                                if ($row['IS_ACTIVE'] == '1')
                                                    echo 'User Status Active';
                                                else
                                                    echo 'User Status In-Active';
                                                ?>
                                            </td>
                                            <td align="center">
                                                <a class="form-control btn btn-sm btn-gradient-info" href="edit.php?emp_ref_id=<?php echo $row['ID'] ?>">Edit
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
                                            EMP_NAME,
                                            RML_ID,
                                            MOBILE_NO,
                                            LEASE_USER,
                                            AREA_ZONE,USER_TYPE ,IS_ACTIVE
                                            FROM RML_COLL_APPS_USER
                                            WHERE ACCESS_APP='RML_COLL'
                                            AND LEASE_USER='AH'
                                            AND IS_ACTIVE=1"
                                    );

                                    oci_execute($allDataSQL);
                                    $number = 0;

                                    while ($row = oci_fetch_assoc($allDataSQL)) {
                                        $number++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $number; ?></td>
                                            <td>
                                                <?php
                                                echo 'Name: ' . $row['EMP_NAME'];
                                                echo '<br>';
                                                echo 'Login ID: ' . $row['RML_ID'];
                                                echo '<br>';
                                                echo 'Mobile: ' . $row['MOBILE_NO'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo 'Role: ' . $row['LEASE_USER'];
                                                echo '<br>';
                                                echo 'Zone: ' . $row['AREA_ZONE'];
                                                echo '<br>';
                                                echo 'User Type: ' . $row['USER_TYPE'];
                                                echo '<br>';
                                                if ($row['IS_ACTIVE'] == '1')
                                                    echo 'User Status Active';
                                                else
                                                    echo 'User Status In-Active';
                                                ?>
                                            </td>

                                            <td align="center">
                                                <a class="form-control btn btn-sm btn-gradient-info" href="edit.php?emp_ref_id=<?php echo $row['ID'] ?>">Edit
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
    //delete data processing

    $(document).on('click', '.delete_check', function () {
        var id = $(this).data('id');
        let url = $(this).data('href');
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        deleteID: id
                    },
                    dataType: 'json'
                })
                    .done(function (response) {
                        swal.fire('Deleted!', response.message, response.status);
                        location.reload(); // Reload the page
                    })
                    .fail(function () {
                        swal.fire('Oops...', 'Something went wrong!', 'error');
                    });

            }

        })

    });
</script>
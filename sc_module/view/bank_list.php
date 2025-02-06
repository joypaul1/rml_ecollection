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
                        <strong><i class='bx bx-filter-alt'></i> Filter Data</strong>
                    </button>


                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">

                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php
                                    if (isset($_POST['bank_name'])) {
                                        $bank_name    = $_POST['bank_name'];
                                        $bank_address = $_POST['bank_address'];
                                        $sql          = "INSERT INTO RML_COLL_CCD_BANK (
                                                            BANK_NAME,
                                                            BANK_ADDRESS,
                                                            CREATED_DATE,
                                                            ENTRY_BY)
                                                        VALUES (
                                                        '$bank_name' ,
                                                        '$bank_address',
                                                        SYSDATE,
                                                        '$emp_session_id')";
                                        $strSQL       = @oci_parse($objConnect, $sql);
                                        if (@oci_execute($strSQL)) {
                                            echo '<div class="alert alert-success" role="alert">
                                            Bank Information is created successfully! </div>';
                                        }
                                        else {
                                            $lastError = error_get_last();
                                            $error     = $lastError ? "" . $lastError["message"] . "" : "";
                                            echo $error;
                                        }
                                    }
                                    ?>
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="row justify-content-center align-items-center">

                                            <div class="col-12">
                                                <label class="form-label" for="bank_name">
                                                    Bank Name :
                                                </label>
                                                <input placeholder="Bank Name will be here.." type="text" name="bank_name" class="form-control  cust-control" id="bank_name" autocomplete="off" <?php
                                                    if (isset($_POST['bank_name'])) {
                                                        echo 'value="' . htmlspecialchars($_POST['bank_name']) . '"';
                                                    } ?>>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="bank_address">
                                                    Bank Address :
                                                </label>
                                                <textarea placeholder="Bank Address will be here.." required class="form-control" rows="2" id="bank_address" name="bank_address"></textarea>
                                            </div>

                                            <div class="col-sm-3">
                                                <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">Submit To Create <i class='bx bx-file'></i></button>
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
                $leftSideName = 'Bank List';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-cust text-uppercase text-center ">
                                <tr>
                                    <th scope="col">Sl</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Bank Address</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT ID,BANK_NAME, 
                                            BANK_ADDRESS, 
                                            CREATED_DATE, 
                                            ENTRY_BY 
                                        from RML_COLL_CCD_BANK
                                        order by BANK_NAME desc";

                                $strSQL = @oci_parse($objConnect, $query);

                                @oci_execute($strSQL);
                                $number = 0;
                                while ($row = @oci_fetch_assoc($strSQL)) {
                                    $number++;
                                    ?>
                                    <tr>
                                        <td><?php echo $number; ?></td>
                                        <td><?php echo $row['BANK_NAME']; ?></td>
                                        <td><?php echo $row['BANK_ADDRESS']; ?></td>
                                        <td><?php echo $row['CREATED_DATE']; ?></td>
                                        <td><?php echo $row['ENTRY_BY']; ?></td>

                                        <td align="center">
                                            <a class="btn btn-sm btn-gradient-primary" href="bank_edit.php?bank_id=<?php echo $row['ID'] ?>">
                                                Edit <i class='bx bx-pencil'></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>

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
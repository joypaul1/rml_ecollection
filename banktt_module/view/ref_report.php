<?php
include_once ('../../_helper/2step_com_conn.php');
include_once ('../../_config/sqlConfig.php');
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
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                        <div class="row justify-content-center align-items-center">

                                            <div class="col-4">
                                                <input required="" class="form-control" name="bank_tt_id" type="text"
                                                    value='<?php echo isset($_POST['bank_tt_id']) ? $_POST['bank_tt_id'] : '' ?>'
                                                    placeholder="Reference Code will be here..." />
                                            </div>
                                            <div class="col-2">
                                                <button class="form-control btn btn-sm btn-gradient-primary" type="submit">
                                                    Search Data <i class='bx bx-file-find'></i>
                                                </button>
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
                $leftSideName = 'Reference Code Report';
                include ('../../_includes/com_header.php');
                ?>
                <div class="card-body">
                    <?php

                    if (isset($_POST['bank_tt_id'])) {
                        @$bank_tt_ref_id = $_REQUEST['bank_tt_id'];
                        $query = "SELECT
                        a.ID,
                        B.RML_ID,
                        b.MOBILE_NO,
                        B.EMP_NAME,
                        b.AREA_ZONE,
                        a.REF_ID,
                        A.AMOUNT,
                        A.CREATED_DATE,
                        A.TT_BRANCH,
                        A.TT_DATE,
                        A.TT_TYPE,
                        A.TT_TOTAL_TAKA,
                        a.TT_REMARKS,
                        a.TT_CHECK,
                        a.TT_CONFIRM_DATE,
                        a.TT_FILE_CLOSE_AMOUNT,
                        a.TT_DUE_AMOUNT,
                        a.TT_CHANGED_REMARKS,
                        a.TT_UPDATED_BY
                    FROM
                        RML_COLL_MONEY_COLLECTION a,
                        RML_COLL_APPS_USER b
                    WHERE
                        A.RML_COLL_APPS_USER_ID = B.ID
                        AND a.REF_ID = '$bank_tt_ref_id'
                        AND a.PAY_TYPE = 'Bank TT'
                        AND a.BANK = 'Sonali Bank'
                        AND a.TT_BRANCH IS NOT NULL
                    ORDER BY
                        A.CREATED_DATE DESC";
                        // echo $query;

                        $strSQL = @oci_parse($objConnect, $query);

                        @oci_execute($strSQL);
                        while ($row = @oci_fetch_assoc($strSQL)) {?>
                            <div class="row" style="border:3px; border-style:solid; border-color:#ca00ff; padding: 1em;">
                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Ref-Code:</label>
                                                        <input type="text" class="form-control" id="title" form="Form2" value="<?php echo $row['REF_ID']; ?>"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">TT Date:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_DATE']; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Entry By:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['EMP_NAME']; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Concern Zone:</label>
                                                        <input type="text" name="eng_no" class="form-control" id="title"
                                                            value="<?php echo $row['AREA_ZONE']; ?>" readonly form="Form2">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Entry Date:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['CREATED_DATE']; ?>"
                                                            readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">TT Amount:</label>
                                                        <input type="text" name="tt_changed_amount" class="form-control" id="title"
                                                            value="<?php echo $row['AMOUNT']; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Total TT Amount:</label>
                                                        <input type="text" name="total_tt_amount" class="form-control" id="title"
                                                            value="<?php echo $row['TT_TOTAL_TAKA']; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">TT Type:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_TYPE']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">TT Branch: </label>
                                                        <input required="" type="text" name="tt_changed_branch" class="form-control" id="title"
                                                            value="<?php echo $row['TT_BRANCH']; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">TT Remarks:</label>
                                                        <input required="" type="text" name="tt_remarks" class="form-control" id="title"
                                                            value="<?php echo $row['TT_REMARKS']; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Is-Confirm:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_CHECK']; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Confirm Date:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_CONFIRM_DATE']; ?>"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">TT File Close Amount: </label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_FILE_CLOSE_AMOUNT']; ?>"
                                                            readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title"> TT Due Amount:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_DUE_AMOUNT']; ?>"
                                                            readonly>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Change Remarks: </label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_CHANGED_REMARKS']; ?>"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="title">Updated By:</label>
                                                        <input type="text" class="form-control" id="title" value="<?php echo $row['TT_UPDATED_BY']; ?>"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                            </div>
                        <?php
                        }
                    }
                    ?>
                    </div>
                </div><!--end row-->

            </div>
    </div>
</div>

<!--end page wrapper -->
<?php
include_once ('../../_includes/footer_info.php');
include_once ('../../_includes/footer.php');
?>
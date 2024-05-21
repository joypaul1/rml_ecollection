<?php
include_once ('../../_helper/2step_com_conn.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <?PHP
        // $user_brand_name = $_SESSION['ECOL_USER_INFO']['user_brand'];
        // $USER_ID         = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);
        // $USER_ROLE       = getUserAccessRoleByID($_SESSION['ECOL_USER_INFO']['user_role_id']);
        ?>
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
                                                <label for="ref_id">Reference ID : </label>
                                                <input required="" type="text" class="form-control" id="title" placeholder="Ref-Code" name="ref_id"
                                                    value='<?php echo isset($_POST['ref_id']) ? $_POST['ref_id'] : '' ?>'>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="form-control btn btn-sm btn-gradient-primary mt-4" type="submit">
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
                $leftSideName = 'Seized Information Changed & Corfirmation';
                include ('../../_includes/com_header.php');
                if (isset($_POST['ref_id'])) {
                    $strSQL = @oci_parse($objConnect, "SELECT ID,DEPOT_LOCATION_CODE,
							                                          REF_ID,
																	  TEAM_MEMBER,
																	  DRIVER_NAME,
																      SEIZE_REASON,
																	  DEPOT_LOCATION,
																	  ENTRY_DATE,
																	  RUNNING_STATUS,
																	  TOTAL_EXPENSE,
																	  CHASSIS_CONDITION,
																	  BODY_CONDITION,
																	  ENGINE_CONDITION,
																	  BATTERY_CONDITION,
																	  NOC,
																	  ROPE,
																	  JACK,
																	  SPARE_TAYRE,
																	  BUCKET,
																	  DYNAMY,
																	  SELF,
																	  VEHICLE_PAPER,
																	  FRONT_GLASS,
																	  TOOLS_BOX,
																	  TRIPAL,
																	  KEY_STATUS,
																	  TO_CHAR(NVL(IS_CONFIRM,0)) AS IS_CONFIRM
																 FROM RML_COLL_SEIZE_DTLS
																WHERE REF_ID='$ref_id'
																and IS_CONFIRM=0");

                    @oci_execute($strSQL);
                    $row = @oci_fetch_assoc($strSQL);
                    ?>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-sm-3">
                                    <label for="title">Entry Date:</label>
                                    <input type="text" class="form-control" id="title" value="<?php echo $row['ENTRY_DATE']; ?>" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Team Member:</label>
                                    <input type="text" class="form-control" id="title" name="team_member" value="<?php echo $row['TEAM_MEMBER']; ?>"
                                        form="Form2">
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Driver Name:</label>
                                    <input type="text" class="form-control" id="title" name="driver_name" value="<?php echo $row['DRIVER_NAME']; ?>"
                                        form="Form2">
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Seized Reason:</label>
                                    <input type="text" class="form-control" id="title" value="<?php echo $row['SEIZE_REASON']; ?>" readonly>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Total Expense:</label>
                                    <input type="text" class="form-control" id="title" name="total_expense" value="<?php echo $row['TOTAL_EXPENSE']; ?>"
                                        form="Form2">
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Running Status:</label>
                                    <select required="" name="runnig_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['RUNNING_STATUS'] == 'Running') {
                                            ?>
                                            <option value="Running">Running</option>
                                            <option value="Not Running">Not Running</option>
                                            <?php
                                        }
                                        else if ($row['RUNNING_STATUS'] == 'Not Running') {
                                            ?>
                                                <option value="Not Running">Not Running</option>
                                                <option value="Running">Running</option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Chasis Condition</label>

                                    <select required="" name="chasis_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['CHASSIS_CONDITION'] == 'Good') {
                                            ?>
                                            <option value="Good">Good</option>
                                            <option value="Partial">Partial</option>
                                            <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['CHASSIS_CONDITION'] == 'Partial') {
                                            ?>
                                                <option value="Partial">Partial</option>
                                                <option value="Good">Good</option>
                                                <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['CHASSIS_CONDITION'] == 'Bad') {
                                            ?>
                                                    <option value="Bad">Bad</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Partial">Partial</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Body Condition:</label>
                                    <select required="" name="body_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['BODY_CONDITION'] == 'Good') {
                                            ?>
                                            <option value="Good">Good</option>
                                            <option value="Partial">Partial</option>
                                            <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['BODY_CONDITION'] == 'Partial') {
                                            ?>
                                                <option value="Partial">Partial</option>
                                                <option value="Good">Good</option>
                                                <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['BODY_CONDITION'] == 'Bad') {
                                            ?>
                                                    <option value="Bad">Bad</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Partial">Partial</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Engine Condition:</label>
                                    <select required="" name="eng_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['ENGINE_CONDITION'] == 'Good') {
                                            ?>
                                            <option value="Good">Good</option>
                                            <option value="Partial">Partial</option>
                                            <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['ENGINE_CONDITION'] == 'Partial') {
                                            ?>
                                                <option value="Partial">Partial</option>
                                                <option value="Good">Good</option>
                                                <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['ENGINE_CONDITION'] == 'Bad') {
                                            ?>
                                                    <option value="Bad">Bad</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Partial">Partial</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Bettery Condition:</label>

                                    <select required="" name="bettery_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['BATTERY_CONDITION'] == 'Good') {
                                            ?>
                                            <option value="Good">Good</option>
                                            <option value="Partial">Partial</option>
                                            <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['BATTERY_CONDITION'] == 'Partial') {
                                            ?>
                                                <option value="Partial">Partial</option>
                                                <option value="Good">Good</option>
                                                <option value="Bad">Bad</option>
                                            <?php
                                        }
                                        else if ($row['BATTERY_CONDITION'] == 'Bad') {
                                            ?>
                                                    <option value="Bad">Bad</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Partial">Partial</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">NOC Complete?</label>

                                    <select required="" name="noc_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['NOC'] == '1') {
                                            ?>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <?php
                                        }
                                        else if ($row['NOC'] == '0') {
                                            ?>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Rope?</label>
                                    <select required="" name="rope_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['ROPE'] == '1') {
                                            ?>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <?php
                                        }
                                        else if ($row['ROPE'] == '0') {
                                            ?>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Jack?</label>
                                    <select required="" name="jack_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['JACK'] == '1') {
                                            ?>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <?php
                                        }
                                        else if ($row['JACK'] == '0') {
                                            ?>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Spare Tyre</label>

                                    <select required="" name="spare_tyre" class="form-control" form="Form2">
                                        <?php
                                        if ($row['SPARE_TAYRE'] == '1') {
                                            ?>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <?php
                                        }
                                        else if ($row['SPARE_TAYRE'] == '0') {
                                            ?>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Bucket?</label>

                                    <select required="" name="bucket_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['BUCKET'] == '1') {
                                            ?>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <?php
                                        }
                                        else if ($row['BUCKET'] == '0') {
                                            ?>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="title">Dynamy?</label>
                                    <select required="" name="dynamy_condition" class="form-control" form="Form2">
                                        <?php
                                        if ($row['DYNAMY'] == '1') {
                                            ?>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            <?php
                                        }
                                        else if ($row['DYNAMY'] == '0') {
                                            ?>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Self?</label>
                                        <select required="" name="self_condition" class="form-control" form="Form2">
                                            <?php
                                            if ($row['SELF'] == '1') {
                                                ?>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                <?php
                                            }
                                            else if ($row['SELF'] == '0') {
                                                ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Vehicle Paper?</label>

                                        <select required="" name="vehicle_papers" class="form-control" form="Form2">
                                            <?php
                                            if ($row['VEHICLE_PAPER'] == '1') {
                                                ?>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                <?php
                                            }
                                            else if ($row['VEHICLE_PAPER'] == '0') {
                                                ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Front Glass?</label>

                                        <select required="" name="front_glass" class="form-control" form="Form2">
                                            <?php
                                            if ($row['FRONT_GLASS'] == '1') {
                                                ?>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                <?php
                                            }
                                            else if ($row['FRONT_GLASS'] == '0') {
                                                ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>

                                                <?php
                                            }
                                            ?>

                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Tool Box?</label>
                                        <select required="" name="tool_box" class="form-control" form="Form2">
                                            <?php
                                            if ($row['TOOLS_BOX'] == '1') {
                                                ?>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                <?php
                                            }
                                            else if ($row['TOOLS_BOX'] == '0') {
                                                ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Tripal?</label>
                                        <select required="" name="tripal_condition" class="form-control" form="Form2">
                                            <?php
                                            if ($row['TRIPAL'] == '1') {
                                                ?>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                <?php
                                            }
                                            else if ($row['TRIPAL'] == '0') {
                                                ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Keys?</label>

                                        <select required="" name="keys_condition" class="form-control" form="Form2">
                                            <?php
                                            if ($row['KEY_STATUS'] == '1') {
                                                ?>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                                <?php
                                            }
                                            else if ($row['KEY_STATUS'] == '0') {
                                                ?>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Seized ID:</label>
                                        <input type="text" name="table_id" class="form-control" id="title" form="Form2" value="<?php echo $row['ID']; ?>"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Ref-Code:</label>
                                        <input type="text" name="ref_code_id" class="form-control" id="title" form="Form2"
                                            value="<?php echo $row['REF_ID']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Depot Location Code:</label>
                                        <input type="text" required="" name="deoprt_location_code" class="form-control" form="Form2" id="title"
                                            value="<?php echo $row['DEPOT_LOCATION_CODE']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Depot Location:</label>
                                        <input type="text" required="" name="deoprt_location_details" class="form-control" form="Form2" id="title"
                                            value="<?php echo $row['DEPOT_LOCATION']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <button class="form-control btn btn-sm btn-gradient-primary mt-4" type="submit">
                                        Search Data <i class='bx bx-file-find'></i>
                                    </button>
                                </div>

                            </div>

                        </form>
                    </div>
                <?php } ?>
            </div><!--end row-->

        </div>
    </div>
    <!--end page wrapper -->
    <?php
    include_once ('../../_includes/footer_info.php');
    include_once ('../../_includes/footer.php');
    ?>
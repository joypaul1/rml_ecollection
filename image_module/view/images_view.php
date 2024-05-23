<?php
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2.min.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.css';
$dynamic_link_css[] = '../../assets/plugins/datetimepicker/css/classic.date.css';
$dynamic_link_css[] = '../../assets/plugins/select2/css/select2-bootstrap4.css';
$dynamic_link_js[]  = '../../assets/plugins/select2/js/select2.min.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.js';
$dynamic_link_js[]  = '../../assets/plugins/datetimepicker/js/picker.date.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js';
$dynamic_link_js[]  = '../../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js';

include_once ('../../_helper/2step_com_conn.php');
include_once ('../../_config/sqlConfig.php');
?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <?PHP
        $user_brand_name = $_SESSION['ECOL_USER_INFO']['user_brand'];
        $USER_ID         = (int) preg_replace('/[^0-9]/', '', $_SESSION['ECOL_USER_INFO']['emp_id']);
        $USER_ROLE       = getUserAccessRoleByID($_SESSION['ECOL_USER_INFO']['user_role_id']);
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
                                            <div class="col-sm-4">
                                                <label for="title">Ref-Code:</label>
                                                <input placeholder="Reference Code.." required="" type='text' class="form-control" name='ref_code'
                                                    value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
                                            </div>

                                            <div class="col-sm-2">
                                                <button class="form-control  btn btn-sm btn-gradient-primary mt-4" type="submit">Search Data <i
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

                $headerType   = 'List';
                $leftSideName = 'Image Gallery';
                include ('../../_includes/com_header.php');
                @$ref_code_id = $_REQUEST['ref_code'];
                $images_1            = '';
                $images_1_entry_date = '';
                $images_1_entry_id   = '';
                $images_1_grade      = '';


                $images_2            = '';
                $images_2_entry_date = '';
                $images_2_entry_id   = '';
                $images_2_grade      = '';


                $images_3            = '';
                $images_3_entry_date = '';
                $images_3_entry_id   = '';
                $images_3_grade      = '';

                $images_4            = '';
                $images_4_entry_date = '';
                $images_4_entry_id   = '';
                $images_4_grade      = '';

                $number_index = 0;
                $is_search    = 0;
                if (isset($_POST['ref_code'])) {
                    $is_search = 1;

                    $strSQL = @oci_parse($objConnect, "SELECT  a.REF_CODE,
                                                    a.IMG_URL,
                                                    b.EMP_NAME UPDATED_BY,
                                                    TO_CHAR(a.ENTRY_DATE,'YYYY-MM-DD HH:MM:SS PM') AS ENTRY_DATE,
                                                    a.VEHICLE_GRADE,a.COMMENTS_TITLE
                                                    FROM RML_COLL_IMAGES a,RML_COLL_APPS_USER b
                                                    WHERE A.UPDATED_BY=B.RML_ID
                                                    AND a.REF_CODE='$ref_code_id' 
                                                    order by ENTRY_DATE desc");

                    @oci_execute($strSQL);

                    while ($row = @oci_fetch_assoc($strSQL)) {
                        $number_index++;

                        if ($number_index == 1) {
                            $images_1            = '';
                            $images_1_entry_date = '';
                            $images_1_entry_id   = '';
                            $images_1_grade      = '';
                            $images_1_comments   = '';
                            $images_1_comments   = '';

                            $images_1            = $row['IMG_URL'];
                            $images_1_entry_date = $row['ENTRY_DATE'];
                            $images_1_entry_id   = $row['UPDATED_BY'];
                            $images_1_grade      = $row['VEHICLE_GRADE'];
                            $images_1_comments   = $row['COMMENTS_TITLE'];

                        }
                        else if ($number_index == 2) {
                            $images_2            = '';
                            $images_2_entry_date = '';
                            $images_2_entry_id   = '';
                            $images_2_grade      = '';
                            $images_2_comments   = '';

                            $images_2            = $row['IMG_URL'];
                            $images_2_entry_date = $row['ENTRY_DATE'];
                            $images_2_entry_id   = $row['UPDATED_BY'];
                            $images_2_grade      = $row['VEHICLE_GRADE'];
                            $images_2_comments   = $row['COMMENTS_TITLE'];
                        }
                        else if ($number_index == 3) {

                            $images_3            = '';
                            $images_3_entry_date = '';
                            $images_3_entry_id   = '';
                            $images_3_grade      = '';
                            $images_3_comments   = '';


                            $images_3            = $row['IMG_URL'];
                            $images_3_entry_date = $row['ENTRY_DATE'];
                            $images_3_entry_id   = $row['UPDATED_BY'];
                            $images_3_grade      = $row['VEHICLE_GRADE'];
                            $images_3_comments   = $row['COMMENTS_TITLE'];
                        }
                        else if ($number_index == 4) {

                            $images_4            = '';
                            $images_4_entry_date = '';
                            $images_4_entry_id   = '';
                            $images_4_grade      = '';
                            $images_4_comments   = '';

                            $images_4            = $row['IMG_URL'];
                            $images_4_entry_date = $row['ENTRY_DATE'];
                            $images_4_entry_id   = $row['UPDATED_BY'];
                            $images_4_grade      = $row['VEHICLE_GRADE'];
                            $images_4_comments   = $row['COMMENTS_TITLE'];
                        }
                    }

                }
                ?>

                <div class="card-header">
                    <p>Dear, remember that here is only display last 4 images that are uploaded by responsible concern.</p>
                    <p>Click on the images to enlarge them.</p>
                </div>
                <div class="card-title">
                    <h4 style="color:red;">
                        <?php
                        if ($number_index > 0) {
                            echo 'REF-CODE: ' . $ref_code_id;
                        }
                        else if ($is_search == 0) {

                        }
                        else {
                            echo 'Not uploaded any images on Ref-Code: ' . $ref_code_id;
                        }

                        ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 card">
                            <div class="card-body thumbnail">
                                <a href="<?php echo $images_1; ?>" target="_blank">
                                    <img src="<?php echo $images_1; ?>" style="width:100%">
                                    <div class="caption">
                                        <p>
                                            <?php
                                            if ($number_index >= 1) {
                                                echo 'Image-1';
                                                echo "<br>";
                                                echo $images_1_entry_date;
                                                echo "<br>";
                                                echo $images_1_entry_id;
                                                echo "<br>";
                                                echo 'Grade: ' . $images_1_grade;
                                                echo "<br>";
                                                echo 'Type: ' . $images_1_comments;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 card">
                            <div class="card-body thumbnail">
                                <a href="<?php echo $images_2; ?>" target="_blank">
                                    <img src="<?php echo $images_2; ?>" style="width:100%">
                                    <div class="caption">
                                        <p>
                                            <?php
                                            if ($number_index >= 2) {
                                                echo 'Image-2';
                                                echo "<br>";
                                                echo $images_2_entry_date;
                                                echo "<br>";
                                                echo $images_2_entry_id;
                                                echo "<br>";
                                                echo 'Grade: ' . $images_2_grade;
                                                echo "<br>";
                                                echo 'Type: ' . $images_2_comments;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 card">
                            <div class="card-body  thumbnail">
                                <a href="<?php echo $images_3; ?>" target="_blank">
                                    <img src="<?php echo $images_3; ?>" style="width:100%">
                                    <div class="caption">
                                        <p>
                                            <?php
                                            if ($number_index >= 3) {
                                                echo 'Image-3';
                                                echo "<br>";
                                                echo $images_3_entry_date;
                                                echo "<br>";
                                                echo $images_3_entry_id;
                                                echo "<br>";
                                                echo 'Grade: ' . $images_3_grade;
                                                echo "<br>";
                                                echo 'Type: ' . $images_3_comments;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 card">
                            <div class="card-body thumbnail">
                                <a href="<?php echo $images_4; ?>" target="_blank">
                                    <img src="<?php echo $images_4; ?>" style="width:100%">
                                    <div class="caption">
                                        <p>
                                            <?php
                                            if ($number_index == 4) {
                                                echo 'Image-4';
                                                echo "<br>";
                                                echo $images_4_entry_date;
                                                echo "<br>";
                                                echo $images_4_entry_id;
                                                echo "<br>";
                                                echo 'Grade: ' . $images_4_grade;
                                                echo "<br>";
                                                echo 'Type: ' . $images_4_comments;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
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
<script>
    function exportF(elem) {
        var table = document.getElementById("tbl");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Images_Zone_Report.xls"); // Choose the file name
        return false;
    }

    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy' // Specify your desired date format
    });
</script>
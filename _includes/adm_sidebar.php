<body>

    <?php
    $v_active      = 'mm-active';
    $v_active_open = 'mm-active';
    $currentUrl    = $_SERVER['REQUEST_URI'];
    function isActive($url)
    {
        global $currentUrl;
        return strpos($currentUrl, $url) !== false ? 'mm-active' : '';
    }
    ?>
    <!--wrapper-->
    <div class="wrapper">

        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <!-- <div>
                    <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                </div> -->
                <div>
                    <h4 class="logo-text">RML APPS</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="<?php echo isActive('/home/dashboard_adm.php'); ?>">
                    <a href="<?php echo $basePath ?>/home/dashboard_adm.php">
                        <div class="parent-icon"><i class="bx bx-home-circle"></i>
                        </div>
                        <div class="menu-title">ADM Home</div>
                    </a>
                </li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-chalkboard'></i>
                        </div>
                        <div class="menu-title">Report Panel</div>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo $basePath ?>/adm_module/view/master_report.php"><i class='bx bxs-arrow-to-right'></i>Collection
                                Report</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-bookmark-alt-plus'></i>
                        </div>
                        <div class="menu-title">Visit Assign Panel</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $basePath ?>/area_head_module/view/adm_daily_visit.php"><i class='bx bxs-arrow-to-right'></i></i>Daily
                                Visit Monitor</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/area_head_module/view/concern_visit.php"><i
                                    class='bx bxs-arrow-to-right'></i></i>Concern Visit Summary</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/area_head_module/view/zone_visit.php"><i class='bx bxs-arrow-to-right'></i></i>Zone
                                Visit Summary</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-images'></i>
                        </div>
                        <div class="menu-title"> Image Module</div>
                    </a>
                    <ul>
                        <!-- <li> <a href="<?php echo $basePath ?>/image_module/view/zone_images.php"><i class='bx bxs-arrow-to-right'></i>Images Zone Unit</a>
                        </li> -->
                        <li> <a href="<?php echo $basePath ?>/image_module/view/images_view.php"><i class='bx bxs-arrow-to-right'></i>Code Wise
                                Images</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/image_module/view/images_grade_summary.php"><i class='bx bxs-arrow-to-right'></i>Grade
                                Summary</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/image_module/view/images_history.php"><i class='bx bxs-arrow-to-right'></i>Uploaded
                                History</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bxs-pyramid'></i>
                        </div>
                        <div class="menu-title"> Target VS Collection</div>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo $basePath ?>/target_vs_collection_module/view/area_head_collection.php"><i
                                    class='bx bxs-arrow-to-right'></i>Area Head Collection</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/target_vs_collection_module/view/zonal_head_collection.php"><i
                                    class='bx bxs-arrow-to-right'></i>Zonal Head Collection</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/target_vs_collection_module/view/collection_concern.php"><i
                                    class='bx bxs-arrow-to-right'></i>Collection Concern</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/target_vs_collection_module/view/collection_history.php"><i
                                    class='bx bxs-arrow-to-right'></i>Collection History</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bxs-bank'></i>
                        </div>
                        <div class="menu-title"> Bank TT Module</div>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo $basePath ?>/banktt_module/view/ref_report.php"><i class='bx bxs-arrow-to-right'></i>Ref-Code List</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/banktt_module/view/confirm_report.php"><i class='bx bxs-arrow-to-right'></i>Confirm
                                TT</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/banktt_module/view/zone_report.php"><i class='bx bxs-arrow-to-right'></i> Zone Wise
                                TT</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/banktt_module/view/concern_report.php"><i class='bx bxs-arrow-to-right'></i>Concern Wise
                                TT </a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-message-alt-dots'></i>
                        </div>
                        <div class="menu-title"> Reason Code Module</div>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo $basePath ?>/reasoncode_module/view/list.php"><i class='bx bxs-arrow-to-right'></i>Reason Code
                                List</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/reasoncode_module/view/report.php"><i class='bx bxs-arrow-to-right'></i>Reason Code
                                Details</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/reasoncode_module/view/last_report.php"><i class='bx bxs-arrow-to-right'></i> Last Reason
                                Code List</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/reasoncode_module/view/summary.php"><i class='bx bxs-arrow-to-right'></i>Reason Code
                                Summary </a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bxs-hand'></i>
                        </div>
                        <div class="menu-title"> Seized Module</div>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo $basePath ?>/seized_module/view/driver_list.php"><i class='bx bxs-arrow-to-right'></i>Driver List</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/seized_module/view/depo_location_list.php"><i class='bx bxs-arrow-to-right'></i>Depo
                                Location</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/seized_module/view/seized_confirm.php"><i class='bx bxs-arrow-to-right'></i> Seized Info.
                                Update</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/seized_module/view/seized_report.php"><i class='bx bxs-arrow-to-right'></i>Seized Report
                                List</a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo isActive('/user_module/view/edit.php'); ?>">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-group'></i>
                        </div>
                        <div class="menu-title">User Panel</div>
                    </a>
                    <ul>
                        <li>
                            <a href="<?php echo $basePath ?>/user_module/view/index.php"><i class='bx bxs-arrow-to-right'></i> List Of User </a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/user_module/view/setup_list.php"><i class='bx bxs-arrow-to-right'></i> User Setup
                                List</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/user_module/view/target_list.php"><i class='bx bxs-arrow-to-right'></i> Target List </a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/user_module/view/data_sync.php"><i class='bx bxs-arrow-to-right'></i> Data Sync </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
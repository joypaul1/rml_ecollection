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
                    <h4 class="logo-text">COLLECTION APPS</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="<?php echo isActive('/home/dashboard_ah.php'); ?>">
                    <a href="<?php echo $basePath ?>/home/dashboard_ah.php">
                        <div class="parent-icon"><i class="bx bx-home-circle"></i>
                        </div>
                        <div class="menu-title">AH Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
                        </div>
                        <div class="menu-title"> Visit Assign Module </div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $basePath ?>/area_head_module/view/daily_visit.php"><i class='bx bxs-arrow-to-right'></i>Daily
                                Visit Monitor</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/area_head_module/view/concern_visit.php"><i
                                    class='bx bxs-arrow-to-right'></i>Concern Visit Summary</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/area_head_module/view/zone_visit.php"><i class='bx bxs-arrow-to-right'></i>Zone
                                Visit Summary</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
                        </div>
                        <div class="menu-title"> Report Module </div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $basePath ?>/report_module/view/collection_report.php"><i
                                    class='bx bxs-arrow-to-right'></i>Collection Report</a>
                        </li>
                        <li>
                            <a href="<?php echo $basePath ?>/report_module/view/visit_report.php"><i class='bx bxs-arrow-to-right'></i>EMI Visit
                                Report</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/report_module/view/seized_report.php"><i class='bx bxs-arrow-to-right'></i>Seized
                                Report</a>
                        </li>

                    </ul>
                </li>

                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-group'></i>
                        </div>
                        <div class="menu-title"> Sales Certificate Module</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $basePath ?>/certificate_module/view/sc_ah_report.php">
                                <i class='bx bxs-arrow-to-right'></i>Code Wise Report
                            </a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/certificate_module/view/sc_ah_summary_report.php">
                                <i class='bx bxs-arrow-to-right'></i>Zone Summary Report
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-group'></i>
                        </div>
                        <div class="menu-title"> Vehicle Inspection Module</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo $basePath ?>/image_module/view/ah_images.php"><i class='bx bxs-arrow-to-right'></i>Code List</a>
                        </li>
                    </ul>
                </li>


                <li class="">
                    <a href="javascript:;" class="has-arrow">

                        <div class="parent-icon"><i class='bx bx-group'></i>
                        </div>
                        <div class="menu-title"> Image Module</div>
                    </a>
                    <ul>
                        <!-- <li> <a href="<?php echo $basePath ?>/image_module/view/zone_images.php"><i class='bx bxs-arrow-to-right'></i>Images Zone Unit</a>
                        </li> -->
                        <li> <a href="<?php echo $basePath ?>/image_module/view/images_view.php"><i class='bx bxs-arrow-to-right'></i>Code Wise
                                Images</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/image_module/view/images_grade_summary.php"><i
                                    class='bx bxs-arrow-to-right'></i>Grade Summary</a>
                        </li>
                        <li> <a href="<?php echo $basePath ?>/image_module/view/images_history.php"><i class='bx bxs-arrow-to-right'></i>Uploaded
                                History</a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
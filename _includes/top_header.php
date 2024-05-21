<!--start header -->

<?php
//echo $_SESSION['ECOL_USER_INFO']['user_role_id'];
//die();
$USER_ROLE = $_SESSION['ECOL_USER_INFO']['user_role_id'];


$VISIT_PENDING = 0;
if($USER_ROLE == 4) {
	$query  = "SELECT COUNT(A.REF_ID) VISIT_APPROVAL_PENDING
    FROM RML_COLL_VISIT_ASSIGN A,COLL_VISIT_ASSIGN_APPROVAL B
    WHERE A.ID=B.RML_COLL_VISIT_ASSIGN_ID
        AND TRUNC(ASSIGN_DATE)= TRUNC(SYSDATE)
        AND B.APPROVAL_STATUS IS NULL
        AND A.CREATED_BY IN
            (
            SELECT RML_ID FROM MONTLY_COLLECTION WHERE IS_ACTIVE=1 AND ZONAL_HEAD='$emp_session_id'
            )";
	$strSQL = oci_parse($objConnect, $query);
	oci_execute($strSQL);
	while ($row = oci_fetch_assoc($strSQL)) {
		$VISIT_PENDING = $row['VISIT_APPROVAL_PENDING'];
	}
	}



?>

<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>
            <div class="search-bar flex-grow-1">
                <form action="<?php echo $basePath ?>/productInfo/view/productionInfo.php" method="GET">
                    <div class="position-relative search-bar-box">
                        <input type="text" value="<?= isset($_GET['searchData'])?$_GET['searchData'] : null?>" name="searchData" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
                        <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
                    </div>
                </form>

            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                        </a>
                    </li>


                    
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false"> <i class='bx bx-category'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="row row-cols-3 g-3 p-3">
                                <a href="#" class="col text-center" id="dlAppsApk">
                                    <div class="app-box mx-auto bg-gradient-cosmic text-white "><i class='bx bx-cloud-download'></i>
                                    </div>
                                    <div class="app-title"> APPS </div>
                                </a>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
                                    </div>
                                    <div class="app-title">Projects</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i>
                                    </div>
                                    <div class="app-title">Tasks</div>
                                </div>
                                <!-- <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-kyoto text-dark"><i class='bx bx-notification'></i>
                                    </div>
                                    <div class="app-title">Feeds</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-blues text-dark"><i class='bx bx-file'></i>
                                    </div>
                                    <div class="app-title">Files</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='bx bx-filter-alt'></i>
                                    </div>
                                    <div class="app-title">Alerts</div>
                                </div> -->
                            </div>
                        </div>
                    </li>
					

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count"><?php echo $VISIT_PENDING; ?></span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-clear ms-auto">Must be do</p>
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                <a class="dropdown-item" href="<?php echo $basePath ?>/zh_module/view/visit_approval_list.php">
                                    <div class="d-flex align-items-center">
                                        <div class="notify bg-light-info text-info"><i class="bx bx-home-circle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Visit Approval Pending</h6>
                                            <p class="msg-info">Today Pending: <?php echo $VISIT_PENDING; ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </li>

                </ul>
            </div>

            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    <img src="<?php echo $_SESSION['ECOL_USER_INFO']['image_link'] != null ? ($basePath . '/' . $_SESSION['ECOL_USER_INFO']['image_link']) : $basePath . '/' . "assets/images/avatars/default_user.png"; ?>" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">
                            <?php echo $_SESSION['ECOL_USER_INFO']['user_name'] ?>
                        </p>
                        <!-- <p class="designattion mb-0">Web Designer</p> -->
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="<?php echo $basePath . '/user_module/view/profile.php?id=' . $_SESSION['ECOL_USER_INFO']['id'] . '&actionType=profileEdit' ?>"><i class="bx bx-user"></i><span>Profile</span></a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="<?php echo $basePath ?>/index.php?logout_hr=true"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<!--end header -->

<script>
    document.getElementById("dlAppsApk").addEventListener("click", function() {
        var fileUrl = "<?php echo $basePath . '/cl_7.apk' ?>";
        var link = document.createElement('a');
        link.href = fileUrl;
        link.download = 'collection_apps'; // Specify the filename
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
</script>
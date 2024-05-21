<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$basePath   = $_SESSION['basePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
$log_user_id   = $_SESSION['ECOL_USER_INFO']['id'];




if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST["submit_approval"])) {

    if (count($_POST['check_list']) > 0) {
        foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

            $strSQL = @oci_parse(
                $objConnect,
                "UPDATE COLL_VISIT_ASSIGN_APPROVAL
                SET    
                        APPROVAL_STATUS          = 1,
                        APPROVED_DATE            = SYSDATE,
                        APPROVED_BY_RML_ID       = '$emp_session_id'
                WHERE  ID ='$TT_ID_SELECTTED'"
            );

            // Execute the query
            if (@oci_execute($strSQL)) {
            } else {
                $e                        = @oci_error($strSQL);
                $message                  = [
                    'text'   => htmlentities($e['message'], ENT_QUOTES),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$basePath}/zh_module/view/visit_approval_list.php'</script>";

                exit();
            }
        }
    } else {
        $message                  = [
            'text'   => 'Sorry! You have not select any ID Code.',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/zh_module/view/visit_approval_list.php'</script>";

        exit();
    }
    $message = [
        'text'   => 'Data Saved & Approved successfully.',
        'status' => 'true',
    ];

    $_SESSION['noti_message'] = $message;
    echo "<script> window.location.href = '{$basePath}/zh_module/view/visit_approval_list.php'</script>";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST["submit_denied"])) {

    if (count($_POST['check_list']) > 0) {
        foreach ($_POST['check_list'] as $TT_ID_SELECTTED) {

            $strSQL = @oci_parse(
                $objConnect,
                "UPDATE COLL_VISIT_ASSIGN_APPROVAL
                SET    
                        APPROVAL_STATUS          = 0,
                        APPROVED_DATE            = SYSDATE,
                        APPROVED_BY_RML_ID       = '$emp_session_id'
                WHERE  ID ='$TT_ID_SELECTTED'"
            );

            // Execute the query
            if (@oci_execute($strSQL)) {
            } else {
                $e                        = @oci_error($strSQL);
                $message                  = [
                    'text'   => htmlentities($e['message'], ENT_QUOTES),
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$basePath}/zh_module/view/visit_approval_list.php'</script>";

                exit();
            }
        }
    } else {
        $message                  = [
            'text'   => 'Sorry! You have not select any ID Code.',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/zh_module/view/visit_approval_list.php'</script>";

        exit();
    }
    $message = [
        'text'   => 'Data Saved & Denied successfully.',
        'status' => 'true',
    ];

    $_SESSION['noti_message'] = $message;
    echo "<script> window.location.href = '{$basePath}/zh_module/view/visit_approval_list.php'</script>";
    exit();
}

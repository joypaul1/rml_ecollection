<?php
session_start();
require_once ('../../config_file_path.php');
require_once ('../../_config/connoracle.php');
$basePath       = $_SESSION['basePath'];
$log_user_id    = $_SESSION['ECOL_USER_INFO']['id'];
$emp_session_id = $_SESSION['ECOL_USER_INFO']['emp_id'];
ini_set('memory_limit', '2560M');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'create') {
    $form_rml_id   = $_POST['form_rml_id'];
    $emp_form_name = $_POST['emp_form_name'];
    $emp_mobile    = $_POST['emp_mobile'];
    $emp_iemi      = $_POST['emp_iemi'];
    $zone_name     = $_POST['zone_name'];
    $user_role     = $_POST['user_role'];
    $remarks       = $_POST['remarks'];

    $query = "INSERT INTO RML_COLL_APPS_USER (
                            EMP_NAME,
                            PASS_MD5,
                            IS_ACTIVE,
                            RML_ID,
                            MOBILE_NO,
                            CREATED_DATE,
                            IEMI_NO,
                            LEASE_USER,
                            USER_FOR,
                            ACCESS_APP,
                            AREA_ZONE,
                            REMARKS,
                            UPDATED_BY)
                        VALUES (
                        '$emp_form_name' ,
                        '202CB962AC59075B964B07152D234B70' ,
                        1 ,
                        '$form_rml_id' ,
                        '$emp_mobile' ,
                        SYSDATE ,
                        '$emp_iemi' ,
                        '$user_role' ,
                        '' ,
                        'RML_COLL' ,
                        '$zone_name' ,
                        '$remarks' ,
                        '$emp_session_id' )";


    // Execute the query
    $strSQL = @oci_parse($objConnect, $query);
    if (@oci_execute($strSQL)) {
        $message = [
            'text'   => 'User is Created successfully.',
            'status' => 'true',
        ];

        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/create.php'</script>";
    }
    else {
        $message                  = [
            'text'   => 'Something Went wrong!',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/create.php'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'edit') {

    $emp_ref_id       = $_POST['editId'];
    $form_rml_id      = $_POST['form_rml_id'];
    $emp_form_name    = $_POST['emp_form_name'];
    $emp_mobile_no    = $_POST['emp_mobile_no'];
    $form_iemi_no     = $_POST['form_iemi_no'];
    $user_role        = $_POST['user_role'];
    $form_zone_name   = $_POST['form_zone_name'];
    $from_user_status = $_POST['from_user_status'];
    $monthly_target   = $_POST['monthly_target'];
    $v_zonal_head     = $_POST['zonal_head'];
    $v_area_head      = $_POST['area_head'];
    $v_visit_unit     = $_POST['visit_unit'];
    $v_user_type      = $_POST['user_type'];

    $strSQL = @oci_parse($objConnect, "UPDATE RML_COLL_APPS_USER SET
                                                    EMP_NAME='$emp_form_name',
                                                    MOBILE_NO='$emp_mobile_no',
                                                    IEMI_NO='$form_iemi_no',
                                                    LEASE_USER='$user_role',
                                                    AREA_ZONE='$form_zone_name',
                                                    UPDATED_BY='$emp_session_id',
                                                    UPDATED_DATE=SYSDATE,
                                                    IS_ACTIVE='$from_user_status',
                                                    USER_TYPE='$v_user_type'
                                                where ID='$emp_ref_id'
                                                AND ACCESS_APP='RML_COLL'");

    if (@oci_execute($strSQL)) {
        if ($user_role == 'CC' || $user_role == 'ZH') {
            $TargetSQL = @oci_parse($objConnect, "UPDATE MONTLY_COLLECTION set
                                                  TARGET='$monthly_target',
                                                  TARGETSHOW='$monthly_target',
                                                  ZONE='$form_zone_name',
                                                  ZONAL_HEAD='$v_zonal_head',
                                                  AREA_HEAD='$v_area_head',
                                                  VISIT_UNIT='$v_visit_unit'
                                            where is_active=1
                                            and RML_ID='$form_rml_id'");

            if (@oci_execute($TargetSQL)) {
                $message                  = [
                    'text'   => 'User Updated successfully.',
                    'status' => 'true',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$basePath}/user_module/view/edit.php?emp_ref_id=$emp_ref_id'</script>";
            }
            else {
                $message                  = [
                    'text'   => 'Something Went wrong!',
                    'status' => 'false',
                ];
                $_SESSION['noti_message'] = $message;
                echo "<script> window.location.href = '{$basePath}/user_module/view/edit.php?emp_ref_id=$emp_ref_id'</script>";
            }
        }
        else {
            $message                  = [
                'text'   => 'User Updated successfully.',
                'status' => 'true',
            ];
            $_SESSION['noti_message'] = $message;
            echo "<script> window.location.href = '{$basePath}/user_module/view/edit.php?emp_ref_id=$emp_ref_id'</script>";
        }
    }
    else {
        $message                  = [
            'text'   => 'Something Went wrong!',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/edit.php?emp_ref_id=$emp_ref_id'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'setup_edit') {

    $v_set_up_id     = $_POST['editId'];
    $v_zonal_head_id = $_REQUEST['zonal_head_id'];
    $v_zone_name     = $_REQUEST['zone_name'];
    $v_area_head_id  = $_REQUEST['area_head_id'];
    $v_taltal_unit   = $_REQUEST['taltal_unit'];
    $v_user_type     = $_REQUEST['user_type'];
    $user_status     = $_REQUEST['user_status'];

    $strSQL = @oci_parse($objConnect, "UPDATE COLL_EMP_ZONE_SETUP
                SET
                ZONE_NAME        = '$v_zone_name',
                ZONE_HEAD        = '$v_zonal_head_id',
                AREA_HEAD        = '$v_area_head_id',
                IS_ACTIVE        = '$user_status',
                TOTAL_UNIT       = '$v_taltal_unit',
                USER_TYPE        = '$v_user_type',
                UPDATE_BY='$emp_session_id',
                UPDATE_DATE=SYSDATE
                WHERE  ID= $v_set_up_id
                ");

    if (@oci_execute($strSQL)) {

        $message                  = [
            'text'   => 'User Setup Updated successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/setup_edit.php?set_up_id=$emp_ref_id'</script>";
    }
    else {
        $message                  = [
            'text'   => 'Something Went wrong!',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/setup_edit.php?set_up_id=$emp_ref_id'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'target_edit') {

    $v_target_table_id    = $_REQUEST['editId'];
    $v_rml_id             = $_REQUEST['rml_id'];
    $v_zonal_head_id      = $_REQUEST['zonal_head_id'];
    $v_aria_head_id       = $_REQUEST['aria_head_id'];
    $v_zone_name          = $_REQUEST['zone_name'];
    $v_target_amount      = $_REQUEST['target_amount'];
    $v_display_amount     = $_REQUEST['display_amount'];
    $v_visit_unit         = $_REQUEST['visit_unit'];
    $v_due_amount         = $_REQUEST['due_amount'];
    $v_current_due_amount = $_REQUEST['current_due_amount'];
    $user_status          = $_REQUEST['user_status'];

    $strSQL = oci_parse($objConnect, "UPDATE MONTLY_COLLECTION SET
                            TARGET            = '$v_target_amount',
                            TARGETSHOW        = '$v_display_amount',
                            ZONE              = :'$v_zone_name',
                            OVER_DUE          = '$v_due_amount',
                            CURRENT_MONTH_DUE = '$v_current_due_amount',
                            IS_ACTIVE         = '$user_status',
                            VISIT_UNIT        = '$v_visit_unit',
                            ZONAL_HEAD        = '$v_zonal_head_id',
                            AREA_HEAD         = ' $v_aria_head_id'
                            WHERE  ID= '$v_target_table_id'");

    if (@oci_execute($strSQL)) {

        $message                  = [
            'text'   => 'User Target Updated successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/target_edit.php?target_table_id=$v_target_table_id'</script>";
    }
    else {
        $message                  = [
            'text'   => 'Something Went wrong!',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/target_edit.php?target_table_id=$v_target_table_id'</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && trim($_POST["actionType"]) == 'data_sync') {


    $strSQL = oci_parse($objConnect, "BEGIN RML_COLL_CCD_DATA_SYN(); END;");

    if (@oci_execute($strSQL)) {

        $message                  = [
            'text'   => 'Data Sync successfully.',
            'status' => 'true',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/data_sync.php'</script>";
    }
    else {
        $message                  = [
            'text'   => 'Something Went wrong!',
            'status' => 'false',
        ];
        $_SESSION['noti_message'] = $message;
        echo "<script> window.location.href = '{$basePath}/user_module/view/data_sync.php'</script>";
    }
}

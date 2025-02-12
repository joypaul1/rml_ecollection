<?php
session_start();
if (!isset($_SESSION['ECOL_USER_INFO'])) {
    $currentScriptPath = __FILE__;
    $directoryPath     = dirname($currentScriptPath);
    $includeFilePath   = $directoryPath . '../../../config_file_path.php';
    $realIncludePath   = realpath($includeFilePath);
    require($includeFilePath);
    header("Location:" . $basePath);
    exit;
}
$basePath = $_SESSION['basePath'];
$emp_session_id  = $_SESSION['ECOL_USER_INFO']['emp_id'];
include_once('../../../_config/connoracle.php');
include_once('../../../_includes/header.php');

if ($_SESSION['ECOL_USER_INFO']['user_role_id'] == 2) {
    include_once('../../../_includes/adm_sidebar.php');
}
if ($_SESSION['ECOL_USER_INFO']['user_role_id'] == 3) {
    include_once('../../../_includes/ah_sidebar.php');
}
if ($_SESSION['ECOL_USER_INFO']['user_role_id'] == 4) {
    include_once('../../../_includes/zh_sidebar.php');
}
if ($_SESSION['ECOL_USER_INFO']['user_role_id'] == 5) {
    include_once('../../../_includes/sc_sidebar.php');
}
include_once('../../../_includes/top_header.php');

<?php
session_start();
require_once('../../config_file_path.php');
require_once('../../_config/connoracle.php');
$basePath   = $_SESSION['basePath'];
$folderPath = $rs_img_path;
ini_set('memory_limit', '2560M');
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
$log_user_id   = $_SESSION['ECOL_USER_INFO']['id'];





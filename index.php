<?php 
session_start();

require_once('inc/config.php');

if(isset($_POST['login']))
{
	if(!empty($_POST['email']) && !empty($_POST['password']))
	{
		$email 		= trim($_POST['email']);
		$password 	= trim($_POST['password']);
		
		$md5Password = md5($password);
		
		$sql = "select * from tbl_users where emp_id = '".$email."' and password = '".$md5Password."'";
		$rs = mysqli_query($conn,$sql);
		$getNumRows = mysqli_num_rows($rs);
		
		if($getNumRows == 1)
		{
			$getUserRow = mysqli_fetch_assoc($rs);
			unset($getUserRow['password']);
			
			$_SESSION = $getUserRow;
			
			// For Separation Dashbord
			$USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
             if($USER_ROLE=="SC"){
				header('location:dashboard_sc.php'); 
			 }else if($USER_ROLE=="IT"){
				 header('location:dashboard_it.php'); 
			 }else if($USER_ROLE=="TT"){
				 header('location:dashboard_tt.php'); 
			 }else if($USER_ROLE=="AH"){
				 header('location:dashboard_ah.php'); 
			 }else if($USER_ROLE=="ZH"){
				 header('location:dashboard_zh.php'); 
			 }else if($USER_ROLE=="ADM"){
				 header('location:dashboard_adm.php'); 
			 }else if($USER_ROLE=="AUDIT"){
				 header('location:dashboard_audit.php'); 
			 }else if($USER_ROLE=="SERVICE"){
				 header('location:dashboard_service.php'); 
			 }else if($USER_ROLE=="SEIZED"){
				 header('location:dashboard_seized.php'); 
			 }else if($USER_ROLE=="RMWL"){
				 header('location:dashboard_rmwl.php'); 
			 }else if($USER_ROLE=="CALL SERVICE"){
				 header('location:dashboard_service.php'); 
			 }else if($USER_ROLE=="Accounts"){
				 header('location:dashboard_accounts.php'); 
			 }else if($USER_ROLE=="CCD_CALL"){
				 header('location:dashboard_ccd_call.php'); 
			 }else if($USER_ROLE=="SALE"){
				 header('location:dashboard_sale.php'); 
			 }
			 else{
				 header('location:dashboard.php');
			 }			
			// For Separation Dashbord End
			
			
			exit;
		}
		else
		{
			$errorMsg = "Wrong EMP-ID or password";
		}
	}
}

if(isset($_GET['logout']) && $_GET['logout'] == true)
{
	session_destroy();
	header("location:index.php");
	exit;
}


if(isset($_GET['lmsg']) && $_GET['lmsg'] == true)
{
	$errorMsg = "Login required to access dashboard";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Rangs Group Apps</title>
  <link rel="shortcut icon" href="http://202.40.181.98:9090/rangs_collection_rml/app_icon_round.png" type="image/x-icon" />
  <!-- Bootstrap core CSS-->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container jumbotron vertical-center bg-dark mt-4">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header" align="center"><b>Rangs Collection Apps Login</b></div>
      <div class="card-body">
		<?php 
			if(isset($errorMsg))
			{
				echo '<div class="alert alert-danger">';
				echo $errorMsg;
				echo '</div>';
				unset($errorMsg);
			}
		?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">EMP-ID:</label>
            <input class="form-control" id="exampleInputEmail1" name="email" type="text" placeholder="Enter EMP-ID" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password:</label>
            <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Password" required>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
        </form>
       
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>

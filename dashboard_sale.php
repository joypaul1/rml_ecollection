<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php');
	require_once('inc/connoracle.php');
	//$USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
	//$USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);

		 
?>

 <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Welcome to Rangs Group Collection Apps Dashboard</a>
        </li>
        
      </ol>
      <hr>
	  
	  
	  <div class="container-fluid">
		<div class="row">
           <div class="col-lg-12">
						
						
				</div>


		
        </div>
	  </div>
       <hr>
    <!-- /.container-fluid-->
	 <div style="height: 1000px;"></div>
    </div>
<?php require_once('layouts/footer.php'); ?>	
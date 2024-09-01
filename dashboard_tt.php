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

?>	
	

 <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Welcome to Rangs Group Collection Apps Bank TT Dashboard</a>
        </li>
        
      </ol>
      <hr>
	  
	  
	  <div class="container-fluid">
		<div class="row">
           <div class="col-lg-12">
						<div class="row">
							<div class="col-sm-6">
								<div class="input-group">
								<div id="collection_summary"></div>
							   </div>
							</div>
							<div class="col-sm-">
								<div class="input-group">
								<div id="visit_summary"></div>
							   </div>
							</div>
							
						</div>	
						
				</div>


		
        </div>
	  </div>
       <hr>
    <!-- /.container-fluid-->
	 <div style="height: 1000px;"></div>
    </div>
<?php require_once('layouts/footer.php'); ?>	
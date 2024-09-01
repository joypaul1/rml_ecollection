<?php 
	session_start();
	if($_SESSION['user_role_id']!= 1)
	  {
		header('location:index.php?lmsg=true');
		exit;
	  } 			
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Data Synchronization Panel</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   
							 <div class="col-sm-6">
							<label for="title">Information for Data Syn</label>
								<input required=""  type="text" class="form-control" id="title" value="lease_all_info@ERP_LINK_LIVE TO LEASE_ALL_INFO_ERP" readonly>
							</div>
							<div class="col-sm-6">
							<label for="title">Information for Data Syn</label>
								<input required=""  type="text" class="form-control" id="title" value="FILESUM_V@ERP_LINK_LIVE TO FILESUM_ERP" readonly>
							</div>
							
							<div class="col-sm-4 mt-3">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							
						</div>	
						<div class="row md-form mt-3">
							 <div class="col-sm-4">
							 <div class="md-form mt">
								 <input class="form-control btn btn-primary" type="submit" value="Data Syn ERP To Apps Server">
							</div>							
							</div>	
						</div>
						
						<hr>
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   

	         <?php
			if(isset($_POST['start_date'])){													
				$synSQL  = oci_parse($objConnect, "BEGIN RML_COLL_CCD_DATA_SYN();END;");						   
				if(oci_execute($synSQL)){
                       echo 'Data successfully Marged';					
                    	 }		  
			        }
            ?>

					</div>
				  </div>
				</div>
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
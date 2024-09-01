<?php 
	session_start();
		if($_SESSION['user_role_id']!= 5)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 			
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	$bank_id=$_REQUEST['bank_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT 
													BANK_NAME, 
													BANK_ADDRESS, 
													CREATED_DATE, 
													ENTRY_BY, 
													UPDATED_BY, 
													UPDATE_DATE
											FROM RML_COLL_CCD_BANK where id='$bank_id'"); 
						  
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   <form action="" method="post">
								<div class="md-form mt-5">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you update anything here.
									</li>
								</ol>
								 <div class="resume-item d-flex flex-column flex-md-row">
						   
						   
							<div class="container">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
										  <label for="title">Bank Name:</label>
										  <input type="text"class="form-control" required="" id="title"  name="bank_name" value= "<?php echo $row['BANK_NAME'];?>">
										</div>
									</div>
									<div class="col-sm-12">
								        <div class="md-form mt-3">
									    <label for="comment">Bank Address:</label>
										<input type="text"class="form-control" required="" id="title"  name="bank_address" value= "<?php echo $row['BANK_ADDRESS'];?>">
									    </div>
							        </div>
									<div class="col-sm-4">
								        <div class="md-form mt-3">
									    <label for="comment">Created Date:</label>
										<input type="text"class="form-control" required="" id="title" value= "<?php echo $row['CREATED_DATE'];?>" readonly>
									    </div>
							        </div>
									<div class="col-sm-4">
								        <div class="md-form mt-3">
									    <label for="comment">Created By:</label>
										<input type="text"class="form-control" required="" id="title" value= "<?php echo $row['ENTRY_BY'];?>" readonly>
									    </div>
							        </div>
									<div class="col-sm-4">
								        <div class="md-form mt-3">
									    <label for="comment">Last Updated Date:</label>
										<input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['UPDATE_DATE'];?>" readonly>
									    </div>
							        </div>
											
								</div>
								
								<div class="row">
									 <div class="col-sm-4">
										<div class="md-form mt-5">
										<button type="submit" name="submit" class="btn btn-info" > Update</button>
										</div>
									 </div>	
								</div>
								
								
						
							</div>
						 <?php
						  }
						 ?>
					
					</div>
				  </div>
				  </form>
				</div>

	
	              <?php

                          
						  if(isset($_POST['bank_name'])){
							 
							  $bank_name = $_REQUEST['bank_name'];
                              $bank_address = $_REQUEST['bank_address'];
							  
							   $strSQL  = oci_parse($objConnect, "update RML_COLL_CCD_BANK SET
							            BANK_NAME='$bank_name',
                                        BANK_ADDRESS='$bank_address',
										UPDATED_BY='$emp_session_id',
										UPDATE_DATE=SYSDATE
								where ID=$bank_id"); 
						  
						   if(oci_execute($strSQL)){
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Information is updated successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
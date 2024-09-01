<?php 
	session_start();
		if($_SESSION['user_role_id']!= 5 && $_SESSION['user_role_id']!= 9)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 			
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	$reissues_id=$_REQUEST['reissues_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT CODE, 
														REASON, 
														REGARDS, 
														CREATED_BY, 
														CREATED_DATE, 
														NVL(CCD_APPROVED_BY,0) CCD_APPROVED_BY, 
														CCD_APPROVED_DATE, 
														LEASE_APPROVED_BY, 
														LEASE_APPROVED_DATE
														FROM RML_COLL_CCD_REISSUED where id='$reissues_id'"); 
						  
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   <form action="" method="post">
								<div class="md-form">
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
										  <label for="title">Code:</label>
										  <input type="text"class="form-control" required="" id="title"  name="code" value= "<?php echo $row['CODE'];?>">
										</div>
									</div>
										
								</div>
								<div class="row">	
                           						
							<div class="col-sm-12">
								 <div class="md-form mt-2">
									  <label for="comment">Reason:</label>
									  <textarea required=""  class="form-control" rows="2" id="comment" name="reason"><?php echo $row['REASON'];?></textarea>
									</div>
							</div>
						</div>
						<div class="row">	
                           						
							<div class="col-sm-12">
								 <div class="md-form">
									  <label for="comment">Regards:</label>
									  <textarea required=""  class="form-control" rows="1" id="comment" name="regard"><?php echo $row['REGARDS'];?></textarea>
									</div>
							</div>
						</div>
								<?php
								if($row['CCD_APPROVED_BY']==0){
									?>
								<div class="row">
									 <div class="col-sm-4">
										<div class="md-form mt-5">
										<button type="submit" name="submit" class="btn btn-info" > Update</button>
										</div>
									 </div>	
								</div>
								<?php
								}
								?>
								
						
							</div>
						 <?php
						  }
						 ?>
					
					</div>
				  </div>
				  </form>
				</div>

	
	              <?php

                          
						  if(isset($_POST['code'])){
							 
							$code = $_REQUEST['code'];
						    $reg_no = $_REQUEST['reg_no'];
						    $eng_no = $_REQUEST['eng_no'];
						    $chassis_no = $_REQUEST['chassis_no'];
						    $reason = $_REQUEST['reason'];
						    $regard = $_REQUEST['regard'];
							  
							   $strSQL  = oci_parse($objConnect, "UPDATE RML_COLL_CCD_REISSUED
							   SET CODE='$code',
								REG_NO='$reg_no', 
								ENG_NO= '$eng_no',
								CHASSIS_NO='$chassis_no',
							    REASON='$reason',
								REGARDS='$regard'
								where ID=$reissues_id"); 
						  echo "UPDATE RML_COLL_CCD_REISSUED
							   SET CODE='$code',
								REG_NO='$reg_no', 
								ENG_NO= '$eng_no',
								CHASSIS_NO='$chassis_no',
							    REASON='$reason',
								REGARDS='$regard'
								where ID=$reissues_id";
						   if(oci_execute($strSQL)){
							  echo $htmlHeader;
							 while($stuff){
							  echo $stuff;
								}
						    echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/reissues_edit.php?reissues_id=$reissues_id'</script>";
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
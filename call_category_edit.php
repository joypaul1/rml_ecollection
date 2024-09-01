<?php 
	session_start();
		if($_SESSION['user_role_id']!= 13)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 			
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	$category_id=$_REQUEST['category_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT 
													ID, 
													CALL_CATEGORY_TITLE, 
													REMARKS, 
													CREATED_DATE, 
													ENTRY_BY, 
													UPDATED_BY, 
													UPDATE_DATE
													FROM RML_COLL_CALL_CATEGORY Where id='$category_id'"); 
						  
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
										  <label for="title">Call Category Title:</label>
										  <input type="text"class="form-control" required="" id="title"  name="call_category_title" value= "<?php echo $row['CALL_CATEGORY_TITLE'];?>">
										</div>
									</div>
									<div class="col-sm-12">
								        <div class="md-form mt-3">
									    <label for="comment">Call Category Remarks:</label>
										<input type="text"class="form-control" required="" id="title"  name="remarks" value= "<?php echo $row['REMARKS'];?>">
									    </div>
							        </div>
									<div class="col-sm-3">
								        <div class="md-form mt-3">
									    <label for="comment">Created Date:</label>
										<input type="text"class="form-control" required="" id="title" value= "<?php echo $row['CREATED_DATE'];?>" readonly>
									    </div>
							        </div>
									<div class="col-sm-3">
								        <div class="md-form mt-3">
									    <label for="comment">Created By:</label>
										<input type="text"class="form-control" required="" id="title" value= "<?php echo $row['ENTRY_BY'];?>" readonly>
									    </div>
							        </div>
									<div class="col-sm-3">
								        <div class="md-form mt-3">
									    <label for="comment">Last Updated Date:</label>
										<input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['UPDATE_DATE'];?>" readonly>
									    </div>
							        </div>
									<div class="col-sm-3">
								        <div class="md-form mt-3">
									    <label for="comment">Last Updated By:</label>
										<input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['UPDATED_BY'];?>" readonly>
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

                    $emp_session_id=$_SESSION['emp_id'];
					if(isset($_POST['call_category_title'])){
						$call_category_title = $_REQUEST['call_category_title'];
                        $remarks = $_REQUEST['remarks'];
						$strSQL  = oci_parse($objConnect, "update RML_COLL_CALL_CATEGORY SET
							            CALL_CATEGORY_TITLE='$call_category_title',
                                        REMARKS='$remarks',
										UPDATED_BY='$emp_session_id',
										UPDATE_DATE=SYSDATE
								where ID=$category_id"); 
						  
						   if(oci_execute($strSQL)){
							 echo $htmlHeader;
							  while($stuff){
								echo $stuff;
							  }
							  echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/call_category_edit.php?category_id=$category_id'</script>";
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
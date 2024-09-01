<?php 
	session_start();
	if($_SESSION['user_role_id']!= 5)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
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
          <a href="">List</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form action="" method="post">
						<div class="row">
						
							
						</div>	
						<div class="row">	
                           <div class="col-sm-12">
								 <div class="md-form mt-3">
									  <label for="comment">Bank Name:</label>
									  <input required=""  class="form-control"  id="comment" name="bank_name"></textarea>
									</div>
							</div>						
							<div class="col-sm-12">
								 <div class="md-form mt-3">
									  <label for="comment">Bank Address:</label>
									  <textarea required=""  class="form-control" rows="2" id="comment" name="bank_address"></textarea>
									</div>
							</div>
						</div>
						<div class="row">						
							<div class="col-sm-12">
								<div class="md-form mt-3">
									<input class="btn btn-primary btn pull-right" type="submit" value="Submit to Create">
								</div>
							</div>
						</div>
						<hr>
					</form>
					
				</div>

				
				
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						

						if(isset($_POST['bank_name'])){
							
							$bank_name = $_REQUEST['bank_name'];
						    $bank_address = $_REQUEST['bank_address'];
						  
						  $strSQL  = oci_parse($objConnect, 
						   "INSERT INTO RML_COLL_CCD_BANK (
                                BANK_NAME, 
								BANK_ADDRESS, 
							    CREATED_DATE, 
								ENTRY_BY) 
							VALUES (
							 '$bank_name' ,
							 '$bank_address',
							  SYSDATE,
							 '$emp_session_id')"); 
						
						  if(oci_execute($strSQL)){
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Bank Information is created successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						}else{
							 $lastError = error_get_last();
				             $error=$lastError ? "".$lastError["message"]."":"";
							 if (strpos($error, 'ATTN_DATE_PK') !== false) {
											?>
											 <div class="container-fluid">
											  <div class="md-form mt-5">
												<ol class="breadcrumb">
												<li class="breadcrumb-item">
												  This Holiday/Weekend is already created. You can not create duplicate holiday or weekend at same day.
												</li>
											   </ol>
											  </div>
											  </div>
											<?php
										 }
						                }
						               }
                           ?>

		 </div>
       </div>
	   
	    <div class="container-fluid">
			<div class="row">
				
				
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">Bank Name</th>
								  <th scope="col">Bank Address</th>
								  <th scope="col">Created Date</th>
								  <th scope="col">Created By</th>
								  <th scope="col">Action</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_id=$_SESSION['emp_id'];
						
						  $strSQL  = oci_parse($objConnect, 
						                        "select ID,BANK_NAME, 
														BANK_ADDRESS, 
														CREATED_DATE, 
														ENTRY_BY 
													from RML_COLL_CCD_BANK
													order by BANK_NAME desc"); 
						  oci_execute($strSQL);
						  $number=0;
							
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['BANK_NAME'];?></td>
							  <td><?php echo $row['BANK_ADDRESS'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['ENTRY_BY'];?></td>
						
							  <td align="center">
							      
							    <a href="bank_edit.php?bank_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							  </td>
                             
						 </tr>
						 <?php
						  
						  }
						?>
					</tbody>	
				 
		              </table>
					</div>
				  </div>
				</div>
			</div>
		</div>
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
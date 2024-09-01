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
						   <div class="col-sm-6">
								 <div class="md-form mt-3">
									  <label for="comment">Code:</label>
									  <input required=""  class="form-control"  id="comment" name="code"></textarea>
									</div>
							</div>	
							<div class="col-sm-6 mt-3">
									<div class="form-group">
									<label for="title">Re-Issues Select Reason:</label>
									 <select required="" name="reisse_reason" class="form-control">
								     <option selected value="">--</option>
								     <option value="SC Copy lost by Rangs Concern">SC Copy lost by Rangs Concern</option>
								     <option value="SC Copy lost by Customer">SC Copy lost by Customer</option>
								     <option value="Customer requested since Customer sold the vehcile to another party">Customer requested since Customer sold the vehcile to another party</option>
								     <option value="Customer requested since the vehcile was handover to 3rd party">Customer requested since the vehcile was handover to 3rd party</option>
								     <option value="Customer has expired - Ressiue to Nomenie">Customer has expired - Ressiue to Nomenie</option>
								     <option value="Deed received by Rangs Concern but not attached before SC completed">Deed received by Rangs Concern but not attached before SC completed</option>
								     <option value="Typing mistake by CCD Team">Typing mistake by CCD Team</option>
								     
							       </select>
									</div>
								</div>
                           
						</div>	
						<div class="row">	
                           						
							<div class="col-sm-12">
								 <div class="md-form mt-2">
									  <label for="comment">Remarks:</label>
									  <textarea required=""  class="form-control" rows="2" id="comment" name="reason"></textarea>
									</div>
							</div>
						</div>
						<div class="row">						
							<div class="col-sm-12">
								 <div class="md-form">
									  <label for="comment">Regards:</label>
									  <textarea required=""  class="form-control" rows="1" id="comment" name="regard"></textarea>
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
						
						
						

						if(isset($_POST['code'])){
							
							$code = $_REQUEST['code'];
						   	$reason = $_REQUEST['reason'];
						    $regard = $_REQUEST['regard'];
						    $reisse_reason = $_REQUEST['reisse_reason'];
						  
						  $strSQL  = oci_parse($objConnect, 
						   "INSERT INTO RML_COLL_CCD_REISSUED (
										   CODE, 
										   REASON, 
										   REGARDS, 
										   CREATED_BY, 
										   CREATED_DATE,
										   REISSE_REASON) 
										VALUES ( 
										 '$code',
										 '$reason',
										 '$regard',
										 '$emp_session_id',
										 SYSDATE,
										 '$reisse_reason')"); 
						
						  if(oci_execute($strSQL)){
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Reissues Information is created successfully.
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
												  This is already created. You can not create duplicate holiday or weekend at same day.
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
								  <th scope="col">Code</th>
								  <th scope="col">Reg No</th>
								  <th scope="col">Eng No</th>
								  <th scope="col">Chassis No</th>
								  <th scope="col">Created Date</th>
								  <th scope="col">Created By</th>
								  <th scope="col">Action</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_id=$_SESSION['emp_id'];
						
						  $strSQL  = oci_parse($objConnect, 
						                        "SELECT 
														a.ID, 
														a.CODE, 
														b.REG_NO, 
														b.ENG_NO, 
														b.CHASSIS_NO, 
														a.REASON, 
														a.REGARDS, 
														a.CREATED_BY, 
														a.CREATED_DATE, 
														a.CCD_APPROVED_BY, 
														a.CCD_APPROVED_DATE, 
														a.LEASE_APPROVED_BY, 
														a.LEASE_APPROVED_DATE
														FROM RML_COLL_CCD_REISSUED a,RML_COLL_SC_CCD B
														where a.CODE=b.REF_CODE"
											); 
						  oci_execute($strSQL);
						  $number=0;
							
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['CODE'];?></td>
							  <td><?php echo $row['REG_NO'];?></td>
							  <td><?php echo $row['ENG_NO'];?></td>
							  <td><?php echo $row['CHASSIS_NO'];?></td>
							  <td><?php echo $row['CREATED_BY'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
						
							  <td align="center">
							      
							    <a href="reissues_edit.php?reissues_id=<?php echo $row['ID'] ?>"><?php
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
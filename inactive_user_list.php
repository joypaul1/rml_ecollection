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
						<div class="col-sm-4">
							<div class="form-group">
								  <label for="title">User ID:</label>
								  <input name="r_rml_id" class="form-control"  type='text' value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />
							</div>
					</div>
					<div class="col-sm-4">
						<label for="title">Select User Role</label>
						<select required="" name="r_concern" class="form-control">
						    <option selected  value="">--</option>
						    <option  value="AH">Area Head</option>
							<option  value="ZH">Zonal Head</option>
							<option  value="CC">Collection Concern</option>
							
										
						</select>
					</div>
							
							
							<div class="col-sm-3">
								<div class="form-group">
								  <label for="title"> <br></label>
								  <input class="form-control btn btn-primary" type="submit" value="Search Data">
								</div>
							</div>
							
						</div>	
						
						
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								 <th scope="col">Sl</th>
								  <th scope="col">User ID</th>
								  <th scope="col">Name</th>
								  <th scope="col">Mobile</th>
								  <th scope="col">Role</th>
								  <th scope="col">Zone Name</th>
								  <th scope="col">Action</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['r_concern'])){
						  $r_concern = $_REQUEST['r_concern'];
						  $r_rml_id = $_REQUEST['r_rml_id'];
						  $strSQL  = oci_parse($objConnect, "select ID,
							                         EMP_NAME,
													 RML_ID,
													 MOBILE_NO,
													 LEASE_USER,
													 AREA_ZONE 
										    FROM RML_COLL_APPS_USER
												WHERE ACCESS_APP='RML_COLL'
												AND IS_ACTIVE=0
												AND ('$r_rml_id' is null OR RML_ID='$r_rml_id')
												AND ('$r_concern' is null OR LEASE_USER='$r_concern')
													 "); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['MOBILE_NO'];?></td>
							  <td><?php echo $row['LEASE_USER'];?></td>
							  <td><?php echo $row['AREA_ZONE'];?></td>
							 
							 
							<td align="center">
							      
							    <a target="_blank" href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							</td>

						 </tr>
						 <?php
						  }
						  }else{
						     $allDataSQL  = oci_parse($objConnect, 
							                "select ID,
							                         EMP_NAME,
													 RML_ID,
													 MOBILE_NO,
													 LEASE_USER,
													 AREA_ZONE 
										    FROM RML_COLL_APPS_USER
												WHERE ACCESS_APP='RML_COLL'
												AND LEASE_USER='AH'
												AND IS_ACTIVE=0"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['MOBILE_NO'];?></td>
							  <td><?php echo $row['LEASE_USER'];?></td>
							  <td><?php echo $row['AREA_ZONE'];?></td>
							 
							 
							<td align="center">
							      
							    <a target="_blank" href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							</td>

						 </tr>
						 <?php
						  }
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
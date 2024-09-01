<?php 
	session_start();
	if($_SESSION['user_role_id']!= 4 && $_SESSION['user_role_id']!= 1)
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
		 <a href="">Last Assign Information</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
					<div class="row">
					    <div class="col-sm-6"></div>
						<div class="col-sm-3">
							<div class="form-group">
								  <label for="title">Concern ID:</label>
								  <input name="r_rml_id" class="form-control"  type='text' value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />
							</div>
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
						<thead class="table-success">
								<tr>
								 <th scope="col"><center>Sl<br>Number</center></th>
								  <th scope="col">User <br>Information</th>
								  <th scope="col">Code <br>Information</th> 
								  <th scope="col">Collection <br>Information</th>
								  <th scope="col"><center>Others<br> Information</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['r_rml_id'])){
						  $r_concern = $_REQUEST['r_rml_id'];
						  
						  $strSQL  = oci_parse($objConnect, "select TARGET,TARGETSHOW,
											   ZONE,RML_ID,CONCERN,OVER_DUE,
											   CURRENT_MONTH_DUE,
											   START_DATE,END_DATE,
											   ENTRY_DATE,VISIT_UNIT,
											   AREA_HEAD,DATA_ADMIN
										FROM MONTLY_COLLECTION
										WHERE IS_ACTIVE=1
										AND ZONAL_HEAD='$emp_session_id'
										AND ('$r_concern' IS NULL OR RML_ID='$r_concern')
													 "); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						  <tr>
							  <td align="center"><?php echo $number;?></td>
							  <td>
							   <?php 
							     echo 'Name: '.$row['CONCERN'];
								 echo '<br>';
								 echo 'Login ID: '.$row['RML_ID'];
								  echo '<br>';
								 echo 'User Zone: '.$row['ZONE'];
								 echo '<br>';
								 echo 'Area Head: '.$row['AREA_HEAD'];
							   ?>
							</td>
							<td>
							    <?php 
								 echo 'Target: '.$row['TARGET'];
								 echo '<br>';
								 echo 'Display Target: '.$row['TARGETSHOW'];
								 echo '<br>';
								 echo 'Overdue: '.$row['OVER_DUE'];
								 echo '<br>';
								  echo 'Current Month Due: '.$row['CURRENT_MONTH_DUE'];
								?>
							</td>
							<td>
							    <?php 
								 echo 'Start Date: '.$row['START_DATE'];
								 echo '<br>';
								 echo 'End Date: '.$row['END_DATE'];
								 echo '<br>';
								 echo 'Visit Unit: '.$row['VISIT_UNIT'];
								 
								 echo '<br>';
								 echo 'Data Admin: '.$row['DATA_ADMIN'];
								?>
							</td>
							 
							<td align="center">
							      
							    <a href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							</td>

						 </tr>
						 <?php
						  }
						  }else{
						     $allDataSQL  = oci_parse($objConnect, 
							                "select 
											   TARGET,
											   TARGETSHOW,
											   ZONE,
											   RML_ID,
											   CONCERN,
											   OVER_DUE,
											   CURRENT_MONTH_DUE,
											   START_DATE,
											   END_DATE,
											   ENTRY_DATE,
											   VISIT_UNIT,
											   AREA_HEAD,
											   DATA_ADMIN
										FROM MONTLY_COLLECTION
										WHERE IS_ACTIVE=1
										AND ZONAL_HEAD='$emp_session_id'"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td>
							  <td>
							   <?php 
							     echo 'Name: '.$row['CONCERN'];
								 echo '<br>';
								 echo 'Login ID: '.$row['RML_ID'];
								  echo '<br>';
								 echo 'User Zone: '.$row['ZONE'];
								 echo '<br>';
								 echo 'Area Head: '.$row['AREA_HEAD'];
							   ?>
							</td>
							<td>
							    <?php 
								 echo 'Total Code: '.$row['TARGET'];
								 echo '<br>';
								 echo 'Visited Plan: '.$row['TARGETSHOW'];
								 echo '<br>';
								 echo 'Unique Visited Plan: '.$row['OVER_DUE'];
								 echo '<br>';
								  echo 'Visited: '.$row['CURRENT_MONTH_DUE'];
								?>
							</td>
							<td>
							    <?php 
								 echo 'Target: '.$row['TARGET'];
								 echo '<br>';
								 echo 'Display Target: '.$row['TARGETSHOW'];
								 echo '<br>';
								 echo 'Overdue: '.$row['OVER_DUE'];
								 echo '<br>';
								  echo 'Current Month Due: '.$row['CURRENT_MONTH_DUE'];
								?>
							</td>
							<td>
							    <?php 
								 echo 'Start Date: '.$row['START_DATE'];
								 echo '<br>';
								 echo 'End Date: '.$row['END_DATE'];
								 echo '<br>';
								 echo 'Visit Unit: '.$row['VISIT_UNIT'];
								 
								 echo '<br>';
								 echo 'Data Admin: '.$row['DATA_ADMIN'];
								?>
							</td>
							 
							<td align="center">
							      
							    <a href="apps_user_edit.php?emp_ref_id=<?php echo $row['ID'] ?>"><?php
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
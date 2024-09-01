<?php 
	session_start();
	if($_SESSION['user_role_id']!= 2 && $_SESSION['user_role_id']!= 1)
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
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								  <label for="title">User ID:</label>
								  <input name="r_rml_id" class="form-control"  type='text' value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />
							</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">User Zone:</label>
						  <select name="zone_name" class="form-control">
						  <option required="" value="">----</option>
									  <?php
										$strSQLA  = oci_parse($objConnect, "SELECT  unique ZONE ZONE_NAME
																			FROM MONTLY_COLLECTION
																			where IS_ACTIVE=1
																			order by ZONE"); 
										oci_execute($strSQLA);
									   
									   while($rowdata=oci_fetch_assoc($strSQLA)){
											  ?> 
											  <option <?php echo isset($_POST['zone_name']) ? $_REQUEST['zone_name'] == $rowdata['ZONE_NAME']?'selected':''  :'' ?> value="<?php echo $rowdata['ZONE_NAME'];?>"><?php echo $rowdata['ZONE_NAME'];?></option>
											   <?php
											   }
									  ?>
								</select>
						 
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title">Data Admin:</label>
						  <select name="data_admin" class="form-control">
						  <option value="">----</option>
									  <?php
										$strSQLA  = oci_parse($objConnect, "SELECT  unique DATA_ADMIN DATA_ADMIN
																			FROM MONTLY_COLLECTION
																			where IS_ACTIVE=1
																			order by DATA_ADMIN"); 
										oci_execute($strSQLA);
									   
									   while($rowdata=oci_fetch_assoc($strSQLA)){
											  ?> 
											   <option <?php echo isset($_POST['data_admin']) ? $_REQUEST['data_admin'] == $rowdata['DATA_ADMIN']?'selected':''  :'' ?> value="<?php echo $rowdata['DATA_ADMIN'];?>"><?php echo $rowdata['DATA_ADMIN'];?></option>
											   <?php
											   }
									  ?>
								</select>
						 
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
								  <th scope="col"><center>Sl</center></th>
								  <th scope="col">Target<br>Info</th>
								  <th scope="col"><center>Others<br>Info</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['data_admin'])){
						  $v_data_admin = $_REQUEST['data_admin'];
						  $v_zone_name = $_REQUEST['zone_name'];
						  $r_rml_id = $_REQUEST['r_rml_id'];
						  $strSQL  = oci_parse($objConnect, "SELECT ID,
												DEALER_ID, 
												TARGET, 
												TARGETSHOW, 
												ZONE, RML_ID, CONCERN, 
												OVER_DUE, CURRENT_MONTH_DUE, 
												START_DATE, 
												END_DATE, 
												IS_ACTIVE, 
												ENTRY_DATE, 
												BRAND_NAME, 
												VISIT_UNIT, 
												ZONAL_HEAD, 
												AREA_HEAD, 
												DATA_ADMIN
												FROM MONTLY_COLLECTION
												where IS_ACTIVE=1
												and ('$r_rml_id' IS NULL OR RML_ID='$r_rml_id')
												and ('$v_zone_name' IS NULL OR ZONE='$v_zone_name')
												and ('$v_data_admin' IS NULL OR DATA_ADMIN='$v_data_admin')
												"); 
									
						  @oci_execute(@$strSQL);
						  $number=0;
							
		                  while($row=@oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						  <tr>
							    <td align="center"><?php echo $number;?></td>
							    <td><?php 
								    echo 'Login ID: '.$row['RML_ID'].' ['.$row['ZONE'].']';
									echo '<br>';
									echo 'Name: '.$row['CONCERN'];
									echo '<br>';
									echo 'Target: '.$row['TARGET'];
									echo '<br>';
									echo 'Display Target: '.$row['TARGETSHOW'];
									echo '<br>';	
                                    echo 'Data From: '.$row['DATA_ADMIN'];	
									echo '<br>';	
									echo 'Start Date: '.$row['START_DATE'];
									echo '<br>';
									echo 'End Date: '.$row['END_DATE'];
                                    
							      ?>
								</td>
				
						
							  <td><?php 
							        echo 'Over Due: '.$row['OVER_DUE'];
									echo '<br>';
									echo 'Current Month Due: '.$row['CURRENT_MONTH_DUE'];
									echo '<br>';
									 echo 'Zonal Head: '.$row['ZONAL_HEAD'];
									echo '<br>';
									echo 'Area Head: '.$row['AREA_HEAD'];
									echo '<br>';	
									echo 'Visit Unit: '.$row['VISIT_UNIT'];	
									echo '<br>';
									echo 'Dealer ID: '.$row['DEALER_ID'];
                                  
							  ?></td>
							<td align="center">
							      
							    <a href="target_list_edit.php?target_table_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							</td>

						 </tr>
						 <?php
						  }
						  }else{
						     $allDataSQL  = oci_parse($objConnect, 
							                "SELECT ID,
												DEALER_ID, 
												TARGET, 
												TARGETSHOW, 
												ZONE, RML_ID, CONCERN, 
												OVER_DUE, CURRENT_MONTH_DUE, 
												START_DATE, 
												END_DATE, 
												IS_ACTIVE, 
												ENTRY_DATE, 
												BRAND_NAME, 
												VISIT_UNIT, 
												ZONAL_HEAD, 
												AREA_HEAD, 
												DATA_ADMIN
												FROM MONTLY_COLLECTION
												where IS_ACTIVE=1"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							    <td align="center"><?php echo $number;?></td>
							    <td><?php 
								    echo 'Login ID: '.$row['RML_ID'].' ['.$row['ZONE'].']';
									echo '<br>';
									echo 'Name: '.$row['CONCERN'];
									echo '<br>';
									echo 'Target: '.$row['TARGET'];
									echo '<br>';
									echo 'Display Target: '.$row['TARGETSHOW'];
									echo '<br>';	
                                    echo 'Data From: '.$row['DATA_ADMIN'];	
									echo '<br>';	
									echo 'Start Date: '.$row['START_DATE'];
									echo '<br>';
									echo 'End Date: '.$row['END_DATE'];
                                    
							      ?>
								</td>
				
						
							  <td><?php 
							        echo 'Over Due: '.$row['OVER_DUE'];
									echo '<br>';
									echo 'Current Month Due: '.$row['CURRENT_MONTH_DUE'];
									echo '<br>';
									 echo 'Zonal Head: '.$row['ZONAL_HEAD'];
									echo '<br>';
									echo 'Area Head: '.$row['AREA_HEAD'];
									echo '<br>';	
									echo 'Visit Unit: '.$row['VISIT_UNIT'];	
									echo '<br>';
									echo 'Dealer ID: '.$row['DEALER_ID'];
                                  
							  ?></td>
							<td align="center">
							      
							    <a href="target_list_edit.php?target_table_id=<?php echo $row['ID'] ?>"><?php
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
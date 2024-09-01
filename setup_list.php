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
						<div class="col-sm-3">
							<div class="form-group">
								  <label for="title">ZH ID:</label>
								  <input name="r_rml_id" class="form-control"  type='text' value='<?php echo isset($_POST['r_rml_id']) ? $_POST['r_rml_id'] : ''; ?>' />
							</div>
					</div>
					<div class="col-sm-3">
						<label for="title">Select User Type</label>
						<select required="" name="user_type" class="form-control">
                                <option <?php echo  isset($_POST['user_type']) ? $_REQUEST['user_type'] == ''?'selected':''  :''?> value="">-----</option>
                                <option <?php echo isset($_POST['user_type']) ? $_REQUEST['user_type'] == 'C-C'?'selected':''  :'' ?> value="C-C">Collection - Collection</option>
                                <option <?php echo isset($_POST['user_type']) ? $_REQUEST['user_type'] == 'S-C'?'selected':''  :''?> value="S-C">Sales - Collection</option>
                            </select>
					</div>	
					<div class="col-sm-3">
					<label for="title">Select Zone</label>
							<select  name="zone_name" class="form-control">
								  <option value="">---</option>
								      <?php
										$strSQL  = oci_parse($objConnect, "select unique ZONE_NAME from COLL_EMP_ZONE_SETUP order by ZONE_NAME");    
									  
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	
									 <!-- <option value="<?php echo $row['ZONE_NAME'];?>"><?php echo $row['ZONE_NAME'];?></option> -->
									  <option <?php echo isset($_POST['zone_name']) ? $_REQUEST['zone_name'] == $row['ZONE_NAME'] ?'selected':''  :''?> value="<?php echo $row['ZONE_NAME'];?>"><?php echo $row['ZONE_NAME'];?></option>
									 <?php
									   }
									  ?>
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
					<div class="md-form mt-3">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="table-success">
								<tr>
								 <th scope="col"><center>Sl<br>Number</center></th>
								  <th scope="col">User <br>Zone</th>
								  <th scope="col">Zonal Head<br>ID</th>
								  <th scope="col"><center>Area Head<br>ID</center></th>
								  <th scope="col"><center>Status</center></th>
								  <th scope="col"><center>Total Unit</center></th>
								  <th scope="col"><center>User Type</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['user_type'])){
						  $v_user_type = $_REQUEST['user_type'];
						  $r_rml_id = $_REQUEST['r_rml_id'];
						  $r_zone_name = $_REQUEST['zone_name'];
						  $strSQL  = oci_parse($objConnect, "SELECT 
															    ID, 
															   ZONE_NAME, ZONE_HEAD,
															   (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=ZONE_HEAD) ZONE_HEAD_NAME,AREA_HEAD,
															    (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=AREA_HEAD) AREA_HEAD_NAME,
															   IS_ACTIVE, TOTAL_UNIT, 
															   USER_TYPE
															FROM COLL_EMP_ZONE_SETUP 
						                                     where USER_TYPE='$v_user_type'
															 and ('$r_zone_name' IS NULL OR ZONE_NAME='$r_zone_name')
															 AND ('$r_rml_id' IS NULL OR ZONE_HEAD='$r_rml_id')
											order by ZONE_NAME"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						  <tr>
							  <td align="center"><?php echo $number;?></td>
							  <td><?php echo $row['ZONE_NAME'];?></td>
							   <td><?php echo $row['ZONE_HEAD_NAME'].'['.$row['ZONE_HEAD'].']';?></td>
							  <td><?php echo $row['AREA_HEAD_NAME'].'['.$row['AREA_HEAD'].']';?></td>
							 <td><?php 
							       if($row['IS_ACTIVE']=='1')
							           echo 'Active';
								  else
									  echo 'In-Active';
								  ?></td>
							  <td><?php echo $row['TOTAL_UNIT'];?></td>
							  <td><?php echo $row['USER_TYPE'];?></td>
							
							
							 
							<td align="center">
							      
							    <a href="setup_list_edit.php?set_up_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							</td>

						 </tr>
						 <?php
						  }
						  }else{
						     $allDataSQL  = oci_parse($objConnect, 
							                "SELECT 
												  ID, 
												  ZONE_NAME, ZONE_HEAD,
												  (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=ZONE_HEAD) ZONE_HEAD_NAME,AREA_HEAD,
												   (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=AREA_HEAD) AREA_HEAD_NAME,
												   BRAND_NAME, IS_ACTIVE, TOTAL_UNIT, 
												   USER_TYPE
												FROM COLL_EMP_ZONE_SETUP
											order by ZONE_NAME,USER_TYPE"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td>
							  <td><?php echo $row['ZONE_NAME'];?></td>
							  <td><?php echo $row['ZONE_HEAD_NAME'].'['.$row['ZONE_HEAD'].']';?></td>
							  <td><?php echo $row['AREA_HEAD_NAME'].'['.$row['AREA_HEAD'].']';?></td>
							  <td><?php 
							       if($row['IS_ACTIVE']=='1')
							           echo 'Active';
								  else
									  echo 'In-Active';
								  ?></td>
							  <td><?php echo $row['TOTAL_UNIT'];?></td>
							  <td><?php echo $row['USER_TYPE'];?></td>
							
							
							 
							<td align="center">
							      
							    <a href="setup_list_edit.php?set_up_id=<?php echo $row['ID'] ?>"><?php
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
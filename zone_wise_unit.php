<?php 
	session_start();
	if($_SESSION['user_role_id']!= 2)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	$emp_session_id=$_SESSION['emp_id'];
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">List</a>  &nbsp;&nbsp;
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								  <label for="title">Session User</label>
								  <input name="r_rml_id" class="form-control"  type='text' readonly value='<?php echo $emp_session_id; ?>' />
							</div>
					</div>		
					<div class="col-sm-3">
						<div class="form-group">
						  <label for="title"> <br></label>
						  <input class="form-control btn btn-primary" type="submit" value="Marge Data">
						</div>
					</div>
							
						</div>	
						
						
					</form>
				</div>
				
				<div class="col-lg-6">
					<div class="md-form mt-3">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								 <th scope="col">Sl</th>
								  <th scope="col">Zone</th>
								  <th scope="col">Zonal Head ID</th>
								  <th scope="col">Area Head ID</th>
								  <th scope="col">Total Unit</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
						
						
						if(isset($_POST['r_rml_id'])){
							 $refSQL  = oci_parse($objConnect, "BEGIN RML_ZONE_REFFESH('',''); END;"); 
                                oci_execute($refSQL);
								
								}
						 $strSQL  = oci_parse($objConnect, "SELECT 
												ID, 
												ZONE_NAME, 
												ZONE_HEAD,  
												AREA_HEAD,  
												BRAND_NAME, 
												IS_ACTIVE, 
												TOTAL_UNIT
												FROM COLL_EMP_ZONE_SETUP where IS_ACTIVE=1
												order by ZONE_NAME"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['ZONE_NAME'];?></td>
							  <td><?php echo $row['ZONE_HEAD'];?></td>
							  <td><?php echo $row['AREA_HEAD'];?></td>
							  <td><?php echo $row['TOTAL_UNIT'];?></td>
						 </tr>
						 <?php
						  }
						 
						  ?>
					</tbody>	
				 
		              </table>
					</div>
					
				  </div>
				</div>
				<div class="col-lg-6">
					<div class="md-form mt-3">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								 <th scope="col">Sl</th>
								  <th scope="col">Zone</th>
								  <th scope="col">Total Unit</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
						 $strSQL  = oci_parse($objConnect, "SELECT ZONE,
						                                   SUM(VISIT_UNIT)TOTAL_VISIT_UNIT FROM MONTLY_COLLECTION
														WHERE IS_ACTIVE=1
														GROUP BY ZONE
														ORDER BY ZONE"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['ZONE'];?></td>
							  <td><?php echo $row['TOTAL_VISIT_UNIT'];?></td>
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
<?php 
	session_start();
	if($_SESSION['user_role_id']!= 10)
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
								  <label for="title">Ref Code:</label>
								  <input  required="" name="ref_code" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-4">
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
								  <th scope="col"><center>Sl</center></th>
								  <th scope="col"><center>REF-ID</center></th>
								  <th scope="col"><center>Seized By</center></th>
								  <th scope="col"><center>Seized Date</center></th>
								  <th scope="col"><center>Seized Confirm Date</center></th>
								  <th scope="col"><center>Release Date</center></th>
								  <th scope="col"><center>Depot Location</center></th>
							      <th scope="col"><center>Area Zone</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['ref_code'])){
						  $ref_code = $_REQUEST['ref_code'];
						  
						  $strSQL  = oci_parse($objConnect, "select B.RML_ID,
						                                            B.EMP_NAME,
																	A.REF_ID,
																	a.ENTRY_DATE, 
																	B.AREA_ZONE,
																	a.DRIVER_NAME,
																	a.DEPOT_LOCATION,
																	a.IS_CONFIRM,
																	a.RELEASE_DATE,
																	a.ERP_PASS_DATE
									from RML_COLL_SEIZE_RELEASE a,RML_COLL_APPS_USER b
									where A.ENTRY_BY_RML_ID=b.RML_ID
									and A.REF_ID='$ref_code'
									and IS_CONFIRM=1"); 	
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['REF_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							  <td align="center"><?php echo $row['ERP_PASS_DATE'];?></td>
							  <td align="center"><?php echo $row['RELEASE_DATE'];?></td>
							  <td align="center"><?php echo $row['DEPOT_LOCATION'];?></td>
							  <td align="center"><?php echo $row['AREA_ZONE'];?></td> 
							  
						 </tr>
						 <?php
						  }
						  }else{
							 
						     $allDataSQL  = oci_parse($objConnect, "select b.RML_ID,
							                                               b.EMP_NAME,
																		   a.REF_ID,
																		   a.ENTRY_DATE, 
																		   b.AREA_ZONE,
																		   a.DRIVER_NAME,a
																		   .DEPOT_LOCATION,
																		   a.IS_CONFIRM,
																		   a.RELEASE_DATE,a.ERP_PASS_DATE
									from RML_COLL_SEIZE_RELEASE a,RML_COLL_APPS_USER b
									where A.ENTRY_BY_RML_ID=b.RML_ID
									and IS_CONFIRM=1
									and rownum<=20"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						    <tr>
							  <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['REF_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							  <td align="center"><?php echo $row['ERP_PASS_DATE'];?></td>
							  <td align="center"><?php echo $row['RELEASE_DATE'];?></td>
							  <td align="center"><?php echo $row['DEPOT_LOCATION'];?></td>
							  <td align="center"><?php echo $row['AREA_ZONE'];?></td> 
							  
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
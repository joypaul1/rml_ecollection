<?php 
	session_start();
	if($_SESSION['user_role_id']!= 5)
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
								  <label for="title">Ref-Code:</label>
								  <input required="" name="ref_code" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
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
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Customer Info</center></th>
								  <th scope="col"><center>CCD Approval Info</center></th>
								  <th scope="col"><center>Request Info</center></th>
								  <th scope="col"><center>Reason/Regards</center></th>
								  <th scope="col"><center>Chassis/Reg/Eng No</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['ref_code'])){
							
						  $reference_code = $_REQUEST['ref_code'];
						  $strSQL  = oci_parse($objConnect, "SELECT B.ID,
											A.CODE, 
											B.REG_NO, 
											B.ENG_NO, 
											B.CHASSIS_NO, 
											A.REASON, 
											A.REGARDS, 
											A.CREATED_BY, 
											A.CREATED_DATE, 
											A.CCD_APPROVED_BY, 
											A.CCD_APPROVED_DATE, 
											A.LEASE_APPROVED_BY, 
											A.LEASE_APPROVED_DATE, 
											A.CCD_APPROVAL_STATUS, 
											A.LEASE_APPROVAL_STATUS,
											B.CURRENT_PARTY_NAME,
											B.CURRENT_PARTY_MOBILE
											FROM RML_COLL_CCD_REISSUED A, RML_COLL_SC_CCD B
											WHERE A.CODE=B.REF_CODE
											AND  B.REF_CODE='$reference_code'"); 	
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							<td><?php echo $number;?></td>
							 <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['CODE'].'</b></i> ';
								 echo '<br>';
								 echo $row['CURRENT_PARTY_NAME'];
								 echo '<br>';
								 echo $row['CURRENT_PARTY_MOBILE'];
								?>
							</td>
							<td align="center">
								  <?php if($row['CCD_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['CCD_APPROVED_DATE'];
									  echo '<br>';
									  echo $row['CCD_APPROVED_BY'];
								  }
								  else if($row['CCD_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['CCD_APPROVED_DATE'];
									   echo '<br>';
									   echo $row['CCD_APPROVED_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							  <!--
							 <td align="center">
								  <?php if($row['LEASE_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['LEASE_APPROVED_DATE'];
									  echo '<br>';
									  echo $row['LEASE_APPROVED_BY'];
								  }
								  else if($row['LEASE_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['LEASE_APPROVED_DATE'];
									   echo '<br>';
									   echo $row['LEASE_APPROVED_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							  -->
							  <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['CREATED_BY'].'</b></i> ';
								 echo '<br>';
								 echo $row['CREATED_DATE'];
								
								?>
							  </td>
							  <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['REASON'].'</b></i> ';
								 echo '<br>';
								 echo $row['REGARDS'];
								
								?>
							  </td>
							  <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['CHASSIS_NO'].'</b></i> ';
								 echo '<br>';
								 echo $row['REG_NO'];
								 echo '<br>';
								 echo $row['ENG_NO'];
								?>
							</td>
							<td align="center">
							     <a href="sc_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="branch_edit">Information</button>';
								?>
								</a>
							</td>
						 </tr>
						 <?php
						  }
						  }else{
							 
						     $allDataSQL  = oci_parse($objConnect, 
							            "SELECT B.ID,
											A.CODE, 
											B.REG_NO, 
											B.ENG_NO, 
											B.CHASSIS_NO, 
											A.REASON, 
											A.REGARDS, 
											A.CREATED_BY, 
											A.CREATED_DATE, 
											A.CCD_APPROVED_BY, 
											A.CCD_APPROVED_DATE, 
											A.LEASE_APPROVED_BY, 
											A.LEASE_APPROVED_DATE, 
											A.CCD_APPROVAL_STATUS, 
											A.LEASE_APPROVAL_STATUS,
											B.CURRENT_PARTY_NAME,
											B.CURRENT_PARTY_MOBILE
											FROM RML_COLL_CCD_REISSUED A, RML_COLL_SC_CCD B
											WHERE A.CODE=B.REF_CODE"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							 <td><?php echo $number;?></td>
							 <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['CODE'].'</b></i> ';
								 echo '<br>';
								 echo $row['CURRENT_PARTY_NAME'];
								 echo '<br>';
								 echo $row['CURRENT_PARTY_MOBILE'];
								?>
							</td>
							<td align="center">
								  <?php if($row['CCD_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['CCD_APPROVED_DATE'];
									  echo '<br>';
									  echo $row['CCD_APPROVED_BY'];
								  }
								  else if($row['CCD_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['CCD_APPROVED_DATE'];
									   echo '<br>';
									   echo $row['CCD_APPROVED_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							  <!--
							 <td align="center">
								  <?php if($row['LEASE_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['LEASE_APPROVED_DATE'];
									  echo '<br>';
									  echo $row['LEASE_APPROVED_BY'];
								  }
								  else if($row['LEASE_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['LEASE_APPROVED_DATE'];
									   echo '<br>';
									   echo $row['LEASE_APPROVED_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							  -->
							  <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['CREATED_BY'].'</b></i> ';
								 echo '<br>';
								 echo $row['CREATED_DATE'];
								
								?>
							  </td>
							  <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['REASON'].'</b></i> ';
								 echo '<br>';
								 echo $row['REGARDS'];
								
								?>
							  </td>
							  <td align="center">
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['CHASSIS_NO'].'</b></i> ';
								 echo '<br>';
								 echo $row['REG_NO'];
								 echo '<br>';
								 echo $row['ENG_NO'];
								?>
							</td>
							<td align="center">
							     <a href="sc_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="branch_edit">Information</button>';
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
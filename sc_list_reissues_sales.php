<?php 
	session_start();
	if($_SESSION['user_role_id']!= 14)
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
								  <label for="title">Chassis No/Buyers No:</label>
								  <input name="ref_code" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-4">
							 <label for="title">Select File Problem:</label>
							    <select name="issues" class="form-control">
								 <option selected value="">--</option>
								      <?php
									  $strSQL  = oci_parse($objConnect, "select CHECK_LIST_TITLE from RML_COLL_CCD_CHECK_LIST ORDER BY CHECK_LIST_TITLE");
									  	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['CHECK_LIST_TITLE'];?>"><?php echo $row['CHECK_LIST_TITLE'];?></option>
									  <?php
									   }
									  ?>
							    </select> 
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
					   <table class="table table-bordered piechart-key table-responsive" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Customer Info</center></th>
								  <th scope="col"><center>Lease Aprvl.Info</center></th>
								  <th scope="col"><center>Acc Aprvl.Info</center></th>
								  <th scope="col"><center>CCD Aprvl. Info</center></th>
								  <th scope="col"><center>SC Status</center></th>
								  <th scope="col"><center>Requester Info</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['ref_code'])){
							
						  $reference_code = $_REQUEST['ref_code'];
						  $issues = $_REQUEST['issues'];
						  $strSQL  = oci_parse($objConnect, "SELECT 
															   A.ID, 
															   A.REF_CODE, 
															   A.CURRENT_PARTY_NAME, 
															   A.CURRENT_PARTY_MOBILE, 
															   A.CURRENT_PARTY_ADDRS, 
															   A.MODEL_NAME, 
															   A.INSTALLMENT_RECEIVED, 
															   A.SALES_AMOUNT, 
															   A.DP, 
															   A.FIRST_PARTY_NAME, 
															   A.FIRST_PARTY_DP, 
															   A.FRIST_PARTY_INSTALLMENT_REC, 
															   A.RESOLED_DP, 
															   A.RESOLED_RECEIVED, 
															   A.RECEIVABLE, 
															   A.DISCOUNT, 
															   A.RECEIVED, 
															   A.CLOSING_DATE, 
															   A.RESALE_APPROVAL_DATE, 
															   A.REQUEST_DATE, 
															   A.REQUEST_BY, 
															   A.REQUESTER_NAME, 
															   A.REQUESTER_MOBILE, 
															   A.LEASE_APPROVAL_STATUS, 
															   A.LEASE_APPROVAL_DATE, 
															   A.LEASE_APPROVAL_BY, 
															   A.ACC_APPROVAL_DATE, 
															   A.ACC_APPROVAL_BY, 
															   A.ACC_APPROVAL_STATUS, 
															   A.CCD_APPROVAL_DATE, 
															   A.CCD_APPROVAL_BY, 
															   A.CCD_APPROVAL_STATUS, 
															   A.FILE_CLEAR_STATUS,
															   A.FILE_CLEAR_DATE,
															   A.FILE_CLEAR_BY,
															   A.SALE_TYPE
															FROM RML_COLL_SC_CCD a,RML_COLL_SC_CCD_CHECKLIST_FAIL b,RML_COLL_SC_CCD_CHECKLIST c
															WHERE A.ID=B.RML_COLL_SC_CCD_ID
															and b.RML_COLL_SC_CCD_ID=c.RML_COLL_SC_CCD_ID
															AND ('$reference_code' IS NULL OR A.REF_CODE='$reference_code' OR CHASSIS_NO='$reference_code')
															AND a.FILE_CLEAR_STATUS=0
															AND B.STATUS=0
															AND C.STATUS IS NULL
															AND SALE_TYPE='CSH'
															AND ('$issues' IS NULL OR C.CHECK_LIST_NAME='$issues')
															");
															
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							    <td>
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['REF_CODE'].'</b></i> ';
								 echo '<br>';
								 echo $row['CURRENT_PARTY_NAME'];
								 echo '<br>';
								 echo $row['CURRENT_PARTY_MOBILE'];
								 echo '<br>';
								 echo '<i style="color:gray;"><b> Sale Type: '.$row['SALE_TYPE'].'</b></i> ';
								?>
							</td>
							   <td>
								  <?php if($row['LEASE_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['LEASE_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['LEASE_APPROVAL_BY'];
								  }
								  else if($row['LEASE_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['LEASE_APPROVAL_DATE'];
									   echo '<br>';
									   echo $row['LEASE_APPROVAL_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							   <td>
								  <?php if($row['ACC_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['ACC_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['ACC_APPROVAL_BY'];
								  }
								  else if($row['ACC_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['ACC_APPROVAL_DATE'];
									   echo '<br>';
									   echo $row['ACC_APPROVAL_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							   <td>
								  <?php if($row['CCD_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['CCD_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['CCD_APPROVAL_BY'];
								  }
								  else if($row['CDD_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['CCD_APPROVAL_DATE'];
									   echo '<br>';
									   echo $row['CCD_APPROVAL_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							  <td> 
							    <?php  if ($row['FILE_CLEAR_STATUS']==0){
								     echo '<i style="color:red;"><b>File Problem</b></i>';
									 echo '<br>';
									 echo $row['FILE_CLEAR_DATE'];
									 echo '<br>';
									 echo $row['FILE_CLEAR_BY'];
							     }else if($row['FILE_CLEAR_STATUS']==1){
									 echo 'SC Ready';
									 echo '<br>';
									 echo $row['FILE_CLEAR_DATE'];
									 echo '<br>';
									 echo $row['FILE_CLEAR_BY'];
								}
								?>
							  </td>
							  <td><?php echo $row['REQUESTER_NAME'].'<br>'.$row['REQUESTER_MOBILE'].'<br>'.$row['REQUEST_DATE'].'<br>'.$row['REQUEST_BY'];?></td>
							 
							 <td align="center">
							     <a href="sc_list_reissues_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
								echo '<button class="form-control btn btn-primary">Check List</button>';
								?></a><br><br>
								<a href="sc_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
								 echo '<button class="form-control btn btn-primary">Update Info</button>';?>
								 </a>
							</td>
						 </tr>
						 <?php
						  }
						  }else{
							 
						     $allDataSQL  = oci_parse($objConnect, "SELECT 
																	   A.ID, 
																	   A.REF_CODE, 
																	   A.CURRENT_PARTY_NAME, 
																	   A.CURRENT_PARTY_MOBILE, 
																	   A.CURRENT_PARTY_ADDRS, 
																	   A.MODEL_NAME, 
																	   A.INSTALLMENT_RECEIVED, 
																	   A.SALES_AMOUNT, 
																	   A.DP, 
																	   A.FIRST_PARTY_NAME, 
																	   A.FIRST_PARTY_DP, 
																	   A.FRIST_PARTY_INSTALLMENT_REC, 
																	   A.RESOLED_DP, 
																	   A.RESOLED_RECEIVED, 
																	   A.RECEIVABLE, 
																	   A.CLOSING_DATE, 
																	   A.REQUEST_DATE, 
																	   A.REQUEST_BY, 
																	   A.REQUESTER_NAME, 
																	   A.REQUESTER_MOBILE, 
																	   A.LEASE_APPROVAL_STATUS, 
																	   A.LEASE_APPROVAL_DATE, 
																	   A.LEASE_APPROVAL_BY, 
																	   A.ACC_APPROVAL_DATE, 
																	   A.ACC_APPROVAL_BY, 
																	   A.ACC_APPROVAL_STATUS, 
																	   A.CCD_APPROVAL_DATE, 
																	   A.CCD_APPROVAL_BY, 
																	   A.CCD_APPROVAL_STATUS, 
																	   A.FILE_CLEAR_STATUS,
																	   A.FILE_CLEAR_DATE,
																	   A.FILE_CLEAR_BY,
																	   A.SALE_TYPE
																	FROM RML_COLL_SC_CCD a,RML_COLL_SC_CCD_CHECKLIST_FAIL b
																	WHERE A.ID=B.RML_COLL_SC_CCD_ID
																	AND A.FILE_CLEAR_STATUS=0
																	AND B.STATUS=0
																	AND a.SALE_TYPE='CSH'
																	"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  
							  <td>
							    <?php 
								 echo '<i style="color:red;"><b>'.$row['REF_CODE'].'</b></i> ';
								 echo '<br>';
								 echo $row['CURRENT_PARTY_NAME'];
								 echo '<br>';
								 echo $row['CURRENT_PARTY_MOBILE'];
								 echo '<br>';
								 echo '<i style="color:gray;"><b> Sale Type: '.$row['SALE_TYPE'].'</b></i> ';
								?>
							</td>
							<td>
								  <?php if($row['LEASE_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['LEASE_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['LEASE_APPROVAL_BY'];
								  }
								  else if($row['LEASE_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['LEASE_APPROVAL_DATE'];
									   echo '<br>';
									   echo $row['LEASE_APPROVAL_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							   <td>
								  <?php if($row['ACC_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['ACC_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['ACC_APPROVAL_BY'];
								  }
								  else if($row['ACC_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['ACC_APPROVAL_DATE'];
									   echo '<br>';
									   echo $row['ACC_APPROVAL_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							   <td>
								  <?php if($row['CCD_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['CCD_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['CCD_APPROVAL_BY'];
								  }
								  else if(@$row['CDD_APPROVAL_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo @$row['CCD_APPROVAL_DATE'];
									   echo '<br>';
									   echo @$row['CCD_APPROVAL_BY'];
								       }
									else{
										
									}  
								  ?>
							  </td>
							  <td> 
							    <?php  if ($row['FILE_CLEAR_STATUS']==0){
								     echo '<i style="color:red;"><b>File Problem</b></i>';
									 echo '<br>';
									 echo $row['FILE_CLEAR_DATE'];
									 echo '<br>';
									 echo $row['FILE_CLEAR_BY'];
							     }else if($row['FILE_CLEAR_STATUS']==1){
									 echo 'SC Ready';
									 echo '<br>';
									 echo $row['FILE_CLEAR_DATE'];
									 echo '<br>';
									 echo $row['FILE_CLEAR_BY'];
								}
								?>
							  </td>
							<td><?php echo $row['REQUESTER_NAME'].'<br>'.$row['REQUESTER_MOBILE'].'<br>'.$row['REQUEST_DATE'].'<br>'.$row['REQUEST_BY'];?></td>
							<td align="center">
							     <a href="sc_list_reissues_edit.php?sc_id=<?php echo $row['ID'] ?>">
								 <?php echo '<button class="form-control btn btn-primary">Check List</button>';?>
								 </a><br><br>
								<a href="sc_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php
								 echo '<button class="form-control btn btn-primary">Update Info</button>';?>
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
<?php 
	session_start();
	if($_SESSION['user_role_id']!= 12)
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
				    <form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<form id="Form3" action="" method="post"></form>
						<div class="row">
						   <div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Ref-Code:</label>
								  <input name="ref_code" form="Form1" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							 <div class="col-sm-4">
							  <label for="title"><br></label>
							    <input class="form-control btn btn-primary" type="submit" value="Search Data" form="Form1">
							  </div>
						
						
					</form>
				</div>
				
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post">
					
					<div class="md-form mt-3">
					<label for="title">System are showing only 20 Data for better performanace but search is always open for all data.</label>
					 <div class="resume-item d-flex flex-column flex-md-row">
					   
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Select</center></th>
								  <th scope="col"><center>Customer Info</center></th>
								   <th scope="col"><center>Lease Approval Info</center></th>
								  <th scope="col"><center>Acc Approval Info</center></th>
								  <th scope="col"><center>CCD Approval Info</center></th>
								  <th scope="col"><center>Requester Info</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						

						if(isset($_POST['ref_code'])){
							$ref_code = $_REQUEST['ref_code'];
						    $strSQL  = oci_parse($objConnect, 
						             "SELECT 
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
									   A.FILE_CLEAR_STATUS
									FROM RML_COLL_SC_CCD A,RML_COLL_CCD_BNAK_NOC B
									WHERE A.ID=B.RML_COLL_SC_CCD_ID
									AND B.NOC_RECEIVED_ACC_STATUS IS NULL
									AND ('$ref_code' IS NULL OR A.REF_CODE='$ref_code')
									"); 
						  
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						    <tr>
							<td><?php echo $number;?></td>
							<td align="center">
								<input type="checkbox" name="check_list[]" value="<?php echo $row['ID'];?>" 
								style="text-align: center; vertical-align: middle;horiz-align: middle;">
							</td>
							<td>
							    <?php 
								echo '<i style="color:red;"><b>'.$row['REF_CODE'].'</b></i> ';
								echo '<br>';
								echo $row['CURRENT_PARTY_NAME'];
								echo '<br>';
								echo $row['CURRENT_PARTY_MOBILE'];
								?>
							</td>
							<td align="center">
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
							  <td align="center">
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
							   <td align="center">
								  <?php if($row['CCD_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['CCD_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['CCD_APPROVAL_BY'];
								  }
								  else if($row['CCD_APPROVAL_STATUS']=='0'){
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
							<td align="center"><?php echo $row['REQUESTER_NAME'].'<br>'.$row['REQUESTER_MOBILE'].'<br>'.$row['REQUEST_DATE'];?></td>
							
						 </tr>
						 <?php
						  } ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="NOC Delivered"/>	
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
						
							</td>
						   </tr>
						  <?php
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
																	   A.FILE_CLEAR_STATUS
																	FROM RML_COLL_SC_CCD a,RML_COLL_CCD_BNAK_NOC b
																	WHERE A.ID=B.RML_COLL_SC_CCD_ID 
																	AND B.NOC_RECEIVED_ACC_STATUS IS NULL
																	AND rownum<=20"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							<td><?php echo $number;?></td>
							<td align="center">
								<input type="checkbox" name="check_list[]" value="<?php echo $row['ID'];?>" 
								style="text-align: center; vertical-align: middle;horiz-align: middle;">
							</td>
							<td>
							    <?php 
								echo '<i style="color:red;"><b>'.$row['REF_CODE'].'</b></i> ';
								echo '<br>';
								echo $row['CURRENT_PARTY_NAME'];
								echo '<br>';
								echo $row['CURRENT_PARTY_MOBILE'];
								?>
							</td>
							<td align="center">
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
							  <td align="center">
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
							   <td align="center">
								  <?php if($row['CCD_APPROVAL_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Approved</b></i> ';
									  echo '<br>';
									  echo $row['CCD_APPROVAL_DATE'];
									  echo '<br>';
									  echo $row['CCD_APPROVAL_BY'];
								  }
								  else if($row['CCD_APPROVAL_STATUS']=='0'){
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
							<td align="center"><?php echo $row['REQUESTER_NAME'].'<br>'.$row['REQUESTER_MOBILE'].'<br>'.$row['REQUEST_DATE'];?></td>
							
						 </tr>
						 <?php
						  }
						   ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="NOC Delivered"/>	
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								
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
			  </form>
				<?php
				
					
					if(isset($_POST['submit_approval'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					                        "update RML_COLL_SC_CCD set 
												BANK_NOC_RECEIVED_STATUS=1,
												BANK_NOC_RECEIVED_BY='$emp_session_id',
												BANK_NOC_RECEIVED_DATE=SYSDATE
											   where ID='$TT_ID_SELECTTED'");
						
						oci_execute($strSQL);
											
				 // echo 'Successfully Approved Outdoor Attendance ID '.$TT_ID_SELECTTED."</br>";
					
					// Go to new url
					echo $htmlHeader;
					while($stuff)
					{
					 echo $stuff;
					}
					 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_bank_requsition_acc.php'</script>";
					 // END
					}
					}else{
						echo 'Sorry! You have not select any ID Code.';
					}
					}
				
					
				 ?>
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
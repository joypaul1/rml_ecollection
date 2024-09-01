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
				
				<div class="col-lg-12  mt-5">
				    <form id="Form1" action="" method="post">
					    <div class="row">
					        <div class="col-sm-4">
								<div class="form-group">
								  <label for="title">ZH Name:</label>
								  <input required="" name="zh_name"  class="form-control"  type='text'/>
								</div>
							</div>
							 <div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Area:</label>
								  <input required="" name="area_name" class="form-control"  type='text'/>
								</div>
							</div>
							 <div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Mobile:</label>
								  <input required="" name="zh_mobile" class="form-control"  type='text'/>
								</div>
							</div>
					    </div>
					<div class="md-form">
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
								  <th scope="col"><center>NOC Received Info</center></th>
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
									   ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   CURRENT_PARTY_ADDRS, 
									   MODEL_NAME, 
									   INSTALLMENT_RECEIVED, 
									   SALES_AMOUNT, 
									   DP, 
									   FIRST_PARTY_NAME, 
									   FIRST_PARTY_DP, 
									   FRIST_PARTY_INSTALLMENT_REC, 
									   RESOLED_DP, 
									   RESOLED_RECEIVED, 
									   RECEIVABLE, 
									   DISCOUNT, 
									   RECEIVED, 
									   CLOSING_DATE, 
									   RESALE_APPROVAL_DATE, 
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   BANK_NOC_RECEIVED_STATUS,
									   BANK_NOC_RECEIVED_DATE,
									   BANK_NOC_RECEIVED_BY
									FROM RML_COLL_SC_CCD
									where LEASE_APPROVAL_STATUS=1 
									and ACC_APPROVAL_STATUS=1
									AND FILE_CLEAR_STATUS=1
									AND ('$ref_code' IS NULL OR REF_CODE='$ref_code')
									AND BANK_NOC_RECEIVED_STATUS=1
									AND BANK_NOC_DISBURSED_STATUS IS NULL
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
							      echo $row['CURRENT_PARTY_NAME'].'<br>'.$row['CURRENT_PARTY_MOBILE'];
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
							   <td align="center">
								  <?php if($row['BANK_NOC_RECEIVED_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Received</b></i> ';
									  echo '<br>';
									  echo $row['BANK_NOC_RECEIVED_DATE'];
									  echo '<br>';
									  echo $row['BANK_NOC_RECEIVED_BY'];
								  }
								  else if($row['BANK_NOC_RECEIVED_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['BANK_NOC_RECEIVED_DATE'];
									   echo '<br>';
									   echo $row['BANK_NOC_RECEIVED_BY'];
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
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="NOC Disbursed"/>	
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
																	   ID, 
																	   REF_CODE, 
																	   CURRENT_PARTY_NAME, 
																	   CURRENT_PARTY_MOBILE, 
																	   CURRENT_PARTY_ADDRS, 
																	   MODEL_NAME, 
																	   INSTALLMENT_RECEIVED, 
																	   SALES_AMOUNT, 
																	   DP, 
																	   FIRST_PARTY_NAME, 
																	   FIRST_PARTY_DP, 
																	   FRIST_PARTY_INSTALLMENT_REC, 
																	   RESOLED_DP, 
																	   RESOLED_RECEIVED, 
																	   RECEIVABLE, 
																	   DISCOUNT, 
																	   RECEIVED, 
																	   CLOSING_DATE, 
																	   RESALE_APPROVAL_DATE, 
																	   REQUEST_DATE, 
																	   REQUEST_BY, 
																	   REQUESTER_NAME, 
																	   REQUESTER_MOBILE, 
																	   LEASE_APPROVAL_STATUS, 
																	   LEASE_APPROVAL_DATE, 
																	   LEASE_APPROVAL_BY, 
																	   ACC_APPROVAL_DATE, 
																	   ACC_APPROVAL_BY, 
																	   ACC_APPROVAL_STATUS, 
																	   CCD_APPROVAL_DATE, 
																	   CCD_APPROVAL_BY, 
																	   CCD_APPROVAL_STATUS, 
																	   FILE_CLEAR_STATUS,
																	   BANK_NOC_RECEIVED_STATUS,
																	   BANK_NOC_RECEIVED_DATE,
																	   BANK_NOC_RECEIVED_BY
																	FROM RML_COLL_SC_CCD
																	where LEASE_APPROVAL_STATUS=1
																	AND ACC_APPROVAL_STATUS=1
																	AND CCD_APPROVAL_STATUS=1
																	AND FILE_CLEAR_STATUS=1
																	AND BANK_NOC_RECEIVED_STATUS=1
																	AND BANK_NOC_DISBURSED_STATUS IS NULL"); 
									
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
							      echo $row['CURRENT_PARTY_NAME'].'<br>'.$row['CURRENT_PARTY_MOBILE'];
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
							  <td align="center">
								  <?php if($row['BANK_NOC_RECEIVED_STATUS']=='1'){
									  echo '<i style="color:blue;"><b>Received</b></i> ';
									  echo '<br>';
									  echo $row['BANK_NOC_RECEIVED_DATE'];
									  echo '<br>';
									  echo $row['BANK_NOC_RECEIVED_BY'];
								  }
								  else if($row['BANK_NOC_RECEIVED_STATUS']=='0'){
									   echo '<i style="color:red;"><b>Denied</b></i> ';
									   echo '<br>';
									   echo $row['BANK_NOC_RECEIVED_DATE'];
									   echo '<br>';
									   echo $row['BANK_NOC_RECEIVED_BY'];
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
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="NOC Disbursed"/>	
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

					if(isset($_POST['submit_approval'])){
						
							@$zh_name = $_REQUEST['zh_name'];
							@$area_name = $_REQUEST['area_name'];
						    @$zh_mobile = $_REQUEST['zh_mobile'];
							
					
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					                        "update RML_COLL_SC_CCD set 
												BANK_NOC_DISBURSED_STATUS=1,
												BANK_NOC_DISBURSED_BY='$emp_session_id',
												BANK_NOC_DISBURSED_DATE=SYSDATE,
												NOC_DISBURSED_ZH='$zh_name',
												NOC_DISBURSED_AREA='$area_name',
												NOC_DISBURSED_MOBILE='$zh_mobile'
											   where ID='$TT_ID_SELECTTED'");
						
						oci_execute($strSQL);
											
					echo $htmlHeader;
					while($stuff)
					{
					 echo $stuff;
					}
					 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_bank_noc_disbursed.php'</script>";
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
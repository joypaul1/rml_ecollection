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
          <a href="">Data Refresh</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
					<form id="Form3" action="" method="post"></form>
						<div class="row">
						   <div class="col-sm-3">
								<div class="form-group">
								  <label for="title">Ref-Code/File No:</label>
								  <input name="ref_code" form="Form1" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-3">
							 <label for="title">Select Sales Type:</label>
							    <select name="sales_type" class="form-control" form="Form1">
								 <option selected value="CRT">Credit Sale</option>
								 <option value="CSH">Cash Sale</option>
							    </select> 
							</div>
							<div class="col-sm-3">
							<label>From Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' form="Form1" />
							   </div>
							</div>
							<div class="col-sm-3">
							<label>To Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>'  form="Form1"/>
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">		
                              <div class="col-sm-6">
							  </div>
							 <div class="col-sm-3">
							  </div>
                             <div class="col-sm-3">
							    <input class="form-control btn btn-primary" type="submit" value="Approval Data Search" form="Form1">
							  </div>							  	
						</div>
						
					</form>
				</div>
				
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Select</center></th>
								  <th scope="col"><center>Customer Information</center></th>
								  <th scope="col"><center>Lease Approval Info</center></th>
								  <th scope="col"><center>Acc Approval Date</center></th>
								  <th scope="col"><center>CCD Accept Date</center></th>
								  <th scope="col"><center>SC Status</center></th>
								  <th scope="col"><center>Requester Info</center></th>
								 <!-- <th scope="col"><center>Action </center></th>  -->
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						

						if(isset($_POST['ref_code'])){
							$ref_code = trim($_REQUEST['ref_code']);
							$sales_type = trim($_REQUEST['sales_type']);
							
							
						    $attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            $attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						 
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
										   CCD_APPROVAL_DATE,
                                           CCD_APPROVAL_BY,										   
										   FILE_CLEAR_STATUS
										FROM RML_COLL_SC_CCD
									where LEASE_APPROVAL_STATUS=1
									AND ACC_APPROVAL_STATUS IS NULL
									AND ('$ref_code' IS NULL OR REF_CODE='$ref_code' OR CHASSIS_NO='$ref_code')
									AND trunc(LEASE_APPROVAL_DATE) BETWEEN to_date('$attn_start_date','dd/mm/yyyy') AND to_date('$attn_end_date','dd/mm/yyyy')
									AND SALE_TYPE='$sales_type'"); 
						  
									
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
							<td align="center">
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
							<td><?php echo $row['FILE_CLEAR_STATUS'];?></td>
							<td align="center"><?php echo $row['REQUESTER_NAME'].'<br>'.$row['REQUESTER_MOBILE'].'<br>'.$row['REQUEST_DATE'];?></td>
							<!--<td align="center">
							    <a href="sc_list_edit.php?sc_id=<?php echo $row['ID'];?>">
								<?php echo '<button class="branch_edit">Information</button>';?>
								</a>
							</td>-->
						 </tr>
						 <?php
						  } ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve"/>	
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Save & Denied"/>	
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
															   FILE_CLEAR_STATUS
															FROM RML_COLL_SC_CCD
																	where LEASE_APPROVAL_STATUS=1
																	AND ACC_APPROVAL_STATUS IS NULL"); 
									
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
							<td align="center">
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
							<td><?php echo $row['FILE_CLEAR_STATUS'];?></td>
							<td align="center"><?php echo $row['REQUESTER_NAME'].'<br>'.$row['REQUESTER_MOBILE'].'<br>'.$row['REQUEST_DATE'];?></td>
						<!--	<td align="center"><a href="sc_list_edit.php?sc_id=<?php echo $row['ID'] ?>"><?php echo '<button class="branch_edit">Information</button>';?></a>
							</td> -->
						 </tr>
						 <?php
						  }
						   ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Approve"/>	
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Save & Denied"/>	
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
														ACC_APPROVAL_STATUS=1,
														ACC_APPROVAL_BY='$emp_session_id',
														ACC_APPROVAL_DATE=SYSDATE
                                                       where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						  
					
					}
					 echo $htmlHeader;
						while($stuff)
						{echo $stuff;}
					     echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_accounts_approval.php'</script>"; 
					}else{
						echo 'Sorry! You have not select any ID Code.';
					}
					}
					
					// Denied option
					if(isset($_POST['submit_denied'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "update RML_COLL_SC_CCD set 
														ACC_APPROVAL_STATUS=0,
														ACC_APPROVAL_BY='$emp_session_id',
														ACC_APPROVAL_DATE=SYSDATE
                                                       where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						  
					   
					}
					 echo $htmlHeader;
						while($stuff)
						{echo $stuff;}
					     echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_accounts_approval.php'</script>"; 
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
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
          <a href="">SC Handover List[Default 50 Data]</a>
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
				
				<div class="col-lg-12 mt-5">
				    <form id="Form1" action="" method="post">
					 <script>
						  function onChangeZonalHead(zonal_head_id)
						  {

							 //alert(zonal_head_id);
							  if(window.XMLHttpRequest){
								  xmlhttp = new XMLHttpRequest();
							  }else{
								  xmlhttp = new ActiveXObject("Migrosoft.XMLHTTP");
							  }
							
							xmlhttp.onreadystatechange = function()
							{
							  if (this.readyState == 4 && this.status == 200) 
							  {
								document.getElementById('emp_dept').innerHTML = this.responseText;  
							  }
							};
							xmlhttp.open("GET","populate_zh_to_cc.php?zonal_head_id="+zonal_head_id,true);
							xmlhttp.send();
							
						  }
						 
						</script>
					
					
					
					
					
					 <div class="row">
					 
					        <div class="col-sm-3">
							    <label for="exampleInputEmail1">Select Zonal Head:</label>
							    <select name="zh_name" class="form-control" required="" onchange="onChangeZonalHead(this.value)">
								  <option  value="">--</option>
								      <?php
										$strSQL  = oci_parse($objConnect, 
										        "select RML_ID,EMP_NAME from RML_COLL_APPS_USER
													where IS_ACTIVE=1
													and ACCESS_APP='RML_COLL'
													and LEASE_USER='ZH'");    
						               oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
									  <option value="<?php echo $row['RML_ID'];?>"><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							    </select>
							</div>
							 <div class="col-sm-3">
							 	<div class="form-group">
								   <label for="title">Select Concern:</label>
								     <div id="emp_dept">
										 <select  name="concern_cc" class="form-control" required="" >
										  <option  value="">--</option>
										</select>
								     </div>
								</div>
							</div>
					        
							<div class="col-sm-3">
								<div class="form-group">
								  <label for="title">Area:</label>
								  <input required="" name="area_name" class="form-control"  type='text'/>
								</div>
							</div>
							 <div class="col-sm-3">
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
								  <th scope="col"><center>Ref-Code</center></th>
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
									where FILE_CLEAR_STATUS=1
									AND ('$ref_code' IS NULL OR REF_CODE='$ref_code')
									AND ID NOT IN (select RML_COLL_SC_CCD_ID from RML_COLL_CCD_SC_HANDOVER)
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
							<td><?php echo $row['REF_CODE'];?></td>
							<td><?php echo $row['CURRENT_PARTY_NAME'].'<br>'.$row['CURRENT_PARTY_MOBILE'].'<br>'.$row['MODEL_NAME'];?></td>
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
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="SC Handover"/>	
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
6																	   ACC_APPROVAL_STATUS, 
																	   CCD_APPROVAL_DATE, 
																	   CCD_APPROVAL_BY, 
																	   CCD_APPROVAL_STATUS, 
																	   FILE_CLEAR_STATUS
																	FROM RML_COLL_SC_CCD
																	where FILE_CLEAR_STATUS=1
																	AND ID NOT IN (select RML_COLL_SC_CCD_ID from RML_COLL_CCD_SC_HANDOVER)
																	and rownum<=50"); 
									
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
							<td><?php echo $row['REF_CODE'];?></td>
							<td><?php echo $row['CURRENT_PARTY_NAME'].'<br>'.$row['CURRENT_PARTY_MOBILE'].'<br>'.$row['MODEL_NAME'];?></td>
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
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="SC Handover"/>	
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
						@$cc_name = $_REQUEST['concern_cc'];
						@$area_name = $_REQUEST['area_name'];
						@$zh_mobile = $_REQUEST['zh_mobile'];
					if(!empty($_POST['check_list'])){

					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
		
						$strSQL = oci_parse($objConnect, 
					                        "INSERT INTO RML_COLL_CCD_SC_HANDOVER (
												   RML_COLL_SC_CCD_ID, 
												   SC_HANDOVER_DATE, 
												   SC_HANDOVER_BY,
												   HANDOVER_ZH, 
												   HANDOVER_AREA, 
												   HANDOVER_MOBILE,
												   ZH_ID,
												   CC_ID) 
												VALUES ( 
												   '$TT_ID_SELECTTED',
												    SYSDATE,
												   '$emp_session_id',
												   '',
												   '$area_name',
												   '$zh_mobile',
												   '$zh_name',
												   '$cc_name')");
						
						oci_execute($strSQL);
					echo $htmlHeader;
					while($stuff)
					{
					 echo $stuff;
					}
					 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_customer_handover.php'</script>";
					
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
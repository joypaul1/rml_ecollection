<?php 
	session_start();
	if($_SESSION['user_role_id']!= 4 && $_SESSION['user_role_id']!= 1)
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
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Visit Approval Page</a>
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
							    <label>Select Your Concern:</label>
								<select name="emp_concern" class="form-control" form="Form1" > 
								 <option selected value="">---</option>
								      <?php
									 
									   
						                $strSQL  = oci_parse($objConnect, "select 
											   CONCERN,RML_ID FROM MONTLY_COLLECTION
										       WHERE IS_ACTIVE=1
										AND ZONAL_HEAD='$emp_session_id'"); 
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
									  <option <?php echo isset($_POST['emp_concern']) ? $_REQUEST['emp_concern'] == $row['RML_ID']?'selected':''  :'' ?> value="<?php echo $row['RML_ID'];?>"><?php echo $row['CONCERN'];?></option>
									  <?php
									   }
									  ?>
							</select>
							</div>
							<div class="col-sm-4">
							<label>From Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									 <input required="" class="form-control" form="Form1" name="start_date" type="date" 
								                value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01'); ?>' />
							   </div>
							</div>
							<div class="col-sm-4">
							<label>To Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input required="" class="form-control" form="Form1" id="date" name="end_date" type="date"
								               value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t'); ?>' />
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">		
                              <div class="col-sm-4">
							  </div>
							 <div class="col-sm-4">
							  </div>
                             <div class="col-sm-4">
							    <input class="form-control btn btn-primary" type="submit" value="Search Data" form="Form1">
							  </div>							  	
						</div>
						
					</form>
				</div>
				
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered table-striped table-responsive" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Select</center></th>
								  <th scope="col"><center>Customer Information</center></th>
								  <th scope="col"><center>Concern Information</center></th>
								  <th scope="col"><center>Visit Information</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						

						if(isset($_POST['start_date'])){
							
							$emp_concern = $_REQUEST['emp_concern'];
						    $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
					
						    $strSQL  = oci_parse($objConnect, "SELECT B.ID, 
						                           A.REF_ID,
												   A.ASSIGN_DATE,
												   A.CREATED_BY CONCERN_ID,
												   C.AREA_ZONE,C.EMP_NAME CC_NAME,
												   A.CUSTOMER_REMARKS,
												   A.CREATED_DATE,
												   A.VISIT_LOCATION,
												   A.CUSTOMER_NAME,
												   A.INSTALLMENT_AMOUNT,
												   (select NUMBER_OF_DUE from LEASE_ALL_INFO_ERP K where REF_CODE=A.REF_ID) NUMBER_OF_DUE,
												   (select LAST_PAYMENT_AMOUNT from LEASE_ALL_INFO_ERP where REF_CODE=A.REF_ID) LAST_PAYMENT_AMOUNT,
												   (select LAST_PAYMENT_DATE from LEASE_ALL_INFO_ERP where REF_CODE=A.REF_ID) LAST_PAYMENT_DATE,
												    (select PARTY_ADDRESS from LEASE_ALL_INFO_ERP where REF_CODE=A.REF_ID) PARTY_ADDRESS
											 FROM RML_COLL_VISIT_ASSIGN A,COLL_VISIT_ASSIGN_APPROVAL B,RML_COLL_APPS_USER C
											WHERE A.ID=B.RML_COLL_VISIT_ASSIGN_ID
											AND A.CREATED_BY=C.RML_ID
											AND TRUNC(ASSIGN_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
											AND B.APPROVAL_STATUS IS NULL
											AND A.CREATED_BY IN
											(
											SELECT RML_ID FROM MONTLY_COLLECTION
												WHERE IS_ACTIVE=1
												 AND ZONAL_HEAD='$emp_session_id'
											)"); 
									
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
								 echo 'Customer: '.$row['CUSTOMER_NAME'];
								 echo '<br>';
								 echo 'Number Of Due: <b style="color:red;">'.$row['NUMBER_OF_DUE'].'</b>';
								 echo '<br>';
								 echo 'Last Payment:  <b>'.$row['LAST_PAYMENT_AMOUNT'].'</b>';
								 echo '<br>';
								 echo 'Last Payment Date: <b style="color:red;">'.$row['LAST_PAYMENT_DATE'].'</b>';
								 echo '<br>';
								 echo 'EMI: '.$row['INSTALLMENT_AMOUNT'];
							   ?>
							   </td>
							   <td>
							   <?php 
							     echo 'Concern Name: '.$row['CC_NAME'];
								 echo '<br>';
								 echo 'Concern ID: '.$row['CONCERN_ID'];
								 echo '<br>';
								 echo 'Zone: '.$row['AREA_ZONE'];
								 echo '<br>';
								 echo 'Entry Date: '.$row['CREATED_DATE'];
							   ?>
							   </td>
							    <td>
							   <?php 
							      echo 'Code: '.$row['REF_ID'];
								 echo '<br>';
							     echo 'Assign Visit Location: <b style="color:red;">'.$row['VISIT_LOCATION'].'</b>';
								 echo '<br>';
							    echo 'Party Address: <i>'.$row['PARTY_ADDRESS'].'</i>';
								 echo '<br>';
								 echo 'Visit Date: <b>'.$row['ASSIGN_DATE'].'</b>';
								  echo '<br>';
								 echo 'Remarks: <b style="color:red;">'.$row['CUSTOMER_REMARKS'].'</b>';
							   ?>
							   </td>
						 </tr>
						 <?php
						  } ?>
						   <tr>
							<td></td>
							<td></td>
							<td><input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Save & Approve"/>	</td>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_denied" value="Save & Denied"/>	
							</td>
						   </tr>
						  <?php
						  }else{
							 $month_start=date('01/m/Y');
							 $month_end=date('t/m/Y');
						     $allDataSQL  = oci_parse($objConnect, "SELECT B.ID, 
						                           A.REF_ID,
												   A.ASSIGN_DATE,
												   A.CREATED_BY CONCERN_ID,C.AREA_ZONE,
												   C.EMP_NAME CC_NAME,
												   A.CUSTOMER_REMARKS,
												   A.CREATED_DATE,
												   A.VISIT_LOCATION,
												   A.CUSTOMER_NAME,
												   A.INSTALLMENT_AMOUNT,
												   (select NUMBER_OF_DUE from LEASE_ALL_INFO_ERP K where REF_CODE=A.REF_ID) NUMBER_OF_DUE,
												   (select LAST_PAYMENT_AMOUNT from LEASE_ALL_INFO_ERP where REF_CODE=A.REF_ID) LAST_PAYMENT_AMOUNT,
												   (select LAST_PAYMENT_DATE from LEASE_ALL_INFO_ERP where REF_CODE=A.REF_ID) LAST_PAYMENT_DATE,
												   (select PARTY_ADDRESS from LEASE_ALL_INFO_ERP where REF_CODE=A.REF_ID) PARTY_ADDRESS
											 FROM RML_COLL_VISIT_ASSIGN A,COLL_VISIT_ASSIGN_APPROVAL B,RML_COLL_APPS_USER C
											WHERE A.ID=B.RML_COLL_VISIT_ASSIGN_ID
											AND A.CREATED_BY=C.RML_ID
											AND TRUNC(ASSIGN_DATE) BETWEEN TO_DATE('$month_start','DD/MM/YYYY') AND TO_DATE('$month_end','DD/MM/YYYY')
											AND B.APPROVAL_STATUS IS NULL
											AND A.CREATED_BY IN
											(
											SELECT RML_ID FROM MONTLY_COLLECTION
												WHERE IS_ACTIVE=1
												 AND ZONAL_HEAD='$emp_session_id'
											)"); 
									
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
								 echo 'Customer: '.$row['CUSTOMER_NAME'];
								 echo '<br>';
								 echo 'Number Of Due: <b style="color:red;">'.$row['NUMBER_OF_DUE'].'</b>';
								 echo '<br>';
								 echo 'Last Payment:  <b>'.$row['LAST_PAYMENT_AMOUNT'].'</b>';
								 echo '<br>';
								 echo 'Last Payment Date: <b style="color:red;">'.$row['LAST_PAYMENT_DATE'].'</b>';
								 echo '<br>';
								 echo 'EMI: '.$row['INSTALLMENT_AMOUNT'];
							   ?>
							   </td>
							   <td>
							   <?php 
							     echo 'Concern Name: '.$row['CC_NAME'];
								 echo '<br>';
								 echo 'Concern ID: '.$row['CONCERN_ID'];
								 echo '<br>';
								 echo 'Zone: '.$row['AREA_ZONE'];
								 echo '<br>';
								 echo 'Entry Date: '.$row['CREATED_DATE'];
							   ?>
							   </td>
							    <td>
							   <?php 
							     echo 'Code: '.$row['REF_ID'];
								 echo '<br>';
							     echo 'Assign Visit Location: <b style="color:red;">'.$row['VISIT_LOCATION'].'</b>';
								 echo '<br>';
							     echo 'Party Address: <i>'.$row['PARTY_ADDRESS'].'</i>';
								 echo '<br>';
								 echo 'Visit Date: <b>'.$row['ASSIGN_DATE'].'</b>';
								  echo '<br>';
								 echo 'Remarks: <b style="color:red;">'.$row['CUSTOMER_REMARKS'].'</b>';
							   ?>
							   </td>
						 </tr>
						 <?php
						  }
						   ?>
						   <tr>
							<td></td>
							<td></td>
							<td><input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Save & Approve"/>	</td>
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
				   
					if(isset($_POST['submit_approval'])){
					if(!empty($_POST['check_list'])){
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "UPDATE COLL_VISIT_ASSIGN_APPROVAL
											SET    
												   APPROVAL_STATUS          = 1,
												   APPROVED_DATE            = SYSDATE,
												   APPROVED_BY_RML_ID       = '$emp_session_id'
											WHERE  ID ='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						
						  
					//echo 'Successfully Approved Visit Assign ID '.$TT_ID_SELECTTED."</br>";
					echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/zh_visit_approval_list.php'</script>";
					}
					}else{
						echo 'Sorry! You have not select any ID Code.';
					}
					}
					
					// Denied option
					if(isset($_POST['submit_denied'])){
					if(!empty($_POST['check_list'])){
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "UPDATE COLL_VISIT_ASSIGN_APPROVAL
											SET    
												   APPROVAL_STATUS          = 0,
												   APPROVED_DATE            = SYSDATE,
												   APPROVED_BY_RML_ID       = '$emp_session_id'
											WHERE  ID ='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						  
					echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/zh_visit_approval_list.php'</script>";
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
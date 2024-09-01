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
							    <label for="title">&nbsp;</label>
							    <input class="form-control btn btn-primary" type="submit" value="Search Approval Data" form="Form1">
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
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Issued Date</center></th>
								  <th scope="col"><center>Reg No</center></th>
								  <th scope="col"><center>Eng No</center></th>
								  <th scope="col"><center>Chassis No</center></th>
								  <th scope="col"><center>Re-Issues Reason</center></th>
								  <th scope="col"><center>Remarks</center></th>
								  <th scope="col"><center>Regards</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						if(isset($_POST['ref_code'])){
							$ref_code = $_REQUEST['ref_code'];
							
						    $strSQL  = oci_parse($objConnect, 
						             "SELECT A.ID, 
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
										b.FILE_CLEAR_DATE,
										A.REISSE_REASON
						FROM RML_COLL_CCD_REISSUED A,RML_COLL_SC_CCD B
						where A.code=B.REF_CODE
						and A.CODE='$ref_code'
						AND 'RML-00814'='$emp_session_id'
						AND A.CCD_APPROVAL_STATUS IS NULL"); 
						
		                
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
							<td><?php echo $row['CODE'];?></td>
							<td><?php echo $row['REG_NO'];?></td>
							<td><?php echo $row['FILE_CLEAR_DATE'];?></td>
							<td><?php echo $row['ENG_NO'];?></td>
							<td><?php echo $row['CHASSIS_NO'];?></td>
							<td><?php echo $row['REISSE_REASON'];?></td>
							<td><?php echo $row['REASON'];?></td>
							<td><?php echo $row['REGARDS'];?></td>
							
						   </tr>
						 <?php
						  } ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Accept"/>	
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
							 
						     $allDataSQL  = oci_parse($objConnect, 
							                      "SELECT 
														A.ID, 
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
														b.FILE_CLEAR_DATE,
														a.REISSE_REASON
									FROM RML_COLL_CCD_REISSUED A,RML_COLL_SC_CCD B
									WHERE a.code=b.REF_CODE
									AND 'RML-00814'='$emp_session_id'
									and a.CCD_APPROVAL_STATUS IS NULL"); 
									
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
							<td><?php echo $row['CODE'];?></td>
							<td><?php echo $row['FILE_CLEAR_DATE'];?></td>
							<td><?php echo $row['REG_NO'];?></td>
							<td><?php echo $row['ENG_NO'];?></td>
							<td><?php echo $row['CHASSIS_NO'];?></td>
							<td><?php echo $row['REISSE_REASON'];?></td>
							<td><?php echo $row['REASON'];?></td>
							<td><?php echo $row['REGARDS'];?></td>
							
						 </tr>
						 <?php
						  }
						  if($number>0)
						  {
						   ?>
						   <tr>
							<td></td>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit_approval" value="Accept"/>	
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
					                        "update RML_COLL_CCD_REISSUED set 
											    CCD_APPROVAL_STATUS=1,
												CCD_APPROVED_BY='$emp_session_id',
												CCD_APPROVED_DATE=SYSDATE
											   where ID='$TT_ID_SELECTTED'");
						
						oci_execute($strSQL);
												
					//echo 'Successfully Approved Outdoor Attendance ID '.$TT_ID_SELECTTED."</br>";
					
					// Go to new url
					echo $htmlHeader;
					while($stuff)
					{
					 echo $stuff;
					}
					 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/reissues_approval_ccd.php'</script>";
					 // END
					}
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
					           "update RML_COLL_CCD_REISSUED set 
											    CCD_APPROVAL_STATUS=0,
												CCD_APPROVED_BY='$emp_session_id',
												CCD_APPROVED_DATE=SYSDATE
											   where ID='$TT_ID_SELECTTED'");
						
						  oci_execute($strSQL);
						  
					echo 'Successfully Denied Outdoor Attendance ID '.$TT_ID_SELECTTED."</br>";
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
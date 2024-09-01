<?php 
	session_start();
		if($_SESSION['user_role_id']!= 5 && $_SESSION['user_role_id']!= 2 && $_SESSION['user_role_id']!= 9)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 			
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	$sc_id=$_REQUEST['sc_id'];
?>
  <div class="content-wrapper">
    <div class="container-fluid"> 
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Data Refresh</a>
        </li>
      </ol>	
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT ID, REF_CODE, CURRENT_PARTY_NAME, 
												   CURRENT_PARTY_MOBILE, CURRENT_PARTY_ADDRS, MODEL_NAME, 
												   INSTALLMENT_RECEIVED, SALES_AMOUNT, DP, 
												   FIRST_PARTY_NAME, FIRST_PARTY_DP, FRIST_PARTY_INSTALLMENT_REC, 
												   RESOLED_DP, RESOLED_RECEIVED, RECEIVABLE, 
												   DISCOUNT, RECEIVED, CLOSING_DATE, 
												   RESALE_APPROVAL_DATE, REQUEST_DATE, REQUEST_BY, 
												   REQUESTER_NAME, REQUESTER_MOBILE, 
												   CCD_APPROVAL_BY, CCD_APPROVAL_STATUS, FILE_CLEAR_STATUS, 
												   CLOSING_FEE,
												   (SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=1
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_1,
													(SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=2
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_2,
													(SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=3
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_3,
													(SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=4
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_4,	
													(SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=5
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_5,
													(SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=6
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_6,
													(SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=7
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_7,
                                                    (SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=8
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_8,
                                                    (SELECT NVL(STATUS,0) FROM RML_COLL_SC_CCD_CHECKLIST
																where LIST_ID=9
																and RML_COLL_SC_CCD_ID=$sc_id)  AS FILE_STATUS_9																
												FROM RML_COLL_SC_CCD where id=$sc_id"); 
						  
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   
								<div class="md-form">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
									  You will be respondible if you update anything here.
									</li>
								</ol>
							
						   
							<div class="container">
							  <form action="" method="post">
								<div class="row">
								
									<div class="col-sm-4">
										<div class="form-group">
										  <label for="title">REF_CODE:</label>
										  <input type="text"class="form-control" required="" id="title"  name="ref_code" value= "<?php echo $row['REF_CODE'];?>" readonly>
										</div>
									</div>
									<div class="col-sm-4">
								        <div class="md-form">
									    <label for="comment">Customer Name:</label>
										<input type="text"class="form-control" required="" id="title"  name="bank_address" value= "<?php echo $row['CURRENT_PARTY_NAME'];?>" readonly>
									    </div>
							        </div>
									<div class="col-sm-4">
								        <div class="md-form">
									    <label for="comment">Customer Mobile Number:</label>
										<input type="text"class="form-control" required="" id="title" value= "<?php echo $row['CURRENT_PARTY_MOBILE'];?>" readonly>
									    </div>
							        </div>
		
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
										  <label for="title">Model Name:</label>
										  <input type="text"class="form-control" required="" id="title"  value= "<?php echo $row['MODEL_NAME'];?>" readonly>
										</div>
									</div>
									<div class="col-sm-4">
								        <div class="md-form">
									    <label for="comment">Requester Name:</label>
										<input type="text"class="form-control" required="" id="title"  name="bank_address" value= "<?php echo $row['REQUESTER_NAME'];?>" readonly>
									    </div>
							        </div>
									<?php	
								     if($row['FILE_CLEAR_STATUS']!='0' && $row['FILE_CLEAR_STATUS']!='1'){
								     ?>
									<div class="col-sm-4">
										<div class="form-group">
										  <label for="title">Action Status:</label>
										    <select required="" name="file_status" class="form-control">
											<option value="">--</option>
											<option value="update">Information Update</option>
											<option value="clear">File Clear No issues</option>
											<option value="reissues">File Problem Issues</option>
										  </select>
										</div>
									</div>	
									<?php
									  } else { ?>
									  <div class="col-sm-4">
								        <div class="md-form">
									    <label for="comment">Action Status:</label>
										<input readonly type="text"class="form-control" value= "<?php 
										    if($row['FILE_CLEAR_STATUS']==1){
												echo 'File Clear No issues';
											}else if($row['FILE_CLEAR_STATUS']==0){
												echo 'File Problem Issues';
											}
											?>">
									    </div>
							        </div>
		                            <?php
									  }?>
								</div>
								<div class="row">
									<div class="col-sm-12">
									   <div class="col-sm-12">
									<u><b>Check List for SC Processing :-</b></u>
									</div>	
                                    	
								    <?php	if($row['FILE_STATUS_1']=='1'){ ?>
										<div class="col-sm-12 mt-3">
											<div class="form-check">
											  <input class="form-check-input" type="checkbox" value="1" id="check_list_1" name="check_list_1" checked="" onclick="return false;">
											  <label class="form-check-label">
												<i style="color:#2c900c;">1.Physical File Received - ref Code(Completed)</i>
											  </label>
											</div>
										</div> 
									<?php
									  } else { ?>
										<div class="col-sm-12 mt-3">
											<div class="form-check">
											  <input class="form-check-input" type="checkbox" value="1" id="check_list_1" name="check_list_1">
											  <label class="form-check-label" style="color:red;">
												1.Physical File Received - ref Code
											  </label>
											</div>
										</div> 
										
									<?php 
									    }
									    if($row['FILE_STATUS_2']=='1'){
									?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="2" id="check_list_2" name="check_list_2" checked="" onclick="return false;">
										  <label class="form-check-label" for="check_list_2">
											<i style="color:#2c900c;">2.Final Settlement Approval Amount Check(Completed)</i>
										  </label>
										</div>
									</div>
									<?php
									  } else { ?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="2" id="check_list_2" name="check_list_2">
										  <label class="form-check-label" for="check_list_2" style="color:red;">
											2.Final Settlement Approval Amount Check
										  </label>
										</div>
									</div> 
									<?php	
									 }
									 if($row['FILE_STATUS_3']=='1'){
									?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="3" id="check_list_3" name="check_list_3" checked="" onclick="return false;">
										  <label class="form-check-label" for="check_list_3">
										  <i style="color:#2c900c;">3.Current Customer NID(Completed)</i>
											
										  </label>
										</div>
									</div>
									<?php
									  } else { ?>
									 <div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="3" id="check_list_3" name="check_list_3">
										  <label class="form-check-label" for="check_list_3" style="color:red;">
											3.Current Customer NID
										  </label>
										</div>
									</div> 
									  
									 <?php	
									 }if($row['FILE_STATUS_8']=='1'){
									?> 
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="8" id="check_list_8" name="check_list_8" checked="" onclick="return false;">
										  <label class="form-check-label" for="check_list_8">
											<i style="color:#2c900c;">4.Clear NID(Completed)</i>
										  </label>
										</div>
									</div> 
									 <?php
									  } else { ?> 
									    <div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="8" id="check_list_8" name="check_list_8">
										  <label class="form-check-label" for="check_list_8" style="color:red;">
											4.Clear NID
										  </label>
										</div>
									</div>
									  
									  
									<?php	
									 }if($row['FILE_STATUS_4']=='1'){
									?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="4" id="check_list_4" name="check_list_4" checked="" onclick="return false;">
										  <label class="form-check-label" for="check_list_4">
											<i style="color:#2c900c;">5.Registration Acknowledgement  Slip(Completed)</i>
										  </label>
										</div>
									</div>
									<?php
									  } else { ?>
									  <div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="4" id="check_list_4" name="check_list_4">
										  <label class="form-check-label" for="check_list_4" style="color:red;">
											5.Registration Acknowledgement  Slip
										  </label>
										</div>
									</div>
									<?php	
									 }if($row['FILE_STATUS_5']=='1'){
									?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="5" id="check_list_5" name="check_list_5" checked="" onclick="return false;">
										  <label class="form-check-label" for="check_list_5">
										   <i style="color:#2c900c;">6.Accurate Deed(Completed)</i>
											
										  </label>
										</div>
									</div>
									<?php
									  } else { ?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="5" id="check_list_5" name="check_list_5">
										  <label class="form-check-label" for="check_list_5" style="color:red;">
											6.Accurate Deed
										  </label>
										</div>
									</div>  
									<?php	
									 }if($row['FILE_STATUS_6']=='1'){
									?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="6"   checked="" onclick="return false;">
										  <label class="form-check-label" for="check_list_6">
										    <i style="color:#2c900c;">7.LC Documents(Completed)</i>
											
										  </label>
										</div>
									</div>
									<?php
									  } else { ?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="6" id="check_list_6" name="check_list_6">
										  <label class="form-check-label" for="check_list_6" style="color:red;">
											7.LC Documents
										  </label>
										</div>
									</div> 
									<?php	
									 }if($row['FILE_STATUS_7']=='1'){
									?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="7" checked="" onclick="return false;">
										  <label class="form-check-label">
										    <i style="color:#2c900c;">8.Customer signature on deed(Completed)</i>
											
										  </label>
										</div>
									</div>
									<?php
									  } else { ?>
									  	<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="7" id="check_list_7" name="check_list_7">
										  <label class="form-check-label" style="color:red;">
											8.Customer signature on deed
										  </label>
										</div>
									</div>
									<?php	
									 }if($row['FILE_STATUS_9']=='1'){
									?>
									<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="9" checked="" onclick="return false;">
										  <label class="form-check-label">
										    <i style="color:#2c900c;">9.Deed Missing(Completed)</i>
											
										  </label>
										</div>
									</div>
									<?php
									  } else { ?>
									  	<div class="col-sm-12">
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="9" id="check_list_9" name="check_list_9">
										  <label class="form-check-label" style="color:red;">
											9.Deed Missing
										  </label>
										</div>
									</div>
									<?php	
									 }
									?>
									</div>
								</div>
								<?php	
								   if($row['FILE_CLEAR_STATUS']=='0' || $row['FILE_CLEAR_STATUS']=='1'){
								?>
								<div class="row">
								   <div class="col-sm-12">
								        <div class="md-form">
									    <label for="comment">Remarks to CCD:</label>
										<input type="text"class="form-control" required="" id="title"  name="remarks_to_ccd">
									    </div>
							        </div>
								</div>
								<div class="row"> 
									<div class="col-sm-4">
										<div class="md-form mt-3">
										<button type="submit" name="submit" class="btn btn-info" > Resend Request</button>
										</div>
									</div>	
								</div>
								<?php	
								}
								?>
								
						
							
						 <?php
						  }
						 ?>
					
				  </div>
				  </form>
				</div>

	
	              <?php

                          $emp_session_id=$_SESSION['emp_id'];
						  if(isset($_POST['ref_code'])){
							 
                             $remarks_to_ccd = $_REQUEST['remarks_to_ccd'];
							
								 $strSQL  = oci_parse($objConnect, "UPDATE RML_COLL_SC_CCD SET
																	FILE_CLEAR_STATUS='',
																	FILE_CLEAR_DATE='',
																	FILE_CLEAR_BY=''
													 WHERE ID=$sc_id");


                                $strSQLReissue  = oci_parse($objConnect, 
								                   "UPDATE RML_COLL_SC_CCD_CHECKLIST_FAIL SET
												           RESEND_DATE=SYSDATE,RESEND_BY='$emp_session_id',
														   LEASE_REMARKS='$remarks_to_ccd',STATUS=1
                                                      WHERE RML_COLL_SC_CCD_ID=$sc_id AND STATUS=0"); 	
                                oci_execute($strSQLReissue);														
							  
							 

						      if(oci_execute($strSQL)){
								 echo $htmlHeader;
									while($stuff)
									{
									 echo $stuff;
									}
									 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/sc_list_reissues_edit.php?sc_id=$sc_id'</script>"; 
							 
						   } 
						  }
						?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
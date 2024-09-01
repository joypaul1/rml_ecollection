<?php 
	session_start();
	if($_SESSION['user_role_id']== 4 || $_SESSION['user_role_id'] == 3)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
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
          <a href="">User Feed Back</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-3">
								 <input required=""  type="text" class="form-control" id="title" placeholder="REF-CODE" name="ref_code" form="Form1">
							</div>
							<div class="col-sm-3">
							    <div class="input-group">
									<div class="input-group-addon">
									  <i class="fa fa-calendar"></i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							    </div>
							</div>
							<div class="col-sm-3">
							    <div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="end_date" type="date" />
							    </div>
							</div>
							<div class="col-sm-3">
							  <input class="form-control btn btn-primary" type="submit" value="Search Data" form="Form1"> 
							</div>
						</div>		
					<hr>
					
				</div>
				
	 
				
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						@$ref_code=$_REQUEST['ref_code'];
						@$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
						@$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

						if(isset($_POST['ref_code'])){
					     
						  $SQL_singleData  = oci_parse($objConnect, "select ID,
																	REF_CODE,
																	MODEL_NAME,
																	BRAND_NAME,
																	CUSTOMER_NAME,
																	CUSTOMER_MOBILE,
																	SALES_PERSON,
																	(select EMP_NAME from RML_COLL_APPS_USER
																		where RML_ID=ENTRY_BY_RML_ID
																		and ACCESS_APP='RML_COLL')
																	ENTRY_BY_RML_ID,
																	REQUESTER_NAME,
																	REQUESTER_MOBILE,
																	ENTRY_DATE ,
																	NEW_SMS,
																	ROOT
																	from RML_COLL_SC
																	where REQUEST_TYPE='New'
																	and REF_CODE='$ref_code'
																	"); 
						  
						  oci_execute($SQL_singleData);
		                  while($row=oci_fetch_assoc($SQL_singleData)){	
                           ?>
						   
						    
						    <div class="col-lg-12 border border-secondary md-form mt-5">
										<div class="row">
										    <div class="col-sm-3" style="display: none;">
												<div class="form-group">
												  <label for="title">SC-ID:</label>
												  <input type="text"class="form-control" id="title" form="Form2" name="sc_id" value= "<?php echo $row['ID'];?>" form="Form1">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Ref-Code:</label>
												  <input type="text" name="ref_code" class="form-control" id="title" form="Form2" value= "<?php echo $row['REF_CODE'];?>" readonly>
												</div>
											</div>
										
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Customer Name:</label>
												  <input type="text" name="cust_name" class="form-control" id="title" value= "<?php echo $row['CUSTOMER_NAME'];?>" readonly form="Form2">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Customer Mobile:</label>
												  <input type="text" name="cust_mobile" class="form-control" id="title" value= "<?php echo $row['CUSTOMER_MOBILE'];?>" readonly form="Form2">
												</div>
											</div>
										</div>
										
										
									
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Created By:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['ENTRY_BY_RML_ID'];?>" readonly form="Form2">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Created Date:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['ENTRY_DATE'];?>" readonly form="Form2">
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
												  <label for="title">Created From:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['ROOT'];?>" readonly form="Form2">
												</div>
											</div>
											
										</div>
										
										
										<div class="row">
										    <div class="col-sm-12">
												<div class="form-group">
												  <label for="title">New SMS:</label>
												  <input type="text" name="new_sms" class="form-control" id="title" value= "<?php echo $row['NEW_SMS'];?>" readonly>
												</div>
											</div>
										</div>
										<div class="row">
										    <div class="col-sm-12">
												<div class="form-group">
												  <label for="title">Updated SMS Will Be Send to Requester:</label>
												  <input type="text" name="update_sms" class="form-control" id="title" value= "সম্মানিত গ্রাহক  আগামী ৩০ কর্ম-দিবসের মধ্যে আপনার সেলস সার্টিফিকেট প্রদান করা হবে।" readonly form="Form2">
												</div>
											</div>
										</div>
                                        <div class="row">
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Requester Name:</label>
												  <input type="text" class="form-control" id="title" value= "<?php echo $row['REQUESTER_NAME'];?>" readonly form="Form2">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
												  <label for="title">Requester Mobile:</label>
												  <input type="text" name="reqst_mobile" class="form-control" id="title" value= "<?php echo $row['REQUESTER_MOBILE'];?>" readonly form="Form2">
												</div>
											</div> 	
											<div class="col-sm-6">
												<div class="form-group">
												  <label for="title">Feedback Remarks:</label>
												  <input required="" type="tel" name ="feedback_remarks" class="form-control" id="title" form="Form2">
												</div>
											</div>
																					
										</div>
										<div class="row">
											 <div class="col-lg-12">
												<div class="md-form mt-5">
												<button type="submit" name="submit" class="btn btn-info" form="Form2">Submit To Feed-Back</button>
												</div>
										     </div>	
										</div>
						
                       
						 <?php
						  }}
						 ?>
				</div>

	
	              <?php
                          $emp_session_id=$_SESSION['emp_id'];
                          @$sc_id = $_REQUEST['sc_id'];
						  @$update_sms = $_REQUEST['update_sms'];
						  @$feedback_remarks = $_REQUEST['feedback_remarks'];
						  @$reqst_mobile = $_REQUEST['reqst_mobile'];
						  
						 
						  if(isset($_POST['sc_id'])){
							
							   $strSQL  = oci_parse($objConnect, "UPDATE RML_COLL_SC SET
																	UPDATE_SMS='$update_sms',
																	REQUEST_TYPE='Updated',
																	UPDATE_DATE=SYSDATE,
																	UPDATE_BY='$emp_session_id',
																	UPDATED_REMARKS='$feedback_remarks'
														    where id=$sc_id"); 
																				  
						   if(oci_execute($strSQL)){
							    // SMS TO Requester
								$smsReceverNumber='88'.$reqst_mobile;
							    $url='http://api.rankstelecom.com/api/v3/sendsms/json';
								$ch=curl_init($url);
								
								$data=array(
								'authentication'=>array('username'=>'Rml','password'=>'R@ngs*it123'),
								'messages'=>array(array('sender'=>'8804445601212','text'=>'সম্মানিত গ্রাহক  আগামী ৩০ কর্ম-দিবসের মধ্যে আপনার সেলস সার্টিফিকেট প্রদান করা হবে।', 'datacoding'=>8,'type'=>'longsms','recipients'=>array(array('gsm'=>$smsReceverNumber))
								))
								);
								$jsondataencode=json_encode($data);
								CURL_SETOPT($ch,CURLOPT_POST,1);
								CURL_SETOPT($ch,CURLOPT_POSTFIELDS,$jsondataencode);
								CURL_SETOPT($ch,CURLOPT_HTTPHEADER,array('content-type:application/json'));
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // not want to show result messages
								$result=CURL_EXEC($ch);
								// End
								
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  Information is updated successfully.
									</li>
								   </ol>
								  </div>
								  </div>
							  <?php
						   } 
						  }
						?>
		 </div>
       </div>
	   
	      <!--    List Data Show Start    -->				   
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">Code</th>
								  <th scope="col">Cust. Name</th>
								  <th scope="col">Entry By</th>
								  <th scope="col">Entry Date</th>
								   <th scope="col">Day Pass</th>
								  <th scope="col">Requested By</th>
								  <th scope="col">Requested Mobile</th>
								    <th scope="col">Cust. Mobile</th>
								</tr>
					   </thead>
					   <tbody>
						<?php
						$emp_id=$_SESSION['emp_id'];
						
						$SQLList  = oci_parse($objConnect, "select REF_CODE,
														CUSTOMER_NAME,
														CUSTOMER_MOBILE,
														(select EMP_NAME from RML_COLL_APPS_USER
																		where RML_ID=ENTRY_BY_RML_ID
																		and ACCESS_APP='RML_COLL')
														ENTRY_BY_RML_ID,
														REQUESTER_NAME,
														REQUESTER_MOBILE,
														ENTRY_DATE,
														TRUNC (SYSDATE-ENTRY_DATE) DAY_PASS
														from RML_COLL_SC
														where REQUEST_TYPE='New'
														ORDER BY ENTRY_DATE DESC"); 
						  oci_execute($SQLList);
						  $number=0;
		                  while($row=oci_fetch_assoc($SQLList)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							 
							  <td><?php echo $row['ENTRY_BY_RML_ID'];?></td>
							  <td><?php echo $row['ENTRY_DATE'];?></td>
							  <td align ="center"><?php 
							  if($row['DAY_PASS']>7){
								  echo '<font color="red">'.$row['DAY_PASS'].'</font>';
							  }else{
								 echo $row['DAY_PASS'];
							  }
							     
							  
							  ?></td>
							  <td><?php echo $row['REQUESTER_NAME'];?></td>
							  <td><?php echo $row['REQUESTER_MOBILE'];?></td>
							  <td><?php echo $row['CUSTOMER_MOBILE'];?></td>
						 </tr>
						 <?php
						  }
						  ?>
					    </tbody>	
		              </table>
					</div>
				  </div>
				</div>
		<!--    List Data Show End    -->	

	   
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
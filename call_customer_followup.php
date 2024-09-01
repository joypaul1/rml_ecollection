<?php 
	session_start();
	if($_SESSION['user_role_id']!= 13)
	{
	  header('location:index.php?lmsg=true');
	  exit;
	} 			
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	$followup_id=$_REQUEST['followup_id'];
	
	
	
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						  $strSQL  = oci_parse($objConnect, 
						  "select  
						    b.id,
							a.RML_COLL_CALL_CATEGORY_ID,
							b.ENTRY_REMARKS,
							b.CUSTOMER_REMARKS,
							b.FOLLOW_UP_DATE,
							a.ENTRY_BY,
							a.CALLER_MOBILE,
							a.CALLER_NAME,a.RESPONSIBLE_PERON
                        from CCD_CALL a,CCD_CALL_FOLLOWUP b
                            where a.id=b.CCD_CALL_ID
                            and b.CCD_CALL_ID=$followup_id
							and b.CLOSE_STATUS=0"
							); 
						oci_execute($strSQL);
		                while($row=oci_fetch_assoc($strSQL)){	
                           ?>
						   <div class="col-lg-12">
						   <form action="" method="post">
								<div class="md-form mt-3">
							<div class="resume-item d-flex flex-column flex-md-row">						   
	<div class="container">
	
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
				   
				    <div class="col-sm-6">
						<div class="form-group">
						  <label for="title">Customer Mobile Number:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="mobile_no" required="" id="title" value= "<?php echo $row['CALLER_MOBILE'];?>">
						</div>
					</div>
					 <div class="col-sm-6">
						<div class="form-group">
						  <label for="title">Customer Name:</label>
						  <input type="text"class="form-control text-danger font-weight-bold" name ="name_call" required="" id="title" value= "<?php echo $row['CALLER_NAME'];?>">
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-sm-6">
					<label for="title">Admin Remarks:</label>
						<textarea required="" name="admin_remarks" rows="2" style="width:100%;"><?php echo $row['ENTRY_REMARKS'];?></textarea>
					</div>
					<div class="col-sm-6">
					<label for="title">Customer Remarks:</label>
						<textarea  required="" name="customer_remarks" rows="2" style="width:100%;"><?php echo $row['CUSTOMER_REMARKS'];?></textarea>
					</div>
			    </div>
				<div class="row mt-3">
					<div class="col-sm-12">
					<label for="title">Responsible Person:</label>
						<textarea  required="" name="responsible_person" rows="2" style="width:100%;"><?php echo $row['RESPONSIBLE_PERON'];?></textarea>
					</div>
			    </div>
				
				<div class="row mt-3">
					<div class="col-sm-4">
						<label for="title">Select Call Category:</label>
						<select required="" name="call_category" class="form-control">
						<option selected value="">--</option>
						<?php
						$strSQL  = oci_parse($objConnect, "select ID,CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY");
						oci_execute($strSQL);
						while($row1=oci_fetch_assoc($strSQL)){
                          if($row1['ID']==$row['RML_COLL_CALL_CATEGORY_ID']){
							  							
						?>
						<option selected value="<?php echo $row1['ID'];?>"><?php echo $row1['CALL_CATEGORY_TITLE'];?></option>
						<?php
						}
						}
						?>
						</select>
					</div>
					<div class="col-sm-4">
						<label for="title">Select Status:</label>
						<select required="" name="status" class="form-control" onchange="showDiv(this)">>
						<option selected value="">--</option>
						<option value="1">Closed</option>
						<option value="0">Continue</option>
						
						</select>
					</div>
					<div class="col-sm-4">
							    <label for="title">Follow-Up Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
                </div>
				
				<div class="row mt-3" id="hidden_div" style="display:none;">
					<div class="col-sm-12">
					<label for="title">Closing Remarks:</label>
						<textarea name="close_remarks" rows="2" style="width:100%;"></textarea>
					</div>
			    </div>
				<script type="text/javascript">
					function showDiv(select){
					   if(select.value==1){
						document.getElementById('hidden_div').style.display = "block";
					   } else{
						document.getElementById('hidden_div').style.display = "none";
					   }
					} 
			   </script>
			
				<div class="row">
					 <div class="col-lg-12">
						<div class="md-form mt-5">
						<button type="submit" name="submit" class="btn btn-info" >Create & Save</button>
						</div>
					 </div>	
				</div>
				
			</div>
		</div>
	</div>
	 <?php
	  }
	 ?>					
	</div>
  </div>
  </form>
</div>

	 <?php 

	 
	  if(isset($_POST['mobile_no'])){
		  $emp_session_id=$_SESSION['emp_id'];
		  
		  $admin_remarks = $_REQUEST['admin_remarks'];
		  $customer_remarks = $_REQUEST['customer_remarks'];
		  $close_remarks = $_REQUEST['close_remarks'];
		  $call_category_id = $_REQUEST['call_category'];
		  $status_lebel = $_REQUEST['status'];
		  $responsible_person = $_REQUEST['responsible_person'];
		  
		  @$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
		  
		       if($status_lebel=="1"){
				  $strSQL  = oci_parse($objConnect, 
		               "update CCD_CALL_FOLLOWUP set 
					    CLOSED_DATE=SYSDATE,
						CLOSE_STATUS=1,
						ENTRY_DATE=SYSDATE,
						CLOSED_ENTRY_REMARKS='$admin_remarks',
						CLOSED_CUSTOMER_REMARKS='$customer_remarks',
						CLOSED_BY='$emp_session_id'
						WHERE CCD_CALL_ID=$followup_id 
					and CLOSE_STATUS=0");	
                 $strSQLMain  = oci_parse($objConnect, 
		               "update CCD_CALL set 
					    CLOSE_STATUS=1,
						CLOSED_DATE=SYSDATE,
						CLOSING_REMARKS='$close_remarks',
						RESPONSIBLE_PERON='$responsible_person'
						WHERE ID=$followup_id");	
					
                oci_execute($strSQLMain);						
			   }else{
				   
				 $strSQLUpdate  = oci_parse($objConnect, 
		          "UPDATE CCD_CALL_FOLLOWUP set 
				               CLOSE_STATUS=1, 
							   CLOSED_DATE=SYSDATE,
							   CLOSED_BY='$emp_session_id'
					WHERE 
					CCD_CALL_ID=$followup_id 
					and CLOSE_STATUS=0");
					
				  oci_execute($strSQLUpdate);  
				   
				   
				$strSQL  = oci_parse($objConnect, 
		          "INSERT INTO CCD_CALL_FOLLOWUP (
                      CCD_CALL_ID, 
					  ENTRY_REMARKS, 
                      CUSTOMER_REMARKS, 
					  CLOSE_STATUS, 
                      ENTRY_BY, 
					  ENTRY_DATE, 
					  FOLLOW_UP_DATE) 
							VALUES ( 
							 $followup_id,
							 '$admin_remarks',
							 '$customer_remarks',
							  0,
							 '$emp_session_id',
							 SYSDATE,
							 TO_DATE('$start_date','dd/mm/yyyy'))");
				   }
			  
		
											  
						   if(oci_execute($strSQL)){
							  // echo '<script>alert("Information is Created successfully.")</script>';
							  ?>
							
                                 <div class="container-fluid">
							      <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  
									  <?php
										  echo $htmlHeader;
										  while($stuff){
											echo $stuff;
										  }
										 if($status_lebel=="1"){
											 echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/call_customer_report_closed.php'</script>";   
										  }else{
											  echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/call_customer_followup.php?followup_id=$followup_id'</script>";  
										  }
										 
										?>
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
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
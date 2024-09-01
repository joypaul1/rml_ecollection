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
	
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">List</a>   &nbsp;&nbsp; <a href="call_customer_to_ccd_call.php">New</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						   
							<div class="col-sm-3">
								<div class="form-group">
								  <label for="title">Customer Mobile:</label>
								  <input name="customer_mobile" class="form-control"  type='text' value='<?php echo isset($_POST['customer_mobile']) ? $_POST['customer_mobile'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label for="title">Ref Code:</label>
								  <input name="ref_code" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-3">
							 <label for="title">Select Call Category:</label>
							    <select name="call_category" class="form-control">
								 <option selected value="">--</option>
								      <?php
									  $strSQL  = oci_parse($objConnect, "select ID,CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY ORDER BY CALL_CATEGORY_TITLE");
									  	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['ID'];?>"><?php echo $row['CALL_CATEGORY_TITLE'];?></option>
									  <?php
									   }
									  ?>
							    </select> 
							</div>
							
							<div class="col-sm-3">
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
								  <th scope="col">Customer Mobile</th>
								  <th scope="col">Customer Name</th>
								  <th scope="col"><center>Admin Remarks</center></th>
								  <th scope="col"><center>Customer Remarks</center></th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col"><center>Entry By</center></th>
								  <th scope="col"><center>Open/Close</center></th>
								  <th scope="col"><center>Ref Code</center></th>
								  <th scope="col"><center>Call Category</center></th>
								  
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['customer_mobile'])){
							$ref_code = $_REQUEST['ref_code'];
							$customer_mobile = $_REQUEST['customer_mobile'];
							$call_category = $_REQUEST['call_category'];
							
						  $strSQL  = oci_parse($objConnect, 
						            "SELECT 
										a.ID,
										a.REF_CODE,										
										c.ENTRY_REMARKS, 
										c.CUSTOMER_REMARKS, 
										A.CLOSING_REMARKS,
										CALL_TYPE, 
										A.RML_COLL_CALL_CATEGORY_ID, 
										a.ENTRY_BY, a.ENTRY_DATE, 
										UPDATE_BY, 
										UPDATED_DATE,
										b.CALL_CATEGORY_TITLE,
										a.CALLER_MOBILE,
										a.CALLER_NAME,a.CLOSE_STATUS,
										a.REF_CODE
										FROM CCD_CALL A,RML_COLL_CALL_CATEGORY B,CCD_CALL_FOLLOWUP C
										WHERE a.RML_COLL_CALL_CATEGORY_ID=B.ID
										AND A.ID=C.CCD_CALL_ID
										and C.CLOSE_STATUS=0
										and A.CALL_TYPE='IN'
										and a.ENTRY_BY='$emp_session_id'
										AND ('$ref_code' IS NULL OR A.REF_CODE='$ref_code')
										AND ('$customer_mobile' IS NULL OR A.CALLER_MOBILE='$customer_mobile')
										AND ('$call_category' IS NULL OR A.RML_COLL_CALL_CATEGORY_ID='$call_category')
										"); 	
		
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						    <tr>
							  <td><?php echo $number;?></td>
							 
							<td align="center"><?php echo $row['CALLER_MOBILE'];?></td>
							<td align="center"><?php echo $row['CALLER_NAME'];?></td>
							<td align="center"><?php echo $row['ENTRY_REMARKS'];?></td>
							<td align="center"><?php echo $row['CUSTOMER_REMARKS'];?></td>
							<td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							<td align="center"><?php echo $row['ENTRY_BY'];?></td>
							
							<td align="center">
							   <?php if($row['CLOSE_STATUS']=='1')
							          echo '<i style="color:blue;"><b>Closed</b></i> ';
								   else
									   echo 'Open';
							   ?></td>
							   <td align="center"><?php echo $row['REF_CODE'];?></td>
							<td align="center">
							     <a href="call_customer_followup.php?followup_id=<?php echo $row['ID'];?>">
								 <?php echo $row['CALL_CATEGORY_TITLE'];?>
								 </a>
							</td>
							
						 </tr>
						 <?php
						  }
						  }else{
							 
						     $allDataSQL  = oci_parse($objConnect, 
							       "SELECT 
										a.ID, 
										a.REF_CODE,
										c.ENTRY_REMARKS, 
										c.CUSTOMER_REMARKS, 
										A.CLOSING_REMARKS,
										CALL_TYPE, 
										RML_COLL_CALL_CATEGORY_ID, 
										a.ENTRY_BY, a.ENTRY_DATE, 
										UPDATE_BY, 
										UPDATED_DATE,
										b.CALL_CATEGORY_TITLE,
										a.CALLER_MOBILE,
										a.CALLER_NAME,a.CLOSE_STATUS
										FROM CCD_CALL A,RML_COLL_CALL_CATEGORY B,CCD_CALL_FOLLOWUP C
										WHERE a.RML_COLL_CALL_CATEGORY_ID=B.ID
										AND A.ID=C.CCD_CALL_ID
										and C.CLOSE_STATUS=0
										and a.ENTRY_BY='$emp_session_id'
										and CALL_TYPE='IN'
										and rownum<=50"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
						   <td><?php echo $number;?></td>
						    <td align="center"><?php echo $row['CALLER_MOBILE'];?></td>
							<td align="center"><?php echo $row['CALLER_NAME'];?></td>
							<td align="center"><?php echo $row['ENTRY_REMARKS'];?></td>
							<td align="center"><?php echo $row['CUSTOMER_REMARKS'];?></td>
							<td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							<td align="center"><?php echo $row['ENTRY_BY'];?></td>
							<td align="center">
							   <?php if($row['CLOSE_STATUS']=='1')
							          echo '<i style="color:blue;"><b>Closed</b></i> ';
								   else
									   echo 'Open';
							   ?></td>
							<td align="center"><?php echo $row['REF_CODE'];?></td>
							<td align="center">
							     <a href="call_customer_followup.php?followup_id=<?php echo $row['ID'];?>">
								 <?php echo $row['CALL_CATEGORY_TITLE'];?>
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
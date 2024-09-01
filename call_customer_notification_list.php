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
	$call_category_id=$_REQUEST['call_category_id'];
	$v_date=$_REQUEST['v_date'];
	$v_type=$_REQUEST['v_type'];
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">List</a> 
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Ref Code</center></th>
								  <th scope="col"><center>Admin Remarks</center></th>
								  <th scope="col"><center>Customer Remarks</center></th>
								  <th scope="col"><center>Follow-Up Date</center></th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col"><center>Entry By</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						$allDataSQL  = oci_parse($objConnect, 
							       "select  
								    a.id,
									A.CHASSIS_NO,
									A.ENG_NO,a.REG_NO,a.REF_CODE,
								    A.ENTRY_REMARKS,a.CUSTOMER_REMARKS,
                                    B.FOLLOW_UP_DATE,A.ENTRY_BY,A.ENTRY_DATE
                                   from CCD_CALL a,CCD_CALL_FOLLOWUP b
                                where a.id=b.CCD_CALL_ID
                                and b.CLOSE_STATUS=0
								and a.CALL_TYPE='$v_type'
                                and a.RML_COLL_CALL_CATEGORY_ID=$call_category_id
                                and trunc(b.FOLLOW_UP_DATE)= TO_DATE('$v_date','DD/MM/RRRR')"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							<td><?php echo $number;?></td>
							<td align="center"><?php echo $row['REF_CODE'];?></td>
							<td align="center"><?php echo $row['ENTRY_REMARKS'];?></td>
							<td align="center"><?php echo $row['CUSTOMER_REMARKS'];?></td>
							<td align="center"><?php echo $row['FOLLOW_UP_DATE'];?></td>
							<td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							<td align="center"><?php echo $row['ENTRY_BY'];?></td>
							<td align="center">
							     <a href="call_customer_followup.php?followup_id=<?php echo $row['ID'];?>">
								 <?php echo 'Follow-Up';?>
								 </a>
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
			 
				
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
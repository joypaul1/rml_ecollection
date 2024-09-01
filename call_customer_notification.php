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
          <a href="">Outbound List </a> 
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						   
							<div class="col-sm-3">
							    <label for="title">Follow-Up Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='followup_date' value='<?php echo isset($_POST['followup_date']) ? $_POST['followup_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-3">
							    <label for="title">Follow-Up End Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='followup_date_end' value='<?php echo isset($_POST['followup_date_end']) ? $_POST['followup_date_end'] : ''; ?>' />
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
					<div class="md-form mt-3">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Call Category</center></th>
								  <th scope="col"><center>Notificatin Count</center></th>
								  <th scope="col"><center>Follow Up Date</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['followup_date'])){
							
							$call_category = $_REQUEST['call_category'];
							$followup_date = date("d/m/Y", strtotime($_REQUEST['followup_date']));
							$v_followup_date_end = date("d/m/Y", strtotime($_REQUEST['followup_date_end']));
							
							$sql="select (select CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY where id=a.RML_COLL_CALL_CATEGORY_ID)RML_COLL_CALL_CATEGORY,
						                  count(a.ID) TOTAL_NUMBER,b.FOLLOW_UP_DATE FOLLOW_UP_DATE,RML_COLL_CALL_CATEGORY_ID
							      from CCD_CALL a,CCD_CALL_FOLLOWUP b
										where a.id=b.CCD_CALL_ID
										and b.CLOSE_STATUS=0
										AND a.CALL_TYPE='OUT'
										and a.ENTRY_BY='$emp_session_id'
										and ('$call_category' IS NULL OR a.RML_COLL_CALL_CATEGORY_ID ='$call_category')
										and trunc(b.FOLLOW_UP_DATE) BETWEEN TO_DATE('$followup_date','dd/mm/yyyy') and TO_DATE('$v_followup_date_end','dd/mm/yyyy')
										group by RML_COLL_CALL_CATEGORY_ID,b.FOLLOW_UP_DATE";
							
						  $strSQL  = oci_parse($objConnect, $sql); 	
								
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							<td align="center">
							     <a href="call_customer_notification_list.php?call_category_id=<?php echo $row['RML_COLL_CALL_CATEGORY_ID'].'&v_date='.$row['FOLLOW_UP_DATE'].'&v_type=OUT';?>">
								 <?php echo $row['RML_COLL_CALL_CATEGORY'];?>
								 </a>
							</td>
							<td align="center"><?php echo $row['TOTAL_NUMBER'];?></td>
							<td align="center"><?php echo $row['FOLLOW_UP_DATE'];?></td>	
						 </tr>
						 <?php
						  }
						  }else{
							 
						$allDataSQL  = oci_parse($objConnect, "select 
							    (select CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY where id=a.RML_COLL_CALL_CATEGORY_ID)RML_COLL_CALL_CATEGORY,
								   count(a.ID) TOTAL_NUMBER,b.FOLLOW_UP_DATE FOLLOW_UP_DATE,RML_COLL_CALL_CATEGORY_ID
								   from CCD_CALL a,CCD_CALL_FOLLOWUP b
								where a.id=b.CCD_CALL_ID
								and b.CLOSE_STATUS=0
								AND a.CALL_TYPE='OUT'
								and a.ENTRY_BY='$emp_session_id'
								and trunc(b.FOLLOW_UP_DATE) BETWEEN  TO_DATE(SYSDATE,'dd/mm/RRRR') and TO_DATE(SYSDATE,'dd/mm/RRRR')
								group by RML_COLL_CALL_CATEGORY_ID,b.FOLLOW_UP_DATE"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							<td><?php echo $number;?></td>
							<td align="center">
							     <a href="call_customer_notification_list.php?call_category_id=<?php echo $row['RML_COLL_CALL_CATEGORY_ID'].'&v_date='.$row['FOLLOW_UP_DATE'].'&v_type=OUT';?>">
								 <?php echo $row['RML_COLL_CALL_CATEGORY'];?>
								 </a>
							</td>
							<td align="center"><?php echo $row['TOTAL_NUMBER'];?></td>
							<td align="center"><?php echo $row['FOLLOW_UP_DATE'];?></td>
							
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
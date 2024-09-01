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
          <a href="">Visit Report Page</a>
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
					   <table class="table table-bordered table-striped" id="admin_list">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Concern Information</center></th>
								  <th scope="col"><center>Assign Information</center></th>
								  <th scope="col"><center>Hot Information</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						

						if(isset($_POST['start_date'])){
							
							$emp_concern = $_REQUEST['emp_concern'];
						    $month_start = date("d/m/Y", strtotime($_REQUEST['start_date']));
                            $month_end = date("d/m/Y", strtotime($_REQUEST['end_date']));
					
						    $strSQL  = oci_parse($objConnect, "SELECT 
											   ZONE,
											   RML_ID,
											   CONCERN,
											   CODE_ASSIGN_ERP(RML_ID) TOTAL_CODE,
											  (select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
													WHERE B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												 TOTAL_VISIT_ASSIGN,
												 (select count(UNIQUE(B.REF_ID)) from RML_COLL_VISIT_ASSIGN B
													WHERE B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												 TOTAL_UNIQUE_ASSIGN,
										       (select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
													WHERE B.VISIT_STATUS=1
													AND B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												TOTAL_VISITED,
												(select count(unique(B.REF_ID)) from RML_COLL_VISIT_ASSIGN B
													WHERE B.VISIT_STATUS=1
													AND B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												UNIQUE_VISITED	
										FROM MONTLY_COLLECTION A
										WHERE IS_ACTIVE=1
										AND ZONAL_HEAD='$emp_session_id'
									    AND ('$emp_concern' IS NULL OR RML_ID='$emp_concern')");  
										
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						     <tr>
							  <td><?php echo $number;?></td>
							 
							   <td>
							   <?php 
								 echo 'Name: '.$row['CONCERN'];
								 echo '<br>';
								 echo 'ID: '.$row['RML_ID'];
								 echo '<br>';
								 echo 'Zone: <b style="color:red;">'.$row['ZONE'].'</b>';
							   ?>
							   </td>
							   <td>
                                  <a href="cc_visit_code.php?<?php echo '&login_id='.$row['RML_ID'].'&start_date='.$month_start.'&end_date='.$month_end.'&want=total_code';?>">
								  <?php 
								   echo 'Total Code: '.$row['TOTAL_CODE'];
								   echo '<br>';?>
								  </a>
								   <a href="cc_visit_code.php?<?php echo '&login_id='.$row['RML_ID'].'&start_date='.$month_start.'&end_date='.$month_end.'&want=total_assign';?>">
								  <?php 
								   echo 'Total Assign: '.$row['TOTAL_VISIT_ASSIGN'];
								   echo '<br>';?>
								  </a>
							   <?php 
								
								
								 echo 'Unique Assign: '.$row['TOTAL_UNIQUE_ASSIGN'];
								 echo '<br>';
								 
							   ?>
							   </td>
							    <td>
								 <a target="_blank" href="cc_visit_code.php?<?php echo '&login_id='.$row['RML_ID'].'&start_date='.$month_start.'&end_date='.$month_end.'&want=Not_Touching_Code';?>">
								  <?php echo 'Not Touching: '.($row['TOTAL_CODE']-$row['TOTAL_UNIQUE_ASSIGN']);?>
								  </a>
							   <?php 
							   
								echo '<br>';
								echo 'Total Visited: '.$row['TOTAL_VISITED'];
								echo '<br>';
								echo 'Unique Visited: '.$row['UNIQUE_VISITED'];
							   ?>
							   </td>
						 </tr>
						 <?php
						  } 
						  }else{
							$month_start=date('01/m/Y');
							$month_end=date('t/m/Y');
						
						    $allDataSQL  = oci_parse($objConnect, "SELECT 
											   ZONE,
											   RML_ID,
											   CONCERN,
											   CODE_ASSIGN_ERP(RML_ID) TOTAL_CODE,
											  (select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
													WHERE B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												 TOTAL_VISIT_ASSIGN,
												 (select count(UNIQUE(B.REF_ID)) from RML_COLL_VISIT_ASSIGN B
													WHERE B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												 TOTAL_UNIQUE_ASSIGN,
										       (select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
													WHERE B.VISIT_STATUS=1
													AND B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												TOTAL_VISITED,
												(select count(unique(B.REF_ID)) from RML_COLL_VISIT_ASSIGN B
													WHERE B.VISIT_STATUS=1
													AND B.CREATED_BY=A.RML_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$month_start','DD/MM/YYYY') and TO_DATE('$month_end','DD/MM/YYYY'))
												UNIQUE_VISITED	
										FROM MONTLY_COLLECTION A
										WHERE IS_ACTIVE=1
										AND ZONAL_HEAD='$emp_session_id'"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						    <tr>
							  <td><?php echo $number;?></td>
							 
							   <td>
							   <?php 
								 echo 'Name: '.$row['CONCERN'];
								 echo '<br>';
								 echo 'ID: '.$row['RML_ID'];
								 echo '<br>';
								 echo 'Zone: <b style="color:red;">'.$row['ZONE'].'</b>';
							   ?>
							   </td>
							   <td>
                                  <a href="cc_visit_code.php?<?php echo '&login_id='.$row['RML_ID'].'&start_date='.$month_start.'&end_date='.$month_end.'&want=total_code';?>">
								  <?php 
								   echo 'Total Code: '.$row['TOTAL_CODE'];
								   echo '<br>';?>
								  </a>
								   <a href="cc_visit_code.php?<?php echo '&login_id='.$row['RML_ID'].'&start_date='.$month_start.'&end_date='.$month_end.'&want=total_assign';?>">
								  <?php 
								   echo 'Total Assign: '.$row['TOTAL_VISIT_ASSIGN'];
								   echo '<br>';?>
								  </a>
							   <?php 
								
								
								 echo 'Unique Assign: '.$row['TOTAL_UNIQUE_ASSIGN'];
								 echo '<br>';
								 
							   ?>
							   </td>
							    <td>
								 <a target="_blank" href="cc_visit_code.php?<?php echo '&login_id='.$row['RML_ID'].'&start_date='.$month_start.'&end_date='.$month_end.'&want=Not_Touching_Code';?>">
								  <?php echo 'Not Touching: '.($row['TOTAL_CODE']-$row['TOTAL_UNIQUE_ASSIGN']);?>
								  </a>
							   <?php 
							   
								echo '<br>';
								echo 'Total Visited: '.$row['TOTAL_VISITED'];
								echo '<br>';
								echo 'Unique Visited: '.$row['UNIQUE_VISITED'];
							   ?>
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
				
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
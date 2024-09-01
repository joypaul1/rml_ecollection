<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
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
          <a href="">INBOUND & OUTBOUND Notification Dashboard</a>
        </li>
        
      </ol>
      <hr>
	  
	  
	  <div class="container-fluid">
		<div class="row">
		 <div class="col-sm-6">	             	 			 					
				<table class="table table-striped table-bordered table-sm table table-hover" style="width:100%">  						
					<thead class="p-3 mb-2 bg-danger text-white">	
                        <tr>
						  <th><center>OUTBOUND</center></th>
						</tr>					
					   <tr>							  
					   <th class="text-center" scope="col">Sl</th>							  
					   <th class="text-center" scope="col">Call Category</th>							  
					   <th class="text-center" scope="col">Count</th>								
					   <th class="text-center" scope="col">Date</th>								
					   </tr>						
					</thead>									   						
					<tbody>						
					<?php

                       if($emp_session_id=='RML-00955')					
					   {
                       $winloastSQL  = oci_parse($objConnect, "select (select CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY where id=a.RML_COLL_CALL_CATEGORY_ID)RML_COLL_CALL_CATEGORY,
								   count(a.ID) TOTAL_NUMBER,b.FOLLOW_UP_DATE FOLLOW_UP_DATE,RML_COLL_CALL_CATEGORY_ID
								   from CCD_CALL a,CCD_CALL_FOLLOWUP b
								where a.id=b.CCD_CALL_ID
								and b.CLOSE_STATUS=0
								AND a.CALL_TYPE='OUT'
								and trunc(b.FOLLOW_UP_DATE)= TO_DATE(SYSDATE,'dd/mm/RRRR')
								group by RML_COLL_CALL_CATEGORY_ID,b.FOLLOW_UP_DATE"); 
					   }else{
						  $winloastSQL  = oci_parse($objConnect, "select (select CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY where id=a.RML_COLL_CALL_CATEGORY_ID)RML_COLL_CALL_CATEGORY,
								   count(a.ID) TOTAL_NUMBER,b.FOLLOW_UP_DATE FOLLOW_UP_DATE,RML_COLL_CALL_CATEGORY_ID
								   from CCD_CALL a,CCD_CALL_FOLLOWUP b
								where a.id=b.CCD_CALL_ID
								and b.CLOSE_STATUS=0
								AND a.CALL_TYPE='OUT'
								and a.ENTRY_BY='$emp_session_id'
								and trunc(b.FOLLOW_UP_DATE)= TO_DATE(SYSDATE,'dd/mm/RRRR')
								group by RML_COLL_CALL_CATEGORY_ID,b.FOLLOW_UP_DATE");   
					   }
			
						 $WIN=0;
						 $LOST=0;
						 $number=0;	
						if(oci_execute($winloastSQL)) {
						   while($row=oci_fetch_assoc($winloastSQL)){ 
						   	$number++;	
                            ?>
							<tr>							  
					<td class="text-center"><?php echo $number;?></td>
                    <td align="center">
						 <a href="call_customer_notification_list.php?call_category_id=<?php echo $row['RML_COLL_CALL_CATEGORY_ID'].'&v_date='.$row['FOLLOW_UP_DATE'].'&v_type=OUT';?>">
						 <?php echo $row['RML_COLL_CALL_CATEGORY'];?>
						 </a>
					</td>							  
					<td class="text-center"><?php echo $row['TOTAL_NUMBER'];?></td>														
					<td class="text-center"><?php echo $row['FOLLOW_UP_DATE'];?></td>														
					</tr>
					<?php
							}
						}							 
					?>
					</tbody>	 					
				</table>
				</div>
          <div class="col-sm-6">	             	 			 					
				<table class="table table-striped table-bordered table-sm table table-hover" style="width:100%">  						
					<thead class="p-3 mb-2 bg-danger text-white">	
                        <tr>
						  <th><center>INBOUND</center></th>
						</tr>					
					   <tr>							  
					   <th class="text-center" scope="col">Sl</th>							  
					   <th class="text-center" scope="col">Call Category</th>							  
					   <th class="text-center" scope="col">Count</th>								
					   <th class="text-center" scope="col">Date</th>								
					   </tr>						
					</thead>									   						
					<tbody>						
					<?php

                     if($emp_session_id=='RML-00955')					
					   {					
                       $winloastSQL  = oci_parse($objConnect, "select (select CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY where id=a.RML_COLL_CALL_CATEGORY_ID)RML_COLL_CALL_CATEGORY,
								   count(a.ID) TOTAL_NUMBER,b.FOLLOW_UP_DATE FOLLOW_UP_DATE,RML_COLL_CALL_CATEGORY_ID
								   from CCD_CALL a,CCD_CALL_FOLLOWUP b
								where a.id=b.CCD_CALL_ID
								and b.CLOSE_STATUS=0
								AND a.CALL_TYPE='IN'
								and trunc(b.FOLLOW_UP_DATE)= TO_DATE(SYSDATE,'dd/mm/RRRR')
								group by RML_COLL_CALL_CATEGORY_ID,b.FOLLOW_UP_DATE"); 
					   }else{
						 $winloastSQL  = oci_parse($objConnect, "select (select CALL_CATEGORY_TITLE from RML_COLL_CALL_CATEGORY where id=a.RML_COLL_CALL_CATEGORY_ID)RML_COLL_CALL_CATEGORY,
								   count(a.ID) TOTAL_NUMBER,b.FOLLOW_UP_DATE FOLLOW_UP_DATE,RML_COLL_CALL_CATEGORY_ID
								   from CCD_CALL a,CCD_CALL_FOLLOWUP b
								where a.id=b.CCD_CALL_ID
								and b.CLOSE_STATUS=0
								AND a.CALL_TYPE='IN'
								and a.ENTRY_BY='$emp_session_id'
								and trunc(b.FOLLOW_UP_DATE)= TO_DATE(SYSDATE,'dd/mm/RRRR')
								group by RML_COLL_CALL_CATEGORY_ID,b.FOLLOW_UP_DATE");   
					   }
			
						 $WIN=0;
						 $LOST=0;
						 $number=0;	
						if(oci_execute($winloastSQL)) {
						   while($row=oci_fetch_assoc($winloastSQL)){ 
						   	$number++;	
                            ?>
							<tr>							  
					<td class="text-center"><?php echo $number;?></td>							  
                    <td align="center">
						 <a href="call_customer_notification_list.php?call_category_id=<?php echo $row['RML_COLL_CALL_CATEGORY_ID'].'&v_date='.$row['FOLLOW_UP_DATE'].'&v_type=IN';?>">
						 <?php echo $row['RML_COLL_CALL_CATEGORY'];?>
						 </a>
					</td>							  
					<td class="text-center"><?php echo $row['TOTAL_NUMBER'];?></td>														
					<td class="text-center"><?php echo $row['FOLLOW_UP_DATE'];?></td>														
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
       <hr>
    <!-- /.container-fluid-->
	 <div style="height: 1000px;"></div>
    </div>
<?php require_once('layouts/footer.php'); ?>	
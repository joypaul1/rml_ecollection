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
	
	//============ Start Collection Pie Chart ==============
	     $CollectionPieChart  = oci_parse($objConnect, "select REQUEST_TYPE,count(*) AS TOTAL_NUMBER from RML_COLL_SC group by REQUEST_TYPE order by REQUEST_TYPE"); 
		 oci_execute($CollectionPieChart);
		 $NEW_REQUESR=0;
		 $UPDATE_REQUESR=0;
		 $CLOSED_REQUESR=0;
	       while($row=oci_fetch_assoc($CollectionPieChart)){ 
		   if($row['REQUEST_TYPE']=='New'){
			   $NEW_REQUESR=$row['TOTAL_NUMBER'];
		   }else if($row['REQUEST_TYPE']=='Updated'){
			    $UPDATE_REQUESR=$row['TOTAL_NUMBER'];
		   }else if($row['REQUEST_TYPE']=='Closed'){
			    $CLOSED_REQUESR=$row['TOTAL_NUMBER'];
		   }
				  
				 
		   }
	   //============ End Collection Pie Chart ==============
?>	

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {	
	
	var NEW_REQUESR=<?php echo $NEW_REQUESR; ?> ;
	var UPDATE_REQUESR=<?php echo $UPDATE_REQUESR; ?> ;
	var CLOSED_REQUESR=<?php echo $CLOSED_REQUESR; ?> ;
	
	var DUE_VISIT=NEW_REQUESR-(UPDATE_REQUESR+CLOSED_REQUESR);
	var data = google.visualization.arrayToDataTable([
	['Task', 'Hours per Day'],
  ['New Request: '+NEW_REQUESR,NEW_REQUESR],
  ['Under Processing: '+UPDATE_REQUESR, UPDATE_REQUESR],
  ['Closed Request: '+CLOSED_REQUESR, CLOSED_REQUESR]
  
  
  
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Sales Certificate Request Status: '+(NEW_REQUESR+UPDATE_REQUESR+CLOSED_REQUESR), 'width':550, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('visit_summary'));
  chart.draw(data, options);
}
</script>




 <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Sales Certificate Last 5 Days Summary</a>
        </li>
        
      </ol>
      <hr>
	  
	  
	  <div class="container-fluid">
		<div class="row">
           <div class="col-lg-12">
						<div class="row">
							<div class="col-sm-12">	             	 			 					
									 <table class="table table-bordered piechart-key" style="width:100%">  						
									<thead class="thead-dark">							
									   <tr>							  
									      <th scope="col">Sl No</th>
										  <th scope="col"><center>Request Date</center></th>
										  <th scope="col"><center>Request Total</center></th>
										  <th scope="col"><center>L&C To ACC</center></th>
										  <th scope="col"><center>ACC To CCD</center></th>
										  <th scope="col"><center>CCD Issued</center></th>
										  <th scope="col"><center>Bank NOC Requsition to ACC</center></th>
										  <th scope="col"><center>Bank NOC Received</center></th>
										  <th scope="col"><center>Bank NOC Disbursed</center></th>						
									   </tr>						
									</thead>									   						
									<tbody>						
									<?php	
									   $winloastSQL  = oci_parse($objConnect, 
									   "SELECT TO_DATE(SYSDATE,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-1,'DD/MM/YYYY') PARAMETER_DATE, 
                                        (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-2,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-3,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-4,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
							"); 
										 $WIN=0;
										 $LOST=0;
										 $number=0;	
										if(oci_execute($winloastSQL)) {
										   while($row=oci_fetch_assoc($winloastSQL)){ 
											$number++;	
											?>
											<tr>							  
									<td class="text-center"><?php echo $number;?></td>							  
									<td class="text-center"><?php echo $row['PARAMETER_DATE'];?></td>							  
									<td class="text-center"><?php echo $row['REQUEST_TOTAL'];?></td>							  
									<td class="text-center"><?php echo $row['LEASE_TO_ACC'];?></td>																
									<td class="text-center"><?php echo $row['ACC_TO_CCD'];?></td>																
									<td class="text-center"><?php echo $row['CCD_COMPLETED'];?></td>																
									<td class="text-center"><?php echo $row['BANK_REQUISITION_TO_ACC'];?></td>																
									<td class="text-center"><?php echo $row['BANK_NOC_RECEIVED'];?></td>																
									<td class="text-center"><?php echo $row['BANK_NOC_DISBURSED'];?></td>																
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
       <hr>
    <!-- /.container-fluid-->
	 <div style="height: 1000px;"></div>
    </div>
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
	
	if($_SESSION['user_role_id']!= 8)
	  {
		header('location:index.php?lmsg=true');
		exit;
	  }		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php');
    require_once('inc/connoracle.php');
	
	$USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
	$USER_BRAND=$_SESSION['user_brand'];
	$USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
		

	     $RMLstrSQL  = oci_parse($objConnect, "select(SELECT COLL_SUMOF_TARGET_AMOUNT('$USER_ID','$USER_ROLE','$USER_BRAND') FROM DUAL) TERGET_COLLECTION,
												   (SELECT COLL_SUMOF_RECEIVED_AMOUNT('$USER_ID','$USER_ROLE','$USER_BRAND',(SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),(SELECT TO_CHAR(add_months(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1), 1) -1,'dd/mm/yyyy') FROM dual)) FROM DUAL) COLLECT_COLLECTION
												  from DUAL"); 

		oci_execute($RMLstrSQL);
		$TERGET_COLLECTION=0;
		$COLLECT_COLLECTION=0;		 
	     while($row=oci_fetch_assoc($RMLstrSQL)){ 
			$TERGET_COLLECTION=$row['TERGET_COLLECTION'];
			$COLLECT_COLLECTION=$row['COLLECT_COLLECTION'];	
		 }
	     // For visit
	      $AMISHEstrSQL  = oci_parse($objConnect, "Select SUM(VISIT_UNIT) ASSIGN_VISIT,SUM(TOTAL_VISIT) NON_PAYMENT_VISIT,SUM(EMI_VISIT) PAYMENT_VISIT FROM
                                                (select 
                                                         COLL_VISIT_UNIT(RML_ID, (SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),(SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL)) VISIT_UNIT,
                                                         COLL_VISIT_TOTAL(ID,TO_DATE((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),TO_DATE((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy')) TOTAL_VISIT,
                                                         COLL_EMI_VISIT_TOTAL(ID,TO_DATE((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),TO_DATE((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy')) EMI_VISIT
                                                 from RML_COLL_APPS_USER a
                                                   where ACCESS_APP='RML_COLL'
                                                   and RML_ID NOT IN('001','002','956','955')
                                                   --and USER_FOR='$USER_BRAND'
                                                   and LEASE_USER='CC'
                                                   and IS_ACTIVE=1)"); 
						  
		  
			 $ASSIGN_VISIT=0;
			 $NON_PAYMENT_VISIT=0;
			 $PAYMENT_VISIT=0;
			 
			if(oci_execute($AMISHEstrSQL)) {
			   while($row=oci_fetch_assoc($AMISHEstrSQL)){ 
					  $ASSIGN_VISIT=$row['ASSIGN_VISIT'];
					  $NON_PAYMENT_VISIT=$row['NON_PAYMENT_VISIT'];
					  $PAYMENT_VISIT=$row['PAYMENT_VISIT'];
					
			    }
			}
		
			
	
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {

	var TERGET_COLLECTION=<?php echo $TERGET_COLLECTION; ?> ;
	var COLLECT_COLLECTION=<?php echo $COLLECT_COLLECTION; ?> ;
	var DUE_TOTAL=TERGET_COLLECTION -COLLECT_COLLECTION;
	var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['Collection:'+COLLECT_COLLECTION, COLLECT_COLLECTION],
  ['Due:'+DUE_TOTAL,DUE_TOTAL]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Collection Current Month Target: '+TERGET_COLLECTION+' BDT', 'width':550, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('collection_summary'));
  chart.draw(data, options);
}
</script>

<script type="text/javascript">

// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {	
	
	var ASSIGN_VISIT=<?php echo $ASSIGN_VISIT; ?> ;
	var PAYMENT_VISIT=<?php echo $PAYMENT_VISIT; ?> ;
	var NON_PAYMENT_VISIT=<?php echo $NON_PAYMENT_VISIT; ?> ;
	var DUE_VISIT=ASSIGN_VISIT-(PAYMENT_VISIT+NON_PAYMENT_VISIT);
	var data = google.visualization.arrayToDataTable([
	['Task', 'Hours per Day'],
  ['Total Visited: '+(PAYMENT_VISIT+NON_PAYMENT_VISIT),PAYMENT_VISIT+NON_PAYMENT_VISIT],
  ['Payment Visited: '+PAYMENT_VISIT, PAYMENT_VISIT],
  ['Non Payment Visited: '+NON_PAYMENT_VISIT, NON_PAYMENT_VISIT]
  
  
  
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Visit Current Month Target: '+ASSIGN_VISIT, 'width':550, 'height':400};

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
          <a href="">Welcome to Rangs Group Collection Apps Dashboard</a>
        </li>
        
      </ol>
      <hr>
	  
	  
	  <div class="container-fluid">
		<div class="row">
           <div class="col-lg-12">
						<div class="row">
							<div class="col-sm-6">
								<div class="input-group">
								<div id="collection_summary"></div>
							   </div>
							</div>
							<div class="col-sm-">
								<div class="input-group">
								<div id="visit_summary"></div>
							   </div>
							</div>
							
						</div>	
						
				</div>
        </div>
		<hr>
			<div class="row">
			<div class="col-sm-12">	             	 			 					
				<table class="table table-bordered piechart-key" style="width:100%">  						
					<thead class="thead-dark">							
					   <tr>							  
					   <th class="text-center" scope="col">Sl</th>							  
					   <th class="text-center" scope="col">Current Month Apps Collection Target</th>							  
					   <th class="text-center" scope="col">Current Month Apps Collection Amount</th>								
					   <th class="text-center" scope="col">Current Month ERP Collection Amount[POST]</th>								
					   <th class="text-center" scope="col">Current Month ERP Collection Amount[UN-POST]</th>								
					  <!-- <th class="text-center" scope="col">Gap between ERP collection and Apps collection</th>	 -->							
					   </tr>						
					</thead>									   						
					<tbody>						
					<?php	
                       $winloastSQL  = oci_parse($objConnect, "select(SELECT COLL_SUMOF_TARGET_AMOUNT('$USER_ID','$USER_ROLE','$USER_BRAND') FROM DUAL) TERGET_COLLECTION,
												   (SELECT COLL_SUMOF_RECEIVED_AMOUNT('$USER_ID','$USER_ROLE','$USER_BRAND',(SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),(SELECT TO_CHAR(add_months(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1), 1) -1,'dd/mm/yyyy') FROM dual)) FROM DUAL) COLLECT_COLLECTION,
												   ERP_MR_AMOUNT('POST',TO_DATE((SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),'DD/MM/YYYY'),TO_DATE((SELECT TO_CHAR(add_months(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1), 1) -1,'dd/mm/yyyy') FROM dual),'DD/MM/YYYY')) AS ERP_POST_AMOUNT,
												   ERP_MR_AMOUNT('UNPOST',TO_DATE((SELECT TO_CHAR(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1),'dd/mm/yyyy') FROM dual),'DD/MM/YYYY'),TO_DATE((SELECT TO_CHAR(add_months(trunc(sysdate) - (to_number(to_char(sysdate,'DD')) - 1), 1) -1,'dd/mm/yyyy') FROM dual),'DD/MM/YYYY')) AS ERP_UNPOST_AMOUNT
												  from DUAL"); 
						  
			
						 $WIN=0;
						 $LOST=0;
						 $number=0;	
						if(oci_execute($winloastSQL)) {
						   while($row=oci_fetch_assoc($winloastSQL)){ 
						   	$number++;	
                            ?>
							<tr>							  
					<td class="text-center"><?php echo $number;?></td>							  
					<td class="text-center"><?php echo $row['TERGET_COLLECTION'];?></td>							  
					<td class="text-center"><?php echo $row['COLLECT_COLLECTION'];?></td>														
					<td class="text-center"><?php echo $row['ERP_POST_AMOUNT'];?></td>														
					<td class="text-center"><?php echo $row['ERP_UNPOST_AMOUNT'];?></td>															
					</tr>
					<?php
							}
						}							 
					?>
					</tbody>	 					
				</table>
				</div>
			    
				<div class="col-sm-4">
					<div class="input-group">
					<div id="product_wise"></div>	
				   </div>
				</div>
				
			</div>	
		
		
		
	  </div>
       <hr>
    <!-- /.container-fluid-->
	 <div style="height: 1000px;"></div>
    </div>
<?php require_once('layouts/footer.php'); ?>	
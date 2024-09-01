<?php 
	session_start();
	if($_SESSION['user_role_id']!= 9 && $_SESSION['user_role_id']!= 7 && $_SESSION['user_role_id']!= 10)
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
          <a href="">List</a>  &nbsp;&nbsp; 
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
							
							<div class="col-sm-4">
							 <label for="title">From Date:</label>
								<div class="input-group">
								   
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-4">
							 <label for="title">To Date:</label>
								<div class="input-group">
								
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>
							
							
						</div>	
						<div class="row">
							<div class="col-sm-4">
							</div>
						    <div class="col-sm-4">
								<div class="form-group">
								  <label for="title"> <br></label>
								  <input class="form-control btn btn-primary" type="submit" value="Search Data">
								</div>
							</div>
						</div>	
						
						
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5" style="overflow-x:auto;">
					   <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0">  
					
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">Ref Code</th>
								  <th scope="col">Customer Name</th>
								  <th scope="col">Sales Concern</th>
								  <th scope="col">Collection Concern</th>
								  <th scope="col">Delivery Date</th>
								  <th scope="col">EMI Start Date</th>
								  <th scope="col">Reg. NO</th>
								  <th scope="col">Sales Price</th>
								  <th scope="col">DP</th>
								  <th scope="col">Installment No</th>
								  <th scope="col">Installment Amount</th>
								  <th scope="col">Rcv.Instll.No</th>
								  <th scope="col"> Rcv.Instl.Amount</th>
								  <th scope="col"> Due Instl.No</th>
								  <th scope="col"> Due Amount </th>
								  	  			
                                  <th scope="col">Not Yet Due No</th>
                                  <th scope="col">Not Yet Due Amount</th>
								  <th scope="col"><center>Last Pay Date</center></th>
								  <th scope="col">Lat Pay Amount</th>
								  <th scope="col">Contact  No</th>
								  <th scope="col">Product</th>
								  
								  
								  <th scope="col">Chassis No</th>
								  <th scope="col">Participants Name</th>
								  <th scope="col">Impact Status</th>
								  <th scope="col">Call Date</th>
								  <th scope="col">Call Time</th>
								  
								  
								  <th scope="col"><center>Customer Comments</center></th>
								  
								  	
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						if(isset($_POST['start_date'])){

						  $start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                          $end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						  
						  $strSQLss  = oci_parse($objConnect, "select 
							                                                REF_CODE,
																			CUSTOMER_NAME,
																			SALES_CONCERN_NAME,
																			COLL_CONCERN_NAME,
																			CUSTOMER_MOBILE_NO,
																			DELIVERY_DATE,
																			EMI_START_DATE,
																			REG_NO,
																			SALES_AMOUNT,
																			DP,
																			INSTALLMENT_NUMBER,
																			INSTALLMENT_AMOUNT,
																			RECEIVED_INSTALLMENT_NUMBER,
																			TOTAL_RECEIVED_AMOUNT,
																			NUMBER_OF_DUE,
																			DUE_AMOUNT,
																			NUMBER_OF_NOT_YET_DUE,
																			NOT_YET_DUE_AMOUNT,
																			LAST_PAYMENT_DATE,
																			PRODUCT_TYPE,
																			CHASSIS_NO,
                                                                            PARTICIPANTS_NAME,
																			TO_CHAR(CALL_DATE,'DD-MON-YYYY ') CALL_DATE,
																			TO_CHAR (CALL_DATE, 'HH:MI:SS AM')CALL_TIME,
																			IMPACT_STATUS,
																			CUSTOMER_COMMENTS,
																			LAST_PAYMENT_AMOUNT  
																from RML_COLL_SERVICE
						  WHERE TRUNC(CALL_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')"); 
						
						  $number=0;
						  oci_execute($strSQLss);
		                  while($row1=oci_fetch_assoc($strSQLss)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row1['REF_CODE'];?></td>
							  <td><?php echo $row1['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row1['SALES_CONCERN_NAME'];?></td>
							  <td><?php echo $row1['COLL_CONCERN_NAME'];?></td>
							  <td><?php echo $row1['DELIVERY_DATE'];?></td>
							  <td><?php echo $row1['EMI_START_DATE'];?></td>
							  <td><?php echo $row1['REG_NO'];?></td>
							  <td><?php echo $row1['SALES_AMOUNT'];?></td>
							  <td><?php echo $row1['DP'];?></td>
							  <td><?php echo $row1['INSTALLMENT_NUMBER'];?></td>
							  <td><?php echo $row1['INSTALLMENT_AMOUNT'];?></td>
							  <td><?php echo $row1['RECEIVED_INSTALLMENT_NUMBER'];?></td>
							  <td><?php echo $row1['TOTAL_RECEIVED_AMOUNT'];?></td>
							  <td><?php echo $row1['NUMBER_OF_DUE'];?></td>
							  <td><?php echo $row1['DUE_AMOUNT'];?></td>
							  <td><?php echo $row1['NUMBER_OF_NOT_YET_DUE'];?></td>
							  <td><?php echo $row1['NOT_YET_DUE_AMOUNT'];?></td>
							   <td><?php echo $row1['LAST_PAYMENT_DATE'];?></td>
							  <td><?php echo $row1['LAST_PAYMENT_AMOUNT'];?></td>
							  <td><?php echo $row1['CUSTOMER_MOBILE_NO'];?></td>
							  <td><?php echo $row1['PRODUCT_TYPE'];?></td>
							  <td><?php echo $row1['CHASSIS_NO'];?></td>
							  <td><?php echo $row1['PARTICIPANTS_NAME'];?></td>
							  <td><?php echo $row1['IMPACT_STATUS'];?></td>
							  <td><?php echo $row1['CALL_DATE'];?></td>
							  <td><?php echo $row1['CALL_TIME'];?></td>
							 
							  
							  <td><?php echo $row1['CUSTOMER_COMMENTS'];?></td>
						 </tr>
						 <?php
						  }
						  }else{
						      $allDataSQL  = oci_parse($objConnect, "select CUSTOMER_NAME,
							                                                REF_CODE,
																			SALES_CONCERN_NAME,
																			COLL_CONCERN_NAME,
																			CUSTOMER_MOBILE_NO,
																			DELIVERY_DATE,
																			EMI_START_DATE,
																			REG_NO,
																			SALES_AMOUNT,
																			DP,
																			INSTALLMENT_NUMBER,
																			INSTALLMENT_AMOUNT,
																			RECEIVED_INSTALLMENT_NUMBER,
																			TOTAL_RECEIVED_AMOUNT,
																			NUMBER_OF_DUE,
																			DUE_AMOUNT,
																			NUMBER_OF_NOT_YET_DUE,
																			NOT_YET_DUE_AMOUNT,
																			LAST_PAYMENT_DATE,
																			CHASSIS_NO,
																			PRODUCT_TYPE,
                                                                            PARTICIPANTS_NAME,
																			TO_CHAR(CALL_DATE,'DD-MON-YYYY ') CALL_DATE,
																			TO_CHAR (CALL_DATE, 'HH:MI:SS AM')CALL_TIME,
																			IMPACT_STATUS,
																			CUSTOMER_COMMENTS,
																			LAST_PAYMENT_DATE,
																			LAST_PAYMENT_AMOUNT									
							  from RML_COLL_SERVICE where rownum<5");		
						    //$allDataSQL  = oci_parse($objConnect, "select sysdate from dual");		
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						    <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							   <td><?php echo $row['CUSTOMER_NAME'];?></td>
							   <td><?php echo $row['SALES_CONCERN_NAME'];?></td>
							   <td><?php echo $row['COLL_CONCERN_NAME'];?></td>
							   <td><?php echo $row['DELIVERY_DATE'];?></td>
							   <td><?php echo $row['EMI_START_DATE'];?></td>
							   <td><?php echo $row['REG_NO'];?></td>
							   <td><?php echo $row['SALES_AMOUNT'];?></td>
							   <td><?php echo $row['DP'];?></td>
							   <td><?php echo $row['INSTALLMENT_NUMBER'];?></td>
							   <td><?php echo $row['INSTALLMENT_AMOUNT'];?></td>
							   <td><?php echo $row['RECEIVED_INSTALLMENT_NUMBER'];?></td>
							   <td><?php echo $row['TOTAL_RECEIVED_AMOUNT'];?></td>
							   <td><?php echo $row['NUMBER_OF_DUE'];?></td>
							   <td><?php echo $row['DUE_AMOUNT'];?></td>
							   <td><?php echo $row['NUMBER_OF_NOT_YET_DUE'];?></td>
							   <td><?php echo $row['NOT_YET_DUE_AMOUNT'];?></td>
							   <td><?php echo $row['LAST_PAYMENT_DATE'];?></td>
							   <td><?php echo $row['LAST_PAYMENT_AMOUNT'];?></td>
							   <td><?php echo $row['CUSTOMER_MOBILE_NO'];?></td>
							   <td><?php echo $row['PRODUCT_TYPE'];?></td>
							   
							  <td><?php echo $row['CHASSIS_NO'];?></td>
							  <td><?php echo $row['PARTICIPANTS_NAME'];?></td>
							  <td><?php echo $row['IMPACT_STATUS'];?></td>
							  <td><?php echo $row['CALL_DATE'];?></td>
							  <td><?php echo $row['CALL_TIME'];?></td>
							  
							  
							  <td><?php echo $row['CUSTOMER_COMMENTS'];?></td>
						 </tr>
						 <?php
						  }
						  }
						  ?>
					</tbody>	
				 
		              </table>
					
					<div>
					<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
					</div>
				  </div>
				</div>
			
			 
				
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Service_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
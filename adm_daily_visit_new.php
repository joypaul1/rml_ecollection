<?php 
	session_start();
	$exit_status=0;
	if($_SESSION['user_role_id']== 2 || $_SESSION['user_role_id']== 8 || $_SESSION['user_role_id']== 3)
	{
		$exit_status=1;
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
          <a href="">VISIT MONITORING REPORT</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						<div class="col-sm-3"></div>
						  <div class="col-sm-3">
							 <label for="title">Select Concern:</label>
							    <select name="created_id" id="created_id" class="form-control">
								 <option selected value="">--ALL--</option>
								      <?php
									  $strSQL  = oci_parse($objConnect, 
									   "select unique CREATED_BY,
									   (SELECT B.EMP_NAME FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) EMP_NAME
										from RML_COLL_VISIT_ASSIGN BB
										order by CREATED_BY");
									  	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['CREATED_BY'];?>"><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							    </select> 
							</div>
							
						<!--
							<div class="col-sm-3">
							 <label for="title">Select Zone:</label>
							    <select name="area_zone" class="form-control">
								 <option selected value="">--ALL--</option>
								      <?php
									  $strSQL  = oci_parse($objConnect, 
									   "SELECT unique AREA_ZONE FROM
									(select (SELECT B.AREA_ZONE FROM RML_COLL_APPS_USER B WHERE B.RML_ID=BB.CREATED_BY) AREA_ZONE
									from RML_COLL_VISIT_ASSIGN BB)
									order by AREA_ZONE");
									  	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['AREA_ZONE'];?>"><?php echo $row['AREA_ZONE'];?></option>
									  <?php
									   }
									  ?>
							    </select> 
							</div>
							
							-->
							<div class="col-sm-3">
							    <label for="title">Visit From:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-3">
							    <label for="title">Visit To:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="end_date" type="date" />
							   </div>
							</div>
							
							
						</div>	
						<div class="row">
						      <div class="col-sm-9"> </div>
						      <div class="col-sm-3">
							   <label for="title">&nbsp;</label>
							   <input class="form-control btn btn-primary" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
							  </div>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					  <table class="table table-striped table-bordered table-sm table-responsive" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Collection Concern</center></th>
								  <th scope="col"><center>Zone Name</center></th>
								  <th scope="col"><center>Last Target Place</center></th>
								  <th scope="col"><center>Last Visited Place</center></th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Monthly EMI</center></th>
								  <th scope="col"><center>Collected Amount</center></th>
								  <th scope="col"><center>Target Units</center></th>
								  <th scope="col"><center>No. Of Visit</center></th>
								  <th scope="col"><center>Brand</center></th>
								  <th scope="col"><center>Last Reason Code</center></th>
								  <th scope="col"><center>Last Customer Feedback</center></th>
								 <!-- <th scope="col"><center>Next Followup Date</center></th>  -->
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$LOGIN_ID=$_SESSION['emp_id'];
						

						if(isset($_POST['start_date'])){
							$emp_id=(int)(explode("RML-",$LOGIN_ID)[1]);
						    $v_created_id = $_REQUEST['created_id'];
						    //$v_area_zone = $_REQUEST['area_zone'];
						    $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
						    $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
							
							$sqlQuery="SELECT A.REF_CODE,
										    LAST_REASON_CODE(A.REF_CODE) LAST_REASON_CODE,
											LAST_VISIT_LOCATION(A.REF_CODE,B.COLL_CONCERN_ID,'$v_start_date','$v_end_date') LAST_LOCATION,
                                            B.BRAND,
										    B.INSTALLMENT_AMOUNT,
										    B.COLL_CONCERN_NAME,
										    B.COLL_CONCERN_ID,
										    B.CUSTOMER_NAME,
										    A.TARGET_UNIT,
										   (SELECT SUM(VISIT_STATUS) FROM RML_COLL_VISIT_ASSIGN 
											  WHERE REF_ID=A.REF_CODE
											  AND TRUNC(ASSIGN_DATE) BETWEEN TO_DATE ('$v_start_date', 'dd/mm/yyyy') AND TO_DATE ('$v_end_date', 'dd/mm/yyyy')
											) NUMBER_OF_VISIT,
											(SELECT AREA_ZONE FROM RML_COLL_APPS_USER WHERE ACCESS_APP='RML_COLL' AND RML_ID= TO_NUMBER (B.COLL_CONCERN_ID)) CONCERN_ZONE,
											(SELECT (CUSTOMER_REMARKS ||'##'|| VISIT_LOCATION)  FROM RML_COLL_VISIT_ASSIGN 
													WHERE  ID=(
														   SELECT MAX(ID) FROM RML_COLL_VISIT_ASSIGN 
															WHERE REF_ID=A.REF_CODE 
															AND ASSIGN_DATE BETWEEN TO_DATE ('$v_start_date', 'dd/mm/yyyy') AND TO_DATE ('$v_end_date', 'dd/mm/yyyy')
														)) INFORMATION,
														 (SELECT  NVL(SUM(C.AMOUNT),0) FROM RML_COLL_MONEY_COLLECTION C
															WHERE C.REF_ID=A.REF_CODE 
															AND TRUNC(C.CREATED_DATE) BETWEEN TO_DATE('$v_start_date','dd/mm/yyyy') AND TO_DATE('$v_end_date','dd/mm/yyyy')) COLLECTED_AMOUNT
											FROM 
											(
											SELECT BB.REF_ID REF_CODE,
												 COUNT(BB.REF_ID) TARGET_UNIT
												FROM RML_COLL_VISIT_ASSIGN bb
												WHERE TRUNC(bb.ASSIGN_DATE) BETWEEN TO_DATE ('$v_start_date', 'dd/mm/yyyy') AND TO_DATE ('$v_end_date', 'dd/mm/yyyy')
												AND ('$v_created_id' IS NULL OR bb.CREATED_BY='$v_created_id')
												 GROUP BY BB.REF_ID
												 ) A,LEASE_ALL_INFO_ERP B
											WHERE A.REF_CODE=B.REF_CODE
											--AND B.STATUS='Y'
											";
							
							$strSQL  = oci_parse($objConnect,$sqlQuery);  
										 
								
						  oci_execute($strSQL);
						  $number=0;
						  
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++; 
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['COLL_CONCERN_NAME']."[".$row['COLL_CONCERN_ID'].']';?></td>
							  <td><?php echo $row['CONCERN_ZONE'];?></td>
							  <td><?php echo explode("##",$row['INFORMATION'])[1] ;?></td>
							 
							  <td><?php 
							            if ($row['LAST_LOCATION']=="NO LOCATON FOUND"){
											
										}else{
											$latitu=explode("##",$row['LAST_LOCATION'])[0];
										    $lng=explode("##",$row['LAST_LOCATION'])[1];
								            $url="http://www.google.com/maps/place/".$latitu.",".$lng;
										    echo '<br>';
										
							             
									?>
										  <a id="myLink" href="<?php echo $url;?>" target="_blank">View Location</a>
										  <?php 
										  }
										  ?>
							  </td>
							 
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['INSTALLMENT_AMOUNT'];?></td>
							  <td><?php echo $row['COLLECTED_AMOUNT'];?></td>
							  <td><?php echo $row['TARGET_UNIT'];?></td>
							  <td><?php echo $row['NUMBER_OF_VISIT'];?></td>
							   <td><?php echo $row['BRAND'];?></td>
							   <td><?php echo $row['LAST_REASON_CODE'];?></td>
							   <td><?php echo explode("##",$row['INFORMATION'])[0] ;?></td>
							  
							 
						  </tr>
						 <?php
			}}
						   ?>
						  
					</tbody>	
				 
		              </table>
					</div>
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
	$('#created_id').select2({
     selectOnClose: true
     });
	
	
	
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Visit Assign Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
	if($_SESSION['user_role_id']!= 11)
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
								  <th scope="col">Chassis No</th>
								  <th scope="col">Customer Name</th>
								  <th scope="col">Reg. NO</th>
								  <th scope="col">Eng No</th>
								  <th scope="col">Number of Due</th>
								  <th scope="col">Free Service No</th>
								  <th scope="col">Service Taken Position</th>		
                                  <th scope="col">Ref Code</th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col">Entry By</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						if(isset($_POST['start_date'])){
						
						  $start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                          $end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						  
						  $strSQLss  = oci_parse($objConnect, "select CUSTOMER_NAME,
						                                              CHASSIS_NO,
																	  REG_NO,
																	  ENG_NO,
																	  NUMBER_OF_DUE,
																	  FREE_SERVICE_NO,
																	  FREE_SERVICE_TAKEN,
																	  REF_CODE,
																	  ENTRY_DATE,
																	  ENTRY_BY 
																FROM RML_COLL_FREE_SERVICE
																where trunc(ENTRY_DATE) between to_date('$start_date ','dd/mm/yyyy') and to_date('$end_date ','dd/mm/yyyy')"); 
						
						  $number=0;
						  oci_execute($strSQLss);
		                  while($row=oci_fetch_assoc($strSQLss)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							   <td><?php echo $row['CHASSIS_NO'];?></td>
							   <td><?php echo $row['CUSTOMER_NAME'];?></td>
							   <td><?php echo $row['REG_NO'];?></td>
							   <td><?php echo $row['ENG_NO'];?></td>
							   <td><?php echo $row['NUMBER_OF_DUE'];?></td>
							   <td><?php echo $row['FREE_SERVICE_NO'];?></td>
							   <td>
							       <?php 
								   if($row['FREE_SERVICE_TAKEN']==1){
								        echo '1st';
								   }else if($row['FREE_SERVICE_TAKEN']==2){
								        echo '2nd';
								   }else if($row['FREE_SERVICE_TAKEN']==3){
								        echo '3rd';
								   }else if($row['FREE_SERVICE_TAKEN']==4){
								        echo '4th';
								   }else if($row['FREE_SERVICE_TAKEN']==5){
								        echo '5th';
								   }else if($row['FREE_SERVICE_TAKEN']==6){
								        echo '6th';
								   }
                                   ?>
							   </td>
							   <td><?php echo $row['REF_CODE'];?></td>
							   <td><?php echo $row['ENTRY_DATE'];?></td>
							   <td><?php echo $row['ENTRY_BY'];?></td>
						 </tr>
						 <?php
						  }
						  }else{
						      $allDataSQL  = oci_parse($objConnect, "select 
							                                            CUSTOMER_NAME,
																		CHASSIS_NO,
																		REG_NO,
																		ENG_NO,
																		NUMBER_OF_DUE,
																		FREE_SERVICE_NO,
																		FREE_SERVICE_TAKEN,
																		REF_CODE,
																		ENTRY_DATE,
																		ENTRY_BY 
																	FROM RML_COLL_FREE_SERVICE 
																	ORDER BY ID DESC,CHASSIS_NO");			
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						    <tr>
							   <td><?php echo $number;?></td>
							   <td><?php echo $row['CHASSIS_NO'];?></td>
							   <td><?php echo $row['CUSTOMER_NAME'];?></td>
							   <td><?php echo $row['REG_NO'];?></td>
							   <td><?php echo $row['ENG_NO'];?></td>
							   <td><?php echo $row['NUMBER_OF_DUE'];?></td>
							   <td><?php echo $row['FREE_SERVICE_NO'];?></td>
							   <td>
							       <?php 
								   if($row['FREE_SERVICE_TAKEN']==1){
								        echo '1st';
								   }else if($row['FREE_SERVICE_TAKEN']==2){
								        echo '2nd';
								   }else if($row['FREE_SERVICE_TAKEN']==3){
								        echo '3rd';
								   }else if($row['FREE_SERVICE_TAKEN']==4){
								        echo '4th';
								   }else if($row['FREE_SERVICE_TAKEN']==5){
								        echo '5th';
								   }else if($row['FREE_SERVICE_TAKEN']==6){
								        echo '6th';
								   }
                                   ?>
							   </td>
							   <td><?php echo $row['REF_CODE'];?></td>
							   <td><?php echo $row['ENTRY_DATE'];?></td>
							   <td><?php echo $row['ENTRY_BY'];?></td>
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
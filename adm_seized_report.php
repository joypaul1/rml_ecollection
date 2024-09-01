<?php 
	session_start();
	
	
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
          <a href="">Zone Wise Seized Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-3">
							<select name="emp_zone" class="form-control">
								 <option selected value="">Select Zone</option>
								      <?php
									   
						               $strSQL  = oci_parse($objConnect, "select distinct AREA_ZONE AS ZONE_NAME
																			from RML_COLL_APPS_USER 
																			where ACCESS_APP='RML_COLL' AND IS_ACTIVE=1 
																			order by AREA_ZONE");  
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	
									  <option value="<?php echo $row['ZONE_NAME'];?>"><?php echo $row['ZONE_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
							  
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							 <div class="col-sm-3">
							<select name="seized_status" class="form-control">
								 <option selected value="">Select Status</option>
								   <option value="1">Approved</option>	  
								   <option value="0">Pending</option>	  
							</select>
							  
							</div>
							
						</div>	
						<div class="row mt-3">
						      <div class="col-sm-3">
							 </div>
							  <div class="col-sm-3">
							 </div>
							 <div class="col-sm-3">
							 </div>
							 <div class="col-sm-3">
									<input class="form-control btn btn-primary" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
								</div>
							</div>
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col"><center>Sl</center></th>
								  <th scope="col"><center>Seized/Entry By</center></th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col"><center>REF-ID</center></th>
								  <th scope="col"><center>Driver Name</center></th>
								  <th scope="col"><center>Others Driver Name(Mobile)</center></th>
								  <th scope="col"><center>Depot Location</center></th>
							      <th scope="col"><center>Area Zone</center></th>
							      <th scope="col"><center>Total Expence</center></th>
							      <th scope="col"><center>Status</center></th>
								 
								</tr>
					   </thead>
					   <tbody>

						<?php
						@$emp_zone = $_REQUEST['emp_zone'];
						@$seized_status = $_REQUEST['seized_status'];
						@$seized_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$seized_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						
						

			if(isset($_POST['emp_zone'])){

					    $strSQL  = oci_parse($objConnect, 
						        "select B.RML_ID,
								        A.RENT_DRIVER_NAME,
										A.RENT_DRIVER_MOBILE,
								        B.EMP_NAME,
										A.REF_ID,
										A.ENTRY_DATE, 
										B.AREA_ZONE,
										A.DRIVER_NAME,
										A.DEPOT_LOCATION,
										A.IS_CONFIRM,
										A.TOTAL_EXPENSE
									FROM RML_COLL_SEIZE_DTLS a,RML_COLL_APPS_USER b
									where A.ENTRY_BY_RML_ID=b.RML_ID
									and ('$emp_zone' is null OR B.AREA_ZONE='$emp_zone')
									and ('$seized_status' is null OR A.IS_CONFIRM='$seized_status')
									and trunc(a.ENTRY_DATE) between to_date('$seized_start_date','dd/mm/yyyy') and  to_date('$seized_end_date','dd/mm/yyyy')");  									
				 
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							  <td align="center"><?php echo $row['REF_ID'];?></td>
							  <td align="center"><?php echo $row['DRIVER_NAME'];?></td>
							  <td align="center"><?php 
							                     if(strlen($row['RENT_DRIVER_NAME'])>0)
													 if(strlen($row['RENT_DRIVER_MOBILE'])>0)
														echo $row['RENT_DRIVER_NAME']."[".$row['RENT_DRIVER_MOBILE']."]"; 
													 else
							                            echo $row['RENT_DRIVER_NAME'];
							  
							  ?></td>
							  <td align="center"><?php echo $row['DEPOT_LOCATION'];?></td>
							  <td align="center"><?php echo $row['AREA_ZONE'];?></td> 
							  <td align="center"><?php echo $row['TOTAL_EXPENSE'];?></td> 
							  <td align="center"><?php 
							    if($row['IS_CONFIRM']==1){
									echo 'Confirm';
								}else
							       echo 'Pending';?>
							   </td>
						  </tr>
						 <?php
						  }
						  }
						
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
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Seized_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
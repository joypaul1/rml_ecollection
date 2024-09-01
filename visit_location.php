<?php 
	session_start();
	$exit_status=0;
	if($_SESSION['user_role_id']== 2)
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
							
							<div class="col-sm-3">
							    <label for="title">Start Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-3">
							    <label for="title">End Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="end_date" type="date" />
							   </div>
							</div>
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
					  <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								 <th scope="col"><center>Collection Concern</center></th>
								  <th scope="col"><center>Ref-Code</center></th>
								  
								  <th scope="col"><center>Reason Code</center></th>
								  <th scope="col"><center>Customer Feedback</center></th>
								  <th scope="col"><center>Visit Date</center></th>
								  <th scope="col"><center>Visit Location</center></th>
								  
								  
								  
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
				

						if(isset($_POST['start_date'])){
						    $v_created_id = $_REQUEST['created_id'];
						    $v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
						    $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
							
							$strSQL  = oci_parse($objConnect, 
										   "select (select EMP_NAME from RML_COLL_APPS_USER p where ID=RML_COLL_APPS_USER_ID) EMP_NAME,
										           REF_ID,
										           CUSTOMER_COMMENTS REASON_CODE,
												   CONCERN_COMMENTS,
												   CREATED_DATE,
												   LATITUDE,
												   LONGITUDE
												   from RML_COLL_CUST_VISIT a
                                            where a.RML_COLL_APPS_USER_ID= (select p.ID from RML_COLL_APPS_USER p where p.RML_ID='$v_created_id')
                                            and trunc(CREATED_DATE) between to_date('$v_start_date','dd/mm/yyyy') and to_date('$v_end_date','dd/mm/yyyy')");  
									 
							
									
						  oci_execute($strSQL);
						  $number=0;
						  
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++; 
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['REF_ID'];?></td>
							  <td><?php echo $row['REASON_CODE'];?></td>
							  <td><?php echo $row['CONCERN_COMMENTS'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php 
										 $lat=$row['LATITUDE'];
										 $long=$row['LONGITUDE'];
										 if($number==1){
											$golbalLat_1=$lat;
											$golbalLang_1=$long;
			
										 }else if($number==2){
											$golbalLat_2=$lat;
											$golbalLang_2=$long;
										 }

										 
										    $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=AIzaSyBDQDOeUoFxB8GptvYRk9f_lR1UFRawVO0";
											$ch = curl_init();
											curl_setopt($ch, CURLOPT_URL, $geocode);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
											curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
											curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
											curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
											$response = curl_exec($ch);
											curl_close($ch);
											$output = json_decode($response);
											$dataarray = get_object_vars($output);
											if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
												if (isset($dataarray['results'][0]->formatted_address)) {

													$address = $dataarray['results'][0]->formatted_address;
												} else {
													$address = '';

												}
											} else {
												$address = '';
											}
										echo $address;
										if($number==1)
											   {
												$firstLocationAddress=$address ;
											 }else if($number==2){
												$secondLocationAddress=$address ;
											 }
											 
										  ?>
							  </td>
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
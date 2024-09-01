<?php 
	session_start();
	$exit_status=0;
	if($_SESSION['user_role_id']== 2 || $_SESSION['user_role_id']== 8 || $_SESSION['user_role_id']== 3)
	{
		$exit_status=1;
	}
	
	if($exit_status==0){
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
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Vehicle Grade Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   
							<div class="col-sm-4">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-4">
							        <select name="vehicle_grade" class="form-control">
								      <option selected value="">Select Vehicle Grade</option>
								      <?php
									   
						               $reasonSQL  = oci_parse($objConnect, "select distinct(VEHICLE_GRADE) AS VEHICLE_GRADE from RML_COLL_IMAGES
                                                                              order by VEHICLE_GRADE");  
									   
						                oci_execute($reasonSQL);
									   while($row=oci_fetch_assoc($reasonSQL)){	
									  ?>
									  <option value="<?php echo $row['VEHICLE_GRADE'];?>"><?php echo $row['VEHICLE_GRADE'];?></option>
									  <?php
									   }
									  ?>
							       </select>
							</div>
						</div>	
						<div class="row mt-3">
                          	  
							  <div class="col-sm-4">
							  </div>
							  <div class="col-sm-4">
							  </div>
							  <div class="col-sm-4">
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
								   <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Concern Name</center></th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col"><center>Present Vehicle Grade</center></th>
								  <th scope="col"><center>Zone</center></th>
								  <th scope="col"><center>Type</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						@$visit_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$visit_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$vehicle_grade = $_REQUEST['vehicle_grade'];
						
						

			  if(isset($_POST['start_date'])){
				
							 $strSQL  = oci_parse($objConnect, 
										   "SELECT A.REF_CODE,A.PRESENT_GRADE,A.ENTRY_DATE,B.EMP_NAME,A.TYPE_COMMENTS,B.AREA_ZONE
												FROM RML_COLL_IMAGES_SUMMARY A,RML_COLL_APPS_USER B
												 where A.UPDATED_BY=B.RML_ID
												  and ('$vehicle_grade' is null OR a.PRESENT_GRADE='$vehicle_grade')
												 and trunc(a.ENTRY_DATE) between to_date('$visit_start_date','dd/mm/yyyy') and  to_date('$visit_end_date','dd/mm/yyyy')");  
					
				
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['ENTRY_DATE'];?></td>
							 <td><?php echo $row['PRESENT_GRADE'];?></td>
							 <td><?php echo $row['AREA_ZONE'];?></td>
							 <td><?php echo $row['TYPE_COMMENTS'];?></td>
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
		  elem.setAttribute("download", "Images_Uploaded_History.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
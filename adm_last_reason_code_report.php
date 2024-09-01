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
	
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Last Reason code wise report</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-3">
						    <label for="title">Select Collection Concern</label>
							    <select name="emp_concern" class="form-control">
								 <option selected value="">--</option>
								      <?php
									   
						               $strSQL  = oci_parse($objConnect, "select RML_ID,EMP_NAME from RML_COLL_APPS_USER
																				where is_active=1
																				and ACCESS_APP='RML_COLL'
																				and LEASE_USER='CC'
																				and RML_ID  NOT IN('955','713')
																				order by EMP_NAME");  
									   
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	                                  <option value="<?php echo $row['RML_ID'];?>" <?php echo (isset($_POST['emp_concern']) && $_POST['emp_concern'] == $row['RML_ID']) ? 'selected="selected"' : ''; ?>><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							    </select>
							</div>
							<div class="col-sm-3">
							    <label for="title">Select Collection Concern Zone</label>
							    <select name="emp_zone" class="form-control">
								 <option selected value="">--</option>
								      <?php
						               $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");  
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	                                  <option value="<?php echo $row['ZONE_NAME'];?>" <?php echo (isset($_POST['emp_zone']) && $_POST['emp_zone'] == $row['ZONE_NAME']) ? 'selected="selected"' : ''; ?>><?php echo $row['ZONE_NAME'];?></option>
									  <?php
									   }
									  ?>
							    </select>
							</div>
							<div class="col-sm-3">
							        <label for="title">Select Reason Code</label>
							        <select name="reason_code" class="form-control">
								      <option selected value="">--</option>
								      <?php
						               $reasonSQL  = oci_parse($objConnect, "select TITLE from RML_COLL_ALKP where PAREN_ID=1 and is_active=1");  
						               oci_execute($reasonSQL);
									   while($row=oci_fetch_assoc($reasonSQL)){	
									  ?>
									  <option value="<?php echo $row['TITLE'];?>" <?php echo (isset($_POST['reason_code']) && $_POST['reason_code'] == $row['TITLE']) ? 'selected="selected"' : ''; ?>><?php echo $row['TITLE'];?></option>
									  <?php
									   }
									  ?>
							       </select>
							</div>
						</div>	
						<div class="row mt-3">
						   
                          	<div class="col-sm-3">
							     <label for="title">Select Start Date</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-3">
							    <label for="title">Select End Date</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
							    <input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							    </div>
							</div>
							<div class="col-sm-3 mt-2">
							    <label for="title"></label>
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
								  <th scope="col"><center>Concern ID</center></th>
								  <th scope="col"><center>Concern Name</center></th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Reason Code</center></th>
								  <th scope="col"><center>Last Reason Code</center></th>
								  <th scope="col"><center>Updated Date</center></th>
								  <th scope="col"><center>Zone Name</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
						
						
						
						

			  if(isset($_POST['emp_zone'])){
				$emp_concern = $_REQUEST['emp_concern']; 
				$emp_zone = $_REQUEST['emp_zone'];
			    $reason_code = $_REQUEST['reason_code'];
				$v_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                $v_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
				
				$strSQL  = oci_parse($objConnect, 
										   "select b.RML_ID,B.EMP_NAME,A.REF_CODE,A.REASON_CODE,A.UPDATED_REASON_CODE,B.AREA_ZONE,UPDATED_DAY
											from RML_COLL_REASON_CODE_SETUP a,RML_COLL_APPS_USER b
											where A.CC_ID=B.RML_ID
											and ('$emp_concern' is null OR b.RML_ID='$emp_concern')
											and ('$emp_zone' is null OR b.AREA_ZONE='$emp_zone')
											and ('$reason_code' is null OR a.REASON_CODE='$reason_code')
											AND TRUNC(UPDATED_DAY) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') AND TO_DATE('$v_end_date','DD/MM/YYYY')
											");  
					
					
						  
						  oci_execute($strSQL);
						  $number=0;
						  $GRANT_TOTAL_TARGET=0;
						  $GRANT_TOTAL_COLLECTION=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							 <td><?php echo $row['REASON_CODE'];?></td>
							 <td><?php echo $row['UPDATED_REASON_CODE'];?></td>
							 <td><?php echo $row['UPDATED_DAY'];?></td>
							 <td><?php echo $row['AREA_ZONE'];?></td>
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
		  elem.setAttribute("download", "Reason_Code_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
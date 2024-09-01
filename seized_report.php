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
          <a href="">Zone Wise Seized Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-3">
							<select required="" name="emp_zone" class="form-control">
								 <option selected value="">Select Zone</option>
								  <option value="All">ALL</option>
								      <?php
									  
									   $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									   $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									
									  if($USER_ROLE=="ADM" || $USER_ROLE=="ALL" || $USER_ROLE=="AUDIT"){
										$strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");    
									   }else if($USER_ROLE=="AH"){
						               $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD='$USER_ID' order by ZONE");   
									   }

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
							        <select name="emp_concern" class="form-control">
								        <option selected value="">Select Concern</option>
								        <?php
									     $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									      if($USER_ROLE=="ADM"){
										  ?>
										     <option value="CC">Collection Concern</option>
										     <option value="ZH">Zonal Head</option> 
										     <option value="AH">Area Head</option>
										  <?php
										 }else if($USER_ROLE=="AUDIT"){
											  ?>
											 <option value="CC">Collection Concern</option>
										   <?php
										 }else if($USER_ROLE=="AH"){
											  ?>
											 <option value="CC">Collection Concern</option>
										     <option value="ZH">Zonal Head</option> 
										   <?php
										 }else if($USER_ROLE=="ALL"){
						                    ?>
										     <option value="CC">Collection Concern</option>
										     <option value="ZH">Zonal Head</option> 
										     <option value="AH">Area Head</option>
										  <?php
									   } ?>     
							        </select>
							</div>
							
						</div>	
						<div class="row">
							<div class="col-sm-9">
							</div>
							<div class="col-sm-3 mt-3">
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
								  <th scope="col"><center>Concern ID</center></th>
								  <th scope="col"><center>Seized By</center></th>
								  <th scope="col"><center>Start Date</center></th>
								  <th scope="col"><center>End Date</center></th>
								  <th scope="col"><center>ZH_ID</center></th>
								   <th scope="col"><center>Zone</center></th>
								  <th scope="col"><center>REF_ID</center></th>
								  <th scope="col"><center>Seized Unit</center></th>
							      <th scope="col"><center>Seized Date</center></th>
								 
								</tr>
					   </thead>
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						$user_brand_name=$_SESSION['user_brand'];
						$USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
						$USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
						
						@$emp_zone = $_REQUEST['emp_zone'];
						@$emp_concern = $_REQUEST['emp_concern'];
						@$seized_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$seized_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						
						

			if(isset($_POST['emp_zone'])){
				
				if($USER_ROLE=="ADM" || $USER_ROLE=="AUDIT"){
					if($emp_zone=='All'){
					    $strSQL  = oci_parse($objConnect, 
						        "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
								UT.ACTUAL_DEALER_ID DEALER_ID,
								UT.EMP_NAME RML_NAME,
								UT.AREA_ZONE ZONE_NAME,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
							        WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)
								)ZH_ID,
								1 TOTAL_SEIZED
									FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
								 WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
								-- AND UT.USER_FOR='$user_brand_name'
								 AND UT.LEASE_USER='CC'
								 AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$seized_start_date','dd/mm/yyyy') AND TO_DATE('$seized_end_date','dd/mm/yyyy')
								 AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
								 ORDER BY ENTRY_BY_RML_ID"); 
							 
																
				    }else {
						$strSQL  = oci_parse($objConnect, 
						       "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
								UT.ACTUAL_DEALER_ID DEALER_ID,
								UT.EMP_NAME RML_NAME,
								UT.AREA_ZONE ZONE_NAME,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
								    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)) 
								ZH_ID,
								1 TOTAL_SEIZED
									FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
								WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
								--AND UT.USER_FOR='$user_brand_name'
								AND UT.LEASE_USER='CC'
								AND UT.AREA_ZONE='$emp_zone'
								AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$seized_start_date','dd/mm/yyyy') AND TO_DATE('$seized_end_date','dd/mm/yyyy')
								AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
								    ORDER BY ENTRY_BY_RML_ID");
				                  													 			
					}
				}else if($USER_ROLE=="AH"){
					if($emp_zone=='All'){
					    $strSQL  = oci_parse($objConnect, 
						        "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
								UT.ACTUAL_DEALER_ID DEALER_ID,UT.LEASE_USER,
								UT.EMP_NAME RML_NAME,
								UT.AREA_ZONE ZONE_NAME,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
							        WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)
								)ZH_ID,
								1 TOTAL_SEIZED
									FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
								 WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
								 --AND UT.USER_FOR='$user_brand_name'
								and ('$emp_concern' is null OR UT.LEASE_USER='$emp_concern')
								 AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$seized_start_date','dd/mm/yyyy') AND TO_DATE('$seized_end_date','dd/mm/yyyy')
								 AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
								 AND AREA_ZONE IN (select distinct(ZONE_NAME) ZONE_NAME from COLL_EMP_ZONE_SETUP where IS_ACTIVE=1 and AREA_HEAD='$USER_ID')
								 ORDER BY ENTRY_BY_RML_ID");  
													
				    }else {
						$strSQL  = oci_parse($objConnect, 
						       "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
								UT.ACTUAL_DEALER_ID DEALER_ID,
								UT.EMP_NAME RML_NAME,
								UT.AREA_ZONE ZONE_NAME,UT.LEASE_USER,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
								    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)) 
								ZH_ID,
								1 TOTAL_SEIZED
									FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
								WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
								--AND UT.USER_FOR='$user_brand_name'
								and ('$emp_concern' is null OR UT.LEASE_USER='$emp_concern')
								AND UT.AREA_ZONE='$emp_zone'
								AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$seized_start_date','dd/mm/yyyy') AND TO_DATE('$seized_end_date','dd/mm/yyyy')
								AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
								    ORDER BY ENTRY_BY_RML_ID");
				                  													 			
					}
				}else if($USER_ROLE=="ALL"){
					if($emp_zone=='All'){
					    $strSQL  = oci_parse($objConnect, 
						        "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
								UT.ACTUAL_DEALER_ID DEALER_ID,
								UT.EMP_NAME RML_NAME,
								UT.AREA_ZONE ZONE_NAME,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
							        WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)
								)ZH_ID,
								1 TOTAL_SEIZED
									FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
								 WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
								 AND UT.LEASE_USER='CC'
								 AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$seized_start_date','dd/mm/yyyy') AND TO_DATE('$seized_end_date','dd/mm/yyyy')
								 AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
								 ORDER BY ENTRY_BY_RML_ID");  
																
				    }else {
						$strSQL  = oci_parse($objConnect, 
						       "SELECT ENTRY_BY_RML_ID RML_ID,REF_ID,ENTRY_DATE,UT.USER_FOR,
								UT.ACTUAL_DEALER_ID DEALER_ID,
								UT.EMP_NAME RML_NAME,
								UT.AREA_ZONE ZONE_NAME,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP
								    WHERE IS_ACTIVE=1 AND ZONE_NAME=(SELECT AREA_ZONE FROM RML_COLL_APPS_USER A WHERE A.RML_ID=ENTRY_BY_RML_ID)) 
								ZH_ID,
								1 TOTAL_SEIZED
									FROM RML_COLL_SEIZE_DTLS  SD,RML_COLL_APPS_USER UT
								WHERE SD.ENTRY_BY_RML_ID=UT.RML_ID
								AND UT.LEASE_USER='CC'
								AND UT.AREA_ZONE='$emp_zone'
								AND TRUNC(ENTRY_DATE) BETWEEN TO_DATE('$seized_start_date','dd/mm/yyyy') AND TO_DATE('$seized_end_date','dd/mm/yyyy')
								AND SD.ENTRY_BY_RML_ID NOT IN ('001','002','956','955')
								    ORDER BY ENTRY_BY_RML_ID");
				                  													 			
					}
				}
				

						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['RML_NAME'];?></td>
							 
							  <td align="center"><?php echo $seized_start_date;?></td>
							  <td align="center"><?php echo $seized_end_date;?></td>
							  <td align="center"><?php echo $row['ZH_ID'];?></td>
							  <td align="center"><?php echo $row['ZONE_NAME'];?></td>
							  <td align="center"><?php echo $row['REF_ID'];?></td>
							  <td align="center"><?php echo $row['TOTAL_SEIZED'];?></td>
							  <td align="center"><?php echo $row['ENTRY_DATE'];?></td> 
						  </tr>
						 <?php
						  }
						  ?>
						   <tr>
						      <td align="center"></td> 
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center">Grand Total:</td>
							  <td align="center"><?php echo $number;?></td>
							  <td align="center"></td>
						 </tr>
						  <?php
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
		  elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
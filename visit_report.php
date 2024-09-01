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
          <a href="">Zone Wise Visit Summary</a>
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

									   $user_brand_name=$_SESSION['user_brand'];
									   $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									   $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									   
									   if($USER_ROLE=="ADM"){
										$strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");    
									   }else if($USER_ROLE=="AH"){
						               $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD='$USER_ID' order by ZONE");   
									   }else if($USER_ROLE=="ALL" || $USER_ROLE=="AUDIT" ){
						               $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");  
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
							        <select required="" name="emp_concern" class="form-control">
								        <option selected value="">Select Concern</option>
								        <?php
									     $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									      if($USER_ROLE=="ADM" ||$USER_ROLE=="AUDIT"){
										  ?>
										     <option value="CC">Collection Concern</option>
										     <option value="ZH">Zonal Head</option> 
										     <option value="AH">Area Head</option>
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
							<div class="col-sm-3">
								<div class="md-form mt-3">
									<input class="form-control btn btn-primary" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
								</div>
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
								  <th scope="col"><center>Emp ID</center></th>
								  <th scope="col"><center>Emp Name</center></th>
								  <th scope="col"><center>Start Date</center></th>
								  <th scope="col"><center>End Date</center></th>
								  <th scope="col"><center>ZH_ID</center></th>
								  <th scope="col"><center>AH_ID</center></th>
								   <th scope="col"><center>Zone</center></th>
								  <th scope="col"><center>Visit Unit</center></th>
								  <th scope="col"><center>Regular Visit</center></th>
								  <th scope="col"><center>EMI Unit</center></th>
								  <th scope="col"><center>Total</center></th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						$user_brand_name=$_SESSION['user_brand'];
						$USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
						$USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
						
						@$emp_zone = $_REQUEST['emp_zone'];
						@$visit_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$visit_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$emp_concern = $_REQUEST['emp_concern'];
						
						

			if(isset($_POST['emp_zone'])){
			
			if($USER_ROLE=="ADM" || $USER_ROLE=="AUDIT"){
				if($emp_zone=='All'){
					$strSQL = oci_parse($objConnect, 
					           "SELECT RML_ID,
								EMP_NAME,
								ACTUAL_DEALER_ID,
								AREA_ZONE,
							    (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME=AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR ) ZH_ID, 
							    (SELECT AREA_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME= AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR) AH_ID ,
								COLL_VISIT_UNIT(RML_ID,'$visit_start_date','$visit_end_date') VISIT_UNIT,
								COLL_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) TOTAL_VISIT,
								COLL_EMI_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) EMI_VISIT
								    FROM RML_COLL_APPS_USER a
							    where ACCESS_APP='RML_COLL'
							    and RML_ID NOT IN('001','002','956','955')
							    and LEASE_USER='CC'
							    and IS_ACTIVE=1
								    ORDER BY AREA_ZONE");  										
				    }else {
						$strSQL  = oci_parse($objConnect, 
						       "SELECT RML_ID,
								EMP_NAME,
								ACTUAL_DEALER_ID,
								AREA_ZONE,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME=AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR ) ZH_ID, 
								(SELECT AREA_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME= AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR) AH_ID ,
								COLL_VISIT_UNIT(RML_ID,'$visit_start_date','$visit_end_date') VISIT_UNIT,
								COLL_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) TOTAL_VISIT,
								COLL_EMI_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) EMI_VISIT
									 FROM RML_COLL_APPS_USER
								where ACCESS_APP='RML_COLL'
								and LEASE_USER='CC'
								and RML_ID NOT IN('001','002','956','955')
								and AREA_ZONE ='$emp_zone'
								and IS_ACTIVE=1
									 ORDER BY AREA_ZONE");
		
					}
				}else if($USER_ROLE=="AH"){
					if($emp_zone=='All'){
						$strSQL = oci_parse($objConnect, 
					           "select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
										a.ZONAL_HEAD ZH_ID,
										a.AREA_HEAD AH_ID,
										COLL_VISIT_UNIT_ASSIN(a.RML_ID,'$visit_start_date','$visit_end_date',a.ZONE,b.LEASE_USER) VISIT_UNIT,
										 COLL_VISIT_COUNT(b.RML_ID,'$visit_start_date','$visit_end_date',b.LEASE_USER,b.USER_FOR) TOTAL_VISIT,
										COLL_EMI_VISIT_TOTAL(b.ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) EMI_VISIT
								FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
								where A.RML_ID=B.RML_ID
								and B.IS_ACTIVE=1
								AND  a.IS_ACTIVE=1
								and ('$emp_concern' is null OR B.LEASE_USER='$emp_concern')
								AND a.AREA_HEAD='$USER_ID'");
						
					
																
				    }else {
						
						$strSQL = oci_parse($objConnect, 
					           "select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
										a.ZONAL_HEAD ZH_ID,
										a.AREA_HEAD AH_ID,
										COLL_VISIT_UNIT_ASSIN(a.RML_ID,'$visit_start_date','$visit_end_date',a.ZONE,b.LEASE_USER) VISIT_UNIT,
										COLL_VISIT_COUNT(a.RML_ID,'$visit_start_date','$visit_end_date',b.LEASE_USER,b.USER_FOR) TOTAL_VISIT,
										COLL_EMI_VISIT_TOTAL(b.ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) EMI_VISIT
								FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
								where A.RML_ID=B.RML_ID
								and B.IS_ACTIVE=1
								AND  a.IS_ACTIVE=1
								and ('$emp_concern' is null OR B.LEASE_USER='$emp_concern')
								and a.ZONE ='$emp_zone'
								AND a.AREA_HEAD='$USER_ID'");
								
								
						
					}
				}else if($USER_ROLE=="ALL"){
					if($emp_zone=='All'){
					$strSQL = oci_parse($objConnect, 
					           "SELECT RML_ID,
								EMP_NAME,
								ACTUAL_DEALER_ID,
								AREA_ZONE,
							    (SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME=AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR ) ZH_ID, 
							    (SELECT AREA_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME= AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR) AH_ID ,
								COLL_VISIT_UNIT(RML_ID,'$visit_start_date','$visit_end_date') VISIT_UNIT,
								COLL_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) TOTAL_VISIT,
								COLL_EMI_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) EMI_VISIT
								    FROM RML_COLL_APPS_USER a
							    where ACCESS_APP='RML_COLL'
							    and RML_ID NOT IN('001','002','956','955')
							    and LEASE_USER='CC'
							    and IS_ACTIVE=1
								    ORDER BY AREA_ZONE");  
																
				    }else {
						$strSQL  = oci_parse($objConnect, 
						       "SELECT RML_ID,
								EMP_NAME,
								ACTUAL_DEALER_ID,
								AREA_ZONE,
								(SELECT ZONE_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME=AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR ) ZH_ID, 
								(SELECT AREA_HEAD FROM COLL_EMP_ZONE_SETUP WHERE ZONE_NAME= AREA_ZONE AND IS_ACTIVE=1 AND BRAND_NAME=USER_FOR) AH_ID ,
								COLL_VISIT_UNIT(RML_ID,'$visit_start_date','$visit_end_date') VISIT_UNIT,
								COLL_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) TOTAL_VISIT,
								COLL_EMI_VISIT_TOTAL(ID,TO_DATE('$visit_start_date','dd/mm/yyyy'),TO_DATE('$visit_end_date','dd/mm/yyyy')) EMI_VISIT
									 FROM RML_COLL_APPS_USER
								where ACCESS_APP='RML_COLL'
								and LEASE_USER='CC'
								and RML_ID NOT IN('001','002','956','955')
								and AREA_ZONE ='$emp_zone'
								and IS_ACTIVE=1
									 ORDER BY AREA_ZONE");
		
					}
				}
				
						  
						  
						  
						  
						  
						  oci_execute($strSQL);
						  $number=0;
						  $GRANT_ASSIGN_VISIT_UNIT=0;
						  $GRANT_EMI_VISIT_UNIT=0;
						  $GRANT_VISIT_VISIT_UNIT=0;
						  $GRANT_TOTAL_VISIT_UNIT=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php echo $visit_start_date;?></td>
							  <td align="center"><?php echo $visit_end_date;?></td>
							  <td align="center"><?php echo $row['ZH_ID'];?></td>
							  <td align="center"><?php echo $row['AH_ID'];?></td>
							  <td align="center"><?php echo $row['AREA_ZONE'];?></td>
							  <td align="center"><?php echo $row['VISIT_UNIT']; $GRANT_ASSIGN_VISIT_UNIT=$GRANT_ASSIGN_VISIT_UNIT+$row['VISIT_UNIT'];?></td>
							  <td align="center"><?php echo $row['TOTAL_VISIT'];$GRANT_VISIT_VISIT_UNIT=$GRANT_VISIT_VISIT_UNIT+$row['TOTAL_VISIT']; ?></td>
							  <td align="center"><?php echo $row['EMI_VISIT']; $GRANT_EMI_VISIT_UNIT=$GRANT_EMI_VISIT_UNIT+$row['EMI_VISIT'];?></td>
							  <td align="center"><?php echo $row['TOTAL_VISIT']+$row['EMI_VISIT']; $GRANT_TOTAL_VISIT_UNIT=$GRANT_TOTAL_VISIT_UNIT+$row['TOTAL_VISIT']+$row['EMI_VISIT'];?></td>
							 
							  
							  
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
							  <td align="center"><?php echo $GRANT_ASSIGN_VISIT_UNIT;?></td>
							  <td align="center"><?php echo $GRANT_VISIT_VISIT_UNIT;?></td>
							  <td align="center"><?php echo $GRANT_EMI_VISIT_UNIT;?></td>
							  <td align="center"><?php echo $GRANT_TOTAL_VISIT_UNIT;?></td>
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
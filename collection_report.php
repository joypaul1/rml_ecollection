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
          <a href="">Zone Wise Collection Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-3">
						         <label for="title">Select Zone:</label>
							     <select required="" name="emp_zone" class="form-control">
								  <option value="All">ALL</option>
								      <?php
									   
									   $user_brand_name=$_SESSION['user_brand'];
									   $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									   $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									   
									   if($USER_ROLE=="ADM"){
										$strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");    
									   }else if($USER_ROLE=="AH"){
						               $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD='$USER_ID' order by ZONE");   
									   }else if($USER_ROLE=="ALL"){
						               $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 order by ZONE");  
									   }else if($USER_ROLE=="AUDIT"){
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
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							<div class="col-sm-3">
							        <label for="title">Select Concern:</label>
							        <select name="emp_concern" required="" class="form-control">
								        <?php
									     $USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
									      if($USER_ROLE=="ADM"){
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
									   }else if($USER_ROLE=="AUDIT"){
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
								  <th scope="col">Sl</th>
								  <th scope="col">Concern Name</th>
								   <th scope="col">Concern Zone</th>
								  <th scope="col"><center>Start Date</center></th>
								  <th scope="col"><center>End Date</center></th>
								  <th scope="col"><center>Target(Current Month)</center></th>
								  <th scope="col"><center>Collection</center></th>
								  <th scope="col"><center>Collection(%)</center></th>
								 
								  <th scope="col"><center>User Role</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						$USER_ROLE=getUserAccessRoleByID($_SESSION['user_role_id']);
						$USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
						
						@$emp_zone = $_REQUEST['emp_zone'];
						@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$emp_concern = $_REQUEST['emp_concern'];
						
						

			if(isset($_POST['emp_zone'])){
				
				// if($USER_ROLE=="ADM" || $USER_ROLE=="AUDIT" || $USER_ROLE=="AH"){
				 if($USER_ROLE=="ADM" || $USER_ROLE=="AUDIT"){
					 
				    if($emp_zone=='All'){ 
					
					     if($emp_concern=='CC'){ 
							 $strSQL  = oci_parse($objConnect, 
										   "select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
												RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										       --(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
												b.LEASE_USER,
												COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
										FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
										where A.RML_ID=B.RML_ID
										and B.IS_ACTIVE=1
										AND  a.IS_ACTIVE=1
										AND ACCESS_APP='RML_COLL'
										and b.LEASE_USER='CC'
										ORDER BY a.CONCERN");  
				
					
						 }else if($emp_concern=='ZH'){
							 $strSQL  = oci_parse($objConnect, 
						           "select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
										RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										--(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
										b.LEASE_USER,
										COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
								FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
								where A.RML_ID=B.RML_ID
								and B.IS_ACTIVE=1
								AND  a.IS_ACTIVE=1
								AND ACCESS_APP='RML_COLL'
								and b.LEASE_USER='ZH'
								ORDER BY a.CONCERN");  
							
						 }else if($emp_concern=='AH'){
							      $strSQL  = oci_parse($objConnect, 
						           "select b.RML_ID,b.EMP_NAME,b.ACTUAL_DEALER_ID,b.AREA_ZONE,
										RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										--(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
										b.LEASE_USER,
										COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
								FROM RML_COLL_APPS_USER b
								where B.IS_ACTIVE=1
								and b.LEASE_USER='AH'
								AND ACCESS_APP='RML_COLL'
								ORDER BY b.EMP_NAME");

							   }							
				        }else{
							
							if($emp_concern=='CC'){ 
							   $strSQL  = oci_parse($objConnect, 
							        "select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
										RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										--(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
										b.LEASE_USER,
										COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
								FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
								where A.RML_ID=B.RML_ID
								and B.IS_ACTIVE=1
								AND  a.IS_ACTIVE=1
								and b.LEASE_USER='CC'
								AND ACCESS_APP='RML_COLL'
								AND a.ZONE='$emp_zone'
								ORDER BY a.CONCERN");
							 }else if($emp_concern=='ZH'){
								$strSQL  = oci_parse($objConnect, 
							        "select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
										RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										--(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
										b.LEASE_USER,
										COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
								FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
								where A.RML_ID=B.RML_ID
								and B.IS_ACTIVE=1
								AND  a.IS_ACTIVE=1
								AND ACCESS_APP='RML_COLL'
								and b.LEASE_USER='ZH'
								AND a.ZONE='$emp_zone'
								ORDER BY a.CONCERN");
							}else if($emp_concern=='AH'){
								$strSQL  = oci_parse($objConnect, 
							        "select b.RML_ID,b.EMP_NAME,b.ACTUAL_DEALER_ID ,b.AREA_ZONE,
                                        RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										--(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
                                        b.LEASE_USER,
                                        COLL_SUMOF_RECEIVED_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
                                FROM RML_COLL_APPS_USER b
                                where B.IS_ACTIVE=1
								AND ACCESS_APP='RML_COLL'
                                and b.LEASE_USER='AH'
                                AND b.AREA_ZONE='$emp_zone'
                                ORDER BY b.EMP_NAME");
								
							}									
					        }
				 
				 }else if($USER_ROLE=="AH"){
					if($emp_zone=='All'){ 
                            $sqlQuary="select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
										RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										--(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
										b.LEASE_USER,
										COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
								FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
								where A.RML_ID=B.RML_ID
								and B.IS_ACTIVE=1
								AND  a.IS_ACTIVE=1
								AND ACCESS_APP='RML_COLL'
								and ('$emp_concern' is null OR b.LEASE_USER='$emp_concern')
								AND a.AREA_HEAD='$USER_ID'
								ORDER BY a.CONCERN";
//echo $sqlQuary;								
                              $strSQL  = oci_parse($objConnect, $sqlQuary); 
								
								
				        }else{
							$strSQL  = oci_parse($objConnect, 
							        "select a.RML_ID,a.CONCERN EMP_NAME,a.DEALER_ID ACTUAL_DEALER_ID,a.ZONE AREA_ZONE,
									RML_COLL_SUMOF_TARGET(b.RML_ID,'$attn_start_date','$attn_end_date') TARGET_AMNT,
										--(SELECT COLL_SUMOF_TARGET_AMOUNT(b.RML_ID,b.LEASE_USER,b.USER_FOR) FROM DUAL) TARGET_AMNT,
										b.LEASE_USER,
										COLL_SUMOF_RECEIVED_AMOUNT(a.RML_ID,b.LEASE_USER,b.USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT
								FROM MONTLY_COLLECTION a,RML_COLL_APPS_USER b
								where A.RML_ID=B.RML_ID
								and B.IS_ACTIVE=1
								AND  a.IS_ACTIVE=1
								AND ACCESS_APP='RML_COLL'
								and ('$emp_concern' is null OR b.LEASE_USER='$emp_concern')
								AND a.AREA_HEAD='$USER_ID'
								AND a.ZONE='$emp_zone'
								ORDER BY a.CONCERN");		
					        }
				 }else if($USER_ROLE=="ALL"){
					if($emp_zone=='All'){           
					        $strSQL  = oci_parse($objConnect, 
						           "SELECT RML_ID,EMP_NAME,ACTUAL_DEALER_ID,AREA_ZONE,LEASE_USER,
								    COLL_SUMOF_TARGET(ACTUAL_DEALER_ID) TARGET_AMNT,
									COLL_SUMOF_RECEIVED_AMOUNT(RML_ID,LEASE_USER,USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT,
                                    COLL_SUMOF_LEASE(RML_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy')) LEASE_CONFIRM,
                                    COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),1) OTP_YES_AMNT,
                                    COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),0) OTP_NO_AMNT
									    FROM RML_COLL_APPS_USER
									where ACCESS_APP='RML_COLL'
									and ('$emp_concern' is null OR LEASE_USER='$emp_concern')
									--and LEASE_USER='CC'
									and RML_ID NOT IN('001','002','956','955','986','713')
									and IS_ACTIVE=1
									    ORDER BY AREA_ZONE ");  
																
				        }else{
						    $strSQL  = oci_parse($objConnect, 
							        "SELECT RML_ID,EMP_NAME,ACTUAL_DEALER_ID,AREA_ZONE,
								    COLL_SUMOF_TARGET_AMOUNT(RML_ID,LEASE_USER,USER_FOR) TARGET_AMNT ,
									COLL_SUMOF_RECEIVED_AMOUNT(RML_ID,LEASE_USER,USER_FOR,'$attn_start_date','$attn_end_date') COLLECTION_AMNT,
                                    COLL_SUMOF_LEASE(RML_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy')) LEASE_CONFIRM,
                                    COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),1) OTP_YES_AMNT,
                                    COLL_SUMOF_OTP_YES_AMNT(RML_ID,TO_DATE('$attn_start_date','dd/mm/yyyy'),TO_DATE('$attn_end_date','dd/mm/yyyy'),0) OTP_NO_AMNT
										FROM RML_COLL_APPS_USER
									where ACCESS_APP='RML_COLL'
									and AREA_ZONE='$emp_zone'
									and RML_ID NOT IN('001','002','956','955','986','713')
									and IS_ACTIVE=1
										ORDER BY AREA_ZONE");			
					        }
				 }
						  @oci_execute(@$strSQL);
						  $number=0;
						  $GRANT_TOTAL_TARGET=0;
						  $GRANT_TOTAL_COLLECTION=0;
							
		                  while($row=@oci_fetch_assoc(@$strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['EMP_NAME'].'['.$row['RML_ID'].']';?></td>
							  <td><?php echo $row['AREA_ZONE'];?></td>
							  <td align="center"><?php echo $attn_start_date;?></td>
							  <td align="center"><?php echo $attn_end_date;?></td>
							  <td align="center"><?php echo $row['TARGET_AMNT']; $GRANT_TOTAL_TARGET=$GRANT_TOTAL_TARGET+$row['TARGET_AMNT'];?></td>
							  <td align="center"><?php echo $row['COLLECTION_AMNT']; $GRANT_TOTAL_COLLECTION=$GRANT_TOTAL_COLLECTION+$row['COLLECTION_AMNT']?></td>
							  <td align="center"><?php 
							                      if($row['COLLECTION_AMNT']==0 || $row['TARGET_AMNT']==0){
								                     echo "0";
							                        }else{
													 echo ceil(($row['COLLECTION_AMNT']*100)/$row['TARGET_AMNT']);	
													}
											     ?> 
								%</td>
							
							 <td><?php echo $row['LEASE_USER'];?></td>
						  </tr>
						 <?php
						  }
						   ?>
						   <tr>
						      <td align="center"></td> 
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center"></td>
							  <td align="center">Grand Total:</td>
							  <td align="center"><?php echo $GRANT_TOTAL_TARGET;?></td>
							  <td align="center"><?php echo $GRANT_TOTAL_COLLECTION;?></td>
							  <td align="center">
							  <?php 
							   if($GRANT_TOTAL_TARGET>0 || $GRANT_TOTAL_COLLECTION>0){
							      echo ceil(($GRANT_TOTAL_COLLECTION*100)/$GRANT_TOTAL_TARGET);	
							   }else {
								   echo "0";
							   }
							  ?>
							  %</td>
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
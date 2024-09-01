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
          <a href="">Bank TT Confirm Panel</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						 
							<div class="col-sm-3">
							<label for="title"><b>TT Start Date:</b><sup style="color:red;">*</sup></label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-3">
							<label for="title"><b>TT End Date:</b><sup style="color:red;">*</sup></label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							<div class="col-sm-3">
							<label for="title"><b>Select Concern Zone:</b></label>
							     <select name="concern_zone" class="form-control">
								 <option selected value="">Select Zone</option>
								      <?php
									   
						               $strSQL  = oci_parse($objConnect, "select DISTINCT(AREA_ZONE) ZONE_NAME from RML_COLL_APPS_USER where ACCESS_APP='RML_COLL' AND LEASE_USER='CC' AND IS_ACTIVE=1 AND RML_ID NOT IN ('955','956') ORDER BY AREA_ZONE");  
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
							<label for="title"><b>Select TT Type:</b></label>
							     <select name="tt_type" class="form-control">
								 <option selected value="">Select Type</option>
								   <option value="ONLINE">ONLINE</option>
								   <option value="BEFTN">BEFTN</option>
								   <option value="RTGS">RTGS</option>
							     </select>
							</div>
						</div>	
						<div class="row">					
							<div class="col-sm-12">
								<div class="md-form mt-3">
									<input class="btn btn-primary btn pull-right form-control" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
								</div>
							</div>
						</div>
					</form>
				</div>
				
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					 <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col"><center>Select</center></th>
								  <th scope="col"><center>Sl</center></th>
								  <th scope="col"><center>TT ID</center></th>
								  <th scope="col"><center>Entry Date</center></th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Type</center></th>
								  <th scope="col"><center>TT Date</center></th>
								  <th scope="col"><center>TT Amount</center></th>
								  <th scope="col"><center>Total TT Amount</center></th>
								   <th scope="col"><center>Branch</center></th>
								  <th scope="col"><center>Concern Name</center></th>
								  <th scope="col"><center>Concern Zone</center></th>
								  <th scope="col"><center>TT Remarks</center></th>
								  
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						@$visit_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$visit_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
                        @$concern_zone=$_REQUEST['concern_zone'];
                        @$tt_type=$_REQUEST['tt_type'];
						
						

			if(isset($_POST['start_date'])){
			        
					$strSQL = oci_parse($objConnect, 
					           "SELECT TO_CHAR(a.CREATED_DATE,'dd/mm/yyyy') CREATED_DATE,a.ID,
                                 a.REF_ID,
                                 a.TT_TYPE,
                                 TO_CHAR(a.TT_DATE,'dd/mm/yyyy') TT_DATE,
                                 a.AMOUNT,
                                 a.TT_TOTAL_TAKA,
                                 UPPER(a.TT_BRANCH) TT_BRANCH,
                                 UPPER(a.TT_REMARKS) TT_REMARKS,
                                 b.emp_name  CONCERN_NAME,
                                 b.MOBILE_NO  MOBILE_NO,
                                 b.AREA_ZONE CONCERN_ZONE,
                                TO_CHAR(a.TT_CONFIRM_DATE,'dd/mm/yyyy') TT_CONFIRM_DATE,
                                 a.TT_CHECK
                         from RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER b
                        where a.RML_COLL_APPS_USER_ID=b.ID
                        AND a.PAY_TYPE = 'Bank TT'
                        AND a.BANK = 'Sonali Bank'
                        and ('$tt_type' is null OR a.TT_TYPE='$tt_type')
                        and ('$concern_zone' is null OR b.AREA_ZONE='$concern_zone')
                        AND a.TT_CHECK=0
                        AND TRUNC(a.TT_DATE)  BETWEEN TO_DATE('$visit_start_date','dd/mm/yyyy') AND TO_DATE('$visit_end_date','dd/mm/yyyy')");  
					
						  oci_execute($strSQL);
						  $number=0;
						  $grandTotaEMI_TT=0;
						  $grandTotaEMI_TOTAL_TT=0;
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>

						      <td align="center" width="2%">
								  <input type="checkbox" name="check_list[]" value="<?php echo $row['ID'];?>" 
								  >
							  </td>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['ID'];?></td>
							  <td align="center"><?php echo $row['CREATED_DATE'];?></td>
							  <td><b><?php echo $row['REF_ID'];?></b></td>
							  <td align="center"> <?php echo $row['TT_TYPE'];?></td>
							  <td align="center"><b><?php echo $row['TT_DATE'];?></b></td>
							  <td align="center">
							                     <?php echo $row['AMOUNT']; $grandTotaEMI_TT=$grandTotaEMI_TT+$row['AMOUNT'];
												 ?>
							  </td>
							  <td align="center">
							                     <?php echo $row['TT_TOTAL_TAKA']; $grandTotaEMI_TOTAL_TT=$grandTotaEMI_TOTAL_TT+$row['TT_TOTAL_TAKA'];
												 ?>
							  </td>
							  <td align="center"><?php echo $row['TT_BRANCH'];?></td>
							  <td align="center"><?php echo $row['CONCERN_NAME'];?></td>
							  <td align="center"><?php echo $row['CONCERN_ZONE'];?></td>
							  <td align="center"><?php 
							                          if($row['AMOUNT']==$row['TT_TOTAL_TAKA'])
														echo $row['TT_REMARKS'];
												      else
														echo '<span style="color:red;text-align:center;">'.$row['TT_REMARKS'].'</span>';
													      
							  ?></td>
							
							  
							  
						  </tr>
						  
                          <?php 
			                }
						  ?>
						   <tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td></td>
						    <td></td>
						  <td></td>
						  <td>Total: </td>
						  <td><?php echo $grandTotaEMI_TT;?></td>
						  <td><?php echo  $grandTotaEMI_TOTAL_TT;?></td>
						  
						
						  <td></td>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td></td>
						 </tr>
						   <tr>
							<td>
							<input class="btn btn-primary btn pull-right" type="submit" name="submit" value="Confirm"/>
								
							</td>
						   </tr>
						  <?php 
			               } 
						  ?>
						
						
					  </tbody>	
		              </table>
					</div>
					
				  </div>
				  </form>
				  
				  <?php
					if(isset($_POST['submit'])){//to run PHP script on submit
					if(!empty($_POST['check_list'])){
					// Loop to store and display values of individual checked checkbox.
					foreach($_POST['check_list'] as $TT_ID_SELECTTED){
						$strSQL = oci_parse($objConnect, 
					           "UPDATE RML_COLL_MONEY_COLLECTION SET TT_CHECK=1,TT_CONFIRM_DATE=SYSDATE
                                WHERE ID='$TT_ID_SELECTTED'");  
						
						  oci_execute($strSQL);
					echo 'Successfully Updated TT ID '.$TT_ID_SELECTTED."</br>";
					}
					}else{
						echo 'Sorry! You have not select any TT Code.';
					}
					}
				 ?>
				</div>
				
				
				
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
<?php require_once('layouts/footer.php'); ?>	
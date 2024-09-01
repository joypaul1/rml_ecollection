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
          <a href="">List</a>
        </li>
      </ol>
	  <div class="container-fluid">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
							
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Chassis No:</label>
								  <input required=""  name="cassis_no" class="form-control"  type='text' value='<?php echo isset($_POST['cassis_no']) ? $_POST['cassis_no'] : ''; ?>' />
								</div>
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
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Chassis No</center></th>
								  <th scope="col"><center>Reg No</center></th>
								  <th scope="col"><center>Eng No</center></th>
								  <th scope="col"><center>Installment Due No</center></th>
								  <th scope="col"><center>Free Service Assign No</center></th>
								  <th scope="col"><center>Free Service Taken</center></th>
								  <th scope="col"><center>Delivery Date</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['cassis_no'])){
						  $cassis_no = $_REQUEST['cassis_no'];
						  $strSQL  = oci_parse($objConnect, 
						                         "select A.CUSTOMER_NAME,
														 A.CHASSIS_NO,
														 A.REG_NO,
														 A.ENG_NO,
														 A.NUMBER_OF_DUE,
														 FEESRVNO AS FREE_SERVICE_NO,
														 (select count(b.ID) from RML_COLL_FREE_SERVICE b where b.CHASSIS_NO=a.CHASSIS_NO) AS FREE_SERVICE_TAKEN,
														 A.REF_CODE,A.DELIVERY_DATE,
														 A.SALES_AMOUNT                                                 
												 FROM lease_all_info@ERP_LINK_LIVE A 
												where A.CHASSIS_NO='$cassis_no'
													--AND  A.STATUS='Y'
													"); 
						  
						
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['CHASSIS_NO'];?></td>
							  <td><?php echo $row['REG_NO'];?></td>
							  <td><?php echo $row['ENG_NO'];?></td>
							  <td><?php echo $row['NUMBER_OF_DUE'];?></td>
							  <td><?php echo $row['FREE_SERVICE_NO'];?></td>
							  <td><?php echo $row['FREE_SERVICE_TAKEN'];?></td>
							  <td><?php echo $row['DELIVERY_DATE'];?></td>
							  <td>
							    <?php
								 if($row['FREE_SERVICE_NO']>$row['FREE_SERVICE_TAKEN']){
								 ?>
								<a href="free_service_add.php?chassis_no=<?php echo $row['CHASSIS_NO'] ?>"><?php echo '<button class="free_service_add">Add Free Service</button>';?></a>
								
								<?php
								 }else{
									 ?>
								<a href="free_service_add.php?chassis_no=<?php echo $row['CHASSIS_NO'] ?>"><?php echo '<button class="free_service_add">View Info</button>';?></a>	 
								<?php
								}
								?>
							  </td>
						 </tr>
						 <?php
						  }
						  }
						  ?>
					</tbody>	
				 
		              </table>
					</div>
					
				  </div>
				</div>
			 
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
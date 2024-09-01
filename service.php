<?php 
	session_start();
	if($_SESSION['user_role_id']!= 9 && $_SESSION['user_role_id']!= 7 && $_SESSION['user_role_id']!= 10)
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
								  <label for="title">Ref Code:</label>
								  <input  name="ref_code" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Chassis No:</label>
								  <input name="cassis_no" class="form-control"  type='text' value='<?php echo isset($_POST['cassis_no']) ? $_POST['cassis_no'] : ''; ?>' />
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Reg No:</label>
								  <input name="reg_no" class="form-control"  type='text' value='<?php echo isset($_POST['reg_no']) ? $_POST['reg_no'] : ''; ?>' />
								</div>
							</div>
							
						</div>	
						<div class="row">
							<div class="col-sm-8">
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
								  <th scope="col"><center>Ref No</center></th>
								  <th scope="col"><center>Chassis No</center></th>
								  <th scope="col"><center>Sales Amount</center></th>
								  <th scope="col"><center>Number of Due</center></th>
								  <th scope="col"><center>Free Service Assign</center></th>
								  <th scope="col"><center>Free Service Taken</center></th>
								  <th scope="col"><center>Number of Call</center></th>
								  <th scope="col"><center>DP</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['ref_code'])){
						  $ref_code = $_REQUEST['ref_code'];
						  $cassis_no = $_REQUEST['cassis_no'];
						  $reg_no = $_REQUEST['reg_no'];
						  
						  $strSQL  = oci_parse($objConnect, 
						                       "select A.CUSTOMER_NAME,
						                               A.REF_CODE,
													   A.CHASSIS_NO,
													   A.SALES_AMOUNT,
													   A.DP,
													   A.NUMBER_OF_DUE,
													   FEESRVNO AS FREE_SERVICE_NO,
													   (select count(b.ID) from RML_COLL_FREE_SERVICE b where b.CHASSIS_NO=a.CHASSIS_NO) AS FREE_SERVICE_TAKEN,
                                                      (select count(b.ID) from RML_COLL_SERVICE b where b.REF_CODE=a.REF_CODE) NUMBER_OF_CALL													   
											    FROM LEASE_ALL_INFO_ERP A --V_RML_LEASE_API@ERP_LINK_LIVE A 
						                           where (A.REF_CODE='$ref_code' OR A.CHASSIS_NO='$cassis_no') 
												   and A.STATUS='Y'
												   and A.NUMBER_OF_DUE<=4"); 
						  
						
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CHASSIS_NO'];?></td>
							  <td><?php echo $row['SALES_AMOUNT'];?></td>
							  <td><?php echo $row['NUMBER_OF_DUE'];?></td>
							  <td><?php echo $row['FREE_SERVICE_NO'];?></td>
							  <td><?php echo $row['FREE_SERVICE_TAKEN'];?></td>
							  <td><?php echo $row['NUMBER_OF_CALL'];?></td>
							  <td><?php echo $row['DP'];?></td>
							  <td>
								<a target="_blank" href="service_add.php?ref_id=<?php echo $row['REF_CODE'] ?>"><?php
								echo '<button class="service_add">Call Page</button>';
								?>
								</a>
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
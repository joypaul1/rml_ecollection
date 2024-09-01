<?php 
	session_start();
	if($_SESSION['user_role_id']!= 5)
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
          <a href="">List</a>  &nbsp;&nbsp; <a target="_blank" href="bank_noc_add.php">New</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						    <div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Ref-Code:</label>
								  <input required="" type="text" name="ref_code" class="form-control" id="title">
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
								  <th scope="col">Ref-Code</th>
								  <th scope="col">Bank Name</th>
								  <th scope="col">Customer Name</th>
								  <th scope="col">Reg-No</th>
								  <th scope="col">Chassis No</th>
								  <th scope="col">Received Date</th>
								  <th scope="col">Create Date</th>
								  <th scope="col">Bank Flag</th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['ref_code'])){
						  $ref_code = $_REQUEST['ref_code'];
						  $strSQL  = oci_parse($objConnect, "SELECT 
																ID, REF_CODE, BANK_NAME, 
																   CUSTOMER_NAME, REG_NO, CHASIS_NO, 
																   RECEIVED_DATE, CREATED_DATE,BANK_FLAG
																FROM RML_COLL_CCD_BNK_NOC_DISB
																where REF_CODE='$ref_code'"); 		
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						    <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['BANK_NAME'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['REG_NO'];?></td>
							  <td><?php echo $row['CHASIS_NO'];?></td>
							  <td><?php echo $row['RECEIVED_DATE'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['BANK_FLAG'];?></td>
							 
							 <!--
							<td align="center">
							      
							    <a target="_blank" href="user_edit.php?emp_id=<?php echo $row['RML_ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							</td>
                             -->
						 </tr>
						 <?php
						  }
						  }else{
						     $allDataSQL  = oci_parse($objConnect, "SELECT 
																ID, REF_CODE, BANK_NAME, 
																   CUSTOMER_NAME, REG_NO, CHASIS_NO, 
																   RECEIVED_DATE, CREATED_DATE,BANK_FLAG
																FROM RML_COLL_CCD_BNK_NOC_DISB"); 
									
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['BANK_NAME'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['REG_NO'];?></td>
							  <td><?php echo $row['CHASIS_NO'];?></td>
							  <td><?php echo $row['RECEIVED_DATE'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['BANK_FLAG'];?></td>
							 
							  <!--
							<td align="center">
							      
							    <a target="_blank" href="user_edit.php?emp_id=<?php echo $row['RML_ID'] ?>"><?php
								echo '<button class="edit-user">update</button>';
								?>
								</a>
							</td>
							-->

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
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
	
	
	
	// Page access
	if($_SESSION['user_role_id']!= 5 && $_SESSION['user_role_id']!= 3 && $_SESSION['user_role_id']!= 8)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
	
	
	
	/*if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}	
*/	
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
          <a href="">Report Panel-3</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   <div class="col-sm-4">
								<div class="form-group">
								  <label for="title">REF-CODE:</label>
								  <input name="ref_no" class="form-control"  type='text' value='<?php echo isset($_POST['ref_no']) ? $_POST['ref_no'] : ''; ?>' />
								</div>
							</div>
								<div class="col-sm-4">
								<label for="title">.</label>
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
								  <th scope="col"><center>Code</center></th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Customer Mobile</center></th>
								  <th scope="col"><center>Created Date</center></th>
								  <th scope="col"><center>Day Pass</center></th>
								  <th scope="col"><center>Created By</center></th>
								  <th scope="col"><center>Requester Name</center></th>
								  <th scope="col"><center>Requester Mobile</center></th>
								  <th scope="col">Status</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						@$ref_no=$_REQUEST['ref_no'];
						
						
						

			if(isset($_POST['ref_no'])){
				    
                   $strSQL  = oci_parse($objConnect, 
						   "select REF_CODE,
							CUSTOMER_NAME,
							CUSTOMER_MOBILE,
							ENTRY_BY_RML_ID,
							REQUESTER_NAME,
							REQUESTER_MOBILE,
							ENTRY_DATE,
							TRUNC (SYSDATE-ENTRY_DATE) DAY_PASS,
							NEW_SMS,
							UPDATE_SMS,
							CLOSE_SMS,
							STATUS,
							REQUEST_TYPE
							from RML_COLL_SC
							where REF_CODE='$ref_no'"); 
					
					
				  
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['CUSTOMER_MOBILE'];?></td>
							  <td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							  <td align="center"><?php echo $row['DAY_PASS'];?></td>
							  <td align="center"><?php echo $row['ENTRY_BY_RML_ID'];?></td>
							  <td align="center"><?php echo $row['REQUESTER_NAME'];?></td>
							  <td align="center"><?php echo $row['REQUESTER_MOBILE'];?></td>
							  <td><?php echo $row['REQUEST_TYPE'];?></td>
							  
							  
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
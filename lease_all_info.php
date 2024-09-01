<?php 
	session_start();
	if($_SESSION['user_role_id']!= 2 && $_SESSION['user_role_id']!= 1)
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
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								  <label for="title">Ref Code/Chassis No:</label>
								  <input name="v_refcode" class="form-control"  type='text' value='<?php echo isset($_POST['v_refcode']) ? $_POST['v_refcode'] : ''; ?>' />
							</div>
					</div>

					<div class="col-sm-3">
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
					   <table class="table table-bordered piechart-key table-responsive" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								 <th scope="col">Sl</th>
								  <th scope="col">REF_CODE</th>
								  <th scope="col">CUSTOMER_NAME</th>
								  <th scope="col">CUSTOMER_MOBILE_NO</th>
								  <th scope="col">INSTALLMENT_AMOUNT</th>
								  <th scope="col">PARTY_ADDRESS</th>
								  <th scope="col">TOTAL_EMI_AMT</th>
								  <th scope="col">TOTAL_RECEIVED_AMOUNT</th>
								  <th scope="col">LEASE_AMOUNT</th>
								  <th scope="col">COLL_CONCERN_NAME</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						if(isset($_POST['v_refcode'])){
						  $v_refcode = $_REQUEST['v_refcode'];
						  $strSQL  = oci_parse($objConnect, "select REF_CODE,
						             CUSTOMER_NAME,
									 CUSTOMER_MOBILE_NO,INSTALLMENT_AMOUNT,
									 PARTY_ADDRESS,
									 TOTAL_EMI_AMT,
									 TOTAL_RECEIVED_AMOUNT,LEASE_AMOUNT,COLL_CONCERN_NAME
									 from lease_all_info@ERP_LINK_LIVE 
									 WHERE (REF_CODE='$v_refcode' OR CHASSIS_NO='$v_refcode')"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['CUSTOMER_MOBILE_NO'];?></td>
							  <td><?php echo $row['INSTALLMENT_AMOUNT'];?></td>
							  <td><?php echo $row['PARTY_ADDRESS'];?></td>
							  <td><?php echo $row['TOTAL_EMI_AMT'];?></td>
							  <td><?php echo $row['TOTAL_RECEIVED_AMOUNT'];?></td>
							  <td><?php echo $row['LEASE_AMOUNT'];?></td>
							  <td><?php echo $row['COLL_CONCERN_NAME'];?></td>

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
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
								  <label for="title">REF CODE:</label>
								  <input name="ref_code" class="form-control"  type='text' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
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
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								 <th scope="col">RE_SALE_REFCODE</th>
								  <th scope="col">REGULAR_REFCODE</th>
								  <th scope="col">TOTAL_DP_RCV</th>
								  <th scope="col">RE_SALE_RECEIVE_DP</th>
								  <th scope="col">TOTAL_DELAY_INTEREST</th>
								  <th scope="col">RECEIVE_DELAY_INTEREST</th>
								  <th scope="col">FILE_CLOSING_FEE</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['ref_code'])){
						  $ref_code = $_REQUEST['ref_code'];
						  $strSQL  = oci_parse($objConnect, "select 
						  RE_SALE_REFCODE,
						  REGULAR_REFCODE,TOTAL_DP_RCV,RE_SALE_RECEIVE_DP,TOTAL_DELAY_INTEREST,RECEIVE_DELAY_INTEREST,FILE_CLOSING_FEE
						  from FILESUM_V@ERP_LINK_LIVE where RE_SALE_REFCODE='$ref_code'"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $row['RE_SALE_REFCODE'];?></td>
							  <td><?php echo $row['REGULAR_REFCODE'];?></td>
							  <td><?php echo $row['TOTAL_DP_RCV'];?></td>
							  <td><?php echo $row['RE_SALE_RECEIVE_DP'];?></td>
							  <td><?php echo $row['TOTAL_DELAY_INTEREST'];?></td>
							  <td><?php echo $row['RECEIVE_DELAY_INTEREST'];?></td>
							  <td><?php echo $row['FILE_CLOSING_FEE'];?></td>
							
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
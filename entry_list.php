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
								  <label for="title">Ref Code:</label>
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
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								 <th scope="col">Sl</th>
								  <th scope="col">Ref-Code</th>
								  <th scope="col">Concern Name</th>
								  <th scope="col">Collection Amnt.</th>
								  <th scope="col">Pay Type</th>
								  <th scope="col">Bank</th>
								  <th scope="col">Entry Date</th>
								  <th scope="col">Area</th>
								  <th scope="col">Action</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						if(isset($_POST['v_refcode'])){
						  $v_refcode = $_REQUEST['v_refcode'];
						  $strSQL  = oci_parse($objConnect, "SELECT 
										A.ID, 
										A.REF_ID,
                                        B.EMP_NAME, 										
										a.AMOUNT, 
										a.PAY_TYPE, a.BANK, 
										a.CREATED_DATE, 
										b.AREA_ZONE
										FROM RML_COLL_MONEY_COLLECTION A,RML_COLL_APPS_USER B 
										WHERE A.RML_COLL_APPS_USER_ID=B.ID
										AND A.REF_ID='$v_refcode'"); 
									
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['REF_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['AMOUNT'];?></td>
							  <td><?php echo $row['PAY_TYPE'];?></td>
							  <td><?php echo $row['BANK'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['AREA_ZONE'];?></td>
							  <td align="center">
								<a href="entry_list_update.php?entry_id=<?php echo $row['ID'] ?>"><?php
								 echo '<button class="branch_edit">Update Info</button>';?>
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
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
	if($_SESSION['user_role_id']== 4 || $_SESSION['user_role_id'] == 3)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
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
          <a href="">Visit Assign Dashboard[Test]</a>
        </li>
      </ol>
	   
	 
	   
	    <div class="container-fluid">
			<div class="row">
				
				
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
					  <!-- <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  -->
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col">Concern</th>
								  <th scope="col">Zonal Head</th>
								  <th scope="col">Visit Date</th>
								  <th scope="col">Ref Code</th>
								  <th scope="col">Purpose</th>
								  <th scope="col">Visit Location</th>
								  <th scope="col">Customer Name</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_id=$_SESSION['emp_id'];
						@$attn_status = $_REQUEST['attn_status'];
						@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

						  $strSQL  = oci_parse($objConnect, 
						                "SELECT 
						                        A.CREATED_BY,
						                        RML_COLL_ID_TO_NAME(A.CREATED_BY) CONCERN_NAME,
											   (SELECT C.ZONAL_HEAD FROM MONTLY_COLLECTION C WHERE C.RML_ID=A.CREATED_BY AND IS_ACTIVE=1) ZONAL_HEAD_ID,
											   A.ASSIGN_DATE,
											   A.REF_ID,
											   A.CUSTOMER_REMARKS PURPOSE,
											   A.VISIT_LOCATION,
											   A.CUSTOMER_NAME
										 FROM RML_COLL_VISIT_ASSIGN A,COLL_VISIT_ASSIGN_APPROVAL B
										WHERE A.ID=B.RML_COLL_VISIT_ASSIGN_ID"); 
						  oci_execute($strSQL);
						  $number=0;
							
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['CONCERN_NAME'].'['.$row['CREATED_BY'].']';?></td>
							  <td><?php echo $row['ZONAL_HEAD_ID'];?></td>
							  <td><?php echo $row['ASSIGN_DATE'];?></td>
							  <td><?php echo $row['REF_ID'];?></td>
							  <td><?php echo $row['PURPOSE'];?></td>
							  <td><?php echo $row['VISIT_LOCATION'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							
						 </tr>
						 <?php
						  
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
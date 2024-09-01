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
          <a href="">Reason Code List</a>
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
								  <th scope="col">Reason Code</th>
								  <th scope="col">System Keyword</th>
								  <th scope="col">Create Date</th>
								  <th scope="col">Remarks</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_id=$_SESSION['emp_id'];
						@$attn_status = $_REQUEST['attn_status'];
						@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));

						
						  
						  $strSQL  = oci_parse($objConnect, "select TITLE,KEY_WORD,CREATED_DATE,REMARKS from RML_COLL_ALKP
															where is_active=1
															and PAREN_ID=1
															ORDER BY TITLE"); 
						  oci_execute($strSQL);
						  $number=0;
							
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['TITLE'];?></td>
							  <td><?php echo $row['KEY_WORD'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['REMARKS'];?></td>
							
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
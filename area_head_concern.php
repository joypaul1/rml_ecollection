<?php 
	session_start();
	// Page access
	if($_SESSION['user_role_id']!= 3)
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
          <a href="">Your Concern List</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				
				
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					  <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Zone</center></th>
								  <th scope="col">Zonal Head</th>
								  <th scope="col"><center>Area Head</center></th>
								  <th scope="col"><center>Status</center></th>
								    <th scope="col"><center>User Type</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

				     
					 $emp_sesssion_id=$_SESSION['emp_id'];
					 $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
					 $number=0;
					 $strSQL  = oci_parse($objConnect, 
						   "select ZONE_NAME,
						           ZONE_HEAD,
								   (select EMP_NAME from RML_COLL_APPS_USER where RML_ID=ZONE_HEAD) CONCERN_NAME,
								   AREA_HEAD,
								   IS_ACTIVE,
								   USER_TYPE 
								   from COLL_EMP_ZONE_SETUP
                                  where AREA_HEAD=$USER_ID"); 
						  oci_execute($strSQL);
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['ZONE_NAME'];?></td>
							  <td><?php echo $row['CONCERN_NAME'];?></td>
							  <td align="center"><?php echo $row['AREA_HEAD'];?></td>
							  <td align="center"><?php echo $row['IS_ACTIVE'];?></td>
							  <td align="center"><?php echo $row['USER_TYPE'];?></td>
						  </tr>
						 <?php
						  }?>
						 
					</tbody>	
				 
		              </table>
					</div>
					<div>
					
					
					<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
					</div>
				  </div>
				</div>
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "SC_Summary_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
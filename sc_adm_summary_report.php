<?php 
	session_start();
	
	
	
	// Page access
	if($_SESSION['user_role_id']!= 2)
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
          <a href="">Zone Wise Sales Certificate Summary</a>
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
								   <th scope="col"><center>Sl</center></th>
								  <th scope="col"><center>Zone Name</center></th>
								  <th scope="col"><center>Request Unit</center></th>
								  <th scope="col"><center>Completed & Delivered Unit</center></th>
								  <th scope="col"><center>Pending Unit</center></th>
								  <th scope="col"><center>Pending %</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

				      
					  $strSQL  = oci_parse($objConnect, 
						   "Select AREA_ZONE,REQUESTED_UNIT,COMPLETED_UNIT,PENDING_UNIT from
									(select  b.AREA_ZONE,a.REQUEST_TYPE
									 from RML_COLL_SC a,RML_COLL_APPS_USER b 
									where A.ENTRY_BY_RML_ID=B.RML_ID and b.is_active=1
									)
									PIVOT 
									(COUNT(REQUEST_TYPE)
									   FOR REQUEST_TYPE IN ('New' REQUESTED_UNIT, 'Closed' COMPLETED_UNIT,'Updated' PENDING_UNIT)
									)ORDER BY AREA_ZONE"); 

						  oci_execute($strSQL);
						  $number=0;
						  
						  $R_UNIT=0;
						  $C_UNIT=0;
						  $P_UNIT=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
						   $reqUnit=($row['REQUESTED_UNIT']+$row['PENDING_UNIT']+$row['COMPLETED_UNIT']);
						   $compUnit=$row['COMPLETED_UNIT'];
						   $pendUnit=$reqUnit-$compUnit;
						   
						   $R_UNIT=$R_UNIT+$reqUnit;
						   $C_UNIT=$C_UNIT+$compUnit;
						   
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['AREA_ZONE'];?></td>
							  <td align="center"><?php echo $reqUnit;?></td>
							  <td align="center"><?php echo $compUnit;?></td>
							  <td align="center"><?php echo $pendUnit; ?></td>
							  <td align="center"><?php echo round(($pendUnit/$reqUnit)*100); ?> %</td>
						  </tr>
						 <?php
						  }?>
						   <tr>
						   
						  <td></td>
						  <td></td>
						  <td align="center">Grand Total: <?php echo $R_UNIT;?></td>
						  <td align="center">Grand Total: <?php echo $C_UNIT;?></td>
						  <td align="center">Grand Total: <?php echo $R_UNIT-$C_UNIT;?></td>
						  <td align="center">Grand Total: <?php echo round((($R_UNIT-$C_UNIT)/$R_UNIT)*100);?>%</td>

						 </tr>
						
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
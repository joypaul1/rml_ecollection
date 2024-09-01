<?php 
	session_start();

    $exit_status=0;
	if($_SESSION['user_role_id']== 2 || $_SESSION['user_role_id']== 8 || $_SESSION['user_role_id']== 3)
	{
		$exit_status=1;
	}
	
	if($exit_status==0){
		header('location:index.php?lmsg=true');
		exit;
	}
	/*
	if($_SESSION['user_role_id']!= 8)
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
          <a href="">Zone Base Images Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						
						  
				
				<div class="col-lg-12">
					<div class="md-form mt-3">
					 <div class="resume-item d-flex flex-column flex-md-row">
					  <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Zone</center></th>
								  <th scope="col"><center>Total Unit</center></th>
								  <th scope="col"><center>Upload Unit</center></th>
								  <th scope="col"><center>Pending Unit</center></th>
								  <th scope="col"><center>Pending %</center></th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
				      
						
							$strSQL  = oci_parse($objConnect, 
						    "select ZONE_NAME,
							        TOTAL_UNIT,
									COLL_ZONE_WISE_IMGAGE_UNIT(ZONE_NAME) AS UPLOADED_UNIT
							from COLL_EMP_ZONE_SETUP where is_active=1
		                      order by zone_name"); 
						
				  
						  oci_execute($strSQL);
						  $number=0;
						  $GRAND_TOTAL_UNIT=0;
						  $GRAND_TOTAL_UPLOADED_UNIT=0;
						  $GRAND_TOTAL_PENDING_UNIT=0;
						  $B1_TOTAL=0;
						  $B2_TOTAL=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['ZONE_NAME'];?></td>
							  <td align="center"><?php echo $row['TOTAL_UNIT']; $GRAND_TOTAL_UNIT=$GRAND_TOTAL_UNIT+$row['TOTAL_UNIT']; ?></td>
							  <td align="center"><?php echo $row['UPLOADED_UNIT']; $GRAND_TOTAL_UPLOADED_UNIT=$GRAND_TOTAL_UPLOADED_UNIT+$row['UPLOADED_UNIT'] ;?></td>
							  <td align="center"><?php echo $row['TOTAL_UNIT']-$row['UPLOADED_UNIT'];?></td>
							  <td align="center"><?php echo floor((($row['TOTAL_UNIT']-$row['UPLOADED_UNIT'])*100)/($row['TOTAL_UNIT']));?> %</td>

						  </tr>
						 <?php
						  }?>
						  <tr class="table-primary" style="font-weight:bold">
						   
						   <td></td>
						   <td align="right">Grand Total:</td>
						   <td align="center"><?php echo  $GRAND_TOTAL_UNIT;?></td>
						   <td align="center"><?php echo  $GRAND_TOTAL_UPLOADED_UNIT;?></td>
						   <td align="center"><?php echo  $GRAND_TOTAL_UNIT-$GRAND_TOTAL_UPLOADED_UNIT;?></td>
						   <td align="center"><?php echo  floor((($GRAND_TOTAL_UNIT-$GRAND_TOTAL_UPLOADED_UNIT)*100/$GRAND_TOTAL_UNIT));?> %</td>
						  
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
		  elem.setAttribute("download", "Images_Zone_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
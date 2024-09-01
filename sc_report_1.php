<?php 
	session_start();
	// Page access
	if($_SESSION['user_role_id']!= 5 && $_SESSION['user_role_id']!= 3 && $_SESSION['user_role_id']!= 8 && $_SESSION['user_role_id']!= 12)
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
          <a href="">Report Panel</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						     <div class="col-sm-4">
							    <label for="title">Request Start Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							
							<div class="col-sm-4">
							    <label for="title">Request End Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-4"> 
							     <label for="title"><br></label>
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
								  <th scope="col">Sl No</th>
								  <th scope="col"><center>Request Date</center></th>
								  <th scope="col"><center>Request Total</center></th>
								  <th scope="col"><center>L&C To ACC</center></th>
								  <th scope="col"><center>ACC To CCD</center></th>
								  <th scope="col"><center>CCD Issued</center></th>
								  <th scope="col"><center>SC Handover</center></th>
								  <th scope="col"><center>SC CAR Received</center></th>
								  <th scope="col"><center>Bank NOC Requsition to ACC</center></th>
								  <th scope="col"><center>Bank NOC Received</center></th>
								  <th scope="col"><center>Bank NOC Disbursed</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						
						
						

			           if(isset($_POST['start_date'])){
						@$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
				    
						$strSQL  = oci_parse($objConnect, 
						           "SELECT 
								        (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) REQUEST_TOTAL,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) LEASE_TO_ACC,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) ACC_TO_CCD,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.FILE_CLEAR_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) CCD_COMPLETED,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_CCD_SC_HANDOVER aa where trunc(aa.SC_HANDOVER_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) CUSTOMER_HAND_OVER,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_CCD_SC_HANDOVER aa where trunc(aa.SC_CAR_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) SC_CAR_RECEIVED,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_CCD_BNAK_NOC aa where trunc(aa.NOC_REQUISITION_CCD_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) BANK_NOC_REQUISITION_TO_ACC,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_CCD_BNAK_NOC aa where trunc(aa.NOC_RECEIVED_ACC_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) BANK_NOC_RECEIVED,
									   (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) BETWEEN TO_DATE('$start_date','DD/MM/YYYY') AND TO_DATE('$end_date','DD/MM/YYYY')) BANK_DISBURSED
							 FROM dual");
                      
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td align="center"><?php echo $_REQUEST['start_date'].'-'.$_REQUEST['end_date'];?></td>
							  <td align="center"><?php echo $row['REQUEST_TOTAL'];?></td>
							  <td align="center"><?php echo $row['LEASE_TO_ACC'];?></td>
							  <td align="center"><?php echo $row['ACC_TO_CCD'];?></td>
							  <td align="center"><?php echo $row['CCD_COMPLETED'];?></td>
							  <td align="center"><?php echo $row['CUSTOMER_HAND_OVER'];?></td>
							  <td align="center"><?php echo $row['SC_CAR_RECEIVED'];?></td>
							  <td align="center"><?php echo $row['BANK_NOC_REQUISITION_TO_ACC'];?></td>
							  <td align="center"><?php echo $row['BANK_NOC_RECEIVED'];?></td>
							  <td align="center"><?php echo $row['BANK_DISBURSED'];?></td>
							  
							  
						  </tr>
						 <?php
						  }
						  }
						
						?>
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
		  elem.setAttribute("download", "SC_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
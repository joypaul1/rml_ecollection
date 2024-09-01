<?php 
	session_start();
	// Page access
	if($_SESSION['user_role_id']!= 5 && $_SESSION['user_role_id']!= 3 && $_SESSION['user_role_id']!= 8)
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
          <a href="">SC Handover Report</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						     <div class="col-sm-3">
							    <label for="title">Start Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							
							<div class="col-sm-3">
							    <label for="title">End Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>
							<div class="col-sm-3">
							        <label for="title">Select Send/Receive</label>
							        <select name="want_type" required="" class="form-control">
								        <option selected value="">---</option>
								        <option value="All">All</option>
										<option value="1">Customer Received</option>
							        </select>
							</div>
							<div class="col-sm-3">
							      <label for="title">&nbsp;</label>
									<input class="form-control btn btn-primary" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
							</div>
							
						</div>	
						
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					  <table class="table table-striped table-bordered table-sm table-responsive" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl No</th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Product Name</center></th>
								  <th scope="col"><center>ZH Name</center></th>
								  <th scope="col"><center>ZH Area</center></th>
								  <th scope="col"><center>ZH Mobile</center></th>
								  <th scope="col"><center>Handover Date</center></th>
								  <th scope="col"><center>Handover By</center></th>
								  <th scope="col"><center>Prepared By</center></th>
								  <th scope="col"><center>Receiver Name</center></th>
								  <th scope="col"><center>Receiver Mobile</center></th>
								  <th scope="col"><center>Receive Date</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						
						
						

			           if(isset($_POST['start_date'])){
						$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        $end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
				        $v_want_type = $_REQUEST['want_type'];
						
						
						if($v_want_type=="All"){
							$strSQL  = oci_parse($objConnect, 
						           "select   b.REF_CODE,
											 b.CURRENT_PARTY_NAME,
											 b.CURRENT_PARTY_MOBILE,
											 b.MODEL_NAME,
											 a.SC_HANDOVER_DATE,
											 a.HANDOVER_ZH,
											 a.HANDOVER_AREA,
											 a.HANDOVER_MOBILE,
											 a.SC_HANDOVER_BY,
											 b.FILE_CLEAR_BY,
											 a.RECEIVER_NAME,
											 a.RECEIVER_MOBILE,
											 a.RECEIVE_DATE,
											 a.CONFIRM_BY
									 from RML_COLL_CCD_SC_HANDOVER a,RML_COLL_SC_CCD b
									where A.RML_COLL_SC_CCD_ID=b.id
									and trunc(a.SC_HANDOVER_DATE) between to_date('$start_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')");	
						}else if($v_want_type=="1"){
							$strSQL  = oci_parse($objConnect, 
						           "select   b.REF_CODE,
											 b.CURRENT_PARTY_NAME,
											 b.CURRENT_PARTY_MOBILE,
											 b.MODEL_NAME,
											 a.SC_HANDOVER_DATE,
											 a.HANDOVER_ZH,
											 a.HANDOVER_AREA,
											 a.HANDOVER_MOBILE,
											 a.SC_HANDOVER_BY,
											 b.FILE_CLEAR_BY,
											 a.RECEIVER_NAME,
											 a.RECEIVER_MOBILE,
											 a.RECEIVE_DATE,
											 a.CONFIRM_BY
									 from RML_COLL_CCD_SC_HANDOVER a,RML_COLL_SC_CCD b
									where A.RML_COLL_SC_CCD_ID=b.id
									and RECEIVER_STATUS is not null
									and trunc(a.SC_HANDOVER_DATE) between to_date('$start_date','dd/mm/yyyy') and to_date('$end_date','dd/mm/yyyy')");	
						}
						
					
                       
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CURRENT_PARTY_NAME'];?></td>
							  <td align="center"><?php echo $row['MODEL_NAME'];?></td>
							  <td align="center"><?php echo $row['HANDOVER_ZH'];?></td>
							  <td align="center"><?php echo $row['HANDOVER_AREA'];?></td>
							  <td align="center"><?php echo $row['HANDOVER_MOBILE'];?></td>
							  <td><?php echo $row['SC_HANDOVER_DATE'];?></td>
							  <td><?php echo $row['SC_HANDOVER_BY'];?></td>
							  <td><?php echo $row['FILE_CLEAR_BY'];?></td>
							  <td><?php echo $row['RECEIVER_NAME'];?></td>
							  <td><?php echo $row['RECEIVER_MOBILE'];?></td>
							  <td><?php echo $row['RECEIVE_DATE'];?></td>
							  
							  
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
		  elem.setAttribute("download", "SC_Handover_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
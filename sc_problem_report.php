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
          <a href="">SC Problem Report[Beta]</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						   
							<div class="col-sm-4">
										<div class="form-group">
										  <label for="title">REF_CODE:</label>
										  <input type="text" class="form-control"  id="title"  name="ref_code">
										</div>
									</div>
						     <div class="col-sm-4">
							    <label for="title">CCD Accept Start Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='start_date' value='<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>' />
							   </div>
							</div>
							
							<div class="col-sm-4">
							    <label for="title">CCD Accept End Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  type='date' name='end_date' value='<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>' />
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">
						   
							 <div class="col-sm-8">
									
							</div>
                          	<div class="col-sm-4">
									<input class="form-control btn btn-primary" type="submit" placeholder="Search" aria-label="Search" value="Search"> 
							</div>
							
						</div>
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					  <table class="table table-bordered" id="table" cellspacing="0" width="100%" > 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl No</th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>CCD Accept Date</center></th>
								  
								  <th scope="col"><center>Forward date</center></th>
								  <th scope="col"><center>Return Date</center></th>
								  <th scope="col"><center>Problem Type</center></th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						
						
						

			           if(isset($_POST['start_date'])){
						
						$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        $end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						$v_ref_code=$_REQUEST['ref_code'];
				    
						$strSQL  = oci_parse($objConnect, 
						           "select   REF_CODE,
											 STATUS,
											 ISSUED_DATE,
											 ISSUED_BY,
											 RESEND_DATE,
											 RESEND_BY,
											 LEASE_REMARKS,
											 REQUEST_DATE,
											 PROBLEM_LIST from 
									( 
									       select a.REF_CODE,
											 a.STATUS,
											 a.ISSUED_DATE,
											 a.ISSUED_BY,
											 a.RESEND_DATE,
											 a.RESEND_BY,
											 a.LEASE_REMARKS,
											 b.REQUEST_DATE,
											 COLL_PROBLEM_LIST(A.RML_COLL_SC_CCD_ID) PROBLEM_LIST
									           FROM RML_COLL_SC_CCD_CHECKLIST_FAIL a,RML_COLL_SC_CCD b
									           WHERE A.RML_COLL_SC_CCD_ID=b.ID
											   and ('$v_ref_code' is null or a.REF_CODE='$v_ref_code')
									           AND trunc(b.CCD_APPROVAL_DATE) BETWEEN TO_DATE('$start_date','dd/mm/yyyy') and TO_DATE('$end_date','dd/mm/yyyy')
						            )
									");
					
                        
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['REF_CODE'];?></td>
							  
							  <td><?php echo $row['REQUEST_DATE'];?></td>
							  
							  <td><?php echo $row['ISSUED_DATE'];?></td>
							  <td><?php echo $row['RESEND_DATE'];?></td>
							  <td><?php echo $row['PROBLEM_LIST'];?></td>
							  
							  
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
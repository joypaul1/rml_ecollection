<?php 
	session_start();
	// Page access
	if($_SESSION['user_role_id']!= 1)
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
          <a href="">Apps Session Data</a>
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
							        <label for="title">Select Apps</label>
							        <select name="want_type" class="form-control">
								        <option selected value="">---</option>
								        <option value="RML_SAL">Sales Apps</option>
										<option value="RML_COLL">Collection Apps</option>
										<option value="RML_WSHOP">Workshoop Apps</option>
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
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Session Date</center></th>
								  <th scope="col"><center>RML ID</center></th>
								  <th scope="col"><center>Emp-Name</center></th>
								  <th scope="col"><center>Apps Name</center></th>
								  <th scope="col"><center>Device ID</center></th>
								  <th scope="col"><center>First Login Time</center></th>
								  <th scope="col"><center>Last Login Time</center></th>
								  <th scope="col"><center>Total Apps In</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						
						
						

			           if(isset($_POST['start_date'])){
						$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        $end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
				        $v_want_type = $_REQUEST['want_type'];

						
							$strSQL  = oci_parse($objConnect, 
						           "  SELECT UNIQUE
											 TRUNC (a.SESSTION_TIME) SESSTION_DAY,
											 B.RML_ID,
											 B.EMP_NAME,
											 B.IEMI_NO DEVICE_ID,
											 b.ACCESS_APP,
											 (SELECT COUNT (ID)
												FROM APPS_USER_SESSION bb
											   WHERE bb.RML_COLL_APPS_USER_ID = A.RML_COLL_APPS_USER_ID
													 AND TRUNC (BB.SESSTION_TIME) = TRUNC (a.SESSTION_TIME))
												TOTAL_LOGIN,
											 (SELECT TO_CHAR (MIN (SESSTION_TIME), 'HH:MI:SS AM')
												FROM APPS_USER_SESSION bb
											   WHERE bb.RML_COLL_APPS_USER_ID = A.RML_COLL_APPS_USER_ID
													 AND TRUNC (BB.SESSTION_TIME) = TRUNC (a.SESSTION_TIME))
												FIRST_LOGIN,
											 (SELECT TO_CHAR (MAX (SESSTION_TIME), 'HH:MI:SS AM')
												FROM APPS_USER_SESSION bb
											   WHERE bb.RML_COLL_APPS_USER_ID = A.RML_COLL_APPS_USER_ID
													 AND TRUNC (BB.SESSTION_TIME) = TRUNC (a.SESSTION_TIME))
												LAST_LOGIN
										FROM APPS_USER_SESSION a, RML_COLL_APPS_USER b
									   WHERE A.RML_COLL_APPS_USER_ID = b.ID
									         AND ('$v_want_type' IS NULL OR b.ACCESS_APP='$v_want_type')
											 AND TRUNC (SESSTION_TIME) BETWEEN TO_DATE ('$start_date', 'DD/MM/YYYY')
																		   AND TO_DATE ('$end_date ', 'DD/MM/YYYY')
									ORDER BY B.RML_ID, SESSTION_DAY");	
						
					
                       
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['SESSTION_DAY'];?></td>
							  <td><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['ACCESS_APP'];?></td>
							  <td><?php echo $row['DEVICE_ID'];?></td>
							  <td><?php echo $row['FIRST_LOGIN'];?></td>
							  <td><?php echo $row['LAST_LOGIN'];?></td>
							  <td><?php echo $row['TOTAL_LOGIN'];?></td>
							  
							  
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
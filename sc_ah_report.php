<?php 
	session_start();
	// Page access
	if($_SESSION['user_role_id']!= 3)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
	
	
	
	/*if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
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
          <a href="">Zone With Code Wise Sales Certificate Report</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						
						    <div class="col-sm-3">
							<label for="exampleInputEmail1">Select Zone:</label>
							<select name="emp_zone" class="form-control">
								 <option selected value="ALL">All</option>
								      <?php
									   
									   $USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									   $strSQL  = oci_parse($objConnect, "select distinct(ZONE) ZONE_NAME from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD=$USER_ID order by ZONE");    
						               oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  ?>
	
									  <option value="<?php echo $row['ZONE_NAME'];?>"><?php echo $row['ZONE_NAME'];?></option>
									  <?php
									   }
									  ?>
							</select>
							  
							</div>
						
						
						
							<div class="col-sm-3">
							<label for="exampleInputEmail1">From Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date"/>
							   </div>
							</div>
							<div class="col-sm-3">
							<label for="exampleInputEmail1">To Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							<div class="col-sm-3">
							<label for="exampleInputEmail1">Select Status:</label>
								<select name="sc_status" class="form-control">
									 <option selected value="">Select Status</option>
										  <option value="New">New</option>
										  <option value="Updated">Updated</option>
										  <option value="Closed">Closed</option>
								</select>
							</div>
						</div>	
						<div class="row mt-3">
						
						     <div class="col-sm-3">
							 </div>
							 <div class="col-sm-3">
							 </div>
							 <div class="col-sm-3">
							 </div>
							 <div class="col-sm-3">
								 <input class="form-control btn btn-primary" type="submit" placeholder="Search Data" aria-label="Search" value="Search Data"> 
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
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Code</center></th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Customer Mobile</center></th>
								  <th scope="col"><center>Created Date</center></th>
								  <th scope="col"><center>Day Pass</center></th>
								  <th scope="col"><center>Created By</center></th>
								  <th scope="col"><center>Concern Zone</center></th>
								  <th scope="col"><center>Requester Name</center></th>
								  <th scope="col"><center>Requester Mobile</center></th>
								  <th scope="col">Status</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_sesssion_id=$_SESSION['emp_id'];
						$USER_ID= (int)preg_replace('/[^0-9]/', '', $_SESSION['emp_id']);
									  
						@$sc_status=$_REQUEST['sc_status'];
						@$emp_zone=$_REQUEST['emp_zone'];
						@$start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						
						

			        if(isset($_POST['sc_status'])){
				   
						if($emp_zone=="ALL"){
							$strSQL  = oci_parse($objConnect, 
						   "select a.REF_CODE,
                            a.CUSTOMER_NAME,
                            a.CUSTOMER_MOBILE,
                            B.EMP_NAME,
                            a.REQUESTER_NAME,
                            a.REQUESTER_MOBILE,
                            a.ENTRY_DATE,
                            TRUNC (SYSDATE-a.ENTRY_DATE) DAY_PASS,
                            a.STATUS,
                            a.REQUEST_TYPE,
							b.AREA_ZONE
                            from RML_COLL_SC a,RML_COLL_APPS_USER b
                            where A.ENTRY_BY_RML_ID=B.RML_ID
							and ('$sc_status' is null OR a.REQUEST_TYPE='$sc_status')
							and b.AREA_ZONE IN (select distinct(ZONE) from MONTLY_COLLECTION where IS_ACTIVE=1 and AREA_HEAD=$USER_ID)
							and trunc(a.ENTRY_DATE) between to_date('$start_date ','dd/mm/yyyy') and to_date('$end_date ','dd/mm/yyyy')"); 
							
						}else{
							$strSQL  = oci_parse($objConnect, 
						   "select a.REF_CODE,
                            a.CUSTOMER_NAME,
                            a.CUSTOMER_MOBILE,
                            B.EMP_NAME,
                            a.REQUESTER_NAME,
                            a.REQUESTER_MOBILE,
                            a.ENTRY_DATE,
                            TRUNC (SYSDATE-a.ENTRY_DATE) DAY_PASS,
                            a.STATUS,
                            a.REQUEST_TYPE,
							b.AREA_ZONE
                            from RML_COLL_SC a,RML_COLL_APPS_USER b
                            where A.ENTRY_BY_RML_ID=B.RML_ID
							and ('$sc_status' is null OR a.REQUEST_TYPE='$sc_status')
							and b.AREA_ZONE='$emp_zone'
							and trunc(a.ENTRY_DATE) between to_date('$start_date ','dd/mm/yyyy') and to_date('$end_date ','dd/mm/yyyy')"); 
						}

				  
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['CUSTOMER_MOBILE'];?></td>
							  <td align="center"><?php echo $row['ENTRY_DATE'];?></td>
							  <td align="center"><?php echo $row['DAY_PASS'];?></td>
							  <td align="center"><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php echo $row['AREA_ZONE'];?></td>
							  <td align="center"><?php echo $row['REQUESTER_NAME'];?></td>
							  <td align="center"><?php echo $row['REQUESTER_MOBILE'];?></td>
							  <td><?php echo $row['REQUEST_TYPE'];?></td>
							  
							  
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
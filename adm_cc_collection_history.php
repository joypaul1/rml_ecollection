<?php 
	session_start();
	
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
          <a href="">Concern Collection History</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						
						
						 <div class="col-sm-4">
							 <label for="title">Select Concern:</label>
							    <select required="" name="emp_ah_id" id="created_id" class="form-control">
								 <option selected value="">--ALL--</option>
								      <?php
									  $strSQL  = oci_parse($objConnect, 
									   "select EMP_NAME,RML_ID from RML_COLL_APPS_USER
                                            where IS_ACTIVE=1
                                            and LEASE_USER in('CC')
                                            and ACCESS_APP='RML_COLL'
                                            and is_active=1
											 and RML_ID not in ('955','956')
                                            order by EMP_NAME");
									  	
						                oci_execute($strSQL);
									   while($row=oci_fetch_assoc($strSQL)){	
									  
									  ?>
	
									  <option value="<?php echo $row['RML_ID'];?>"><?php echo $row['EMP_NAME'];?></option>
									  <?php
									   }
									  ?>
							    </select> 
							</div>
							<div class="col-sm-4">
							    <label for="title">Start Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required="" class="form-control"  name="start_date" type="date" />
							   </div>
							</div>
							<div class="col-sm-4">
							<label for="title">End Date:</label>
								<div class="input-group">
									<div class="input-group-addon">
									 <i class="fa fa-calendar">
									 </i>
									</div>
									<input  required=""  class="form-control" id="date" name="end_date" type="date"/>
							   </div>
							</div>
							
						</div>	
						<div class="row mt-3">
                           <div class="col-sm-4">
							  </div>
							 <div class="col-sm-4">
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
					  <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Emp ID</center></th>
								  <th scope="col"><center>Emp Name</center></th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Collection Amnt</center></th>
								  <th scope="col"><center>Collection Date</center></th>
								  <th scope="col"><center>Collection Time</center></th>
								  
								  <th scope="col"><center>Bank</center></th>
								  <th scope="col"><center>Pay Type</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
						@$attn_start_date = date("d/m/Y", strtotime($_REQUEST['start_date']));
                        @$attn_end_date = date("d/m/Y", strtotime($_REQUEST['end_date']));
						@$emp_ah_id = $_REQUEST['emp_ah_id'];
						
						

			if(isset($_POST['emp_ah_id'])){
				
				 $strSQL  = oci_parse($objConnect, 
							   "SELECT B.RML_ID,
							           b.EMP_NAME,
									   a.REF_ID,
									   AMOUNT,
									   PAY_TYPE,
									   BANK,
									   MEMO_NO,
									   INSTALLMENT_AMOUNT,
									   a.CREATED_DATE,
									   TO_CHAR(a.CREATED_DATE,'hh:mi:ssam') CREATED_TIME,
									   B.AREA_ZONE
                                from RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER b 
                                                           where a.RML_COLL_APPS_USER_ID=b.ID
                               AND trunc(a.CREATED_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')
							   and ('$emp_ah_id' is null OR b.RML_ID='$emp_ah_id')"); 

							   
						  oci_execute($strSQL);
						  $number=0;
						  
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++; 
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td align="center"><?php echo $row['RML_ID'];?></td>
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['REF_ID'];?></td>
							  <td><?php echo $row['AMOUNT'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['CREATED_TIME'];?></td>
							  <td><?php echo $row['BANK'];?></td>
							  <td><?php echo $row['PAY_TYPE'];?></td>
							 
						  </tr>
						 <?php
			}}
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
	$('#created_id').select2({
     selectOnClose: true
     });
	
	
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
<?php 
	session_start();
	if($_SESSION['user_role_id']!= 9 && $_SESSION['user_role_id']!= 7 && $_SESSION['user_role_id']!= 10)
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
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">List</a>
        </li>
      </ol>
	  <div class="container-fluid">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title">Installment Due Number:</label>
								 <select required=""  name="due_number" class="form-control">
									<option value="">Select Due Number</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title"> <br></label>
								  <input class="form-control btn btn-primary" type="submit" value="Search Data">
								</div>
							</div>
						</div>	
				
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="table" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Customer Name</center></th>
								  <th scope="col"><center>Ref No</center></th>
								  <th scope="col"><center>Chassis No</center></th>
								  <th scope="col"><center>Sales Amount</center></th>
								  <th scope="col"><center>Number of Call</center></th>
								  <th scope="col"><center>Installment of Due</center></th>
								  <th scope="col"><center>Service Assign</center></th>
								  <th scope="col"><center>Service Taken</center></th>
								  <th scope="col"><center>Action</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						if(isset($_POST['due_number'])){
						  $due_number = $_REQUEST['due_number'];
						  
						  $strSQL  = oci_parse($objConnect, 
						                       "SELECT A.CUSTOMER_NAME,
											           A.REF_CODE,
													   A.CHASSIS_NO,
													   A.SALES_AMOUNT,
													   A.DP,
													   A.NUMBER_OF_DUE,
													   A.FEESRVNO AS FREE_SERVICE_NO,
													   (select count(b.ID) from RML_COLL_FREE_SERVICE b where b.CHASSIS_NO=A.CHASSIS_NO) AS FREE_SERVICE_TAKEN,
                                                       (select count(b.ID) from RML_COLL_SERVICE b where b.REF_CODE=a.REF_CODE) NUMBER_OF_CALL													   
													FROM V_RML_LEASE_API@ERP_LINK_LIVE A
						                         WHERE A.NUMBER_OF_DUE=$due_number
												  and A.STATUS='Y'"); 
						 
						
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['CUSTOMER_NAME'];?></td>
							  <td><?php echo $row['REF_CODE'];?></td>
							  <td><?php echo $row['CHASSIS_NO'];?></td>
							  <td><?php echo $row['SALES_AMOUNT'];?></td>
							  <td><?php echo $row['NUMBER_OF_CALL'];?></td>
							  <td><?php echo $row['NUMBER_OF_DUE'];?></td>
							  <td><?php echo $row['FREE_SERVICE_NO'];?></td>
							  <td><?php echo $row['FREE_SERVICE_TAKEN'];?></td>
							  <td>
								<a target="_blank" href="service_add.php?ref_id=<?php echo $row['REF_CODE'] ?>"><?php
								echo '<button class="service_add">Action</button>';
								?>
								</a>
							  </td>
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
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Free Service Report.xls"); // Choose the file name
		  return false;
		}
	</script>
	
<?php require_once('layouts/footer.php'); ?>	
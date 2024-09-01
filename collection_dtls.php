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
	
	
	$v_brand=$_REQUEST['brand'];
	$v_user_type=$_REQUEST['user_type'];
	$v_zone=$_REQUEST['zone'];
	$attn_start_date=$_REQUEST['start_date'];
	$attn_end_date=$_REQUEST['end_date'];
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Collection=><?php echo $v_brand.'=>'.$v_user_type;?></a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">

				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					  <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%"> 
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>DSE Name</center></th>
								  <th scope="col"><center>Ref-Code</center></th>
								  <th scope="col"><center>Amnt</center></th>
								  <th scope="col"><center>Product Type</center></th>
								  <th scope="col"><center>Date</center></th>
								  <th scope="col"><center>Time</center></th>
								  <th scope="col"><center>Bank</center></th>
								  <th scope="col"><center>Pay Type</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
					
				        $strSQL  = oci_parse($objConnect, 
							   "select b.RML_ID,
							           b.EMP_NAME,
									   a.REF_ID,
									   AMOUNT,
									   a.PRODUCT_TYPE,
									   PAY_TYPE,
									   BANK,
									   MEMO_NO,
									   INSTALLMENT_AMOUNT,
									   a.CREATED_DATE,
									   TO_CHAR(a.CREATED_DATE,'hh:mi:ssam') CREATED_TIME,
									   a.AREA_ZONE
                                FROM RML_COLL_MONEY_COLLECTION a,RML_COLL_APPS_USER B 
                                    where a.RML_COLL_APPS_USER_ID=b.ID
									AND BRAND='$v_brand'
									AND B.AREA_ZONE='$v_zone'
									AND B.USER_TYPE='$v_user_type'
                                    AND trunc(a.CREATED_DATE) between to_date('$attn_start_date','dd/mm/yyyy') and to_date('$attn_end_date','dd/mm/yyyy')");
								
						  oci_execute($strSQL);
						  $number=0;
						  
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++; 
                           ?>
						   <tr>
							  <td><?php echo $number;?></td> 
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td><?php echo $row['REF_ID'];?></td>
							  <td><?php echo $row['AMOUNT'];?></td>
							  <td><?php echo $row['PRODUCT_TYPE'];?></td>
							  <td><?php echo $row['CREATED_DATE'];?></td>
							  <td><?php echo $row['CREATED_TIME'];?></td>
							  <td><?php echo $row['BANK'];?></td>
							  <td><?php echo $row['PAY_TYPE'];?></td>
						  </tr>
						 <?php
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
		  elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
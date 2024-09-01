<?php 
	session_start();
	$exit_status=0;
	if($_SESSION['user_role_id']== 2 || $_SESSION['user_role_id']== 8 || $_SESSION['user_role_id']== 3)
	{
		$exit_status=1;
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
          <a href="">Zone Visit Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						  <div class="col-sm-4">
							<div class="input-group">
							  <select name="month_name" required="" class="form-control">
								<option selected value="">Select Month</option>
								<option value="January">January 2023</option>	  
								<option value="February">February 2023</option>	  
								<option value="March">March 2023</option>	  
								<option value="April">April 2023</option>	  
								<option value="May">May 2023</option>	  
								<option value="June">June 2023</option>	  
								<option value="July">July 2023</option>	  
								<option value="August">August 2023</option>	  
								<option value="September">September 2023</option>	  
								<option value="October">October 2023</option>	  
								<option value="November">November 2023</option>	  
								<option value="December">December 2023</option>	  
							  </select>
						    </div>
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
								  <th scope="col"><center>Zone Name</center></th>
								  <th scope="col"><center>Total Visited Target</center></th>
								  <th scope="col"><center>Total Visited</center></th>
								  <th scope="col"><center>%</center></th>
								  <th scope="col"><center>Monthly Target</center></th>
								  <th scope="col"><center>Monthly Collected</center></th>
								  <th scope="col"><center>%</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						
						$LOGIN_ID=$_SESSION['emp_id'];
						$emp_id=(int)(explode("RML-",$LOGIN_ID)[1]);

						if(isset($_POST['month_name'])){
							$month_name = $_REQUEST['month_name'];
							if($month_name=='January'){
								 $attn_start_date = date("d/m/Y", strtotime('01/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('01/31/2023'));
							}else if($month_name=='February'){
								 $attn_start_date = date("d/m/Y", strtotime('02/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('02/28/2023'));
							}else if($month_name=='March'){
								 $attn_start_date = date("d/m/Y", strtotime('03/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('03/31/2023'));
							}else if($month_name=='April'){
								 $attn_start_date = date("d/m/Y", strtotime('04/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('04/30/2023'));
							}else if($month_name=='May'){
								 $attn_start_date = date("d/m/Y", strtotime('05/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('05/31/2023'));
							}else if($month_name=='June'){
								 $attn_start_date = date("d/m/Y", strtotime('06/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('06/30/2023'));
							}else if($month_name=='July'){
								 $attn_start_date = date("d/m/Y", strtotime('07/01/2023'));
								   $attn_end_date = date("d/m/Y", strtotime('07/31/2023'));
							    
							}else if($month_name=='August'){
								 $attn_start_date = date("d/m/Y", strtotime('08/01/2023'));
								   $attn_end_date = date("d/m/Y", strtotime('08/31/2023'));
							}else if($month_name=='September'){
								 $attn_start_date = date("d/m/Y", strtotime('09/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('09/30/2023'));
							}else if($month_name=='October'){
								 $attn_start_date = date("d/m/Y", strtotime('10/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('10/31/2023'));
							}else if($month_name=='November'){
								 $attn_start_date = date("d/m/Y", strtotime('11/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('11/30/2023'));
							}else if($month_name=='December'){
								 $attn_start_date = date("d/m/Y", strtotime('12/01/2023'));
							       $attn_end_date = date("d/m/Y", strtotime('12/31/2023'));
							}
							if(($_SESSION['user_role_id'] == 3)){
								 $strSQL  = oci_parse($objConnect, 
										   "SELECT  UNIQUE(B.AREA_ZONE) AS AREA_ZONE,
										            SUM(A.TARGET) TARGET,
													SUM(VISIT_UNIT) VISIT_UNIT,
													SUM(COLL_VISIT_TOTAL(B.ID,TO_DATE('$attn_start_date','DD/MM/YYYY'),TO_DATE('$attn_end_date','DD/MM/YYYY'))) TOTAL_VISITED,
												    SUM(COLL_SUMOF_COLLECTION(B.RML_ID,TO_DATE('$attn_start_date','DD/MM/YYYY'),TO_DATE('$attn_end_date','DD/MM/YYYY'))) COLLECTION_AMNT 
										 FROM MONTLY_COLLECTION A, RML_COLL_APPS_USER B
										WHERE A.RML_ID=B.RML_ID
										AND TRUNC(A.START_DATE)=TO_DATE('$attn_start_date','DD/MM/YYYY') 
                                        AND TRUNC(A.END_DATE)=TO_DATE('$attn_end_date','DD/MM/YYYY') 
										AND B.ACCESS_APP='RML_COLL'
										AND B.AREA_ZONE IN (select ZONE_NAME from COLL_EMP_ZONE_SETUP where AREA_HEAD='$emp_id')
										GROUP BY B.AREA_ZONE
										order by AREA_ZONE"); 
										
				
							}else{
							 $strSQL  = oci_parse($objConnect, 
										   "SELECT UNIQUE(B.AREA_ZONE) AS AREA_ZONE,
										            SUM(A.TARGET) TARGET,
													SUM(VISIT_UNIT) VISIT_UNIT,
													SUM(COLL_VISIT_TOTAL(B.ID,TO_DATE('$attn_start_date','DD/MM/YYYY'),TO_DATE('$attn_end_date','DD/MM/YYYY'))) TOTAL_VISITED,
												   SUM(COLL_SUMOF_COLLECTION(B.RML_ID,TO_DATE('$attn_start_date','DD/MM/YYYY'),TO_DATE('$attn_end_date','DD/MM/YYYY'))) COLLECTION_AMNT 
										 FROM MONTLY_COLLECTION A, RML_COLL_APPS_USER B
										WHERE A.RML_ID=B.RML_ID
										AND TRUNC(START_DATE)=TO_DATE('$attn_start_date','DD/MM/YYYY') 
                                        AND TRUNC(END_DATE)=TO_DATE('$attn_end_date','DD/MM/YYYY') 
										AND B.ACCESS_APP='RML_COLL'
										GROUP BY B.AREA_ZONE
										order by AREA_ZONE"); 	
							}
							
							  		
						
						 @oci_execute(@$strSQL);
						  $number=0;
						  
		                  while($row=@oci_fetch_assoc(@$strSQL)){	
						   $number++; 
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td><?php echo $row['AREA_ZONE'];?></td>
							  <td align="center"><?php echo $row['VISIT_UNIT'];?></td>
							  <td align="center"><?php echo $row['TOTAL_VISITED'];?></td>
							  <td align="center"><?php echo @round((($row['TOTAL_VISITED']*100)/$row['VISIT_UNIT']),2);?></td>
							  
							  <td align="center"><?php echo $row['TARGET'];?></td>
							  <td align="center"><?php echo $row['COLLECTION_AMNT'];?></td>
							  <td align="center"><?php echo @round((($row['COLLECTION_AMNT']*100)/$row['TARGET']),2);?></td>
							  
							 
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
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Zone Wise Visit Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	
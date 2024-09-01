<?php 
	session_start();
	if($_SESSION['user_role_id']!= 13)
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
								  <label for="title">Ref-Code/Chassis No/Reg-No/Eng-No:</label>
								  <input required=""  name="cassis_no" class="form-control"  type='text' value='<?php echo isset($_POST['cassis_no']) ? $_POST['cassis_no'] : ''; ?>' />
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
				
				
					
					 
					   
						
					   

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						if(isset($_POST['cassis_no'])){
						  $cassis_no = $_REQUEST['cassis_no'];
						  $strSQL  = oci_parse($objConnect, 
						                         "SELECT 
                                                       REF_CODE, 
													   CUSTOMER_NAME, 
													   CUSTOMER_MOBILE_NO, 
													   PARTY_ADDRESS, 
													   REG_NO, 
													   ENG_NO,  
													   CHASSIS_NO, 
													   SALES_AMOUNT, 
													   DP,
                                                       (select F_ERP.RE_SALE_RECEIVE_DP from FILESUM_ERP F_ERP where F_ERP.RE_SALE_REFCODE=REF_CODE) RECEIVE_DP,													   
                                                       (select F_ERP.TOTAL_DELAY_INTEREST from FILESUM_ERP F_ERP where F_ERP.RE_SALE_REFCODE=REF_CODE) TOTAL_DELAY_INTEREST,													   
													   LEASE_AMOUNT, 
													   INSTALLMENT_AMOUNT, 
													   TOTAL_EMI_AMT, 
													   TOTAL_RECEIVED_AMOUNT, 
													   NUMBER_OF_DUE, 
													   DUE_AMOUNT, 
													   NUMBER_OF_NOT_YET_DUE, 
													   NOT_YET_DUE_AMOUNT, 
													   LAST_PAYMENT_AMOUNT, 
													   LAST_PAYMENT_DATE, 
													   STATUS, CLSDATE, 
													   COLL_CONCERN_ID, 
													   COLL_CONCERN_NAME, 
													   DELIVERY_DATE, 
													   PRODUCT_TYPE, 
													   PRODUCT_CODE_NAME,
                                                       BRAND,
                                                       ZONE,
                                                       DISTIC,													   
													   FEESRVNO, 
													   PAMTMODE
													FROM LEASE_ALL_INFO_ERP 
												where (CHASSIS_NO='$cassis_no' OR 
												       REG_NO='$cassis_no' OR 
													   ENG_NO='$cassis_no' OR
                                                       REF_CODE='$cassis_no' )
													"); 
						  oci_execute($strSQL);
						  $number=0;
							
		                  while($row=oci_fetch_assoc($strSQL)){	
						   $number++;
						   
						   if($row['STATUS']=='N'){
							 $v_file_status= "Closed"; 
						   }else{
							 $v_file_status= "Open";  
						   }
						   
						   
                           ?>
						   
						    <div class="col-lg-12">
							<div class="md-form mt-5">
							<div class="resume-item d-flex flex-column flex-md-row">




                                <div class="row">
								<div class="col-sm-4">
								    <table class="table table-bordered piechart-key" id="admin_list" style="width:100%"> 
									 <thead class="thead-dark">
									 <tr>
								       <th scope="col"><center>Customer Info</center></th>
								     </tr>
									 </thead>
									 <tr>
						                <td>
										<?php 
										 echo '<i style="color:red;"><b>Name: </b></i>'.$row['CUSTOMER_NAME'];
										 echo '<br>';
										 echo '<i style="color:red;"><b>Mobile: </b></i>'.$row['CUSTOMER_MOBILE_NO'];
										 echo '<br>';
										 echo '<i style="color:red;"><b>Address: </b></i>'.$row['PARTY_ADDRESS'];
										 echo '<br>';
										 echo '<i style="color:red;"><b>District: </b></i>'.$row['DISTIC'];
										 echo '<br>';
										 echo '<i style="color:red;"><b>Zone: </b></i>'.$row['ZONE'];
										 echo '<br>';
										 echo '<i style="color:red;"><b>File Status: </b></i>'.$v_file_status;
										 echo '<br>';
										 echo '<i style="color:red;"><b>Collection Concern: </b></i>'.$row['COLL_CONCERN_NAME'];
										?>
										</td>
										
						             </tr>
                                    </table>									
								</div>
								
								<div class="col-sm-4">
								    <table class="table table-bordered piechart-key" id="admin_list" style="width:100%"> 
									 <thead class="thead-dark">
									 <tr>
								       <th scope="col"><center>Product Info</center></th>
								     </tr>
									 </thead>
									 <tr>
						                <td>
										<?php 
										     echo '<i style="color:red;"><b>Ref-No: </b></i>'.$row['REF_CODE'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Chas-No: </b></i>'.$row['CHASSIS_NO'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Eng-No: </b></i>'.$row['ENG_NO'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Reg-No: </b></i>'.$row['REG_NO'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Product: </b></i>'.$row['PRODUCT_CODE_NAME'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Brand: </b></i>'.$row['BRAND'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Delivery Date: </b></i>'.$row['DELIVERY_DATE'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Cash/Credit: </b></i>'.$row['PAMTMODE'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Delay Interest: </b></i>'.$row['TOTAL_DELAY_INTEREST'];
										?>
										</td>
						             </tr>
                                    </table>									
								</div>
								
								
								<div class="col-sm-4">
								    <table class="table table-bordered piechart-key" id="admin_list" style="width:100%"> 
									 <thead class="thead-dark">
									 <tr>
								       <th scope="col"><center>Sales Info-1</center></th>
								     </tr>
									 </thead>
									 <tr>
						                <td>
										<?php 
										     echo '<i style="color:red;"><b>S.Price: </b></i>'.$row['SALES_AMOUNT'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>L.Amnt: </b></i>'.$row['LEASE_AMOUNT'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>DP: </b></i>'.$row['DP'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>DP Received: </b></i>'.$row['RECEIVE_DP'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>EMI: </b></i>'.$row['INSTALLMENT_AMOUNT'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>EMI Received: </b></i>'.$row['TOTAL_RECEIVED_AMOUNT'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Due-No: </b></i>'.$row['NUMBER_OF_DUE'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Due-Amount: </b></i>'.$row['DUE_AMOUNT'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Last Payment Amnt.: </b></i>'.$row['LAST_PAYMENT_AMOUNT'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>Last Payment Date.: </b></i>'.$row['LAST_PAYMENT_DATE'];
											 echo '<br>';
											 echo '<i style="color:red;"><b>NYDA: </b></i>'.$row['NOT_YET_DUE_AMOUNT'];
											 
										?>
										</td>
						             </tr>
                                    </table>									
								</div>
								<div class="col-sm-4">
								    <table class="table table-bordered piechart-key" id="admin_list" style="width:100%"> 
									 <thead class="thead-dark">
									 
									 </thead>
									 <tr>
						               <td>
										 <a href="call_customer_add.php?chassis_no=<?php echo $row['CHASSIS_NO'] ?>"><?php echo '<button class="free_service_add">Add Info</button>';?></a>
									     </td>
						             </tr>
                                    </table>									
								</div>
								</div>
									
						    </div>	
						    </div>	
							</div>
						 
							
						 <?php
						  }
						  }
						  ?>
					
					
					
				  
				
			 
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
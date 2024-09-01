<?php 
	session_start();
	if($_SESSION['user_role_id']!= 5)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
	
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	$sc_id=$_REQUEST['sc_id'];	
	
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Closing Approval Sheet</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
			<script type="text/javascript">	
							function getPDF(){

						var HTML_Width = $(".canvas_div_pdf").width();
						var HTML_Height = $(".canvas_div_pdf").height();
						var top_left_margin = 15;
						var PDF_Width = HTML_Width+(top_left_margin*2);
						var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
						var canvas_image_width = HTML_Width;
						var canvas_image_height = HTML_Height;
						
						var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;
						

						html2canvas($(".canvas_div_pdf")[0],{allowTaint:true}).then(function(canvas) {
							canvas.getContext('2d');
							
							console.log(canvas.height+"  "+canvas.width);
							
							
							var imgData = canvas.toDataURL("image/jpeg", 1.0);
							var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
							pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
							
							
							for (var i = 1; i <= totalPDFPages; i++) { 
								pdf.addPage(PDF_Width, PDF_Height);
								pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
							}
							
							pdf.save("Closing Approval Sheet.pdf");
						});
					};
                       function printDiv(divName){
							 var printContents = document.getElementById(divName).innerHTML;
							 var originalContents = document.body.innerHTML;
							 

							 document.body.innerHTML = printContents;
							 window.print();
							 document.body.innerHTML = originalContents;
						}										
					</script>	
            <?php
				$strSQL  = oci_parse($objConnect, "SELECT 
									   ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   CURRENT_PARTY_ADDRS, 
									   MODEL_NAME, 
									   INSTALLMENT_RECEIVED, 
									   SALES_AMOUNT, 
									   DP, 
									   FIRST_PARTY_NAME, 
									   FIRST_PARTY_DP, 
									   FRIST_PARTY_INSTALLMENT_REC, 
									   RESOLED_DP, 
									   RESOLED_RECEIVED, 
									   RECEIVABLE, 
									   DISCOUNT, 
									   RECEIVED, 
									   CLOSING_DATE, 
									   RESALE_APPROVAL_DATE, 
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   CLOSING_FEE,
									   BRTA_LOCATION,
									   RESPONSIBLE_PERSON,
									   RESPONSIBLE_DESIGNATION,
									   CUSTOMER_SO,
									   BANK_ID,
									   (select BANK_NAME from RML_COLL_CCD_BANK where ID=BANK_ID) AS BANK_NAME,
									   (select BANK_ADDRESS from RML_COLL_CCD_BANK where ID=BANK_ID) AS BANK_ADDRESS,
									   ENG_NO,CHASSIS_NO,REG_NO,
									   SYSDATE AS CURRENT_DATA_TIME,
									   FATHER_OR_HUSBAND_NAME,
									   LEASE_REMARKS,ACCOUNTS_REMARKS
									FROM RML_COLL_SC_CCD
									where ID='$sc_id'");
                 oci_execute($strSQL);	
                 while($row=oci_fetch_assoc($strSQL)){					
					$V_REF_CODE=$row['REF_CODE']; 
						$V_CURRENT_PARTY_NAME=$row['CURRENT_PARTY_NAME']; 
						$V_CURRENT_PARTY_MOBILE=$row['CURRENT_PARTY_MOBILE'];  
						$V_CURRENT_PARTY_ADDRS=$row['CURRENT_PARTY_ADDRS'];  
						$V_MODEL_NAME=$row['MODEL_NAME'];  
						$V_INSTALLMENT_RECEIVED=$row['INSTALLMENT_RECEIVED'];  
						$V_SALES_AMOUNT=$row['SALES_AMOUNT']; 
						$V_DP=$row['DP'];  
						$V_FIRST_PARTY_NAME=$row['FIRST_PARTY_NAME'];  
						$V_FIRST_PARTY_DP=$row['FIRST_PARTY_DP'];  
						$V_FRIST_PARTY_INSTALLMENT_REC=$row['FRIST_PARTY_INSTALLMENT_REC'];  
						$V_RESOLED_DP=$row['RESOLED_DP'];  
						$V_RESOLED_RECEIVED=$row['RESOLED_RECEIVED'];  
						$V_RECEIVABLE=$row['RECEIVABLE'];  
						$V_DISCOUNT=$row['DISCOUNT'];  
						$V_RECEIVED=$row['RECEIVED'];  
						$V_CLOSING_DATE=$row['CLOSING_DATE'];  
						$V_RESALE_APPROVAL_DATE=$row['RESALE_APPROVAL_DATE'];  
						$V_REQUEST_DATE=$row['REQUEST_DATE'];  
						$V_REQUEST_BY=$row['REQUEST_BY'];  
						$V_REQUESTER_NAME=$row['REQUESTER_NAME']; 
						$V_REQUESTER_MOBILE=$row['REQUESTER_MOBILE'];  
						$V_LEASE_APPROVAL_STATUS=$row['LEASE_APPROVAL_STATUS'];  
						$V_LEASE_APPROVAL_DATE=$row['LEASE_APPROVAL_DATE'];  
						$V_LEASE_APPROVAL_BY=$row['LEASE_APPROVAL_BY'];  
						$V_ACC_APPROVAL_DATE=$row['ACC_APPROVAL_DATE'];  
						$V_ACC_APPROVAL_BY=$row['ACC_APPROVAL_BY']; 
						$V_ACC_APPROVAL_STATUS=$row['ACC_APPROVAL_STATUS'];  
						$V_CCD_APPROVAL_DATE=$row['CCD_APPROVAL_DATE'];  
						$V_CCD_APPROVAL_BY=$row['CCD_APPROVAL_BY'];  
						$V_CCD_APPROVAL_STATUS=$row['CCD_APPROVAL_STATUS'];  
						$V_FILE_CLEAR_STATUS=$row['FILE_CLEAR_STATUS']; 
						$V_CLOSING_FEE=$row['CLOSING_FEE']; 
						$V_BRTA_LOCATION=$row['BRTA_LOCATION']; 
						$V_RESPONSIBLE_PERSON=$row['RESPONSIBLE_PERSON']; 
						$V_RESPONSIBLE_DESIGNATION=$row['RESPONSIBLE_DESIGNATION']; 
						$V_CUSTOMER_SO=$row['CUSTOMER_SO']; 
						$V_BANK_ID=$row['BANK_ID']; 
						$V_ENG_NO=$row['ENG_NO']; 
						$V_CHASSIS_NO=$row['CHASSIS_NO']; 
						$V_REG_NO=$row['REG_NO']; 
						$V_SYSDATE=$row['CURRENT_DATA_TIME']; 
						$V_BANK_NAME=$row['BANK_NAME']; 
						$V_BANK_ADDRESS=$row['BANK_ADDRESS']; 
						$V_FATHER_OR_HUSBAND_NAME=$row['FATHER_OR_HUSBAND_NAME']; 
						$LEASE_REMARKS=$row['LEASE_REMARKS']; 
						$ACCOUNTS_REMARKS=$row['ACCOUNTS_REMARKS']; 
							}
                           ?>
						   
						   
						   
		   <button type="button" class="btn btn-success" onclick="getPDF();">Download PDF</button>
		   &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-success" onclick="printDiv('printableArea')" value="Print" />
		   <div class="col-lg-12 border border border-dark">
				<div class="md-form mt-2 canvas_div_pdf"  id="printableArea">
		
				<div class="row">
					<div class="col-lg-12">
						<div class="row mt-3 text-uppercase d-flex justify-content-center">
							<h3><b>RANGS MOTORS LIMITED</b></h3>
					   </div>
					   <div class="row text-uppercase d-flex justify-content-center">
							<h6>117/A,Lavel-04,Old Airport Road,Bijoy Sharani,</h6>
					   </div>
					   <div class="row text-uppercase d-flex justify-content-center">
							<h6>Tejgoan,Dhaka-1215</h6>
					   </div>
					   <div class="row mt-3 mt-3 text-uppercase d-flex justify-content-center text-decoration-underline">
							<h5><b>Closing Approval Sheet</b><h5>
					   </div>
					
					<div class="col-sm-12 input-lg">
						<b>01. RML Code No:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_REF_CODE;?>" >
					</div>
					
						<div class="col-sm-12 mt-3 input-lg">
							  <b>02. Customer Name</b>(First Party):&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_FIRST_PARTY_NAME;?>" >
						</div>
							<div class="col-sm-12 mt-2 input-lg">
								  <b>03. Customer Name</b>(Current Party):&nbsp;&nbsp;&nbsp;
								  <input class="input-lg" style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_CURRENT_PARTY_NAME;?>" >
							</div>
							
							<div class="col-sm-12 mt-2">
								  <b>04. Present & Permanent Address</b>:&nbsp;&nbsp;<br>
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
								  <textarea  rows="3" style="width:40%;"><?php echo $V_CURRENT_PARTY_ADDRS;?></textarea>
								 
							</div>
							
							<div class="col-sm-12 mt-2 input-lg">
								  <b>05. Contact No.</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_CURRENT_PARTY_MOBILE;?>" >
							</div>
							<div class="col-sm-12 mt-2 input-lg">
								  <b>06. Product Procured</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;
								  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_MODEL_NAME;?>" >
							</div>
							<div class="col-sm-12 mt-2">
								  <b>07.Closing Amount:</b>
							</div>
							<div class="col-sm-12 mt-2 margin-left">
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <b>1. Installment</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_INSTALLMENT_RECEIVED;?>" >
							</div>
							
							<div class="col-sm-12 mt-2 margin-left">
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <b>2. Delay Interest</b>:
								  
							</div>
							<div class="col-sm-12 mt-2 margin-left">
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <b>i) Receivable</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_RECEIVABLE;?>" >
							</div>
							<div class="col-sm-12 mt-2 margin-left">
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <b>ii) Discount</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_DISCOUNT;?>" >
							</div>
							<div class="col-sm-12 mt-2 margin-left">
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <b>iii) Received</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;
								  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_RECEIVED;?>" >
							</div>
							
							<div class="col-sm-12 mt-2 margin-left">
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  <b>3. Closing Fee</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  
								  <input style="width:40%;" type="text" id="title" form="Form2" value= "<?php echo $V_CLOSING_FEE;?>" >
							</div>
							
							
							<div class="col-sm-12 mt-2">
								  <b>08. Closing Date:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $V_CLOSING_DATE;?></b>
							</div>
					        <div class="col-sm-12 mt-3">
								  <b>09. Lease Remarks:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $LEASE_REMARKS;?></b>
							</div>
							<div class="col-sm-12 mt-3">
								  <b>10. Account Remarks:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $ACCOUNTS_REMARKS;?></b>
							</div>
					</div>
				</div>
			
			<div class="row mt-3">
				<div class="col-sm-4">
					<div class="border border-dark">
					  <br>
					  <center><b><?php echo $V_LEASE_APPROVAL_BY;?></b></center>
					  <center><b><?php echo $V_LEASE_APPROVAL_DATE;?></b></center>
					  <center><b>Varified by Lease Finance</b></center>
					</div>
				</div>
				
				<div class="col-sm-4">
					<div class="border border-dark">
					  <br>
					  <center><b><?php echo $V_ACC_APPROVAL_BY;?></b></center>
					  <center><b><?php echo $V_ACC_APPROVAL_DATE;?></b></center>
					  <center><b>Varified by Accounts</b></center>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="border border-dark">
					  <br>
					  <center><b><?php echo $_SESSION['emp_id'];?></b></center>
					   <center><b><?php echo $V_SYSDATE;?></b></center>
					  <center><b>Top Sheet Prepared By</b></center> 
					</div>
				</div>
			
			   <br>
			</div>
  </div>
 
</div>

		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
	
<?php require_once('layouts/footer.php'); ?>	
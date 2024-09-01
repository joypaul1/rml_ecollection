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
	$is_found=0;
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Minutes of the meeting of board of directors</a>
        </li>
      </ol>
	   
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				 
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
									   ENG_NO,CHASSIS_NO,REG_NO,
									   TO_CHAR(SYSDATE,'dd MONTH YYYY') AS CURRENT_DATA_TIME,
									   SALE_TYPE
									FROM RML_COLL_SC_CCD
									where ID='$sc_id'
									and CCD_APPROVAL_STATUS=1 
									and FILE_CLEAR_STATUS=1");
                 oci_execute($strSQL);	
                 while($row=oci_fetch_assoc($strSQL)){
					    $is_found=1;
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
						$V_SALE_TYPE=$row['SALE_TYPE']; 

                        }
                           ?>
						   
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
							
							pdf.save("Minute Meeting.pdf");
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
                if($is_found==1){
				?>   
						   
						   
						   <button type="button" class="btn btn-success" onclick="getPDF();">Download PDF</button>
						   <input type="button" class="btn btn-success" onclick="printDiv('printableArea')" value="Print" />
					
				<div class="col-lg-12 border border border-dark">
								<div class="md-form mt-2">
						
								<div class="row canvas_div_pdf" id="printableArea">
									<div class="col-lg-12">
									    <div class="row mt-3 d-flex justify-content-left">
											<p style="font-family:Times New Roman;"><?php echo ' '.$V_SYSDATE;?>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo ' '.$V_REF_CODE;?> </p>
									   </div>
									   
									   <div class="row mt-3 mt-3 text-uppercase d-flex justify-content-center text-decoration-underline">
											<h5 style="font-family:Times New Roman;"><u><b>MINUTES OF THE MEETING OF BOARD OF DIRECTORS</b></u><h5>
									   </div>
									   
							    <div class="row mt-2 bg-light d-flex justify-content-between">
									<p style="font-family:Times New Roman;">
									The minutes of the meeting of the Board of Directors of Rangs Motors Limited held at the registered office of the company at 117/A, Old Airport Road, Bijay Sarani, Tejgaon, Dhaka-1215. In the Meeting the following directors were present.</p>
								</div>
								<div class="row mt-2 d-flex justify-content-left">
									<div class="col-sm-6">								
										<div class="row mt-3 d-flex justify-content-left">
												<p style="font-family:Times New Roman;">1) Mrs. Zakia Rouf Chowdhury</p>
										</div>
										<div class="row d-flex justify-content-left">
												<p style="font-family:Times New Roman;">2) Ms. Sohana Rouf Chowdhury</p>
										</div>
										<div class="row d-flex justify-content-left">
												<p style="font-family:Times New Roman;">3) Ms. Romana Rouf Chowdhury</p>
										</div>
										<div class="row d-flex justify-content-left">
											<p style="font-family:Times New Roman;">	4) Md. Ahsanul Azim </p>
										</div>
									</div>
									
									<div class="col-sm-6">										
								    <div class="col-sm-12 mt-3">
										<div class="form-check">
										  <label class="form-check-label">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<b style="font-family:Times New Roman;">Vice Chairman</b>
										  </label>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-check">
										  <label class="form-check-label" for="check_list_2">
										  <b style="font-family:Times New Roman;">Director & Vice President</b>
										  </label>
										</div>
									</div>
									<div class="col-sm-12 mt-3">
										<div class="form-check">
										  <label class="form-check-label" for="check_list_3">
										  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										   <b style="font-family:Times New Roman;">Director</b>
										  </label>
										</div>
									</div>
									<div class="col-sm-12 mt-3">
										<div class="form-check">
										  <label class="form-check-label">
										   <b style="font-family:Times New Roman;">DGM & CS, Finance & Accounts</b>
										  </label>
										</div>
									</div>
									
									
									
									</div>  
								</div>
								
                                <div class="row mt-2 d-flex justify-content-left">
								  <p style="font-family:Times New Roman;">Mrs. Zakia Rouf Chowdhury presided over the meeting.</p>
								</div>
								
								<div class="row mt-2 d-flex justify-content-between">
								<p style="font-family:Times New Roman;">
								  <b>It was resolved in the meeting that the company's vehicle bearing Reg. No: <?php echo $V_REG_NO;?>, Engine No: <?php echo ' '.$V_ENG_NO;?>, Chassis No: <?php echo ' '.$V_CHASSIS_NO;?> transferred in favour of <?php echo $V_CURRENT_PARTY_NAME;?>.</b></p>
								</div>
								
								<div class="row d-flex justify-content-left">
								 <p style="font-family:Times New Roman;">
								  <?php echo ' '.$V_RESPONSIBLE_PERSON;?>, <?php echo ' '.$V_RESPONSIBLE_DESIGNATION;?> is hereby authorized to sign the relevant papers/documents
                                  regarding the sales/disposal of said and to complete the formalities regarding the disposal/transfer.</p>
								 </p>
								</div>
                            
							
							  
							  
                                 <div class="row d-flex justify-content-left">
								  <p style="font-family:Times New Roman;">Having no other topic to discuss the meeting ended with a vote of thanks to the chair.</p>
								</div>


                                <div class="row mt-2 d-flex justify-content-left">
								  <p style="font-family:Times New Roman;">On behalf of the board.</p>
								</div>
								 
								</div>
								<div class="row">
								  <div class="col-sm-12">	
								  <br><br><br>
								  <br><br>
								  <b style="font-family:Times New Roman;">Md. Ahsanul Azim FCCA</b><br>
								  <b style="font-family:Times New Roman;">DGM & CS,Finance & Accounts</b><br>
								  <b style="font-family:Times New Roman;">Rangs Motors Limited</b>
								</div>
								
								</div>
								</div>
					
				  </div>
				 
				</div>
				<?php
					  }
					 ?>

		 </div>
       </div>
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
	
<?php require_once('layouts/footer.php'); ?>	
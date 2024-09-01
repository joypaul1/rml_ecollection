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
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-4">
							     <input  required="" class="form-control" form="Form1"  type='text' name='ref_code' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
							</div>
							
							<div class="col-sm-4">
							  <input class="form-control btn btn-primary" type="submit" value="Search Code" form="Form1">
							</div>
						</div>	
						<hr>
				</div>
            <?php
			$emp_session_id=$_SESSION['emp_id'];
			if(isset($_POST['ref_code'])){
				 $ref_code=$_REQUEST['ref_code'];
			     $strSQL  = oci_parse($objConnect, "select REF_CODE,STATUS,
															 CUSTOMER_NAME,
															 CUSTOMER_MOBILE_NO,
															 REG_NO,
															 ENG_NO,
															 CHASSIS_NO,
															 SALES_AMOUNT,
															 TOTAL_RECEIVED_AMOUNT,
															 DUE_AMOUNT,
															 DP,
															 LEASE_AMOUNT,
															 PRODUCT_TYPE,
															 INSTALLMENT_AMOUNT
													    from lease_all_info@ERP_LINK_LIVE 
													where  REF_CODE='$ref_code'");
                 oci_execute($strSQL);	
                 while($row=oci_fetch_assoc($strSQL)){					
					 $ref_code=$row['REF_CODE'];
					 $customer_name=$row['CUSTOMER_NAME'];
					 $customer_mobile_no=$row['CUSTOMER_MOBILE_NO'];
					 
					 $eng_no=$row['ENG_NO'];
					 $chs_no=$row['CHASSIS_NO'];
					 $reg_no=$row['REG_NO'];
					
					$sales_amount=$row['SALES_AMOUNT'];
					$total_received_amount=$row['TOTAL_RECEIVED_AMOUNT'];
					$due_amount=$row['DUE_AMOUNT'];
					$product_type=$row['PRODUCT_TYPE'];
					
					 $sales_person_name="";
					 $brand="";
					 $model="";
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
					</script>	   
						   
						   
						   
						   
						   <button type="button" class="btn btn-success" onclick="getPDF();">Download PDF</button>
						   <div class="col-lg-12 border border border-dark">
								<div class="md-form mt-2">
						
								<div class="row canvas_div_pdf">
									<div class="col-lg-12">
									   
									    <br> <br><br>
									    <div class="row mt-3 d-flex justify-content-left">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											Date:
									   </div>
									   <div class="row text-uppercase d-flex justify-content-center">
											<h6></h6>
									   </div>
									   <div class="row text-uppercase d-flex justify-content-center">
											<h6></h6>
									   </div>
									   <div class="row mt-3 mt-3 text-uppercase d-flex justify-content-center text-decoration-underline">
											<h3 style="font-family:Times New Roman;"><b>MINUTES OF THE MEETING OF BOARD OF DIRECTORS</b><h3>
									   </div>
									   <br><br>
									   
									    <div class="col-sm-12">
								   <div class="col-sm-12">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									The minutes of the meeting of the Board of Directors of Rangs Motors Limited held on April 5th'
												2016 at10.30 am at the registered office of the company at 113-116, old Airport Road' Teigaon'
												Dhaka-1215. In the Meetirig the folowing directors were present.</p>
									</div>
								</div>
									   <div class="row">
										<div class="col-sm-6">								
											<div class="col-sm-12 mt-3">
												<div class="form-check">
												  <label class="form-check-label">
													1.&nbsp;&nbsp;&nbsp;
													Mr. A.Rouf Chowdhury
												  </label>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-check">
												  <label class="form-check-label" for="check_list_2">
													2.&nbsp;&nbsp;&nbsp;
													Mrs. Zakia Rouf Chowdhury
												  </label>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-check">
												  <label class="form-check-label" for="check_list_3">
													3.&nbsp;&nbsp;&nbsp;
													Ms. Sohana Rouf Chowdhury
												  </label>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-check">
												  <label class="form-check-label" for="check_list_4">
													4.&nbsp;&nbsp;&nbsp;
													Md. Shaiful Islam
												  </label>
												</div>
											</div>
										</div>
									<div class="col-sm-6">
																
								    <div class="col-sm-12 mt-3">
										<div class="form-check">
										  <label class="form-check-label">
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<b>Chairman</b>
										  </label>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-check">
										 
										  <label class="form-check-label" for="check_list_2">
											<b><h6>Executive Vice Chairperson</b></h6>
										  </label>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-check">
										
										  <label class="form-check-label" for="check_list_3">
											<b><h6>Director & Vice President</b></h6>
										  </label>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-check">
										  
										  <label class="form-check-label">
											<b><h6>Group CFO & CS, Finance & Accounts</b></h6>
										  </label>
										</div>
									</div>
									
									
									
									</div>  
								</div>
								
                                <div class="row mt-3">
								   <div class="col-sm-12">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Mr. A.Rouf Chowdhury presided over the meeting.</p>
									</div>
								</div>
                               <div class="col-sm-12">
								   <div class="col-sm-12">
									<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									It was resolved in the meeting that the company's vehicle bearing Reg. No.: <?php echo $reg_no;?>
                                     ,Engine No.: <?php echo ' '.$eng_no;?>,Chassis No: <?php echo ' '.$chs_no;?> transferred in favour of <?php echo $ref_code;?>.</b>
									</div>
								</div>

                               <div class="col-sm-12">
								   <div class="col-sm-12">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Somen Kanti Roy, Manager is hereby authorized to sign the relevant papers/documents
                                  regarding the sales/disposal of said and to complete the formalities regarding the disposal/transfer.</p>
									</div>
								</div>

								<div class="col-sm-12">
								   <div class="col-sm-12">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Having no other topic to discuss the meeting ended with a vote of thanks to the chair.</p>
									</div>
								</div>
								<div class="col-sm-12">
								   <div class="col-sm-12">
									<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									On behalf of the board.</p>
									</div>
								</div>   
								</div>
								<div class="row">
									<div class="col-sm-12">
										
										  <br><br>
										  <center><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Md. Shaiful Islam FCA</b></center>
										  <center><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Group CFO & CS,Finance & Accounts</b></center>
										  <center><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rangs Motors Limited</b></center>
										
									</div>
								 <br>
								</div>
								</div>
								
							
							<div class="row mt-3">
							</div>
							<div class="row mt-3">
							</div>
							<div class="row mt-3">
							</div>
							<div class="col-sm-12 mt-3">
							</div>
						 <?php
						  }
						 ?>
						 
					
					
				  </div>
				 
				</div>

		 </div>
       </div>
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
	
<?php require_once('layouts/footer.php'); ?>	
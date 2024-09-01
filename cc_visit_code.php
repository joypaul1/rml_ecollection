<?php 
	session_start();
	if($_SESSION['user_role_id']!= 4 && $_SESSION['user_role_id']!= 1)
	{
		header('location:index.php?lmsg=true');
		exit;
	} 		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
	
	$emp_session_id=$_SESSION['emp_id'];
	
	$v_rml_id=$_REQUEST['login_id'];
	$v_login_id=0;
	
	
	$v_start_date=$_REQUEST['start_date'];
	$v_end_date=$_REQUEST['end_date'];
	$v_what_want=$_REQUEST['want'];
	
    $len=strlen($_REQUEST['login_id']);
	if($len==1){
		$v_login_id='00000'.$v_rml_id;
	}else if($len==2){
		$v_login_id='0000'.$v_rml_id;
	}else if($len==3){
		$v_login_id='000'.$v_rml_id;
	}else if($len==4){
		$v_login_id='00'.$v_rml_id;
	}else if($len==5){
		$v_login_id='0'.$v_rml_id;
	}

	
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href=""> 
		  <?php  
		    if($v_what_want=='total_code'){
			   echo 'ERP Code Assign Summary';
		    }else if($v_what_want=='total_assign'){
				echo 'Code Assign Summary On Apps';
			}
		                        
		                         echo '<br>';
								 echo 'Start Date: '.$v_start_date;
								 echo '<br>';
								 echo 'End Date: '.$v_end_date;
								 echo '<br>';
								 echo 'Concern ID: '.$v_rml_id;
								
							   ?>
		  </a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
			
				
				<div class="col-lg-12">
				    <form id="Form1" action="" method="post">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered table-striped table-responsive" id="admin_list">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col">Sl</th>
								  <th scope="col"><center>Code Information</center></th>
								  <th scope="col"><center>Payment Information</center></th>
								  <th scope="col"><center>Visited Information</center></th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
                            if($v_what_want=='total_code'){
							$quary="select 
							        A.REF_CODE,
							        A.CUSTOMER_NAME,
									A.PARTY_ADDRESS,
									A.LAST_PAYMENT_AMOUNT,
									A.CUSTOMER_MOBILE_NO,
									A.NUMBER_OF_DUE,
									A.LAST_PAYMENT_DATE,
									A.COLL_CONCERN_ID,
									(select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
													WHERE B.VISIT_STATUS=1
													AND B.REF_ID=A.REF_CODE
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
												TOTAL_VISITED,
									(select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
										WHERE B.REF_ID=A.REF_CODE
										AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
									TOTAL_VISIT_ASSIGN
								FROM LEASE_ALL_INFO_ERP A
									WHERE A.COLL_CONCERN_ID='$v_login_id'
									AND A.STATUS='N'
									AND A.PAMTMODE='CRT'
									ORDER BY A.NUMBER_OF_DUE DESC";
									
							}else if($v_what_want=='total_assign'){
							$quary="select 
							        A.REF_ID REF_CODE,
									A.CUSTOMER_NAME,
									(select B.PARTY_ADDRESS FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)PARTY_ADDRESS,
									(select B.LAST_PAYMENT_AMOUNT FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)LAST_PAYMENT_AMOUNT,
									(select B.LAST_PAYMENT_DATE FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)LAST_PAYMENT_DATE,
									(select B.NUMBER_OF_DUE FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)NUMBER_OF_DUE,
									(select B.COLL_CONCERN_ID FROM LEASE_ALL_INFO_ERP B where B.REF_CODE=A.REF_ID)COLL_CONCERN_ID,
									(select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
													WHERE B.VISIT_STATUS=1
													AND B.REF_ID=A.REF_ID
													AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
												TOTAL_VISITED,
									(select count(B.REF_ID) from RML_COLL_VISIT_ASSIGN B
										WHERE B.REF_ID=A.REF_ID
										AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY'))
									TOTAL_VISIT_ASSIGN			
										 from RML_COLL_VISIT_ASSIGN A
										 where CREATED_BY='$v_rml_id'
										 and trunc(ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
										 ORDER BY A.REF_ID";	
							}else if($v_what_want=='Not_Touching_Code'){
							$quary="select REF_CODE,
							         CUSTOMER_NAME,PARTY_ADDRESS,
											   CUSTOMER_MOBILE_NO,LAST_PAYMENT_AMOUNT,
											   NUMBER_OF_DUE,LAST_PAYMENT_DATE
											   from LEASE_ALL_INFO_ERP
										where COLL_CONCERN_ID='$v_login_id'
										and STATUS='N'
										and PAMTMODE='CRT'
										order by NUMBER_OF_DUE DESC";	
							}
						  
						  
						  $allDataSQL  = oci_parse($objConnect, $quary); 			
						  oci_execute($allDataSQL);
						  $number=0; 
						  
						  while($row=oci_fetch_assoc($allDataSQL)){	
						   $number++;
                           ?>
						    <tr>
							  <td><?php echo $number;?></td>
							 
							   <td>
							   <?php 
								 echo 'Code: '.$row['REF_CODE'];
								 echo '<br>';
								 echo 'Customer Name: '.$row['CUSTOMER_NAME'];
								 echo '<br>';
								 echo 'Address: <i style="color:red;">'.$row['PARTY_ADDRESS'].'</i>';
								 echo '<br>';
								  echo 'RML ID: <i>'.$row['COLL_CONCERN_ID'].'</i>';
								/* if($row['COLL_CONCERN_ID']=='$v_login_id')
								   echo 'RML ID: <i>'.$row['COLL_CONCERN_ID'].'</i>';
							   else
								   echo '<b>RML ID: <i style="color:red;">'.$row['COLL_CONCERN_ID'].'</i></b>';
							   */
							   ?>
							   </td>
							   <td>
							   <?php 
							    echo 'Last Payment: '.$row['LAST_PAYMENT_AMOUNT'];
								echo '<br>';
								echo 'Last Payment Date: '.$row['LAST_PAYMENT_DATE'];
								echo '<br>';
								echo '<u>Number of Due: <b style="color:red;">'.$row['NUMBER_OF_DUE'].'</b></u>';
							   ?>
							   </td>
							    <td>
							   <?php 
							     echo 'Total Visit: '.$row['TOTAL_VISITED'];
								 echo '<br>';
								  echo 'Total Visit Assign: '.$row['TOTAL_VISIT_ASSIGN'];
							   ?>
							   </td>
						 </tr>
						 <?php
						  }
						  
						  ?>
					</tbody>	
				 
		              </table>
					</div>
					
				  </div>
				</div>
			  </form>
				
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
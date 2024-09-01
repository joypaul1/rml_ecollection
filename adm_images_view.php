<?php 
	session_start();
	 $exit_status=0;
	if($_SESSION['user_role_id']== 2 || $_SESSION['user_role_id']== 8 || $_SESSION['user_role_id']== 3)
	{
		$exit_status=1;
	}
	
	if($exit_status==0){
		header('location:index.php?lmsg=true');
		exit;
	}
	/*
	if($_SESSION['user_role_id']!= 8)
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
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				   
					<form id="Form1" action="" method="post"></form>
					<form id="Form2" action="" method="post"></form>
						<div class="row">
							<div class="col-sm-6">
								
								 <input form="Form1"  placeholder="Ref-Code"  required="" type='text' class="form-control" name='ref_code' value='<?php echo isset($_POST['ref_code']) ? $_POST['ref_code'] : ''; ?>' />
							</div>
							<div class="col-sm-6">
							<div class="md-form mt-0">
									<input class="form-control btn btn-primary btn pull-right" type="submit" value="Search Code" form="Form1">
								</div>
							</div>
						</div>	
						<hr>
				</div>

				<div class="col-lg-12">
						<hr>
						<?php
						$emp_session_id=$_SESSION['emp_id'];
						@$ref_code_id=$_REQUEST['ref_code'];
						
						$images_1='';
						$images_1_entry_date='';
						$images_1_entry_id='';
						$images_1_grade='';

						
						$images_2='';
						$images_2_entry_date='';
						$images_2_entry_id='';
						$images_2_grade='';
						
						
						$images_3='';
						$images_3_entry_date='';
						$images_3_entry_id='';
						$images_3_grade='';
						
						$images_4='';
						$images_4_entry_date='';
						$images_4_entry_id='';
						$images_4_grade='';
						
						$number_index=0;	
						$is_search=0;	
						
						if(isset($_POST['ref_code'])){
						   $is_search=1;	
					       
							$strSQL  = oci_parse($objConnect, "select  a.REF_CODE,
																	  a.IMG_URL,
																	  b.EMP_NAME UPDATED_BY,
																	  TO_CHAR(a.ENTRY_DATE,'YYYY-MM-DD HH:MM:SS PM') AS ENTRY_DATE,
																	  a.VEHICLE_GRADE,a.COMMENTS_TITLE																	  
																	  FROM RML_COLL_IMAGES a,RML_COLL_APPS_USER b
																	  WHERE A.UPDATED_BY=B.RML_ID
																	  AND a.REF_CODE='$ref_code_id' 
																	  order by ENTRY_DATE desc"); 
						  
						    oci_execute($strSQL);
                            						
							while($row=oci_fetch_assoc($strSQL)){
								   $number_index++;
								   
								if($number_index==1){
									$images_1='';
									$images_1_entry_date='';
									$images_1_entry_id='';
									$images_1_grade='';
									$images_1_comments='';
									$images_1_comments='';
						
									 $images_1 = $row['IMG_URL'];
									 $images_1_entry_date= $row['ENTRY_DATE'];
									 $images_1_entry_id= $row['UPDATED_BY'];
									 $images_1_grade= $row['VEHICLE_GRADE'];
									 $images_1_comments= $row['COMMENTS_TITLE'];
									 
								}else if($number_index==2){
									$images_2='';
									$images_2_entry_date='';
									$images_2_entry_id='';
									$images_2_grade='';  
									$images_2_comments='';
						
									$images_2 = $row['IMG_URL'];	
									$images_2_entry_date= $row['ENTRY_DATE'];
									$images_2_entry_id= $row['UPDATED_BY'];
									$images_2_grade= $row['VEHICLE_GRADE'];
									$images_2_comments= $row['COMMENTS_TITLE'];
								}
								else if($number_index==3){
									
									$images_3='';
									$images_3_entry_date='';
									$images_3_entry_id='';
									$images_3_grade='';
									$images_3_comments='';
						
						
									$images_3 = $row['IMG_URL'];
									$images_3_entry_date= $row['ENTRY_DATE'];
									$images_3_entry_id= $row['UPDATED_BY'];
									$images_3_grade= $row['VEHICLE_GRADE'];
									$images_3_comments= $row['COMMENTS_TITLE'];
								}
								else if($number_index==4){
									
									$images_4='';
									$images_4_entry_date='';
									$images_4_entry_id='';
									$images_4_grade=''; 
									$images_4_comments='';
						
									$images_4 = $row['IMG_URL'];	
									$images_4_entry_date= $row['ENTRY_DATE'];
									$images_4_entry_id= $row['UPDATED_BY'];
									$images_4_grade= $row['VEHICLE_GRADE'];
									$images_4_comments= $row['COMMENTS_TITLE'];
								}
						      }
							 
						  }
						 ?>
				  </div>
				  
				 

				 
  <div class="container">
  <h2>Image Gallery </h2> 
	  <h2 style="color:red;">
		   <?php 
		   if($number_index>0){
			  echo 'REF-CODE: '.$ref_code_id; 
		   }else if($is_search==0){
			   
		   }else{
			  echo 'Not uploaded any images on Ref-Code: '.$ref_code_id;
		   }
			
		   ?>
	  </h2>
  
  <p>Dear, remember that here is only display last 4 images that are uploaded by responsible concern.</p> 
  <p>Click on the images to enlarge them.</p>
  <div class="row">
    <div class="col-md-3">
      <div class="thumbnail">
        <a href="<?php echo $images_1;?>" target="_blank">
          <img src="<?php echo $images_1;?>" style="width:100%">
          <div class="caption">
             <p>
			    <?php 
				 if($number_index>=1){
					 echo 'Image-1';
					 echo "<br>";
					 echo $images_1_entry_date;
				     echo "<br>";
			         echo $images_1_entry_id;
				     echo "<br>";
			         echo 'Grade: '.$images_1_grade;
                     echo "<br>";					 
			         echo 'Type: '.$images_1_comments; 
				    }
			    ?>
			 </p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="thumbnail">
        <a href="<?php echo $images_2;?>" target="_blank">
          <img src="<?php echo $images_2;?>" style="width:100%">
          <div class="caption">
             <p>
			     <?php 
				  if($number_index>=2){
					  echo 'Image-2';
					  echo "<br>";
					  echo $images_2_entry_date;
					  echo "<br>";
					  echo $images_2_entry_id;
					  echo "<br>";
					  echo 'Grade: '.$images_2_grade;
					  echo "<br>";					 
			          echo 'Type: '.$images_2_comments;
				   }
			     ?>
			 </p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="thumbnail">
        <a href="<?php echo $images_3;?>" target="_blank">
          <img src="<?php echo $images_3;?>" style="width:100%">
          <div class="caption">
              <p>
			    <?php 
				 if($number_index>=3){
					  echo 'Image-3';
					  echo "<br>";
					  echo $images_3_entry_date;
					  echo "<br>";
					  echo $images_3_entry_id;
					  echo "<br>";
					  echo 'Grade: '.$images_3_grade;
					  echo "<br>";					 
			          echo 'Type: '.$images_3_comments;
					  }
			    ?>
			  </p>
          </div>
        </a>
      </div>
    </div>
	<div class="col-md-3">
      <div class="thumbnail">
        <a href="<?php echo $images_4;?>" target="_blank">
          <img src="<?php echo $images_4;?>" style="width:100%">
          <div class="caption">
              <p>
			    <?php 
				 if($number_index==4){
					  echo 'Image-4';
					  echo "<br>";
					  echo $images_4_entry_date;
					  echo "<br>";
					  echo $images_4_entry_id;
					  echo "<br>";
					  echo 'Grade: '.$images_4_grade;
					  echo "<br>";					 
			          echo 'Type: '.$images_4_comments;
				   }
			    ?>
			  </p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>






				</div>
				  
		 </div>
       </div>
	   
	   
	   
      <div style="height: 1000px;"></div>
    </div>
	
<?php require_once('layouts/footer.php'); ?>	
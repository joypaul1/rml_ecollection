<?php 
session_start();
  if($_SESSION['user_role_id']!= 1){
	header('location:index.php?lmsg=true');	
	exit;
	} 		
require_once('inc/config.php');
require_once('layouts/header.php'); 
require_once('layouts/left_sidebar.php'); 
?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Create a new User</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<form action="" method="post">
						<div class="row">
						    <div class="col-sm-4">
								<div class="form-group">
								  <label for="title">User ID:</label>
								  <input type="text" required=""  name="user_id" class="form-control" id="title">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
								  <label for="title">User Name:</label>
								  <input type="text" required=""  name="user_name" class="form-control" id="title">
								</div>
							</div>
							<div class="col-sm-4">
							<div class="form-group">
							   <label for="title">User Mail:</label>
							   <input type="text" required=""  name="user_mail" class="form-control" id="title">
							</div>
						</div>
						</div>													
						<div class="row">
							<div class="col-sm-4">
							    <div class="form-group">
								 <label for="title">Enter Password:</label>
								 <input type="text" required=""  name="user_password" class="form-control" id="title">
							    </div>	
							</div>
                            <div class="col-sm-4">
							    <div class="form-group">
								 <label for="title">Re Enter Password:</label>
								 <input type="text" required=""  name="again_password" class="form-control" id="title">
							    </div>	
							</div>	
                         <div class="col-sm-4">
						<div class="form-group">
						  <label for="title">User Role:</label>
						  <select required="" name="user_role" class="form-control">
							<option value="">--</option>
							<option value="12">Accounts</option>
							<option value="2">ADM(Lease)</option>
							<option value="5">CCD</option>
							<option value="13">CCD Call System</option>
							<option value="14">CS For Sales Department</option>
						  </select>
						 
						</div>
					</div>								
						</div>	
						<div class="row">
						    <div class="col-sm-4">								
							    <div class="form-group">
							      <label for="title"><br/></label>
								   <input class="form-control btn btn-primary" type="submit" value="Save">
								 </div>							
							</div>	
						</div>
						<hr>
					</form>					
				</div>
        <?php          
		$emp_session_id=$_SESSION['emp_id'];           
		if(isset($_POST['user_name'])){                
		
				$user_id = $_REQUEST['user_id'];
				$user_name = $_REQUEST['user_name'];
				$user_mail = $_REQUEST['user_mail'];
				$original_password=$_REQUEST['user_password'];
				$user_role=$_REQUEST['user_role'];
				
				$password = md5($_REQUEST['user_password']);
				$again_password = md5($_REQUEST['again_password']);              
				if($password!=$again_password){                 
				      echo 'Password and re-type password are not same.';                
				}else{                   
				    $sql = "insert into tbl_users(user_role_id,emp_id,user_name,email,password,user_brand,password_hint,created_by_id,created_date)
					values('$user_role','$user_id','$user_name','$user_mail','$password','ALL','$original_password','$emp_session_id',CURDATE())";
					 $rs = mysqli_query($conn,$sql);				                      	                         
					 if($rs)
					       { ?>                                 
					   <div class="container-fluid">
							     <div class="md-form mt-5">
							        <ol class="breadcrumb">
									<li class="breadcrumb-item">
									  User is created successfully.									  
									  <?php	
									     echo $htmlHeader;										  
										 while($stuff){	
										    echo $stuff;										  
											}										  
											echo "<script>window.location = 'http://202.40.181.98:9090/rangs_collection_rml/user.php'</script>";
									   ?>
									</li>
								   </ol>
								  </div>
						</div>
						<?php
						}
						}
						}
                       ?>
		 </div>
       </div>	   
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->	
<?php require_once('layouts/footer.php'); ?>	
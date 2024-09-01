<?php 
	session_start();
	if($_SESSION['user_role_id']!= 1 && $_SESSION['user_role_id']!= 9)
	{
		header('location:index.php?lmsg=true');
		exit;
	}
		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 

	$user_table_id=$_REQUEST['emp_id'];
	
?>
  <div class="content-wrapper">
    <div class="container-fluid">   
	  <div class="container-fluid">
			<div class="row">			
						<?php
						
						 $sql = "SELECT id,user_name,emp_id,email,password,password_hint,created_date FROM tbl_users WHERE id='$user_table_id'";								
						 $rs = mysqli_query($conn,$sql);
						 $getUserRow = mysqli_fetch_assoc($rs);
						 
                           ?>
<div class="col-lg-12">
<div class="md-form mt-3">
<ol class="breadcrumb">
<li class="breadcrumb-item">
You will be respondible if you update anything here.</li>
</ol>
<div class="resume-item d-flex flex-column flex-md-row">
						   
						   
<div class="container">
<div class="row">
<form action="" method="post">
  <div class="row">
      <div class="col-sm-4">
		<div class="form-group">
		  <label for="title">User ID:</label>
		  <input type="text" required=""  value="<?php echo $getUserRow['emp_id'];?>" class="form-control" id="title" readonly>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="form-group">
		  <label for="title">User Name:</label>
		  <input type="text" required="" value="<?php echo $getUserRow['user_name'];?>"  name="user_name" class="form-control" id="title">
		</div>
	</div>
	<div class="col-sm-4">
    	<div class="form-group">
    	  <label for="title">User Mail:</label>
    	  <input type="text" required="" value="<?php echo $getUserRow['email'];?>"  name="user_mail" class="form-control" id="title">
    	</div>
	</div>
	<div class="col-sm-4">
    	<div class="form-group">
    	  <label for="title">Password:</label>
    	  <input type="text" required="" value="<?php echo $getUserRow['password_hint'];?>" name="user_password"  class="form-control" id="title">
    	</div>
	</div>
	<div class="col-sm-4">
						<label for="title">Select User Role</label>
						<select required="" name="user_role" class="form-control">
						    <option selected  value="">--</option>
						    <option  value="3">Area Head</option>
							<option  value="4">Zonal Head</option>
							<option  value="2">ADM</option>
							
										
						</select>
					</div>
	
					
  </div>
 
  <div class="row">
	 <div class="col-lg-12">
		<div class="md-form mt-5">
	<button type="submit" name="submit" class="btn btn-info"> Update</button> 
		</div>
     </div>	
  </div>
</form>
</div>
</div>

</div>
</div>
</div>
				  
			
<?php 

      $emp_id=$_SESSION['emp_id'];
      if(isset($_POST['user_password'])){
		  $user_name = $_REQUEST['user_name'];
		  $user_mail = $_REQUEST['user_mail'];
		  $v_user_role = $_REQUEST['user_role'];
		  $original_password=$_REQUEST['user_password'];
		  $new_password = md5($_REQUEST['user_password']);


			$sql = "update tbl_users set 
						  user_name='$user_name',
						  email='$user_mail',
						  created_by_id='$emp_id',
						  password='$new_password',
						  password_hint='$original_password',
						  user_role_id='$v_user_role'
						  where id=$user_table_id";
				if(mysqli_query($conn,$sql)){
					echo 'Information is updated successfully.';
						} 
        }
?>
		 </div>
       </div>
      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	
<?php require_once('layouts/footer.php'); ?>	
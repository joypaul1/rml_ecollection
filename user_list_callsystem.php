<?php 
	session_start();
	if($_SESSION['user_role_id']!= 9)
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
          <a href="">List</a>  &nbsp;&nbsp; <a href="user_add_callsystem.php">New</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				    <form action="" method="post">
						<div class="row">
						   <div class="col-sm-4">
							<label for="title">User ID</label>
								<input required=""  type="text" class="form-control" id="title" placeholder="user ID" name="user_id">
							</div>
							<div class="col-sm-4">
						    <div class="form-group">
							<label for="title"> <br></label>
							<input class="form-control btn btn-primary" type="submit" value="Search Data">
							</div>
						</div>
                       					
					</form>
				</div>
				
				<div class="col-lg-12">
					<div class="md-form mt-5">
					 <div class="resume-item d-flex flex-column flex-md-row">
					   <table class="table table-bordered piechart-key" id="admin_list" style="width:100%">  
						<thead class="thead-dark">
								<tr>
								 <th scope="col">Sl</th>
								  <th scope="col">Name</th>
								  <th scope="col">User ID</th>
								  <th scope="col">Mail</th>
								  <th scope="col">Password</th>
								  <th style="text-align:center"">Action</th>
								</tr>
					   </thead>
					   
					   <tbody>

						<?php
						$emp_session_id=$_SESSION['emp_id'];
						
						
						
						if(isset($_POST['user_id'])){
							
						  $user_id = $_REQUEST['user_id'];
						  $selectsql = "SELECT id,user_name,emp_id,email,password_hint FROM tbl_users WHERE user_role_id=9 and emp_id='$user_id'";
							  $rs = mysqli_query($conn,$selectsql);
						  $number=0;
							
		                   while($row = $rs->fetch_assoc()) {
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							 <td><?php echo $row['user_name'];?></td>
							  <td><?php echo $row['emp_id'];?></td>
							  <td><?php echo $row['email'];?></td>
							 <td><?php  if ($row['emp_id']!='RML-00955') echo $row['password_hint'];?></td>
							 
							 
							<td align="center"> 
							<?php  if ($row['emp_id']!='RML-00955'){
								?>
							    <a href="user_edit.php?emp_id=<?php echo $row['id'] ?>"><?php
								echo '<button class="btn btn-primary">update</button>';
								?>
								</a>
								<?php
							     }
								?>
							</td>
						 </tr>
						 <?php
						  }
						  }else{
						      $selectsql = "SELECT id,user_name,emp_id,email,password_hint FROM tbl_users WHERE user_role_id=9 and emp_id not in ('cs','RML-00955')";
							  $rs = mysqli_query($conn,$selectsql);
						  $number=0; 
						  
						  while($row = $rs->fetch_assoc()) {
						   $number++;
                           ?>
						   <tr>
							  <td><?php echo $number;?></td>
							  <td><?php echo $row['user_name'];?></td>
							  <td><?php echo $row['emp_id'];?></td>
							  <td><?php echo $row['email'];?></td>
							  <td><?php  if ($row['emp_id']!='RML-00955') echo $row['password_hint'];?></td>
							<td align="center"> 
							<?php  if ($row['emp_id']!='RML-00955'){
								?>
							    <a href="user_edit.php?emp_id=<?php echo $row['id'] ?>"><?php
								echo '<button class="btn btn-primary">update</button>';
								?>
								</a>
								<?php
							     }
								?>
							</td>

						 </tr>
						 <?php
						  }
						  }
						  ?>
					</tbody>	
				 
		              </table>
					</div>
					
				  </div>
				</div>
			 
				
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->
	
<?php require_once('layouts/footer.php'); ?>	
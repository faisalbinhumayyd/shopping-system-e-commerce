   <?php

	ob_start(); 
	session_start();
	$PageTitle = 'Members'; 
    if (!isset($_SESSION['uid'])) {
		header('Location: ../check'); 
	}else{
		include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		if ($do == 'Manage') { 
			$stmt = $con->prepare("SELECT * FROM users ORDER BY user_id DESC");
			$stmt->execute();
			$rows = $stmt->fetchAll();
			if (! empty($rows)) {
			?>
 
			<h1 class="text-center">Manage Members</h1>
            <div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Full Name</td>
							<td>Email</td>
							<td>Password</td>
							<td>Type</td>
							<td>Control</td>
						</tr>
						<?php
							foreach($rows as $row) {
                               if($row['status']!=2){
                                   $type="User"; 
                               }else{
                                  $type="Admin"; 
                               }
                                
								echo "<tr>";
									echo "<td>" . $row['user_id'] . "</td>";
									echo "<td>" . $row['fullname'] . "</td>";
									echo "<td>" . $row['email'] . "</td>";
									echo "<td>" . $row['password'] . "</td>";
									echo "<td>" . $type ."</td>";
									echo "<td>
										<a href='users.php?do=Delete&uid=" . $row['user_id'] . "' class='btn btn-danger confirm'>Delete <i class='fa fa-close'></i>  </a>";
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a style="float:right" href="users.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Member
				</a>
			</div>

			<?php } else {
				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Members To Show</div>';
					echo '<a style="float:right" href="users.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> Add New Member
						</a>';
				echo '</div>';
			} ?>

		<?php 
		} elseif ($do == 'Add') { ?>

			<h1 class="text-center">Add New Member</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Full Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="fullname" class="form-control" autocomplete="off" required="required" placeholder="write name.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10 col-md-6">
							<input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="Password Should Be Hard & Complex" />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-6">
							<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Account Type</label>
						<div class="col-sm-10 col-md-6">
							<select class="form-control" name="cat">
                                <option value="2">Admin</option>           
                                <option value="1">User</option>           
                            </select>
						</div>
					</div>

					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
						</div>
					</div>
				</form>
			</div>

		<?php 
		} elseif ($do == 'Insert') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				echo "<h1 class='text-center'>Insert Member</h1>";
				echo "<div class='container'>";
				
                
				$fullname  = $_POST['fullname'];
				$password  = $_POST['password'];
				$email  = $_POST['email'];
				$cat   = $_POST['cat'];
                
				$formErrors = array();
				if (empty($fullname)) {
					$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
				}
                
				if (empty($password)) {
					$formErrors[] = 'Password Cant Be <strong>Empty</strong>';
				}
				if (empty($email)) {
					$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
				}
				if (empty($cat)) {
					$formErrors[] = 'Select Account Type, Cant Be <strong>Empty</strong>';
				}
				
				foreach($formErrors as $error) {
					echo '<div class="container alert alert-danger">' . $error . '</div>';
				}
				if (empty($formErrors)) {
					$check = checkItem("email", "users", $email);
					if ($check == 1) {
						$theMsg = '<div class="container alert alert-danger">Sorry This Email Is Exist</div>';
						redirectHome($theMsg, 'back');
					} else {

                        $stmt = $con->prepare("INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`,  `status` ) VALUES (NULL, :fullname, :email, :password,  :status) ");
                        $stmt->execute(array(
                            'fullname'  => $fullname ,
                            'email'  => $email ,
                            'password'  => $password ,
                            'status'  => $cat
                        ));
						$theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
						redirectHome($theMsg, 'back');
					}
				}
			} else {
				echo "<div class='container'>";
				$theMsg = '<div class="container alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
				redirectHome($theMsg);
				echo "</div>";
			}
			echo "</div>";
		} elseif ($do == 'Delete') {
			echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";
				$user_id = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;
				$check = checkItem('user_id', 'users', $user_id);
				if ($check > 0) {
					$stmt = $con->prepare("DELETE FROM users WHERE user_id = :zuser");
					$stmt->bindParam(":zuser", $user_id);
					$stmt->execute();
					$theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg, 'back');
				} else {
					$theMsg = '<div class="container alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			echo '</div>';
		}
		include $DirTemp . 'footer.php';
	}
	ob_end_flush(); 
?>
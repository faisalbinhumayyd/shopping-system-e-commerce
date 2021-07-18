   <?php

	ob_start(); 
	session_start();
	$PageTitle = 'Categories'; 
    if (!isset($_SESSION['uid'])) {
		header('Location: ../check'); 
	}else{
		include 'init.php';
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		if ($do == 'Manage') { 
			$stmt = $con->prepare("SELECT * FROM categories ORDER BY cat_id DESC");
			$stmt->execute();
			$rows = $stmt->fetchAll();
			if (! empty($rows)) {
			?>
 
			<h1 class="text-center">Manage Categories</h1>
            <div class="container">
				<div class="table-responsive">
					<table class="main-table manage-Categories text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Category</td>
							<td>Control</td>
						</tr>
						<?php
							foreach($rows as $row) {
                              
                                
								echo "<tr>";
									echo "<td>" . $row['cat_id'] . "</td>";
									echo "<td>" . $row['category'] . "</td>";
									echo "<td>
										<a href='categories.php?do=Delete&uid=" . $row['cat_id'] . "' class='btn btn-danger confirm'>Delete <i class='fa fa-close'></i>  </a>";
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a style="float:right" href="categories.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Category
				</a>
			</div>

			<?php } else {
				echo '<div class="container">';
					echo '<div class="nice-message">There\'s No Categories To Show</div>';
					echo '<a style="float:right" href="categories.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> Add New Category
						</a>';
				echo '</div>';
			} ?>

		<?php 
		} elseif ($do == 'Add') { ?>

			<h1 class="text-center">Add New Category</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category Title</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="title" class="form-control" autocomplete="off" required="required" placeholder="write name.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
						</div>
					</div>
				</form>
			</div>

		<?php 
		} elseif ($do == 'Insert') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				echo "<h1 class='text-center'>Insert Category</h1>";
				echo "<div class='container'>";
				
                
				$title  = $_POST['title'];
                
				$formErrors = array();
				if (empty($title)) {
					$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
				}
				
				foreach($formErrors as $error) {
					echo '<div class="container alert alert-danger">' . $error . '</div>';
				}
				if (empty($formErrors)) {
					$check = checkItem("category", "categories", $title);
					if ($check == 1) {
						$theMsg = '<div class="container alert alert-danger">Sorry This Title Is Exist</div>';
						redirectHome($theMsg, 'back');
					} else {

                        $stmt = $con->prepare("INSERT INTO `categories` (`cat_id`, `category` ) VALUES (NULL, :title) ");
                        $stmt->execute(array(
                            'title'  => $title 
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
			echo "<h1 class='text-center'>Delete Category</h1>";
			echo "<div class='container'>";
				$user_id = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;
				$check = checkItem('cat_id', 'categories', $user_id);
				if ($check > 0) {
					$stmt = $con->prepare("DELETE FROM categories WHERE cat_id = :zuser");
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
 <?php

	ob_start(); 
	session_start();
	$PageTitle = 'Products'; 
    if (!isset($_SESSION['uid'])) {
		header('Location: ../check');
	}else{
		include 'init.php';
        $cid = $_GET['cid'];
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		if ($do == 'Manage') { ?>
            
                <div class="container">
                    <div class="row">
<?php
    $stmt = $con->prepare("SELECT products.*,categories.category FROM products INNER JOIN categories ON categories.cat_id=products.category ORDER BY products.prod_id ASC");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if (! empty($rows)) {?>
       <h1 class="text-center">Products</h1>
        <div>
        <div class="table-responsive">
            <table class="main-table manage-members text-center table table-bordered">
                <tr>
                    <td>#ID</td>
                    <td>Title</td>
                    <td>Price</td>
                    <td>Category</td>
                    <td>Rate</td>
                    <td>Control</td>
                </tr>
       <?php
        $i=1;
        foreach($rows as $row) {
            echo "
            <tr>
                    <td>".$i."</td>
                    <td>".$row['title']."</td>
                    <td>".$row['price']."</td>
                    <td>".$row['category']."</td>
                    <td>".$row['rate']."</td>
                    <td>";
                    echo "    
                        <a href='products.php?do=Show&cid=".$row['prod_id']."' class='btn btn-info'>Show <i class='fa fa-eye'></i> </a>
                        <a href='products.php?do=Edit&cid=".$row['prod_id']."' class='btn btn-success'>Edit <i class='fa fa-edit'></i> </a>
                        <a href='products.php?do=Delete&cid=".$row['prod_id']."' class='btn btn-danger confirm'>Delete <i class='fa fa-close'></i>  </a>
                    </td>
                </tr>
            ";
            $i++;
        }
        ?>
            </table>
        </div>
        <a style="float:right" href="products.php?do=Add" class="btn btn-primary">
            <i class="fa fa-plus"></i> New Product
        </a>
    </div>
        <?php
    }else{
    ?>
        <a style="float:right" href="products.php?do=Add" class="btn btn-primary">
            <i class="fa fa-plus"></i> New Product
        </a>
           
        <?php } ?>         
                      
                    </div>
                </div>    

		<?php 
		} elseif ($do == 'Edit') {
             $stmt = $con->prepare("SELECT products.*,categories.* FROM products INNER JOIN categories ON categories.cat_id=products.category WHERE prod_id=? LIMIT 1");
            $stmt->execute(array($_GET['cid']));
            $rows = $stmt->fetchAll();
            if (! empty($rows)) {
                foreach($rows as $row) {
             ?>

			<h1 class="text-center"> Edit Product</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10 col-md-6">
							<input value="<?php echo $_GET['cid']; ?>" type="hidden" name="cid" class="form-control" autocomplete="off" required="required" placeholder="write Title.." />
							<input value="<?php echo $row['cover']; ?>" type="hidden" name="oldCover" class="form-control" autocomplete="off" required="required" placeholder="write Title.." />
							<input value="<?php echo $row['title']; ?>" type="text" name="title" class="form-control" autocomplete="off" required="required" placeholder="write Title.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input value="<?php echo $row['price']; ?>" type="text" name="price" class="form-control" autocomplete="off" required="required" placeholder="write Price.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Image</label>
						<div class="col-sm-10 col-md-6">
							<input  type="file" name="cover" class="form-control" autocomplete="off" placeholder="write Type.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
                            <select class="form-control" name="category">
                            <option value="<?php echo $row['cat_id']; ?>" selected><?php echo $row['category']; ?></option>
                             <?php
                                $stmt1 = $con->prepare("SELECT * FROM categories ORDER BY cat_id DESC");
                                $stmt1->execute();
                                $rows1 = $stmt1->fetchAll();
                                if (! empty($rows1)) {
                                    foreach($rows1 as $row1) {
                                        echo '<option value="'.$row1['cat_id'].'">'.$row1['category'].'</option>';
                                    }
                                }
                           ?>
                            </select>
                        </div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Details</label>
						<div class="col-sm-10 col-md-6">
                            <textarea required="required"  class="form-control" rows="5" name="about" placeholder="write Details.." ><?php echo $row['description']; ?></textarea>
                        </div>
					</div>
				
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Edit Product" class="btn btn-success btn-lg " />
						</div>
					</div>
				</form>
			</div>

		<?php 
                }
            }
		} elseif ($do == 'Update') {  
		
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				echo "<h1 class='text-center'>Update Product</h1>";
				echo "<div class='container'>";
		
                $cid = $_POST['cid'];
                $oldCover = $_POST['oldCover'];
                $title = $_POST['title'];
				$price = $_POST['price'];
				$category   = $_POST['category'];
				$about  = $_POST['about'];

				$formErrors = array();
				if (empty($title) || empty($cid)) {
					$formErrors[] = 'Title Cant Be <strong>Empty</strong>';
				}
				if (empty($about)) {
					$formErrors[] = 'Details Cant Be <strong>Empty</strong>';
				}
				foreach($formErrors as $error) {
					echo '<div class="container alert alert-danger">' . $error . '</div>';
				}
				if (empty($formErrors)) {
					$check = checkItem("prod_id", "products", "ss");
					if ($check == 1) {
						$theMsg = '<div class="container alert alert-danger">Sorry This Section Is Exist</div>';
						redirectHome($theMsg, 'back');
					} else {
                        if(empty($_FILES['cover']['name'])){
                          $avatar=$_POST['oldCover'];
                      }else{      
                        $avatarName = $_FILES['cover']['name'];
                        $avatarSize = $_FILES['cover']['size'];
                        $avatarTmp	= $_FILES['cover']['tmp_name'];
                        $avatarType = $_FILES['cover']['type'];
                        $avatarExtension = strtolower(end(explode('.', $avatarName)));
                        $avatar = rand(0, 10000000000) . '_' . $avatarName;
                        move_uploaded_file($avatarTmp, "Data//" . $avatar);
                      }
						$stmt = $con->prepare("UPDATE products SET title=?, price=?, cover=?, category=?, description=? WHERE prod_id=?  ");
						$stmt->execute(array($title,$price,$avatar,$category,$about,$cid));
						$theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . ' Product Updated</div>';
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
            
		} elseif ($do == 'Add') {  ?>

			<h1 class="text-center"> New Product</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="title" class="form-control" autocomplete="off" required="required" placeholder="write Title.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="price" class="form-control" autocomplete="off" required="required" placeholder="write Price.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
                            <select class="form-control" name="category">
                             <?php
                                $stmt1 = $con->prepare("SELECT * FROM categories ORDER BY cat_id DESC");
                                $stmt1->execute();
                                $rows1 = $stmt1->fetchAll();
                                if (! empty($rows1)) {
                                    foreach($rows1 as $row1) {
                                        echo '<option value="'.$row1['cat_id'].'">'.$row1['category'].'</option>';
                                    }
                                }
                           ?>
                            </select>
                        </div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Image</label>
						<div class="col-sm-10 col-md-6">
							<input type="file" name="cover" class="form-control" autocomplete="off" required="required" placeholder="write Place.." />
						</div>
					</div>
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Details</label>
						<div class="col-sm-10 col-md-6">
                            <textarea required="required"  class="form-control" rows="5" name="about" placeholder="write Details.." ></textarea>
                        </div>
					</div>
				
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Product" class="btn btn-primary btn-lg " />
						</div>
					</div>
				</form>
			</div>

		<?php 
		} elseif ($do == 'Insert') {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				echo "<h1 class='text-center'>Insert Product</h1>";
				echo "<div class='container'>";
		
                $title = $_POST['title'];
                $price = $_POST['price'];
				$category = $_POST['category'];
				$about  = $_POST['about'];

				$formErrors = array();
				if (empty($title)) {
					$formErrors[] = 'Title Cant Be <strong>Empty</strong>';
				}
				if (empty($price)) {
					$formErrors[] = 'Price Cant Be <strong>Empty</strong>';
				}
				foreach($formErrors as $error) {
					echo '<div class="container alert alert-danger">' . $error . '</div>';
				}
				if (empty($formErrors)) {
					
					$check = checkItem("title", "products", $title);
					if ($check == 1) {
						$theMsg = '<div class="container alert alert-danger">Sorry This Term Is Exist</div>';
						redirectHome($theMsg, 'back');
					} else {
                      if(empty($_FILES['cover']['name'])){
                          $avatar='cover.jpg';
                      }else{      
                        $avatarName = $_FILES['cover']['name'];
                        $avatarSize = $_FILES['cover']['size'];
                        $avatarTmp	= $_FILES['cover']['tmp_name'];
                        $avatarType = $_FILES['cover']['type'];
                        $avatarExtension = strtolower(end(explode('.', $avatarName)));
                        $avatar = rand(0, 10000000000) . '_' . $avatarName;
                        move_uploaded_file($avatarTmp, "Data//" . $avatar);
                      }
						$stmt = $con->prepare("INSERT INTO `products` (`prod_id`, `title`, `cover`, `description`, `price`, `date`, `category`, `rate`) VALUES (NULL, :title, :cover, :description, :price, current_timestamp(), :category, '5') ");
						$stmt->execute(array(
							'title'   => $title,
							'cover' => $avatar,
							'description' => $about,
							'price' => $price ,
							'category' => $category
						));
						$theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . ' Product Inserted</div>';
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
		}  elseif ($do == 'Show') { 
           
				$cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
				$check = checkItem('prod_id', 'products', $cid);
				if ($check > 0) {
                     echo "<h1 class='text-center'> Product</h1>";
			         echo "<div class='container'>";
					$stmt = $con->prepare("SELECT * FROM products WHERE prod_id=? ");
                    $stmt->execute(array($cid));
                    $rows = $stmt->fetchAll();
                    if (! empty($rows)) {
                        foreach($rows as $row){
                           echo '<div style="text-align:center;width:100%">
                           <br/><img width="255" src="Data/'.$row['cover'].'" /> <hr/>
                           </div>
                           <div class="row">
                                
                                <div class="col-sm-10">
                                        <div class="col-sm-8"><h2 class="text-center">'.$row['title'].'</h2><p>'.$row['description'].'</p></div>
                                        <div class="row">
                                        <div class="col-sm-4">
                                            <hr/>
                                            <p><b>Price: </b>'.$row['price'].'</p>
                                            <p><b>Rate: </b>'.$row['rate'].'</p>
                                            <hr/>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-2">
                                    <a href="products.php" class="btn btn-danger btn-block" >Back</a>
                                </div>
                            </div>
                            
                            
                            '; 
                        }
                    }
                    echo '</div>';
				} else {
					$theMsg = '<div class="container alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			
		} elseif ($do == 'Delete') { 
			echo "<h1 class='text-center'>Delete Product</h1>";
			echo "<div class='container'>";
				$cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
				$check = checkItem('prod_id', 'products', $cid);
				if ($check > 0) {
					$stmt = $con->prepare("DELETE FROM products WHERE prod_id = :zuser");
					$stmt->bindParam(":zuser", $cid);
					$stmt->execute();
					$theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . ' Product Deleted</div>';
					redirectHome($theMsg, 'back');
				} else {
					$theMsg = '<div class="container alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			echo '</div>';
		}
    } 
include $DirTemp . 'footer.php';

	ob_end_flush(); 
?>
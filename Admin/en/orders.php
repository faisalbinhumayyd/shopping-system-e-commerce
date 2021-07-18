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
    $stmt = $con->prepare("SELECT products.*,users.*,orders.* FROM `orders` INNER JOIN products ON products.prod_id=orders.prod_id INNER JOIN users ON orders.user_id=users.user_id ");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if (! empty($rows)) {?>
       <h1 class="text-center">Orders</h1>
        <div>
        <div class="table-responsive">
            <table class="main-table manage-members text-center table table-bordered">
                <tr>
                    <td>#ID</td>
                    <td>User</td>
                    <td>Title</td>
                    <td>Price</td>
                    <td>Status</td>
                    <td>Control</td>
                </tr>
       <?php
        $i=1;
        foreach($rows as $row) {
            if($row['status']==2){
                $status='Active';
            }elseif($row['status']==3){
                $status='Accepted';
            }else{
                $status='Rejected';
            }
            echo "
            <tr>
                    <td>".$i."</td>
                    <td>".$row['fullname']."</td>
                    <td>".$row['title']."</td>
                    <td>".$row['price']."</td>
                    <td>".$status."</td>
                    <td>";
                    echo "    
                        <a href='orders.php?do=Action&status=3&cid=".$row['order_id']."' class='btn btn-success'>Accept <i class='fa fa-check'></i> </a>
                        <a href='orders.php?do=Action&status=1&cid=".$row['order_id']."' class='btn btn-danger'>Reject <i class='fa fa-close'></i> </a>
                    </td>
                </tr>
            ";
            $i++;
        }
        ?>
            </table>
        </div>
    </div>
        <?php
    }else{
    ?>
        لا يوجد طلبات حتى الان
           
        <?php } ?>         
                      
                    </div>
                </div>    

		<?php 
		}  elseif ($do == 'Action') { 
			echo "<h1 class='text-center'>Order Control</h1>";
			echo "<div class='container'>";
				$cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
				$check = checkItem('order_id', 'orders', $cid);
				if ($check > 0) {
					$stmt = $con->prepare("UPDATE orders SET status=? WHERE order_id = ?");
					$stmt->execute(array($_GET['status'],$cid));
					$theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . ' Action Done</div>';
					redirectHome($theMsg, 'back');
				} else {
					$theMsg = '<div class="container alert alert-danger">This ID is Not Exist</div>';
					redirectHome($theMsg);
				}
			echo '</div>';
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
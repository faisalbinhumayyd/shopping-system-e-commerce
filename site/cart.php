<?php 
include 'init.php';
session_start();
    if (!isset($_SESSION['uid'])) {
		header('Location: ../enter/');
	}
if(isset($_GET['pid'])&&!isset($_GET['delete'])){
    $stmt = $con->prepare("INSERT INTO `carts` (`cart_id`, `user_id`, `prod_id`) VALUES (NULL, ?, ?) ");
    $stmt->execute(array($_SESSION['uid'],$_GET['pid']));
}
if(isset($_GET['delete'])){
    $stmt = $con->prepare("DELETE FROM `carts` WHERE prod_id=?  ");
    $stmt->execute(array($_GET['delete']));
}
?>

    <div id="Home" class="container ">
        <div class="over ">
           <h1 style="color: #415162;"><i style="font-size: 3rem;color: #415162;" class="fa fa-shopping-cart"></i> Shop Cart </h1>
            <hr/>  
        </div>
        <div class="row">
            
               <?php
            
                $stmt = $con->prepare("SELECT * FROM `products` WHERE prod_id IN (SELECT prod_id FROM carts) ");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if (! empty($rows)) {
                    foreach($rows as $row) {
                        echo '<div class="col-sm-3">
                        <div class="card" >
                          <img class="card-img-top" height="200px" src="../Admin/en/Data/'.$row['cover'].'" width="100%" alt="Card image cap">
                          <div class="card-body">
                            <a href="details.php?pid='.$row['prod_id'].'"><h5 style="color:blue" class="card-title">'.$row['title'].'</h5></a>
                            <p class="card-text">'.$row['description'].'.</p>
                            <a href="?delete='.$row['prod_id'].'" class="btn btn-danger btn-sm btn-block">Delete <i style="color:white" class="fa fa-times"></i></a>
                          </div>
                        </div>
                        </div>';
                    }
                }
                ?>
        </div>
    </div>
<?php include $DirTemp .'Footer.php'; ?>

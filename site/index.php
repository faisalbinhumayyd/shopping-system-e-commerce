<?php 
include 'init.php'; 
    session_start();
    if (!isset($_SESSION['uid'])) {
		header('Location: ../enter/');
	}
?>

    <div id="Home" class="container ">
        <div class="over ">
            <div style="text-align:center" class="row ">
               Order:&nbsp; <a href="?order=recent">Recent Products</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="?order=best">Best Products</a> 
            </div>
            <hr/>  
        </div>
        <div class="row">
            
               <?php
            if(!isset($_GET['order']) || $_GET['order']=='recent'){
                $order= " ORDER BY prod_id DESC"; 
            }else{
                $order= " ORDER BY rate DESC";
            }
                $stmt = $con->prepare("SELECT * FROM `products` ".$order);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if (! empty($rows)) {
                    foreach($rows as $row) {
                        echo '<div class="col-sm-3">
                        <div class="card" >
                          <img class="card-img-top" height="200px" src="../Admin/en/Data/'.$row['cover'].'" width="100%" />
                          <div class="card-body">
                            <a href="details.php?pid='.$row['prod_id'].'"><h5 style="color:blue" class="card-title">'.$row['title'].'</h5></a>
                            <p class="card-text">'.$row['description'].'.</p>
                            <a href="cart.php?pid='.$row['prod_id'].'" class="btn btn-primary btn-block">Shop Cart <i style="color:white" class="fa fa-shopping-cart"></i></a>
                          </div>
                        </div>
                        </div>';
                    }
                }
                ?>
        </div>
    </div>
<?php include $DirTemp .'Footer.php'; ?>

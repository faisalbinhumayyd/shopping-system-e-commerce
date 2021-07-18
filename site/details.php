<?php 
include 'init.php';
session_start();
    if (!isset($_SESSION['uid'])) {
		header('Location: ../enter/');
	}
if(isset($_POST['feed'])){
    $stmt = $con->prepare("INSERT INTO `feedback` (`feed_id`, `user_id`, `prod_id`, `feedback`) VALUES (NULL, ?, ?, ?) ");
    $stmt->execute(array($_SESSION['uid'],$_GET['pid'],$_POST['feed']));
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

    
            
               <?php
            
                $stmt = $con->prepare("SELECT * FROM `products` WHERE prod_id = ? LIMIT 1 ");
                $stmt->execute(array($_GET['pid']));
                $rows = $stmt->fetchAll();
                if (! empty($rows)) {
                    foreach($rows as $row) {
                        echo '
                        <div id="Home" class="container ">
                        <div class="over ">
                           <h1 style="color: #415162;"><i style="font-size: 3rem;color: #415162;" class="fa fa-shopping-cart"></i> '.$row['title'].' </h1>
                            <hr/>  
                        </div>
                        <div class="row">
                        <div class="col-sm-3">
                        <div class="card" >
                          <img class="card-img-top" height="200px" src="../Admin/en/Data/'.$row['cover'].'" width="100%" alt="Card image cap">
                          <div class="card-body">
                            <h5 class="card-title">'.$row['title'].'</h5>
                            </div>
                        </div>
                        
                        </div> <div class="col-sm-7">'.$row['description'].'</div> </div>
    ';
                    }
                }
                ?>
                <hr/>
                <b>FeedBacks</b>
                <ul style="max-width:20rem">
                   <?php
                     $stmt = $con->prepare("SELECT * FROM `feedback` WHERE prod_id = ? ");
                    $stmt->execute(array($_GET['pid']));
                    $rows = $stmt->fetchAll();
                    if (! empty($rows)) {
                        foreach($rows as $row) {
                            echo '<li>'.$row['feedback'].'</li>';
                        }
                    }else{
                       echo '<li>No Feedback</li>'; 
                    }
                    ?>
                    <li>
                       <form action="details.php?pid=<?php echo $_GET['pid']; ?>" method="POST">
                            <input required="required" style="max-width:14rem;display:inline" type="text" name="feed" class="form-control" placeholder="Leave your feedback.."  />
                            <button type="submit" style="max-width:4rem;display:inline" >Add</button>
                        </form>
                    </li>
                </ul>
                <hr/>
      <a href="index.php" class="btn btn-primary btn-block">Back to Shop</a></div>
<?php include $DirTemp .'Footer.php'; ?>

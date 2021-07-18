 <?php
    include 'init.php';
	session_start();
    if (!isset($_SESSION['uid'])) {
		header('Location: ../check');
	}
      
    $sqlq = "SELECT COUNT(user_id) FROM users"; 
    $resultq = $con->prepare($sqlq); 
    $resultq->execute(); 
    $userNum = $resultq->fetchColumn();


    $sqlqqq = "SELECT COUNT(cat_id) FROM categories "; 
    $resultqqq = $con->prepare($sqlqqq); 
    $resultqqq->execute(); 
    $catNum = $resultqqq->fetchColumn();
                            
         
   
    $sqlqqsq = "SELECT COUNT(prod_id) FROM products "; 
    $resultqsqq = $con->prepare($sqlqqsq); 
    $resultqsqq->execute(); 
    $prodNum = $resultqsqq->fetchColumn();
                            
         
           
  if(!isset($_SESSION['type'])&&$_SESSION['type']!='user'){         
?>
<style>
    .card{
        float: left!important;
        color: #ecf0f1;
        height: 110px;
        padding: 5px;
        padding-left: 10px;
    }
    .card .icon{
        float: left;
        color: #ecf0f1;
    }
    .card .part{
        padding-top: 22px;
    }
    .card .title{
        font-size: 24px;
        font-weight: bold;
    }
    .card .num{
        font-size: 22px;
    }
    
</style>
    <div style="width: 57%;" class="container">
  
        <a href="categories.php">
            <div style="background-image:linear-gradient(to bottom ,#e67e22 0,#d35400 60%);border:1px solid #d35400;" class="card">
                <i class="icon fa fa-comments"></i>
                <div class="text-center part">
                   <div class="num"><?php echo $catNum; ?></div>
                    <div style="padding-top:10px;" class="title">Categories</div> 
                </div>
            </div>
        </a>
        <a href="products.php">
            <div style="background-image:linear-gradient(to bottom ,#e67e22 0,#d35400 60%);border:1px solid #d35400;" class="card">
                <i class="icon fa fa-comments"></i>
                <div class="text-center part">
                   <div class="num"><?php echo $prodNum; ?></div>
                    <div style="padding-top:10px;" class="title">Products</div> 
                </div>
            </div>
        </a>
        <a href="users.php">
            <div style="background-image:linear-gradient(to bottom ,#1abc9c 0,#0d7a65 60%);border:1px solid #16a085;" class="card">
                <i class="icon fa fa-users"></i>
                <div class="text-center part">
                    <div class="num"><?php echo $userNum; ?></div>
                    <div class="title">Users</div> 
                </div>
            </div>
        </a>
       
        
    
    </div>
<?php }else{
?>
    <div style="text-align:center;margin:0 auto;width:100%">
    <img src="https://t4.ftcdn.net/jpg/03/64/94/67/240_F_364946785_HU0G0WLRpd9SjBxecLAy7En93HmdxbL5.jpg"  />
    </div>
    <?php
  }
    include $DirTemp . 'footer.php';
?>
<?php
	session_start();
	$noNav = '';
	$PageTitle = 'Login';

	if (isset($_SESSION['uid'])) {
		header('Location: ../en/'); 
	}

	include 'init.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$stmt = $con->prepare("SELECT * FROM users WHERE email = ?  AND password = ? AND status=2 LIMIT 1");
		$stmt->execute(array($email, $pass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if ($count > 0) {
			$_SESSION['uid'] = $row['user_id']; 
			header('Location: ../en/');
			exit();
		}else{
            echo "<div class='col-sm-4'></div><div style='text-align:right' class='col-sm-4 alert alert-danger'>Sorry, Wrong Data</div><div class='col-sm-4'></div>";
        }

	}

?>
    <div class="container">
        <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form id="login" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" >
                    <h1>Log In</h1>
                    <input name="email" class="form-control" placeholder="> Email ..." />
                    <input name="pass" type="password" class="form-control" placeholder="> Password ..." />
                    <button class="btn btn-primary btn-block">Log In </button>
                </form>
            </div>
        <div class="col-sm-4"></div>
    </div>


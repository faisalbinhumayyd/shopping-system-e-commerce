
<?php 
session_start(); 
if(isset($_SESSION['uid'])){
    header("Location: ../site/index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">
        <title>Enter System</title>
        <link href="style.css" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="767091639683-jfjctmiqgt7fb1nn7cpa9fen3lvaa8jg.apps.googleusercontent.com">
    </head>
    <body>
       <?php if(!empty($_GET['result'])){ echo '<p class="alert alert-warning" >'.$_GET['result'].'<p>'; } ?>
        <div class="form">
            <ul class="tab-group">
                <li class="tab active"><a href="#signup">Sign Up</a></li>
                <li class="tab"><a href="#login">Log In</a></li>
            </ul>
            <div class="tab-content">
                <div id="signup">   
                    <h1>Sign Up for Free</h1>
                    <form action="do.php" method="post">
                       <input type="hidden" name="type" value="signup" />
                        <div class="top-row">
                            <div class="field-wrap">
                                <label>
                                First Name<span class="req">*</span>
                                </label>
                                <input name="fname" type="text" required autocomplete="off" />
                            </div>
                            <div class="field-wrap">
                                <label>
                                Last Name<span class="req">*</span>
                                </label>
                                <input name="lname" type="text"required autocomplete="off"/>
                            </div>
                        </div>
                        <div class="field-wrap">
                            <label>
                            Email Address<span class="req">*</span>
                            </label>
                            <input name="email" type="email" required autocomplete="off"/>
                        </div>
                        <div class="field-wrap">
                            <label>
                            Set A Password<span class="req">*</span>
                            </label>
                            <input name="password" type="password"required autocomplete="off"/>
                        </div>
                        <button type="submit" class="button button-block"/>Get Started</button></br>
                        
                    </form>
                </div>
                <div id="login">   
                    <h1>Welcome Back!</h1>
                    <form action="do.php" method="post">
                       <input type="hidden" name="type" value="login" />
                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input name="email" type="email"required autocomplete="off"/>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Password<span class="req">*</span>
                            </label>
                            <input name="password" type="password"required autocomplete="off"/>
                        </div>
                        
                        <p class="forgot"><a href="#" data-toggle="modal" data-target="#exampleModal">Forgot Password?</a></p>
                        <button class="button button-block"/>Log In</button>
                        <p style="text-align:center;margin-top:20px ;color:#284684;">Or Sign In with one of these services
                        </p>
                        </form>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="https://facebook.com" class="loginBtn loginBtn--facebook" style="text-decoration:none;padding-bottom:5px;margin-left:0px;margin-top:20px;">
                                    Login with Facebook
                                    </a>
                                </div>
                                <div class="col-sm-6"><div class="g-signin2" data-onsuccess="onSignIn"></div></div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Forget Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form id="form" action="do.php" method="post">
                               <input type="hidden" name="type" value="forget" />
                                <label>Email: </label><br/><br/>
                                <input name="email" type="email" class="form-control" />
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button form="form" type="submit" class="btn btn-primary">Check Password</button>
                    </div>
                </div>
            </div>
        </div>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script  src="back.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>

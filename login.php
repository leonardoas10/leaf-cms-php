<?php 
include("includes/db.php"); 
include("includes/header.php");
ob_start(); 

checkIfUserIsLoggedInAndRedirect('/leaf-cms-php/admin');

if(ifItIsMethod('post')) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        login_user(escape(trim($_POST['username'])), escape(trim($_POST['password'])));
    } else {
        header("Location: /leaf-cms-php/login");
    }
}
?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body login-card">
                        <div class="text-center">
                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Login</h2>
                            <div class="panel-body">
                                <form id="login-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue user-icon"></i></span>
                                            <input name="username" type="text" class="form-control input-background" placeholder="Enter Username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue wallet-icon"></i></span>
                                            <input name="password" type="password" class="form-control input-background" placeholder="Enter Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="login" class="btn btn-lg btn-primary btn-block login-button" value="Login" type="submit">
                                    </div>
                                </form>
                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->
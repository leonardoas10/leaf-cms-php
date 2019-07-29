<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
<?php 

if(isset($_POST['submit'])) {
    $firstname = escape(ucwords($_POST['firstname']));
    $lastname = escape(ucwords($_POST['lastname']));
    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
    
    if(!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($password)) {
        
        $firstname = mysqli_real_escape_string($connection, ucwords($firstname));
        $lastname = mysqli_real_escape_string($connection, ucwords($lastname));
        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
    
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));       
        
        $query = "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_password, user_role) VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$password}', 'Subscriber')";
    
        $newUser = mysqli_query($connection, $query);
    
            if(!$newUser) {
                die("Query Failed" . mysqli_error($connection));
            }
        $message = "Your registration has been submitted";
        
    } else {
        $message = "Fields cannot be empty";
    }
} else {
    $message = "";
}
?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center">Become A New User</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       <h6 class="text-center"><?php echo $message?></h6>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control input-background" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control input-background" placeholder="Enter Last Name">
                        </div>
                       
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control input-background" placeholder="Enter Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control input-background" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control input-background" placeholder="Enter Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="register-button btn btn-custom btn-lg btn-block " value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

    <hr>

<?php include "includes/footer.php";?>

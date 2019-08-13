<?php
use Pusher\Pusher;

ob_start();
include "includes/db.php";
include "includes/header.php";
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$options = array(
    'cluster' => 'us2',
    'useTLS' => true
);

$pusher = new Pusher(getenv('APP_KEY'),getenv('APP_SECRET'),getenv('APP_ID'),$options);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = escape(ucwords($_POST['firstname']));
    $lastname = escape(ucwords($_POST['lastname']));
    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
 
    $error = [
        'firstname' => '',
        'lastname' => '',
        'username' => '',
        'email' => '',
        'password' => '',
    ];
        
    if (empty($firstname)) {
        $error['firstname'] = "<h4 class='text-center bg-danger'> First Name cannot be empty</h4>";
    } else if (strlen($firstname) < 2) {
        $error['firstname'] = "<h4 class='text-center bg-danger'> First Name: '$firstname' needs to be longer</h4>";
    } 

    if (empty($lastname)) {
        $error['lastname'] = "<h4 class='text-center bg-danger'> Last Name cannot be empty</h4>";
    } else if (strlen($lastname) < 2) {
        $error['lastname'] = "<h4 class='text-center bg-danger'> Last Name: '$lastname' needs to be longer</h4>";
    } 
    
    if (empty($username)) {
        $error['username'] = "<h4 class='text-center bg-danger'> Username cannot be empty</h4>";
    } else if (strlen($username) < 4) {
        $error['username'] = "<h4 class='text-center bg-danger'> Username: '$username' needs to be longer</h4>";
    } else if (username_exists($username)) {
        $error['username'] = "<h4 class='text-center bg-danger'> Username: '$username' already in use </h4>";
    }  
    
    if (empty($email)) {
        $error['email'] = "<h4 class='text-center bg-danger'> Email cannot be empty</h4>";
    } else if (strlen($email) < 4) {
        $error['email'] = "<h4 class='text-center bg-danger'> Email: '$email' needs to be longer</h4>";
    } else if (email_exists($email)) {
        $error['email'] = "<h4 class='text-center bg-danger'> Email: '$email' already in use </h4>";
    }  

    if (empty($password)) {
        $error['password'] = "<h4 class='text-center bg-danger'> Password cannot be empty</h4>";
    } else if (strlen($password) < 4) {
        $error['password'] = "<h4 class='text-center bg-danger'> Password needs to be longer</h4>";
    }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {
        registration_user($firstname, $lastname, $username, $email, $password);

        $data['message'] = $username;
        $pusher->trigger('notifications', 'new_user', $data);
        login_user($username, $password);
    }
}
?>

<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1 class="text-center">Become A New User</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="firstname" class="sr-only">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control input-background" placeholder="Enter First Name">
                                <p for=""><?php echo isset($error['firstname']) ? $error['firstname'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="sr-only">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control input-background" placeholder="Enter Last Name">
                                <p for=""><?php echo isset($error['lastname']) ? $error['lastname'] : '' ?></p>
                            </div>

                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control input-background" placeholder="Enter Username">
                                <p for=""><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control input-background" placeholder="somebody@example.com">
                                <p for=""><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control input-background" placeholder="Enter Password">
                                <p for=""><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="register-button btn btn-custom btn-lg btn-block " value="Register">
                            <p for=""><?php echo isset($_GET['success']) ? "<h4 class='text-center bg-success'> User Created </h4>" : "" ?></p>
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>

    <hr>

    <?php include "includes/footer.php"; ?>
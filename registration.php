<?php
use Pusher\Pusher;

ob_start();
include "includes/db.php";
include "includes/header.php";
require 'vendor/autoload.php';

if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];

    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'>location.reload</script>";
    }
}

if(isset($_SESSION['lang'])) {
    include "includes/languages/" . $_SESSION['lang'] . ".php";
} else {
    include "includes/languages/en.php";
}

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
    <form class="navbar-form navbar-right" action=""  id="language_form">
    <div class="form-group">
        <select name="lang" class="form-control input-background" onchange="changeLanguage()">
            <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {echo "selected";} ?>>English</option>
            <option value="es" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'es') {echo "selected";} ?>>Spanish</option>
        </select>
    </div>
    </form>
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1 class="text-center"><?=translate["_REGISTER"] ?></h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <input type="text" name="firstname" id="firstname" class="form-control input-background" placeholder="<?=translate["_FIRSTNAME"]?>">
                                <p for=""><?php echo isset($error['firstname']) ? $error['firstname'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastname" id="lastname" class="form-control input-background" placeholder="<?=translate["_LASTNAME"] ?>">
                                <p for=""><?php echo isset($error['lastname']) ? $error['lastname'] : '' ?></p>
                            </div>
                            <div class="form-group">    
                                <input type="text" name="username" id="username" class="form-control input-background" placeholder="<?=translate["_USERNAME"] ?>">
                                <p for=""><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control input-background" placeholder="<?=translate["_EMAIL"] ?>">
                                <p for=""><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="key" class="form-control input-background" placeholder="<?=translate["_PASSWORD"] ?>">
                                <p for=""><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="register-button btn btn-custom btn-lg btn-block " value="<?=translate["_REGISTERBUTTON"] ?>">
                            <p for=""><?php echo isset($_GET['success']) ? "<h4 class='text-center bg-success'> User Created </h4>" : "" ?></p>
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>

    <hr>
    <script>
        function changeLanguage() {
            document.getElementById("language_form").submit();
        }
    </script>

    <?php include "includes/footer.php"; ?>
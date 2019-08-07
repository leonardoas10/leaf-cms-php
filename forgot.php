<?php
include "includes/db.php";
include "includes/header.php";

use PHPMailer\PHPMailer\PHPMailer;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

if (!isset($_GET['forgot'])) {
    header("Location: /leaf-cms-php/");
}

if (ifItIsMethod('post')) {
    if (isset($_POST['email'])) {
        $email = escape($_POST['email']);
        $lenght = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($lenght));

        if (email_exists($email)) {

            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ?")) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                // CONFIGURE PHPMAILER
                $mail = new PHPMailer();
                $mail->SMTPDebug = 0; //to see bugs change: 2                                 
                $mail->isSMTP();      
                $mail->SMTPAuth   = true;    
                $mail->SMTPSecure = 'tls';                             
                $mail->Host       = Config::SMTP_HOST;   
                $mail->Username   = Config::SMTP_USER;                    
                $mail->Password   = Config::SMTP_PASSWORD;                           
                $mail->Port       = Config::SMTP_PORT;
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('leoaranguren10@gmail.com', 'Leonardo Aranguren');
                $mail->addAddress($email);
                $mail->Subject = 'This is a test email';
                $mail->Body = '
                
                <p>Please click here to reset your password<a href="http://localhost/leaf-cms-php/reset.php?email=' . $email . '&token=' .$token. ' " target=_blank " >http://localhost/leaf-cms-php/reset.php?email=' . $email . '&token=' .$token. '"</a></p>
                
                ';

                if($mail->send()) {
                    $emailSent = true;
                } else {
                    echo 'not send';
                }
                
            } else {
                echo mysqli_error($connection);
            }
        }
    }
}



?>



<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body forgot-card">
                        <div class="text-center">

                        <?php if(!isset($emailSent)): ?>

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">




                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon "><i class="glyphicon glyphicon-envelope color-blue email-icon"></i></span>
                                            <input id="email" name="email" placeholder="Email Address" class="form-control input-background" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block forgot-button" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                                <?php else: ?>

                                <h2>Please check your email: <?php echo $email?></h2>

                                <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->
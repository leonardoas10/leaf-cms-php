<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
<?php 

// FOR PHP MAILER
//    $newUser = mysqli_query($connection, $query);
//    
//        if(!$newUser) {
//            die("Query Failed" . mysqli_error($connection));
//        }
//    $message = "Your registration has been submitted";
//        
//    } else {
//        $message = "Fields cannot be empty";
//    }
//} else {
//    $message = "";
//}
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
                <h1 class="text-center">Contact Us</h1>
                    <form role="form" action="./phpMailer/MailerConfig.php" method="post" id="login-form" autocomplete="off">
<!--                       <h6 class="text-center"><php echo $message?></h6> ACTIVE PHPMAILER ADD -> ? --> 
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control input-background" placeholder="Enter your Email">
                        </div> 
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control input-background" placeholder="Enter your Subject">
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" id="body" cols="30" rows="10" name="body"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="register-button btn btn-custom btn-lg btn-block " value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
       
        <hr>

<?php include "includes/footer.php";?>

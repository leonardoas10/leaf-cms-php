<?php ob_start(); ?>
<?php include("includes/admin_header.php") ?>
    <div id="wrapper">
       
       <?php 
        
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $query = "SELECT * FROM users WHERE username = '{$username}'";
            $select_user_profile_query = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_array($select_user_profile_query)) {
                
                $user_id = $row['user_id'];
                $username =   stripcslashes($row['username']);
                $user_password = stripcslashes($row['user_password']);
                $user_firstname = stripcslashes($row['user_firstname']);
                $user_lastname = stripcslashes($row['user_lastname']);
                $user_email = $row['user_email'];
                $user_image = stripcslashes($row['user_image']);
            }
        }
        
        
        ?>
        
        
        <?php 
        
            if(isset($_POST{'edit_user'})) {  
        
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        
        $username = mysqli_real_escape_string($connection, $_POST['username']) ;
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
     
//        move_uploaded_file($post_image_temp, "../images/$post_image");
        
       $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}',  username = '{$username}', user_email = '{$user_email}', user_password = '{$user_password}' WHERE username = '{$username}'";
    
    $edit_user_query = mysqli_query($connection, $query); 
    confirmQuery($edit_user_query);
                
        header("Location: profile.php");
    }
?>
       
        <?php include("includes/admin_navigation.php") ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $_SESSION['user_firstname'] . " "; echo $_SESSION['user_lastname'];?>
                            <small><?php echo $_SESSION['username'];?></small>
                        </h1>
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="user_firstname">Firstname</label>
                                <input type="text" class="form-control input-background"  name="user_firstname" value="<?php echo $user_firstname ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_lastname">Lastname</label>
                                <input type="text" class="form-control input-background"  name="user_lastname" value="<?php echo $user_lastname ?>">
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control input-background"  name="username" value="<?php echo $username ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="email" class="form-control input-background"  name="user_email" value="<?php echo $user_email ?>">

                            </div>

                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input autocomplete="off" type="password" class="form-control input-background" name="user_password">
                                

                            </div>

                            <div class="form-group">
                                 <input class="btn btn-success submit-buttons" type="submit" name="edit_user" value="Update Profile">
                            </div>

                        </form>  
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
    
        <!-- /#page-wrapper -->
        
        <?php include("includes/admin_footer.php") ?>

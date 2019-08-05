
<?php 

    if(ifItIsMethod('post')) {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            login_user(escape(trim($_POST['username'])), escape(trim($_POST['password'])));
        } else {
            header("Location: /leaf-cms-php/index");
        }
    }

?>


<div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                        <div class="input-group">
                            <input name="search"type="text" class="form-control input-background" placeholder="Search">
                            <span class="input-group-btn">
                                <button name="submit" class="btn btn-default search-button" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                
                 <!-- Login -->
                <div class="well">
                   
                   <?php if(isset($_SESSION['user_role'])): ?>
                          <div class="text-center">
                                <h4>Logged in as <?php echo $_SESSION['username'] . "!"?></h4> 
                                <a href="includes/logout.php" class="btn btn-primary text-center search-button">Log Out</a>  
                          </div>
                           
                   <?php else: ?>
                       <h4>Login</h4>
                    <form method="post">
                        <div class="form-group">
                            <input name="username" type="text" class="form-control input-background" placeholder="Enter Username">
                        </div>
                        <div class="input-group">
                            <input name="password" type="password" class="form-control input-background" placeholder="Enter Password">
                            <span class="input-group-btn">
                                <button class="btn btn-primary login-button" name="login" type="submit"> 
                                  Submit     
                                </button>
                            </span>
                        </div>

                        <div class="form-group">
                            <a href="forgot.php?forgot=<?php echo uniqid(true)?>">Forgot Password</a>
                        </div>
                    </form>
                    <!-- /.input-group -->   
                   <?php endif; ?>
                    
                </div>  

                <!-- Blog Categories Well -->
                <div class="well">
                   
                <?php 
                    $query = 'SELECT * FROM categories';
                    $select_categories_sidebar = mysqli_query($connection, $query);
                ?>
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                           
                            <ul class="list-unstyled">
                               <?php
                               while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                   $cat_title = $row['cat_title'];
                                   $cat_id = $row['cat_id'];
                    
                    echo "<li><a class='categories-list' href='category.php?category=$cat_id'>{$cat_title}</a></li>";}
                               ?>                         
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- Side Widget Well -->
                <?php include("widget.php");?>

            </div>
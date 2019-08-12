<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container"> 
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/leaf-cms-php"><span class="navbar-brand glyphicon glyphicon-leaf leaf-icon"></span></a>
            <a class=" navbar-brand navbar-title" href="/leaf-cms-php">Leaf CMS</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
        <?php 
            $query = 'SELECT * FROM categories';
            $select_all_categories = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_all_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];                    
                $category_class = '';
                $registration_class = '';
                $contact_class = '';
                $pageName = basename($_SERVER['PHP_SELF']);
                $registration = 'registration.php';
                $contact = 'contact.php';
                
                if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                    $category_class = 'active';
                } else if($pageName == $registration){
                    $registration_class = 'active';
                } else if($pageName == $contact){
                    $contact_class = 'active';
                } 
                echo "<li class='$category_class'><a class='navbar-subtitles' href='/leaf-cms-php/category/$cat_id/1'>{$cat_title}</a></li>";
            }
            ?>
                <li class="<?php echo $contact_class; ?>" ><a class="navbar-subtitles" href='/leaf-cms-php/contact'>Contact Us</a></li>
            </ul>    
            <ul class="nav navbar-nav navbar-right">
            <?php if(isLoggedIn()): ?>
                <li><a class="navbar-subtitles" href='/leaf-cms-php/admin'>Admin</a></li>
                <li><a class="navbar-subtitles" href='/leaf-cms-php/includes/logout'>Log Out</a></li>
            <?php else:?> 
                <li><a class="navbar-subtitles" href='/leaf-cms-php/login '>Login</a></li>
            <?php endif;?>   
                <li class="<?php echo $registration_class; ?>"><a class="navbar-subtitles" href='/leaf-cms-php/registration'>Registration</a></li>
            <?php 
                
            if(isset($_SESSION['user_role'])) {
                if(isset($_GET['p_id'])) {                  
                    $the_post_id = $_GET['p_id'];
                    echo "<li><a class='navbar-subtitles' href='/leaf-cms-php/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                }
            }   
            ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
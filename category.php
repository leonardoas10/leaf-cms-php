<?php include("includes/db.php"); ?>
<?php include("includes/header.php"); ?>
<?php include("includes/navigation.php"); ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if (isset($_GET['category'])) {

                if (!isset($_GET['page'])) {
                    header("Location: index.php?page=1");
                }

                $per_page = 5;
                $page = $_GET['page'];

                if ($page == "" || $page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }
                
                $category = $_GET['category'];

                if (is_admin($_SESSION['username'])) {
                    $stm1 = mysqli_prepare($connection, "SELECT post_id, post_title, 
                        post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");

                } else {
                    $stm2 = mysqli_prepare($connection, "SELECT post_id, post_title, 
                        post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");

                    $published = "Published";
                }
            }

            if(isset($stm1)) {
                mysqli_stmt_bind_param($stm1, "i", $category);
                mysqli_stmt_execute($stm1);
                mysqli_stmt_bind_result($stm1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

                $stm = $stm1;
            } else {
                mysqli_stmt_bind_param($stm2, "is", $category, $published);
                mysqli_stmt_execute($stm2);
                mysqli_stmt_bind_result($stm2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

                $stm = $stm2;
            }

            mysqli_stmt_store_result($stm); 

            $count = mysqli_stmt_num_rows($stm);
            $count = ceil($count / $per_page); 

            if (mysqli_stmt_num_rows($stm) === 0) {
                echo "<h1 class='text-center'>No Post Available</h1>";
            }
           

            $stm3 = mysqli_prepare($connection, "SELECT post_id, post_title, 
                        post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? LIMIT  $page_1,  $per_page");

            mysqli_stmt_bind_param($stm3, "i", $category);
            mysqli_stmt_execute($stm3);
            mysqli_stmt_bind_result($stm3, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

                while (mysqli_stmt_fetch($stm3)) {
                    
                    ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a class="post-title" href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        Posted by: <?php echo $post_user ?>
                    </p>
                    <p><span class="glyphicon glyphicon-time time-icon"></span> Posted on <?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="/">
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary read-more" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                <?php }
             ?>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>
    </div>
    <!-- /.row -->

    <hr>

    <ul class="pager">
        <?php
        for ($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='category.php?category={$category}&page={$i}'>{$i}</a></li>";
            } else {
                echo "<li><a class='inactive_link' href='category.php?category={$category}&page={$i}'>{$i}</a></li>";
            }
        }
        ?>
    </ul>

    <?php include("includes/footer.php"); ?>
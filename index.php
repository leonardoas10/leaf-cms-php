<?php 
include("includes/db.php");
include("includes/header.php");
include("includes/navigation.php"); 
?>   
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php 
            if(!isset($_GET['page'])) {
                header("Location: /leaf-cms-php/1");
            }
                
            $per_page = 5;
            $page = $_GET['page'];

            if($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }
            
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {     
                $result = query("SELECT * FROM posts");
            } else {
                $result = query("SELECT * FROM posts WHERE post_status = 'Published' ");
            }
            
            $count = mysqli_num_rows($result);
            
            if($count < 1) {
                echo "<h1 class='text-center'>No Post Available</h1>";
            } else {
            $count = ceil($count / $per_page);
            
            $result = query("SELECT * FROM posts LIMIT  $page_1,  $per_page");
                
            while($row = mysqli_fetch_assoc($result)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $post_status = $row['post_status'];  
            ?>
            <!-- First Blog Post -->
            <h2><a class="post-title" href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
            <p class="lead">Posted by: <?php echo $post_user?></p>
            <p><span class="glyphicon glyphicon-time time-icon"></span> Posted on <?php echo $post_date?></p>
            <hr>
            <a href="post.php?p_id=<?php echo $post_id;?>">
            <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image)?>" alt="/"></a>
            <hr>
            <p><?php echo $post_content?></p>
            <a class="btn btn-primary read-more" href="post/<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            <?php } }?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
            <?php include("includes/sidebar.php");?>
    </div>
    <!-- /.row -->
    <hr>
    <ul class="pager">
        <?php 
            for($i=1;$i<=$count; $i++) {
                if($i == $page) {
                    echo "<li><a class='active_link' href='/leaf-cms-php/{$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a class='inactive_link' href='/leaf-cms-php/{$i}'>{$i}</a></li>";
                }
            }
        ?>
    </ul>
        
<?php include("includes/footer.php"); ?>

        
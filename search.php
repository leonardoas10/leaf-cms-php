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
            if(isset($_POST['submit'])) {
                $search = escape($_POST['search']);
                $result = query("SELECT * FROM posts WHERE post_tags LIKE '%$search%' ");
                $count = mysqli_num_rows($result);

                if($count == 0) {
                    echo "<h1 class='text-center'>No Result</h1>";
                } else {
            
                while($row = mysqli_fetch_assoc($result)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content']; 
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
            
            <?php   }
                }
            }  
            ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php");?>
    </div>
    <!-- /.row -->

    <hr>
        
<?php include("includes/footer.php"); ?>

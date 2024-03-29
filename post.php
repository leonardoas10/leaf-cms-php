<?php
include("includes/db.php");
ob_start();
include("includes/header.php");
include("includes/navigation.php");

if (isset($_POST['liked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    // 1. FETCHING POST
    $result = query("SELECT * FROM posts WHERE post_id=$post_id");
    $post = mysqli_fetch_array($result);
    $likes = $post['post_likes'];

    // 2. UPDATE POST
    mysqli_query($connection, "UPDATE posts SET post_likes='{$likes}'+1 WHERE post_id='{$post_id}'");

    // 3. CREATE LIKES FOR POST
    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
}
if (isset($_POST['unliked'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    // 1. FETCHING POST
    $result = query("SELECT * FROM posts WHERE post_id=$post_id");
    $post = mysqli_fetch_array($result);
    $likes = $post['post_likes'];
    mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
    // 2. UPDATE POST
    mysqli_query($connection, "UPDATE posts SET post_likes='{$likes}'-1 WHERE post_id='{$post_id}'");
}
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if (isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];
                $result = query("UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id");

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'Published'";
                }

                $select_all_posts = mysqli_query($connection, $query);

                if (mysqli_num_rows($select_all_posts) < 1) {
                    echo "<h1 class='text-center'>No Post Available</h1>";
                } else {

                    while ($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        ?>
                        <h1 class="page-header">Posts</h1>
                        <!-- First Blog Post -->
                        <h2 class="post-title-selected"><?php echo $post_title ?></h2>
                        <p class="lead">Posted by <?php echo $post_user ?></p>
                        <p><span class="glyphicon glyphicon-time time-icon"></span> Posted on <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="/leaf-cms-php/images/<?php echo imagePlaceholder($post_image); ?>" alt="/">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <!-- <?php mysqli_stmt_free_result($stm); ?> -->

                        <hr>
                        <?php if (isLoggedIn()) {  ?>
                            <div class="row">
                                <p class="pull-right">
                                    <a class=" like-icon <?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'; ?>" href="">
                                    <span class="like-icon <?php echo userLikedThisPost($the_post_id) ? 'glyphicon glyphicon-thumbs-down' : 'glyphicon glyphicon-thumbs-up'; ?>"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="<?php echo userLikedThisPost($the_post_id) ? ' I liked this before' : ' Want to like it?'; ?>"
                                    ></span><?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like'; ?></a>
                                </p>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <p class="pull-right">You need to <a href="/leaf-cms-php/login">Login</a> to Like </p>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <p class="pull-right like-icon">Likes: <?php getPostLikes($the_post_id); ?></p>
                        </div>
                        <div class="clearfix"></div>

                    <?php } ?>

                    <!-- Blog Comments -->
                    <?php
                    if (isset($_POST['create_comment'])) {
                        $the_post_id = $_GET['p_id'];
                        $comment_author = escape(ucwords($_POST['comment_author']));
                        $comment_email = escape($_POST['comment_email']);
                        $comment_content = escape($_POST['comment_content']);

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $result = query("INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($the_post_id, '{$comment_author}','{$comment_email}','{$comment_content}', 'Unapproved', now())");

                            header("Location: /leaf-cms-php/post/{$the_post_id}");

                            $result = query("UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id ");
                        }
                    }
                    ?>
                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form role="form" action="" method="post">
                            <div class="form-group">
                                <label for="Author">Author</label>
                                <input class="form-control" type="text" name="comment_author">
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input class="form-control" type="email" name="comment_email">
                            </div>
                            <div class="form-group">
                                <label for="Comment">Your Comment</label>
                                <textarea type="text" class="form-control" id="body" cols="30" rows="10" name="comment_content"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary comment-button" name="create_comment">Submit</button>
                        </form>
                    </div>

                    <?php
                    $result = query("SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'Approved' ORDER BY comment_id DESC ");

                    while ($row = mysqli_fetch_array($result)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                        ?>
                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author ?>
                                    <small><?php echo $comment_date ?></small>
                                </h4>
                                <?php echo $comment_content ?>

                                <!-- End Nested Comment -->
                            </div>
                        </div>
                    <?php

                    }
                }
            } else {
                header("Location: index.php");
            }

            ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>
    </div>
    <!-- /.row -->
    <hr>
    <?php include("includes/footer.php"); ?>

    <script> // TODO
        $(document).ready(function() {
            $("[data-toogle='tooltop']").tooltip();

            const post_id = <?php echo $the_post_id; ?>;
            const user_id = <?php echo loggedInUserId(); ?>

            $('.like').click(function() {
                $.ajax({
                    url: "/leaf-cms-php/post/<?php echo $the_post_id; ?>",
                    type: 'post',
                    data: {
                        'liked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            });

            $('.unlike').click(function() {
                $.ajax({
                    url: "/leaf-cms-php/post/<?php echo $the_post_id; ?>",
                    type: 'post',
                    data: {
                        'unliked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            });
        });
    </script>
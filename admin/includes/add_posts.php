<?php 
ob_start();
if (isset($_POST{'create_post'})) {
    $post_title = ucwords($_POST['post_title']);
    $post_user = ucwords($_POST['post_user']);
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_tags = ucwords($_POST['post_tags']);
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
    $post_comment_count = 0;
    $post_views_count = 0;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_title, post_category_id, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status, post_views_count) VALUES ('{$post_title}','{$post_category_id}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_comment_count}','{$post_status}', '{$post_views_count}') ";

    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);
    $last_id_query = mysqli_insert_id($connection);

    header("Location: posts.php?created&p_id={$last_id_query}");
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control input-background" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category_id">Post Category Id</label>
        <select class="input-background" name="post_category_id" id="post_category_id">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="user_id">Users</label>
        <select class="input-background" name="post_user" id="">
            <?php
            $users_query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $users_query);
            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                echo "<option value='{$username}'>{$username}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="" class="input-background">
            <option value="Draft">Post Status</option>
            <option value="Published">Publish</option>
            <option value="Draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control input-background" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control input-background" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" id="body" cols="30" rows="10" name="post_content"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-success submit-buttons" type="submit" name="create_post" value="Publish Post">
    </div>
</form>
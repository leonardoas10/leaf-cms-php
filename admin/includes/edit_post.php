<?php 
ob_start(); 

if (isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
    $result = query("SELECT * FROM posts WHERE post_id = $the_post_id");
    while ($row = mysqli_fetch_assoc($result)) {
        $post_id = $row['post_id'];
        $post_user = stripcslashes($row['post_user']);
        $post_title =  stripcslashes($row['post_title']);
        $post_category_id = $row['post_category_id'];
        $post_status = stripcslashes($row['post_status']);
        $post_image = $row['post_image'];
        $post_tags = stripcslashes($row['post_tags']);
        $post_comment_count = stripcslashes($row['post_comment_count']);
        $post_date = $row['post_date'];
        $post_content = stripcslashes($row['post_content']);
    }
}

if (isset($_POST['update_post'])) {
    $post_user = escape($_POST['post_user']);
    $post_title = escape($_POST['post_title']);
    $post_category_id = escape($_POST['post_category_id']);
    $post_status = escape(ucwords($_POST['post_status']));
    $post_tags = escape(ucwords($_POST['post_tags']));
    $post_content = escape($_POST['post_content']);

    query("UPDATE posts SET post_title = '{$post_title}', post_user = '{$post_user}', post_category_id = {$post_category_id}, post_status = '{$post_status}', post_tags = '{$post_tags}', post_content = '{$post_content}' WHERE post_id = {$the_post_id}");
    query("UPDATE posts SET post_views_count = 0 WHERE post_id = {$the_post_id}");

    header("Location: posts.php?updated&p_id={$the_post_id}");
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?php echo ucwords($post_title) ?>" type="text" class="form-control input-background" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category_id">Categories</label>
        <select class="input-background" name="post_category_id" id="post_category_id">
            <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    if ($cat_id == $post_category_id) {
                        echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                    } else {
                        echo "<option value='{$cat_id}'>{$cat_title}</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="user_id">Users</label>
        <select name="post_user" id="" class="input-background">
            <?php
            echo "<option value='{$post_user}'>{$post_user}</option>";
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
            <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
            <?php
                if ($post_status == 'Published') {
                    echo "<option value='Draft'>Draft</option>";
                } else {
                    echo "<option value='Published'>Published</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image_box">Post Image</label>
        <input type="file" class="form-control input-background" name="post_image_box">
        <?php
        $fileError = "";
        if (isset($_POST['update_image'])) {
            $post_image_box = $_FILES['post_image_box']['name'];
            $post_image_temp_box = $_FILES['post_image_box']['tmp_name'];
            if (empty($post_image_temp_box)) {
                $fileError = 'UPLOAD AN IMAGE';
            } else {
                move_uploaded_file($post_image_temp_box, "../images/$post_image_box");
                $query = "UPDATE posts SET post_image = '{$post_image_box}' WHERE post_id = '{$the_post_id}'";
                mysqli_query($connection, $query);
                header("Location: posts.php?source=edit_post&p_id={$the_post_id}");
            }
        }
        ?>
        <span class="btn-danger"> <?php echo $fileError; ?></span>
        <br>
        <input class="btn btn-info" type="submit" name="update_image" value="Update Image">
        <img width="100" src="../images/<?php echo $post_image; ?>">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control input-background" name="post_tags" value="<?php echo ucwords($post_tags) ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" id="body" cols="30" rows="10" name="post_content"><?php echo $post_content ?> </textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-success submit-buttons" type="submit" name="update_post" value="Publish Post" <?php echo "onClick=\" javascript: return confirm('Are you sure you want UPDATE this post?'); \""; ?>>
    </div>
</form>
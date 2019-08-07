<?php 
ob_start(); 
include("delete_modal.php"); 

if (isset($_GET['updated'])) {

    $the_post_id = $_GET['p_id'];

    $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
    $select_posts_status = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($select_posts_status);
    $post_status = $row['post_status'];

    if ($post_status == 'Published') {
        echo "<p class=' bg-success center'>Post Updated: " . " " . "<a href='../post.php?p_id={$the_post_id}' class='btn btn-success '>View Post</a></p>" . "<br>" . "<hr>";
    }
}

if (isset($_GET['created'])) {

    $the_post_id = $_GET['p_id'];
    
    echo "<p class=' bg-success center'>Post Created: " . " " . "<a href='../post.php?p_id={$the_post_id}' class='btn btn-success '>View Post</a></p>" . "<br>" . "<hr>";
}
?>

<?php

if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {

        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'Published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_published_status);
                break;
            case 'Draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_draft_status);
                break;
            case 'Delete':
                $delete_query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $update_to_delete_status = mysqli_query($connection, $delete_query);
                confirmQuery($update_to_delete_status);
                break;
            case 'Clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                $select_post_query = mysqli_query($connection, $query);
                confirmQuery($select_post_query);

                $row = mysqli_fetch_assoc($select_post_query);
                $post_title         = escape($row['post_title']);
                $post_category_id   = $row['post_category_id'];
                $post_date          = $row['post_date'];
                $post_user        = escape($row['post_user']);
                $post_status        = $row['post_status'];
                $post_image         = $row['post_image'];
                $post_tags          = $row['post_tags'];
                $post_content       = escape($row['post_content']);
                $post_views_count          = $row['post_views_count'];

                $query = "INSERT INTO posts(post_title, post_category_id, post_user, post_date, post_image, post_content, post_tags, post_status, post_views_count) VALUES ('{$post_title}',{$post_category_id},'{$post_user}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}', 0) ";
                $clone_post_query = mysqli_query($connection, $query);

                if (!$clone_post_query) {
                    die("Error MYSQL " . mysqli_error($connection));
                }
                break;
        }
    }
}
?>

<form action="" method="post">
    <table class="table table-bordered table-hover tr-background">
        <div class="row">
            <div id="bulkOptionsContainer" class="col-xs-4">
                <select class="form-control input-background" id="" name="bulk_options">
                    <option value="">Select Options</option>
                    <option value="Published">Publish</option>
                    <option value="Draft">Draft</option>
                    <option value="Delete">Delete </option>
                    <option value="Clone">Clone</option>
                </select>
            </div>
            <div class="col-xs-4">
                <input type="submit" name="submit" class="btn btn-success submit-buttons" value="Apply">
                <a class="btn btn-primary" href="posts.php?source=add_posts">Add New</a>
            </div>
            <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>User</th>
                    <th>title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>View Post</th>
                    <th>Comments</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user = $_SESSION['username'];
$query = "SELECT posts.post_id, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_views_count, posts.post_date, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE post_user = '$user'";
                $select_posts = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_posts)) {

                    $post_id = $row['post_id'];
                    $post_user =  stripcslashes($row['post_user']);
                    $post_title = stripcslashes($row['post_title']);
                    $post_category_id = $row['post_category_id'];
                    $post_status = stripcslashes($row['post_status']);
                    $post_image = $row['post_image'];
                    $post_tags = stripcslashes($row['post_tags']);
                    $post_views_count = stripcslashes($row['post_views_count']);
                    $post_date = $row['post_date'];
                    $category_title = $row['cat_title'];

                    echo "<tr>";
                    ?>
                    <td><input class="checkBoxes" type="checkbox" name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
                    <?php
                    echo "<td>$post_id</td>";
                    echo "<td>$post_user</td>";
                    echo "<td>$post_title</td>";
                    echo "<td>$category_title</td>";
                    echo "<td>$post_status</td>";
                    echo "<td><image class='img-responsive'src='../images/$post_image'></td>";
                    echo "<td>$post_tags</td>";
                    echo "<td>$post_views_count</td>";
                    echo "<td>$post_date</td>";
                    echo "<td class='links-color'><a href='../post/{$post_id}'>View Post   </a></td>";

                    $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
                    $comment_count_query = mysqli_query($connection, $query);
                    $count_comment = mysqli_num_rows($comment_count_query);

                    echo "<td class='links-color'><a href='post_comments.php?id=$post_id'>$count_comment</a></td>";
                    ?>
                    <form method="post">
                        <?php
                        echo "<td><input rel='$post_id' class='btn-xs btn-success submit-buttons' type='submit' name='edit' value='Edit'></td>";
                        echo "<td><input rel='$post_id' class='btn-xs btn-danger del_link' type='submit' name='delete' value='Delete'></td>";
                        ?>
                    </form>
                    <?php 

                    echo "</tr>";
                }
                ?>

            </tbody>
        </div>
    </table>
</form>

<?php
if (isset($_POST['edit'])) {
    header("Location:posts.php?source=edit_post&p_id=" . $post_id);
}
if (isset($_POST['delete_item'])) {
    $the_post_id =  escape($_POST['delete_item']);
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
    $delete_query = mysqli_query($connection, $query);
    header('Location:posts.php');
}
?>

<?php 
ob_start(); 
include("./includes/delete_modal.php");

if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'Approved':
                query("UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$postValueId}");
                break;
            case 'Unapproved':
                query("UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$postValueId}");
                break;
            case 'Delete':
                query("DELETE FROM comments WHERE comment_id = {$postValueId}");
                break;
        }
    }
}

if (isset($_GET['approve'])) {
    $the_comment_id = $_GET['approve'];
    query("UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $the_comment_id ");
    header("Location: comments.php");
}

if (isset($_GET['unapprove'])) {
    $the_comment_id = $_GET['unapprove'];
    query("UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $the_comment_id ");
    header("Location: comments.php");
}

if (isset($_POST['delete_item'])) {
    $the_comment_id =  escape($_POST['delete_item']);
    query("DELETE FROM comments WHERE comment_id = {$the_comment_id}");
    header('Location:comments.php');
}
?>

<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div class="row">
            <div id="bulkOptionsContainer" class="col-xs-4">
                <select class="form-control input-background" id="" name="bulk_options">
                    <option value="">Select Options</option>
                    <option value="Approved">Approved</option>
                    <option value="Unapproved">Unapproved</option>
                    <option value="Delete">Delete </option>
                </select>
            </div>
            <div class="col-xs-4">
                <input type="submit" name="submit" class="btn btn-success submit-buttons" value="Apply">
            </div>
            <table class="table table-bordered table-hover tr-background">
                <thead>
                    <tr>
                        <th><input id="selectAllBoxes" type="checkbox"></th>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>In Response to</th>
                        <th>Date</th>
                        <th>Approved</th>
                        <th>Unapproved</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     
            $query_comments = query("SELECT * FROM comments");

                    while ($row = mysqli_fetch_assoc($query_comments)) {
                        $comment_id = $row['comment_id'];
                        $comment_post_id = stripcslashes($row['comment_post_id']);
                        $comment_author = stripcslashes($row['comment_author']);
                        $comment_email = $row['comment_email'];
                        $comment_content = stripcslashes($row['comment_content']);
                        $comment_status = $row['comment_status'];
                        $comment_date = stripcslashes($row['comment_date']);
                        echo "<tr>";
                    ?>
                        <td><input class="checkBoxes" type="checkbox" name='checkBoxArray[]' value='<?php echo $comment_id ?>'></td>
                        <?php
                        echo "<td>$comment_id</td>";
                        echo "<td>$comment_author</td>";
                        echo "<td>$comment_content</td>";
                        echo "<td>$comment_email</td>";
                        echo "<td>$comment_status</td>";

                        $result = query("SELECT * FROM posts WHERE post_id = $comment_post_id");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];

                            echo "<td class='links-color'><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                        }
                        echo "<td>$comment_date</td>";
                        echo "<td class='links-color'><a href='comments.php?approve=$comment_id'>Approve</a></td>";
                        echo "<td class='links-color'><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                        ?>
                        <form method="post">
                            <?php
                            echo "<td><input rel='$comment_id' class='btn-xs btn-danger del_link' type='submit' name='delete' value='Delete'></td>";
                            ?>
                        </form>
                        <?php
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </table>
</form>
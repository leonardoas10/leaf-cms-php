<?php
ob_start();
include("includes/admin_header.php");
include("./includes/delete_modal.php");
           
if (isset($_POST['edit'])) {
    $the_cat_id =  escape($_POST['edit']);
    header("Location:categories.php?edit=" . $the_cat_id);
}
if (isset($_POST['delete_item'])) {
    $the_category_id =  escape($_POST['delete_item']);
    $query = "DELETE FROM categories WHERE cat_id = {$the_category_id} ";
    $delete_query = mysqli_query($connection, $query);
    header('Location:categories.php');
}
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'Clone':
                    $query = "SELECT * FROM categories WHERE cat_id = {$postValueId} ";
                    $select_post_query = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($select_post_query);
                    $cat_title = escape($row['cat_title']);

                    $query = "INSERT INTO categories(cat_title) VALUES ('{$cat_title}') ";
                    $clone_post_query = mysqli_query($connection, $query);

                    if (!$clone_post_query) {
                        die("Error MYSQL " . mysqli_error($connection));
                    }
                    break;
            case 'Delete':
                $delete_query = "DELETE FROM categories WHERE cat_id = {$postValueId}";

                $update_to_delete_status = mysqli_query($connection, $delete_query);
                confirmQuery($update_to_delete_status);
                break;
        }
    }
}
?>
<div id="wrapper">
    <?php include("includes/admin_navigation.php") ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php 
                            echo $_SESSION['user_firstname'] . " ";
                            echo $_SESSION['user_lastname']; 
                        ?>
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                    <div class="col-xs-6">
                        <?php 
                        insert_categories(); 
                        ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="cat_title"> Add Category </label>
                                <input class="form-control input-background" type="=text" name="cat_title">
                            </div>
                            <div class="form-group ">
                                <input class="btn btn-success submit-buttons" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>
                            <?php
                            if (isset($_GET['edit'])) {
                                $cat_id = $_GET['edit'];
                                include("includes/update_categories.php");
                            }
                            ?>
                    </div>
                    <form method="post">
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover tr-background">
                            <div class="row">
                                <div id="bulkOptionsContainer" class="col-xs-4">
                                    <select class="form-control input-background" id="" name="bulk_options">
                                        <option value="">Select Options</option>
                                        <option value="Clone">Clone</option>
                                        <option value="Delete">Delete </option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <input type="submit" class="btn btn-success submit-buttons" value="Apply">
                                </div>
                                <thead>
                                    <th><input id="selectAllBoxes" type="checkbox"></th>
                                    <th>ID</th>
                                    <th>Category Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = 'SELECT * FROM categories';
                                    $select_categories = mysqli_query($connection, $query);
                                    while ($row = mysqli_fetch_assoc($select_categories)) {
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];
                                        echo "<tr>";
                                        ?>
                                        <td><input class="checkBoxes" type="checkbox" name='checkBoxArray[]' value='<?php echo $cat_id ?>'></td>
                                        <?php
                                        echo "<td>{$cat_id}</td>";
                                        echo "<td>{$cat_title}</td>";
                                        ?>
                        </form>
                        <form method="post" id="actions">
                                        <?php
                                        echo "<input type='hidden' class='_id' name='edit' value=''>";
                                        echo "<td><input rel='$cat_id' class='btn-xs btn-success submit-buttons edit_link' type='submit' value='Edit'></td>";
                                        echo "<td><input rel='$cat_id' class='btn-xs btn-danger del_link' type='submit' name='delete' value='Delete'></td>";
                                        ?>
                        </form>
                        <?php echo "</tr>";} ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php include("includes/admin_footer.php") ?>
<?php
ob_start();
include("includes/admin_header.php");
include("./includes/delete_modal.php");
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
                        cloneCategories();
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title"> Add Category </label>
                                <input class="form-control input-background" type="=text" name="cat_title">
                            </div>
                            <div class="form-group ">
                                <input class="btn btn-success submit-buttons" type="submit" name="submit" value="Add Category">
                            </div>

                            <?php
                            if (isset($_GET['edit'])) {
                                $cat_id = $_GET['edit'];
                                include("includes/update_categories.php");
                            }
                            ?>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover tr-background">
                            <div class="row">
                                <div id="bulkOptionsContainer" class="col-xs-4">
                                    <select class="form-control input-background" id="" name="bulk_options">
                                        <option value="">Select Options</option>
                                        <option value="Delete">Delete </option>
                                        <option value="Clone">Clone</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <input type="submit" name="submit" class="btn btn-success submit-buttons" value="Apply">
                                </div>
                                <thead>
                                    <th><input id="selectAllBoxes" type="checkbox" class="checkbox-color"></th>
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
                                        <form method="post">
                                            <?php
                                            echo "<td><input rel='$cat_id' class='btn-xs btn-success submit-buttons' type='submit' name='edit' value='Edit'></td>";
                                            echo "<td><input rel='$cat_id' class='btn-xs btn-danger del_link' type='submit' name='delete' value='Delete'></td>";
                                            ?>
                                        </form>
                                        <?php
                                        echo "</tr>";
                                    }

                                    ?>
                                    <?php 
                                    deleteCategories(); 
                                   
                                    if (isset($_POST['edit'])) {
                                        header("Location:categories.php?edit=" . $cat_id);
                                    }
                                    if (isset($_POST['delete_item'])) {
                                        $the_post_id =  escape($_POST['delete_item']);
                                        $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
                                        $delete_query = mysqli_query($connection, $query);
                                        header('Location:posts.php');
                                    }
                                    ?>
                                </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php include("includes/admin_footer.php") ?>
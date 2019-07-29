<form action="" method="post">
    <div class="form-group">
        <label for="cat_title"> Update Category </label>
        <?php
        //UPDATE CATEGORY
        if(isset($_POST['update'])) {
            $cat_title = ucwords($_POST['cat_title']);
            if($cat_title == "" || empty($cat_title)){
                echo "this field shouldn´t be empty";
            }
            else {
                if(isset($_GET['edit'])) {
                    $cat_id = $_GET['edit'];
                    $query = "UPDATE categories SET cat_title = '$cat_title' WHERE cat_id = $cat_id";

                    $update_category_query = mysqli_query($connection, $query);

                if(!$update_category_query) {
                    die("Not connect with DB" . mysqli_error($connection));
                }
                }

            }
            header("Location: categories.php");
        }
        
        //PUT CATEGORIES INSIDE INPUT
        if(isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];
            $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
            $select_categories_id = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
        ?>
        <input value="<?php if(isset($cat_title)){echo $cat_title;}?>" type="text" class="form-control input-background" name="cat_title">
        <?php }}?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update" value="Update">
    </div>
</form>

<?php
// ESCAPE SQL 
function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}
//SELECT FROM AND COUNT 
function selectFromCount($table) {
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select = mysqli_query($connection, $query);
    return mysqli_num_rows($select);
}
//SELECT FROM, COLUMN AND STATUS
function selectFromColumnStatus($table, $column, $status) {
    global $connection; 
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $select_all_column_status = mysqli_query($connection, $query);
    return mysqli_num_rows($select_all_column_status);
}
//SELECT FROM, ROLE AND STATUS
function selectFromRoleStatus($table, $role, $status) {
    global $connection; 
    $query = "SELECT * FROM $table WHERE $role = '$status'";
    $select_all_role_status = mysqli_query($connection, $query);
    return mysqli_num_rows($select_all_role_status);
}


function users_online() {
    
    if(isset($_GET['onlineusers'])) {
    
    global $connection;
        if(!$connection) {
            session_start();
            include("../includes/db.php");
            
            
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 5;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

                if($count == NULL) {
                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('{$session}','{$time}')");

                } else {
                    mysqli_query($connection, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'");   
                }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > {$time_out}"); 
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    } // get request isset 
}

users_online();

function confirmQuery($result) {
    global $connection;       
    if(!$result) {
        die("QUERY FAILED " . mysqli_error($connection));
    }
}

function insert_categories() {
    global $connection;
    if(isset($_POST['submit'])) {
        $cat_title = ucwords($_POST['cat_title']);
        if($cat_title == "" || empty($cat_title)){
            echo "this field shouldn´t be empty";
        }
        else {
            $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";

            $create_category_query = mysqli_query($connection, $query);

            if(!$create_category_query) {
                die("Not connect with DB" . mysqli_error($connection));
            }
        }
        header("Location: categories.php");
    }                    
}

function findAllCategories() {
    global $connection; 
    $query = 'SELECT * FROM categories';
    $select_categories = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        ?>
        <td><input class="checkBoxes" type="checkbox" name='checkBoxArray[]' value='<?php echo $cat_id?>'></td>
        <?php
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td class='links-color'><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<td class='links-color'><a onClick=\" javascript: return confirm('Are you sure you want to delete'); \" href='categories.php?delete={$cat_id}'>Delete</a></td>"; 
        echo "</tr>";    
    }
}

function cloneCategories() {
    global $connection; 
      if(isset($_POST['checkBoxArray'])) {
    
        foreach($_POST['checkBoxArray'] as $postValueId) {
        
        $bulk_options = $_POST['bulk_options'];
        
        switch($bulk_options) {
            case 'Delete':
                $delete_query = "DELETE FROM categories WHERE cat_id = {$postValueId}";
                
                $update_to_delete_status = mysqli_query($connection, $delete_query);
                confirmQuery($update_to_delete_status);     
            break;
            case 'Clone':
               $query = "SELECT * FROM categories WHERE cat_id = {$postValueId} ";
            $select_post_query = mysqli_query($connection, $query);
                
            $row = mysqli_fetch_assoc($select_post_query);
                $cat_title         = mysqli_real_escape_string($connection, $row['cat_title']);
         
                
            $query = "INSERT INTO categories(cat_title) VALUES ('{$cat_title}') ";
            $clone_post_query = mysqli_query($connection, $query);
                
            if(!$clone_post_query) {
                die("Error MYSQL " . mysqli_error($connection));
            }
            break;
        }
    }
}
}

function deleteCategories() {
    global $connection; 
    if(isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

?>

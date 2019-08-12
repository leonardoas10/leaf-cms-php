<?php
// ===== DATABASE HELPERS =====

// MAKE A QUERY CONNECTION
function query($query) {
    global $connection;
    $result = mysqli_query($connection,$query);
    confirmQuery($result); 
    return $result;
}
//CHECK QUERY
function confirmQuery($result){
    global $connection;
    if (!$result) {
        die("QUERY FAILED " . mysqli_error($connection));
    }
}
// ESCAPE SQL 
function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function fetchRecords($result) {
    return mysqli_fetch_array($result);
}

// ===== END DATABASE HELPERS =====

// ===== AUTHENTICATION HELPERS =====

// VALIDATION OF ROLE STATUS TO ADMIN
function is_admin(){
    if(isLoggedIn()) {
        $result = query("SELECT user_role FROM users WHERE user_id = ".$_SESSION['user_id']. "");
        $row = fetchRecords($result);
        if ($row['user_role'] == 'Admin') {
            return true;
        } else {
            return false;
        }
    }  
    return false; 
}

// ===== END AUTHENTICATION HELPERS =====

function imagePlaceholder($image='') {
    return !$image ? 'leaf-cms-php/images/noplacelike.png' : $image;
}

//SELECT FROM AND COUNT 
function selectFromCount($table) {
    $result = query("SELECT * FROM " . $table);
    return mysqli_num_rows($result);
}
//SELECT FROM, COLUMN AND STATUS
function selectFromColumnStatus($table, $column, $status) {
    $result = query("SELECT * FROM $table WHERE $column = '$status'");
    return mysqli_num_rows($result);
}
//SELECT FROM, ROLE AND STATUS
function selectFromRoleStatus($table, $role, $status) {
    $result = query("SELECT * FROM $table WHERE $role = '$status'");
    return mysqli_num_rows($result);
}
//UPDATE USER ROLE 
function updateUserRole($role, $id) {
    return query("UPDATE users SET user_role = '{$role}' WHERE user_id = $id ");
}
//VALIDATE USER ONLINE OR NOT
function users_online() {
    if (isset($_GET['onlineusers'])) {
        global $connection;
        if (!$connection) {
            session_start();
            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 5;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
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
//INSERT CATEGORY
function insert_categories() {
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = ucwords($_POST['cat_title']);
        if ($cat_title == "" || empty($cat_title)) {
            echo "this field shouldn´t be empty";
        } else {
            $stmt = mysqli_prepare($connection, "INSERT INTO categories (cat_title) VALUES(?)");

            mysqli_stmt_bind_param($stmt, "s", $cat_title);
            mysqli_stmt_execute($stmt);

            if (!$stmt) {
                die("Not connect with DB" . mysqli_error($connection));
            }
        }
        header("Location: categories.php");
    }
}
//CLONE CATEGORY
function cloneCategories() {
    global $connection;
    if (isset($_POST['checkBoxArray'])) {

        foreach ($_POST['checkBoxArray'] as $postValueId) {

            $bulk_options = $_POST['bulk_options'];

            switch ($bulk_options) {
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

                    if (!$clone_post_query) {
                        die("Error MYSQL " . mysqli_error($connection));
                    }
                    break;
            }
        }
    }
}


// EXIST USER
function username_exists($username){
    $result = query("SELECT username FROM users WHERE username = '$username'");
    return mysqli_num_rows($result) > 0;
}
// EXIST EMAIL
function email_exists($email){
    $result = query("SELECT username FROM users WHERE user_email = '$email'");
    return mysqli_num_rows($result) > 0;
}
//REGISTER A USER
function registration_user($firstname, $lastname, $username, $email, $password){
    global $connection;
    $firstname = escape(ucwords($firstname));
    $lastname = escape(ucwords($lastname));
    $username = escape($username);
    $email = escape($email);
    $password = escape($password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_password, user_role) VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$password}', 'Subscriber')";
    $newUser = mysqli_query($connection, $query);
    confirmQuery($newUser);
}

function ifItIsMethod($method = null) {
    return $_SERVER['REQUEST_METHOD'] == strtoupper($method);
}
// IF USER IS LOG IN 
function isLoggedIn() {
    return isset($_SESSION['user_role']);
}
// IF USER IS LOG IN AND REDIRECT
function checkIfUserIsLoggedInAndRedirect($redirectLocation = null) {
    return isLoggedIn() ? header(`Location: $redirectLocation `) : false;
}
// LOG IN USER
function login_user($username, $password) {
    $result = query("SELECT * FROM users WHERE username = '{$username}'");

    while ($row = mysqli_fetch_array($result)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

        if (password_verify($password, $db_user_password)) {
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;

            header("Location: /leaf-cms-php/admin/");
        } else {
            return false;
        }
    }
    return true;
}
// USER ID THAT ARE LOG IN
function loggedInUserId() {
    if(isLoggedIn()) {
       $result = query("SELECT * FROM users WHERE username ='". $_SESSION['username'] . "'"); 
       $user = mysqli_fetch_array($result);
       return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;
}
// USERS THAT LIKE THE POST
function userLikedThisPost($post_id = '') {
    $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id ={$post_id}");
    return mysqli_num_rows($result) >= 1 ? true : false;
}
// TOTAL LIKES 
function getPostLikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    echo mysqli_num_rows($result);
}

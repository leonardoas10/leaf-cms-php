<?php 
ob_start();


if (isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];
    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $username = stripcslashes($row['username']);
        $user_password = stripcslashes($row['user_password']);
        $user_firstname = stripcslashes($row['user_firstname']);
        $user_lastname = stripcslashes($row['user_lastname']);
        $user_email = $row['user_email'];
        $user_image = stripcslashes($row['user_image']);
        $user_role = $row['user_role'];
    }
    if (isset($_POST{'edit_user'})) {
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = $_POST['user_role'];
        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);

        if (!empty($user_password)) {
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
            $get_user_query = mysqli_query($connection, $query_password);
            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row['user_password'];
            confirmQuery($get_user_query);

            if ($db_user_password != $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
            }

            $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_role = '{$user_role}', username = '{$username}', user_email = '{$user_email}', user_password = '{$hashed_password}' WHERE user_id = {$the_user_id}";

            $edit_user_query = mysqli_query($connection, $query);
            confirmQuery($edit_user_query);
            header("Location: users.php");
        }
        //Close $_POST
    }
    //Close $_GET
} else {
    header("Location: index.php");
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control input-background" name="user_firstname" value="<?php echo $user_firstname ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control input-background" name="user_lastname" value="<?php echo $user_lastname ?>">
    </div>
    <div class="form-group">
        <select name="user_role" id="" class="input-background">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            if ($user_role == 'Admin') {
                echo "<option value='Subscriber'>Subscriber</option>";
            } else {
                echo "<option value='Admin'>Admin</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control input-background" name="username" value="<?php echo $username ?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control input-background" name="user_email" value="<?php echo $user_email ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input autocomplete="off" type="password" class="form-control input-background" name="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-success submit-buttons" type="submit" name="edit_user" value="Edit User">
    </div>
</form>
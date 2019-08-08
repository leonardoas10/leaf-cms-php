<?php 
ob_start();
include("./includes/delete_modal.php");

if (isset($_GET['createduser'])) {
    $username = $_GET['createduser'];
    echo "<p class=' bg-success center'>User Created: " . " " . "{$username}" . "<br>" . "<hr>";
} 

if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'Admin':
                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$postValueId}";

                $update_to_approved_status = mysqli_query($connection, $query);
                break;
            case 'Subscriber':
                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$postValueId}";

                $update_to_unapproved_status = mysqli_query($connection, $query);
                break;
            case 'Delete':
                $delete_query = "DELETE FROM users WHERE user_id = {$postValueId}";

                $update_to_delete_status = mysqli_query($connection, $delete_query);
                confirmQuery($update_to_delete_status);
                break;
        }
    }
}
?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div class="row">
            <div id="bulkOptionsContainer" class="col-xs-4">
                <select class="form-control input-background" id="" name="bulk_options">
                    <option value="">Select Options</option>
                    <option value="Admin">Admin</option>
                    <option value="Subscriber">Subscriber</option>
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
                        <th>Username</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT * FROM users';
                    $select_users = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_users)) {
                        $user_id = $row['user_id'];
                        $username =
                            stripcslashes($row['username']);

                        $user_firstname =
                            stripcslashes($row['user_firstname']);
                        $user_lastname =
                            stripcslashes($row['user_lastname']);
                        $user_email = $row['user_email'];
                        $user_image = stripcslashes($row['user_image']);
                        $user_role = $row['user_role'];
                        echo "<tr>";
                        ?>

                        <td><input class="checkBoxes" type="checkbox" name='checkBoxArray[]' value='<?php echo $user_id ?>'></td>
                        <?php
                        echo "<td>$user_id</td>";
                        echo "<td>$username</td>";
                        echo "<td>$user_firstname</td>";
                        echo "<td>$user_lastname</td>";
                        echo "<td>$user_email</td>";
                        echo "<td>$user_role</td>";
                        echo "<td class='links-color'><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                        echo "<td class='links-color'><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
                        ?>
                    <form method="post">
                        <?php
                        echo "<td><input rel='$user_id' class='btn-xs btn-success submit-buttons' type='submit' name='edit' value='Edit'></td>";
                        echo "<td><input rel='$user_id' class='btn-xs btn-danger del_link' type='submit' name='delete' value='Delete'></td>";
                        ?>
                    </form>
                    <?php
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
</form>

<?php
if (isset($_GET['change_to_admin'])) {
    updateUserRole('Admin', $_GET['change_to_admin'] );
    header("Location: users.php");
}

if (isset($_GET['change_to_sub'])) {
    updateUserRole('Subscriber', $_GET['change_to_sub'] );
    header("Location: users.php");
}

if (isset($_POST['edit'])) {
    header("Location:users.php?source=edit_user&edit_user=" . $user_id);
}

if (isset($_POST['delete_item'])) {
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'Admin') {
            $the_user_id =  escape($_POST['delete_item']);
            $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
            $delete_query = mysqli_query($connection, $query);
            header('Location:users.php');
        }
    }
}
?>
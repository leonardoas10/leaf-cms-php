<?php
ob_start();
include("includes/admin_header.php");

if (!is_admin($_SESSION['username'])) {
    header('Location: index.php');
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
                        <?php echo $_SESSION['user_firstname'] . " ";
                        echo $_SESSION['user_lastname']; ?>
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
                    <?php
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }
                    switch ($source) {
                        case 'add_user';
                            include("includes/add_user.php");
                            break;

                        case 'edit_user';
                            include("includes/edit_user.php");
                            break;

                        default;
                            
                            include("includes/view_all_users.php");
                            
                            break;
                    }
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>

    <!-- /#page-wrapper -->

    <?php include("includes/admin_footer.php") ?>
<?php include("db.php"); ?>
<?php include("../admin/functions.php"); ?>
<?php  ob_start(); ?>
<?php session_start(); ?>

<?php
if(isset($_POST['login'])) {
    
    login_user(escape(trim($_POST['username'])), escape(trim($_POST['password'])));
    
}
?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="/leaf-cms-php/admin"><span class="navbar-brand glyphicon glyphicon-leaf leaf-icon"></span></a>
        <a class="navbar-brand navbar-title" href="/leaf-cms-php/admin">Leaf ADMIN</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a class="navbar-subtitles" href="">Users Online: <span class="usersonline"></span></a></li>
        <li><a class="navbar-subtitles" href="../index.php">Home Site</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user navbar-subtitles"></i>
                <?php
                    if (isset($_SESSION['username'])) {
                        echo $_SESSION['user_firstname'];
                    }
                ?>
                <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="../admin/profile.php"><i class="fa fa-fw fa-user navbar-subtitles"></i> Profile</a></li>
                <li class="divider"></li>
                <li><a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav navbar-vertical">
            <li><a href="index.php"><i class="fa fa-fw fa-dashboard"></i> My Data</a></li>

            <?php if(is_admin()): ?>

            <li><a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>

            <?php endif ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v "></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse navbar-vertical">
                    <li><a href="./posts.php">View All Posts</a></li>
                    <li><a href="posts.php?source=add_posts">Add Posts</a></li>
                </ul>
            </li>
            <li><a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a></li>
            <li class=""><a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a></li>
            <?php if(is_admin()): ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse navbar-vertical">
                    <li><a href="users.php">View All Users</a></li>
                    <li><a href="users.php?source=add_user">Add User</a></li>
                </ul>
            </li>
            <?php endif ?>
            <li class="active"><a href="profile.php"><i class="fa fa-fw fa-file"></i> Profile</a></li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
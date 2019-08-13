<?php 
include("includes/admin_header.php");

$posts_count = count_records(get_all_user_posts());
$comments_count = count_records(get_all_user_comments());
$categories_count = count_records(get_all_user_categories());
$post_published_count = selectFromColumnStatus('posts', 'post_status', 'Published');
$post_draft_count = selectFromColumnStatus('posts', 'post_status', 'Draft');
$unapproved_comments_count = selectFromColumnStatus('comments', 'comment_status', 'Unapproved');
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
                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php echo "<div class='huge'>".$posts_count."</div>" ?>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php echo "<div class='huge'>".$comments_count."</div>" ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php echo "<div class='huge'>".$categories_count."</div>" ?>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['', 'Count', { role: 'style' }],

                            <?php

                            $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pendind Commments', 'Categories'];
                            $element_count = [$posts_count, $post_published_count, $post_draft_count, $comments_count, $unapproved_comments_count, $categories_count];
                            $color = ['color: gray', 'color: gray', 'color: gray', 'color: gray', 'color: gray', 'color: gray', 'color: gray', 'color: gray',];

                            for ($i = 0; $i < 6; $i++) {
                                echo "['{$element_text[$i]}'" . " ," . "{$element_count[$i]}" . " ," . "'{$color[$i]}' ],";
                            }
                            ?>
                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>

<?php include("includes/admin_footer.php") ?>


<script>
$(document).ready(function() {
    const pusher = new Pusher('d2b0ebf9241225592540', {
        cluster: 'us2',
        forceTLS: true
    });
    const notificationChannel = pusher.subscribe('notifications');

    notificationChannel.bind('new_user', function(notification) {
        const message = notification.message;
        toastr.success(`${message} just registered`);
    });
})
</script>
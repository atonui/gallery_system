<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
$message = null;
if (isset($_GET['photo_id'])) {
    $comments = Comment::find_comment($_GET['photo_id']);
    if (!$comments) {
        $message = "No comments for this photo yet.";
    }
} else {
    redirect('photos.php');
}


?>
    <!-- Top Menu Items -->
<?php include 'includes/top_nav.php' ?>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<?php include 'includes/side_nav.php' ?>
    <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Comments
                        <small><?php echo $message; ?></small>
                    </h1>
                    <?php
                    if ($session->message) {
                    ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $session->message;?>
                    </div>
                        <?php
                    }
                ?>
                    <div class="col-md-12">
                        <img src="<?php echo Photo::find_by_id($_GET['photo_id'])->image_path() ?>" class="admin-photo-thumbnail">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Author</th>
                                <th>Body</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (empty($message)) {
                            foreach ($comments as $comment) {
                                ?>
                                <tr>
                                    <td><?php echo $comment->author ?></td>
                                    <td><?php echo $comment->body ?></td>
                                    <td><a href="delete_specific_comment.php?comment_id=<?php echo $comment->id; ?>" class="btn btn-danger btn-sm" role="button">Delete</a></td>
                                </tr>
                                <?php
                            }
                            }
                            ?>
                            </tbody>
                            <!--                            End of table-->
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>


        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
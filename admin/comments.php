<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
};

$comments = Comment::find_all();
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
                </h1>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Author</th>
                            <th>Body</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($comments as $comment) {
                            ?>
                            <tr>
                                <td> <img src="<?php echo Photo::find_by_id($comment->photo_id)->image_path() ?>" class="admin-photo-thumbnail">
                                    <div class="action_link">
                                        <a href="delete_comment.php?comment_id=<?php echo $comment->id; ?>" class="btn btn-danger btn-sm" role="button">Delete</a>
                                    </div>
                                </td>
                                <td><?php echo $comment->author ?></td>
                                <td><?php echo $comment->body ?></td>
                            </tr>
                            <?php
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
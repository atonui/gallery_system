<?php include("includes/header.php");
    if (!$session->is_signed_in()) {
    redirect('login.php');
    };

    $photos = Photo::find_all();
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
                        Photos
                        <small>Subheading</small>
                    </h1>
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Photo</th>
                                <th>File Name</th>
                                <th>Title</th>
                                <th>Size</th>
                                <th>Comment Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($photos as $photo) {
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $photo->image_path() ?>" class="admin-photo-thumbnail">
                                    <div class="action_link">
                                        <a href="delete_photo.php?photo_id=<?php echo $photo->id; ?>">Delete</a>
                                        <a href="edit_photo.php?photo_id=<?php echo $photo->id; ?>">Edit</a>
                                        <a href="../photo.php?photo_id=<?php echo $photo->id?>">View</a>
                                    </div>
                                </td>
                                <td><?php echo $photo->image_name ?></td>
                                <td><?php echo $photo->title ?></td>
                                <td><?php echo $photo->size ?></td>
                                <td>
                                    <?php
                                        $comment_count = count(Comment::find_comment($photo->id));
                                    ?>
                                    <a href="photo_comments.php?photo_id=<?php echo $photo->id?>"><?php echo $comment_count?></a>
                                </td>
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
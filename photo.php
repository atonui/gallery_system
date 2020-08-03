<?php
include("includes/header.php");
$message = "";

if (empty($_GET['photo_id'])) {
    redirect('index.php');
}

$photo = Photo::find_by_id($_GET['photo_id']);

if (isset($_POST['submit'])) {
    $photo_id = $_GET['photo_id'];
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);
    $new_comment = Comment::create_comment($photo_id, $author, $body);
    if ($new_comment) {
        $new_comment->save();
        redirect('photo.php?photo_id='.$photo_id);
    } else {
        $message = "An error occurred.";
    }
} else {
    $author = "";
    $body = "";
}

$comments = Comment::find_comment($_GET['photo_id']);

?>

<!-- Navigation -->


<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-8">

            <!-- Blog Post -->

            <!-- Title -->
            <h1>Blog Post Title</h1>

            <!-- Author -->
            <p class="lead">
                by <a href="#">Start Bootstrap</a>
            </p>

            <hr>

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

            <hr>

            <!-- Preview Image -->
            <img class="img-responsive" src="<?php echo 'admin/'.$photo->image_path() ?>" alt="">
            <?php echo $message; ?>

            <hr>

            <!-- Post Content -->
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut,
                error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae
                laborum minus inventore?</p>

            <hr>

            <!-- Blog Comments -->

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea class="form-control" name="body" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <!-- Comments -->
            <?php foreach ($comments as $comment): ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment->author; ?>
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        <?php echo $comment->body; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>

<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}

if (empty($_GET['user_id'])) {
    redirect('users.php');
} else {
    $user = User::find_by_id($_GET['user_id']);
    if ($user) {
        if (isset($_POST['update'])) {
            $user->username = $_POST['username'];
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['last_name'];
            $user->save();
        }
    }
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
                        Add New User
                        <small>Subheading</small>
                    </h1>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="form-group">
                                <img src="<?php echo $user->image_path(); ?>" class="thumbnail admin-photo-thumbnail img-responsive">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control"
                                       value="<?php echo $user->username; ?>">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                       value="<?php echo $user->first_name; ?>">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                       value="<?php echo $user->last_name; ?>">
                            </div>
                            <div class="form-group">
                                <a href="delete_user.php?user_id=<?php echo $user->id; ?>" class="btn btn-danger">Delete</a>
                                <input type="submit" name="update" value="Update" class="btn btn-primary pull-right">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>


        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
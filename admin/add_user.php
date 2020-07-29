<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}

$message = "";

if (isset($_POST['add_user'])) {
    $user = new User();
    $user->username = $_POST['username'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->password = $_POST['password'];

    $user->set_file($_FILES['user_image']);

    if ($user->save_photo()) {
        $message = "Image uploaded successfully";
    } else{
        $message = join("<br>", $user->errors);
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="user_image">Profile Picture</label><br>
                                <small><?php echo $message;?></small>
                                <input type="file" name="user_image">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="add_user" value="Add User" class="btn btn-primary pull-right">
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
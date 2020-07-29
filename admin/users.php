<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
};

$users = User::find_all();
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
                    Users
                </h1>
                <a href="add_user.php" class="btn btn-primary">Add User</a>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($users as $user) {
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $user->image_path_placeholder()?>" class="admin-photo-thumbnail">
                                </td>
                                <td><?php echo $user->username ?>
                                <div class="action_link">
                                    <a href="delete_user.php?user_id=<?php echo $user->id; ?>">Delete</a>
                                    <a href="edit_user.php?user_id=<?php echo $user->id; ?>">Edit</a>
                                </div>
                                </td>
                                <td><?php echo $user->first_name ?></td>
                                <td><?php echo $user->last_name ?></td>
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

<?php include("includes/footer.php"); ?>cludes/footer.php"); ?>
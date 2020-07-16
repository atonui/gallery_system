<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>
            <?php
//            $user = new User();
//            $user->last_name = "mimi";
//            $user->first_name = "siimi";
//            $user->password = "124552653";
//
//            $user->save()

            $user = User::find_user_by_id(11);
            $user->password = "1234756347563";
            $user->save();

            ?>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>
<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['user_id'])) {
    redirect('users.php');
}

$user = User::find_by_id($_GET['user_id']);

if ($user) {
    $user->delete_user();
    redirect('users.php');
} else {
    redirect('users.php');
}
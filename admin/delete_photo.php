<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['photo_id'])) {
    redirect('photos.php');
}

$photo = Photo::find_by_id($_GET['photo_id']);

if ($photo) {
    $photo->delete_photo();
    redirect('photos.php');
} else {
    redirect('photos.php');
}
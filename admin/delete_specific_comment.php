<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['comment_id'])) {
    redirect('photos.php');
}
$comment_id = $_GET['comment_id'];
$comment = Comment::find_by_id($comment_id);

if ($comment) {
    $comment->delete();
    $session->message('The comment has been deleted');
    redirect('photo_comments.php?photo_id='.$comment->photo_id);
} else {
    redirect('photos.php');
}
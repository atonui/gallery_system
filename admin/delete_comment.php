<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['comment_id'])) {
    redirect('comments.php');
}

$comment = Comment::find_by_id($_GET['comment_id']);

if ($comment) {
    $comment->delete();
    redirect('comments.php');
} else {
    redirect('users.php');
}
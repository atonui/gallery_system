<?php


class Comment extends Db_object
{
    public $id;
    public $photo_id;
    public $author;
    public $body;
    protected static $db_table = "comments";
    protected static $db_fields = array('photo_id', 'author', 'body');

    public static function create_comment($photo_id, $author, $body) {
        if (!empty($photo_id) && !empty($author) && !empty($body)) {
            $comment = new Comment();
            $comment->photo_id = $photo_id;
            $comment->author = $author;
            $comment->body = $body;
            return $comment;
        } else {
            return false;
        }
    }

    public static function find_comment($photo_id) {
        global $database;
        $photo_id = $database->escape_string($photo_id);
        $sql = "SELECT * FROM ".self::$db_table." WHERE `photo_id` = '$photo_id' ORDER BY id ASC";
        return self::find_by_query($sql);

    }

}
<?php

class Photo extends Db_object
{
    public $id;
    public $title;
    public $caption;
    public $description;
    public $image_name;
    public $alternate_text;
    public $type;
    public $size;
    protected static $db_table = "photos";
    protected static $db_fields = array('title', 'caption', 'description', 'image_name', 'alternate_text', 'type', 'size');

    public function delete_photo() {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->image_name;
            return unlink($target_path);
        } else {
            return false;
        }
    }

}
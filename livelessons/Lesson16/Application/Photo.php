<?php

class PSInvalidPhotoDataException extends Exception { }
define('IMAGE_SUB_PATH', '/images/');


require_once('PhotoData.php');


class Photo
{
    public $Photoid;
    public $Filename;
    public $Userid;
    public $Uploaded;


    public function __construct($pid, $fn, $uid, $up)
    {
        if ((int)$pid <= 0 or $fn == '' or (int)$uid <= 0 or $up == '')
            throw new PSInvalidPhotoDataException();

        $this->Photoid = $pid;
        $this->Filename = $fn;
        $this->Userid = $uid;
        $this->Uploaded = $up;
    }


    public function imageUrl()
    {
        return IMAGE_SUB_PATH . $this->Filename;
    }


    public static function addNewPhotoForUser($userid, $filename)
    {
        if ((int)$userid <= 0 or $filename == '')
            throw new PSInvalidPhotoDataException();

        $row = PhotoData::fetch()->addNewPhotoForUser($userid, $filename);
        return Photo::fromRowData($row);
    }


    public static function fetchPhotosForUser($userid, $start, $cphotos)
    {
        $users = PhotoData::fetch()->fetchPhotosForUser($userid, $start, $cphotos);
        $output = array();
        foreach ($users as $row)
        {
            $output[] = Photo::fromRowData($row);
        }
        return $output;
    }


    public static function countPhotosForUser($userid)
    {
        return PhotoData::fetch()->countPhotosForUser($userid);
    }


    protected static function fromRowData($row)
    {
        return new Photo($row['id'], $row['filename'], $row['userid'], $row['uploaded']);
    }



}
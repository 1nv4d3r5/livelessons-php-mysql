<?php

require_once('DataCore.php');

class PhotoData extends DataCore
{
    protected static $s_instance = NULL;


    public static function fetch()
    {
        if (self::$s_instance === NULL)
        {
            self::$s_instance = new PhotoData();
        }

        return self::$s_instance;
    }


    protected function __construct()
    {
    }


    public function countPhotosForUser($userid)
    {
        $query = 'SELECT COUNT(*) FROM UserPhotos WHERE userid = ' . (int)$userid;
        $conn = $this->getConnection();
        $results = $conn->query($query);
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        $row = $results->fetch_array();
        $results->close();
        return $row[0];
    }


    public function addNewPhotoForUser($userid, $fn)
    {
        if ((int)$userid <= 0 or $fn == '')
            throw new PSInvalidPhotoDataException();

        $uid = (int)$userid;
        $sfn = $this->escapeString($fn);
        $query = <<<EOQ
INSERT INTO UserPhotos (userid, filename, uploaded) VALUES($uid, '$sfn', NOW())
EOQ;
        $conn = $this->getConnection();
        $conn->query($query);
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        $photoid = $conn->insert_id;
        return $this->fetchPhotoById($photoid);
    }


    public function fetchPhotoById($pid)
    {
        if ((int)$pid <= 0)
            throw new PSInvalidPhotoDataException();

        $pid = (int)$pid; // make SURE it's safe for embedding into sql.
        $query = "SELECT * FROM UserPhotos WHERE id = {$pid}";
        $conn = $this->getConnection();
        $results = $conn->query($query);
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        $row = $results->fetch_assoc();
        $results->close();
        return $row;
    }


    public function fetchPhotosForUser($userid, $start, $cphotos)
    {
        $userid = (int)$userid;
        $start = (int)$start;
        $cphotos = (int)$cphotos;

        if ($userid <= 0 or $start < 0 or $cphotos <= 0)
            throw new PSInvalidPhotoDataException();

        $query = <<<EOQ
SELECT *
  FROM UserPhotos 
 WHERE userid = {$userid}
 ORDER BY id DESC
 LIMIT $start, $cphotos
EOQ;
        $conn = $this->getConnection();
        $results = $conn->query($query);
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        $output = array();
        while (($row = $results->fetch_assoc()) != null)
            $output[] = $row;

        $results->close();
        return $output;
    }
}





?>
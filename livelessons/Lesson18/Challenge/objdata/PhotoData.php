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


    public function addNewPhotoForUser($userid, $fn, $desc)
    {
        if ((int)$userid <= 0 or $fn == '')
            throw new PSInvalidPhotoDataException();

        $uid = (int)$userid;
        $sfn = $this->escapeString($fn);
        $sdesc = $this->escapeString($desc);

        $this->beginTransaction();
        try
        {
            $query = <<<EOQ
INSERT INTO UserPhotos (userid, filename, uploaded) VALUES($uid, '$sfn', NOW())
EOQ;
            $conn = $this->getConnection();
            $conn->query($query);
            if ($conn->errno != 0)
                throw new PSDatabaseErrorException($conn->error, $query);

            $photoid = $conn->insert_id;

            $query = <<<EOQ
INSERT INTO UserPhotoDescs (photoid, photodesc) VALUES ($photoid, '$sdesc')
EOQ;
            $conn = $this->getConnection();
            $conn->query($query);
            if ($conn->errno != 0)
                throw new PSDatabaseErrorException($conn->error, $query);

            $this->commitTransaction();
        }
        catch (Exception $e)
        {
            $this->rollbackTransaction();
            throw $e;
        }

        return $this->fetchPhotoById($photoid);
    }


    public function fetchPhotoById($pid)
    {
        if ((int)$pid <= 0)
            throw new PSInvalidPhotoDataException();

        $pid = (int)$pid; // make SURE it's safe for embedding into sql.
        $query = <<<EOQ
SELECT UserPhotos.*, UserPhotoDescs.photodesc
  FROM UserPhotos, UserPhotoDescs
 WHERE UserPhotoDescs.photoid = UserPhotos.id
       AND UserPhotos.id = {$pid}
EOQ;
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

        // order by means we fetch most recent first
        $query = <<<EOQ
SELECT UserPhotos.*, UserPhotoDescs.photodesc
  FROM UserPhotos, UserPhotoDescs
 WHERE UserPhotoDescs.photoid = UserPhotos.id
       AND userid = {$userid}
 ORDER BY UserPhotos.id DESC
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
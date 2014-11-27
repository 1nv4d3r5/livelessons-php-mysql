<?php

require_once('DataCore.php');

define('MYSQL_DUPLICATE_ENTRY', 1062);


class UserData extends DataCore
{
    protected static $s_instance = NULL;


    public static function fetch()
    {
        if (self::$s_instance === NULL)
        {
            self::$s_instance = new UserData();
        }

        return self::$s_instance;
    }


    protected function __construct()
    {
    }


    public function createUser($un, $fn, $pw, $em, $bio, $priv)
    {
        if ($un == '' or $fn == '' or $pw == '' or $em == '')
            throw new PSInvalidArgumentException();

        $sun = $this->escapeString($un);
        $sfn = $this->escapeString($fn);
        $spw = $this->escapeString($pw);
        $sem = $this->escapeString($em);
        $sbi = $this->escapeString($bio);
        $spriv = $priv == 1 ? 1 : 0;

        $this->beginTransaction();
        try
        {
            $query = <<<EOQ
INSERT INTO Users (user_name, full_name, password, email_address, join_date, priv_level)
           VALUES ('$sun', '$sfn', '$spw', '$sem', NOW(), $spriv)
EOQ;
            $conn = $this->getConnection();
            $conn->query($query);
            if ($conn->errno == MYSQL_DUPLICATE_ENTRY)
                throw new PSUsernameInUseException();
            if ($conn->errno != 0)
                throw new PSDatabaseErrorException($conn->error, $query);

            $userid = $conn->insert_id;
            $query = <<<EOQ
INSERT INTO UserBios VALUES($userid, '$sbi')
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

        // fetch the user and return it.
        return $this->loadUserById($userid);
    }


    public function updateUser($userid, $fn, $em, $bio)
    {
        $userid = (int)$userid;
        if ($fn == '' or $em == '' or $userid <= 0)
            throw new PSInvalidArgumentException();

        $sfn = $this->escapeString($fn);
        $sem = $this->escapeString($em);
        $sbi = $this->escapeString($bio);

        $this->beginTransaction();
        try
        {
            $query = <<<EOQ
UPDATE Users
SET 
       full_name = '$sfn',
       email_address = '$sem'
 WHERE id = {$userid}
EOQ;
            $conn = $this->getConnection();
            $conn->query($query);
            if ($conn->errno != 0)
                throw new PSDatabaseErrorException($conn->error, $query);

            $query = <<<EOQ
UPDATE UserBios
   SET userbio = '$sbi' 
 WHERE userid = {$userid}
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
    }


    public function loadUserByUsername($username)
    {
        if ($username == '')
            throw new PSInvalidArgumentException();

        return $this->loadUser('user_name', $username);
    }


    public function loadUserById($userid)
    {
        if ((int)$userid < 0)
            throw new PSInvalidArgumentException();

        return $this->loadUser('id', (int)$userid);
    }


    public function countUsers()
    {
        $query = 'SELECT COUNT(*) FROM Users';
        $conn = $this->getConnection();
        $results = $conn->query($query);
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        $row = $results->fetch_array();
        $results->close();
        return $row[0];
    }


    public function listUsers($start, $cusers)
    {
        if ($start < 0 or $cusers < 1)
            throw new PSInvalidArgumentException();

        $query = <<<EOQ
SELECT Users.*, UserBios.userbio
  FROM Users, UserBios
 WHERE Users.id = UserBios.userid
 LIMIT $start, $cusers
EOQ;
        $conn = $this->getConnection();
        $results = $conn->query($query);
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        $output = array();
        while (($row = $results->fetch_assoc()) != NULL)
        {
            $output[] = $row;
        }

        return $output;
    }


    protected function loadUser($field_name, $field_value)
    {
        if ($field_name == '' or $field_value == '')
            throw new PSInvalidArgumentException();

        if (is_string($field_value))
            $value = "'" . $field_value . "'";
        else
            $value = $field_value;

        $query = <<<EOQ
SELECT Users.*, UserBios.userbio
  FROM Users, UserBios
 WHERE Users.id = UserBios.userid
       AND {$field_name} = {$value}
EOQ;
        $conn = $this->getConnection();
        $results = $conn->query($query);
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        $row = $results->fetch_assoc();
        $results->close();
        return $row;
    }

}





?>
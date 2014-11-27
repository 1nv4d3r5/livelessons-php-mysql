<?php

require_once('DataCore.php');

define('MYSQL_DUPLICATE_ENTRY', 1062);


class PSDatabaseErrorException extends Exception
{
    public function __construct($msg, $query)
    {
        parent::__construct("Database error $msg ocurred when executing $query");
    }
}



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


    public function createUser($un, $fn, $pw, $em, $priv)
    {
        if ($un == '' or $fn == '' or $pw == '' or $em == '')
            throw new PSInvalidArgumentException();

        $sun = $this->escapeString($un);
        $sfn = $this->escapeString($fn);
        $spw = $this->escapeString($pw);
        $sem = $this->escapeString($em);
        $spriv = $priv == 1 ? 1 : 0;

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

        // return the user data
        return $this->loadUserById($conn->insert_id);
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
SELECT *
  FROM Users
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
SELECT * FROM Users WHERE {$field_name} = {$value}
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
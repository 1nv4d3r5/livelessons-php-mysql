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
INSERT INTO Users (user_name, full_name, password, email_address, priv_level)
           VALUES ('$sun', '$sfn', '$spw', '$sem', $spriv)
EOQ;
        $conn = $this->getConnection();
        $conn->query($query);
        if ($conn->errno == MYSQL_DUPLICATE_ENTRY)
            throw new PSUsernameInUseException();
        if ($conn->errno != 0)
            throw new PSDatabaseErrorException($conn->error, $query);

        // return the user's id
        return $conn->insert_id;
    }

}





?>
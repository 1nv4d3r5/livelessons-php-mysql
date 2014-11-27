<?php

class PSDatabaseErrorException extends Exception
{
    public function __construct($msg, $query)
    {
        parent::__construct("Database error $msg ocurred when executing $query");
    }
}


define('DB_HOST', 'localhost');
define('DB_USER', 'psa_user');
define('DB_PASSWORD', 'secret_password');
define('DB_DATABASE', 'PhotoShareApp');


$g_connection = null;

abstract class DataCore
{
    protected function getConnection()
    {
        global $g_connection;

        if ($g_connection === null)
        {
            $conn = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
            if (mysqli_connect_errno() !== 0)
            {
                $msg = mysqli_connect_error();
                throw new PSDatabaseErrorException($msg, 'Connect');
            }

            $conn->query('SET NAMES "utf8"');
            $g_connection = $conn;
        }

        return $g_connection;
    }


    protected function escapeString($in_string)
    {
        if ($in_string === null)
            return '';

        $conn = DataCore::getConnection();
        if ($conn !== NULL)
        {
            $str = $conn->real_escape_string($in_string);
        }

        return $str;
    }

}



?>
<?php


define('DB_HOST', 'localhost');
define('DB_USER', 'psa_user');
define('DB_PASSWORD', 'secret_password');
define('DB_DATABASE', 'PhotoShareApp');

abstract class DataCore
{
    private static $s_connection = NULL;

    protected function getConnection()
    {
        if (DataCore::$s_connection === NULL)
        {
            $conn = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
            if (mysqli_connect_errno() !== 0)
            {
                $msg = mysqli_connect_error();
                throw new PSDatabaseErrorException($msg, 'Connect');
            }

            $conn->query('SET NAMES "utf8"');
            DataCore::$s_connection = $conn;
        }

        return DataCore::$s_connection;
    }


    protected function escapeString($in_string)
    {
        if ($in_string === NULL)
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
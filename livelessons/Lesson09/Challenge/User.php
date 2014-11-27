<?php

define('PRIVILEGES_REGULAR_USER', 0);
define('PRIVILEGES_SUPER_USER', 1);

class User
{
    public $Username;
    public $FullName;
    public $Password;
    public $EmailAddress;
    public $LoggedIn = false;
    public $JoinDate;
    public $Privileges;


    public function __construct($username, $fullname, $password,
                                $email_address, $privileges = PRIVILEGES_REGULAR_USER)
    {
        $this->Username = $username;
        $this->FullName = $fullname;
        $this->Password = md5($password);
        $this->EmailAddress = $email_address;
        $this->Privileges = $privileges;
    }


    public function checkPassword($pw_to_check)
    {
        return (md5($pw_to_check) == $this->Password) ? true : false;
    }


    public function updateDetails($dets_to_update)
    {
        foreach ($dets_to_update as $field => $value)
        {
            if (!isset($this->$field) or $value == '')
                return false;
            else
                $this->$field = $value;
        }

        return true;
    }

    public function login($password)
    {
        if ($this->checkPassword() == false)
            return false;
        else
            $this->LoggedIn = true;

        return true;
    }


    public function logout()
    {
        $this->LoggedIn = false;
    }


    public function debugPrint()
    {
        foreach ($this as $name => $value)
        {
            if ($name == 'Password')
                continue;

            echo "$name:  $value\n";
        }
    }


}








?>
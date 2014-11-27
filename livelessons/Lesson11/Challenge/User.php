<?php

class PSInvalidUserDataException extends Exception { }
class PSInvalidLoginException extends Exception { }


class User
{
    const PRIVILEGES_REGULAR_USER = 0;
    const PRIVILEGES_SUPER_USER = 1;

    public $Username;
    public $FullName;
    public $Password;
    public $EmailAddress;
    public $Birthdate;
    public $Gender;
    public $JoinDate;
    public $Privileges;

    protected $LoggedIn = false;


    public function __construct($username, $fullname, $password,
                                $email_address,
                                $birthdate, $gender,
                                $privileges = User::PRIVILEGES_REGULAR_USER)
    {
        if ($username == '' or $fullname == '' or $password == ''
            or $email_address == '')
            throw new PSInvalidUserDataException();

        $this->Username = $username;
        $this->FullName = $fullname;
        $this->Password = md5($password);
        $this->EmailAddress = $email_address;
        $this->Birthdate = $birthdate;
        $this->Gender = $gender;
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
            throw new PSInvalidLoginException();
        else
            $this->LoggedIn = true;
    }


    public function logout()
    {
        $this->LoggedIn = false;
    }


    public function __toString()
    {
        $str = '';

        foreach ($this as $name => $value)
        {
            if ($name == 'Password')
                continue;

            $str .= "$name: " . htmlspecialchars($value) . "\n";
        }

        return $str;
    }


}








?>
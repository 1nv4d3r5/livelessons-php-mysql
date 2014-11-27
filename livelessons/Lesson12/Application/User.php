<?php

class PSInvalidUserDataException extends Exception { }
class PSInvalidLoginException extends Exception { }
class PSUsernameInUseException extends Exception { }

require_once('UserData.php');

class User
{
    const PRIVILEGES_REGULAR_USER = 0;
    const PRIVILEGES_SUPER_USER = 1;

    public $Userid;
    public $Username;
    public $FullName;
    public $Password;
    public $EmailAddress;
    public $JoinDate;
    public $Privileges;


    protected $LoggedIn = false;


    /**
     * all users registered from the createaccount page are regular users
     */
    public static function registerUser($un, $fn, $pw, $em,
                                        $priv = User::PRIVILEGES_REGULAR_USER)
    {
        if ($un == '' or $fn == '' or $pw == '' or $em == '')
            throw new PSInvalidUserDataException();

        $pw = md5($pw);

        $ud = UserData::fetch();
        $uid = $ud->createUser($un, $fn, $pw, $em, User::PRIVILEGES_REGULAR_USER);

        return new User($uid, $un, $fn, $pw, $em, User::PRIVILEGES_REGULAR_USER);
    }



    public function __construct($userid, $username, $fullname, $password,
                                $email_address,
                                $privileges = User::PRIVILEGES_REGULAR_USER)
    {
        if ($username == '' or $fullname == '' or $password == ''
            or $email_address == '')
            throw new PSInvalidUserDataException();

        $this->Userid = $userid;
        $this->Username = $username;
        $this->FullName = $fullname;
        $this->Password = $password;
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
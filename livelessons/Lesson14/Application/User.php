<?php

class PSInvalidUserDataException extends Exception { }
class PSInvalidLoginException extends Exception { }
class PSUsernameInUseException extends Exception { }
class PSNoSuchUserException extends Exception { }

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
    public $LoggedIn = false;
    public $JoinDate;
    public $UserBio;
    public $Privileges;

    public function __construct($userid, $username, $fullname, $password,
                                $email_address,
                                $join_date,
                                $user_bio,
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
        $this->UserBio = $user_bio;
        $this->Privileges = $privileges;
    }


    public function checkPassword($pw_to_check)
    {
        return (md5($pw_to_check) == $this->Password) ? true : false;
    }


    public function updateDetails($fn, $em, $bio)
    {
        if ($fn == '' or $em == '')
            throw new PSInvalidUserDataException();

        // will throw on failure.
        $ud = UserData::fetch();
        $row = $ud->updateUser($this->Userid, $fn, $em, $bio);

        $this->FullName = $fn;
        $this->EmailAddress = $em;
        $this->UserBio = $bio;
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




    /**
     * all users registered from the createaccount page are regular users
     */
    public static function registerUser($un, $fn, $pw, $em, $bio,
                                        $priv = User::PRIVILEGES_REGULAR_USER)
    {
        if ($un == '' or $fn == '' or $pw == '' or $em == '')
            throw new PSInvalidUserDataException();

        $pw = md5($pw);

        $ud = UserData::fetch();
        $row = $ud->createUser($un, $fn, $pw, $em, $bio, User::PRIVILEGES_REGULAR_USER);

        return User::fromDataRow($row);
    }


    public static function loadUserById($userid)
    {
        if ((int)$userid <= 0)
            throw new PSInvalidArgumentException();

        $row = UserData::fetch()->loadUserById($userid);

        return User::fromDataRow($row);
    }


    public static function loadUserByUsername($username)
    {
        if ($username == '')
            throw new PSInvalidArgumentException();

        $row = UserData::fetch()->loadUserByUsername();

        return User::fromDataRow($row);
    }


    public static function countUsers()
    {
        return UserData::fetch()->countUsers();
    }


    public static function listUsers($start, $cusers)
    {
        $rows = UserData::fetch()->listUsers($start, $cusers);
        $output = array();
        foreach ($rows as $row)
        {
            $output[] = User::fromDataRow($row);
        }

        return $output;
    }



    protected static function fromDataRow($row)
    {
        return new User($row['id'], $row['user_name'], $row['full_name'], $row['password'],
                        $row['email_address'], $row['join_date'], $row['userbio']);

    }

}



?>
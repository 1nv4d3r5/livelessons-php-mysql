<?php


require_once('requires.php');
require_once('PhotoShareBase.php');


class UserProfile extends PhotoShareBase
{
    protected $m_error;
    protected $m_userid = -1;

    public function __construct()
    {
        parent::__construct();
        if (isset($_GET))
        {
            if (isset($_GET['error']))
                $this->m_error = $_GET['error'];
            if (isset($_GET['id']))
                $this->m_userid = $_GET['id'];
        }
    }

    public function title()
    {
        return 'Your New User Account';
    }


    public function inlineStyle()
    {
        $style = <<<EOM
    .error_msg
    {
      color: red;
    }
    #userinfo
    {
      padding: 5px;
    }
    #userinfo h3
    {
      border-bottom: 1px solid #aaa;
      max-width: 400px;
    }
    #userinfo .bio
    {
      color: #777;
    }
    #userinfo .date
    {
      color: #777;
    }
    
EOM;
        return parent::inlineStyle() . $style;
    }


    protected function generateBodyContents()
    {
        parent::generateBodyContents();

        if ($this->m_error != null)
        {
            echo <<<EOM
    <p class='error_msg'>{$this->m_error}</p>
    <p><a href='CreateAccount.php'>Go back</a> and try again.</p> 

EOM;
        }
        else if ($this->m_userid != -1)
        {
            $user = User::loadUserById($this->m_userid);
            $this->dumpUser($user);
        }
        else
        {
            echo <<<EOM
    <p> Please do not call this page directly.</p>
    <p>To see this page, first <a href='CreateAccount.php'>create an account</a></p>

EOM;
        }
    }

    protected function dumpUser($user)
    {
        $un = htmlspecialchars($user->Username);
        $fn = htmlspecialchars($user->FullName);
        $em = htmlspecialchars($user->EmailAddress);
        $jd = strtotime($user->JoinDate);
        $jd = date('j-M, Y');
        $bio = htmlspecialchars($user->UserBio);


        echo <<<USERINFO
    <div id='userinfo'>
      <h3> $un ($fn) </h3>
      <p> Joined: <span class='date'>$jd</span> </p>
      <p> Email Address: <a href='mailto: $em'>$em</a> </p>
      <h4> User Bio </h4>
      <p class='bio'>
        $bio
      </p>
    </div> <!-- userinfo -->    

USERINFO;
    }


}



$page = new UserProfile();
$page->processRequest();



?>
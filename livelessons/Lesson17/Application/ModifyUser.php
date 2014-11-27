<?php

require_once('requires.php');
require_once('PhotoShareBase.php');


class ModifyUser extends PhotoShareBase
{
    protected $m_userid = -1;

    public function __construct()
    {
        parent::__construct();
        if (isset($_GET['id']))
            $this->m_userid = (int)$_GET['id'];
    }


    public function title()
    {
        return 'Modify Account Details';
    }


    public function inlineStyle()
    {
        $style = <<<EOSTYLE
    label
    {
        margin-top: 0.5em;
        display: block;
        font-family: Arial, Helvetica;
        font-size: 10pt;
        color:  #444;
    }

EOSTYLE;
        return parent::inlineStyle() . $style;
    }

    protected function generateBodyContents()
    {
        parent::generateBodyContents();

        if ($this->m_userid == -1)
        {
            echo "<h2>We need a userid to modify!</h2>\n";
            return;
        }

        try
        {
            $user = User::loadUserById($this->m_userid);
            $sfn = htmlspecialchars($user->FullName);
            $sem = htmlspecialchars($user->EmailAddress);
            $sbi = htmlspecialchars($user->UserBio);

            if (!User::amILoggedIn()            
                or User::loggedInUserid() != $user->Userid)
            {
                echo "Please don't call this page directly!";
                return;
            }

            echo <<<EOCONTENTS
<h3>Modify User Account</h3>
  <form method='post' action='SubmitModifyUser.php' name='modify_user_form'>
     <input type='hidden' name='userid' value='{$user->Userid}'>
     <div>
       <label>Full Name:</label>
       <input type='text' name='full_name' value='$sfn' size='30'>
     </div>
     <div>
       <label>Email Address:</label>
       <input type='text' name='email_address' value='$sem' size='30'>
     </div>
     <div>
       <label>User Bio:</label>
       <textarea name='user_bio' rows='10' cols='40'>$sbi</textarea>
     </div>
     <p><input type='submit' value='Modify User'></p>
  </form>
            
EOCONTENTS;
        }
        catch (Exception $e)
        {
            echo "Something unusual happened when processing the page: " . get_class($e)
                . ' ..... ' . $e->getMessage();
        }
    }

}



$page = new ModifyUser();
$page->processRequest();



?>
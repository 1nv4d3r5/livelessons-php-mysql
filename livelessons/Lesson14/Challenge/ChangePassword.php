<?php

require_once('PageBase.php');
require_once('User.php');


class ChangePassword extends VisualPageBase
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
        return 'Change Password!';
    }


    public function inlineStyle()
    {
        return <<<EOSTYLE
    label
    {
        margin-top: 0.5em;
        display: block;
        font-family: Arial, Helvetica;
        font-size: 10pt;
        color:  #444;
    }

EOSTYLE;
    }

    protected function generateBodyContents()
    {
        if ($this->m_userid == -1)
        {
            echo "<h2>We need a userid to modify!</h2>\n";
            return;
        }

        try
        {
            echo <<<EOCONTENTS
  <h3>Change Password</h3>
  <form method='post' action='SubmitChangePassword.php' name='change_password_form'>
     <input type='hidden' name='userid' value='{$this->m_userid}'>
     <div>
       <label>Old Password:</label>
       <input type='password' name='oldpw' value='' size='30'>
     </div>
     <div>
       <label>New Password:</label>
       <input type='password' name='newpw1' value='' size='30'>
     </div>
     <div>
       <label>New Password (confirm):</label>
       <input type='password' name='newpw2' value='' size='30'>
     </div>
     <p><input type='submit' value='Change Password'></p>
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



$page = new ChangePassword();
$page->processRequest();



?>
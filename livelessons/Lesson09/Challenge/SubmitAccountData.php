<?php


require_once('User.php');
require_once('PageBase.php');


class SubmitAccountDataPage extends PageBase
{
    protected $m_error;
    protected $m_createdUser;


    public function title()
    {
        return 'Your New User Account';
    }


    public function inlineStyle()
    {
        return <<<EOM
    .error_msg
    {
      color: red;
    }
    #details_header
    {
      border-bottom: 1px solid #aaa;
      max-width: 400px;
    }

EOM;
    }


    protected function generateBodyContents()
    {
        if ($this->m_error != null)
        {
            echo <<<EOM
                <p class='error_msg'>$err</p>

EOM;
        }
        else
        {
            echo "<h3> Account created Successfully</h3>\n";
            echo "<div id='details_header'>Here are the account details: </div>\n";

            echo "<pre>\n";
            $this->m_createdUser->debugPrint();
            echo "</pre>\n";
        }
    }


    protected function processIncomingFormData()
    {
        if (!isset($_POST['user_name']) or trim($_POST['user_name']) == '')
            $this->m_error = "You must specify a user name";
        else if (!isset($_POST['full_name']) or trim($_POST['full_name']) == '')
            $this->m_error = 'You must specify a full name for your account';
        else if (!isset($_POST['email_address']) or trim($_POST['email_address']) == '')
            $this->m_error = 'Please provide an email address';
        else if (!isset($_POST['password1']) or trim($_POST['password1']) != trim($_POST['password2']))
            $this->m_error = 'The Passwords provide are either invalid or do not match';
        else
            $this->m_error = null;


        if ($this->m_error == null)
        {
            $un = $_POST['user_name'];
            $fn = $_POST['full_name'];
            $pw1 = $_POST['password1'];
            $em = $_POST['email_address'];

            $this->m_createdUser = new User($un, $fn, $pw1, $em);
        }
    }

}



$page = new SubmitAccountDataPage();
$page->processRequest();


?>
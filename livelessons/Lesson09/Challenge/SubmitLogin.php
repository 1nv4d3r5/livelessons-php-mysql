<?php


require_once('PageBase.php');


class SubmitLoginPage extends PageBase
{
    protected $m_error;
    protected $m_loginUsername;
    protected $m_loginPassword;

    public function title()
    {
        return 'Your Login Info';
    }


    public function inlineStyle()
    {
        return <<<EOM
    .fixed
    {
        font-family: courier new, courier;
        text-decoration: underline;
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
            $pw = '';
            for ($x = 0; $x < strlen($this->m_loginPassword); $x++)
                $pw .= '*';

            echo <<<EOM

    <h3>Your login information</h3>
    <div id='details_header'>Here are the details: </div>
    <div>
      <p><strong>Username:</strong> {$this->m_loginUsername}</p>
      <p><strong>Password:</strong> $pw</p>
    </div>     
EOM;
        }
    }


    protected function processIncomingFormData()
    {
        if (!isset($_POST['user_name']) or trim($_POST['user_name']) == '')
            $this->m_error = "You must specify a user name";
        else if (!isset($_POST['password']) or trim($_POST['password']) == '')
            $this->m_error = 'You didn\'t enter a password';
        else
            $this->m_error = null;


        if ($this->m_error == null)
        {
            $un = $_POST['user_name'];
            $pw = $_POST['password'];

            $this->m_loginUsername = $un;
            $this->m_loginPassword = $pw;
        }
    }

}



$page = new SubmitLoginPage();
$page->processRequest();


?>
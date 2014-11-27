<?php

require_once('requires.php');
require_once('PhotoShareBase.php');


class LoginPage extends PhotoShareBase
{
    public function __construct()
    {
        parent::__construct();
    }


    public function title()
    {
        return 'Log In!';
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
    .error
    {
        color: red;
        padding: 0.5em;
    }

EOSTYLE;
        return parent::inlineStyle() . $style;
    }


    protected function generateBodyContents()
    {
        parent::generateBodyContents();

        if (User::amILoggedIn())
        {
            echo 'Sorry, you can\'t be logged in when viewing this page';
            return;
        }

        if (isset($_GET['err']))
            $msg = "<p class='error'>Invalid username/password. Try Again</p>\n";
        else
            $msg = '';

        echo <<<EOCONTENTS
<h3>Login</h3>
  <form method='post' action='SubmitLogin.php' name='login_form'>
     $msg
     <div>
       <label>User Name:</label>
       <input type='text' name='user_name' size='30'>
     </div>
     <div>
       <label>Password:</label>
       <input type='password' name='password' size='20'>
     </div>
     <p><input type='submit' value='Login'></p>
  </form>
            
EOCONTENTS;
    }

}



$page = new LoginPage();
$page->processRequest();



?>


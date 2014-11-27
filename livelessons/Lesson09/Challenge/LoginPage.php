<?php

require_once('PageBase.php');


class LoginPage extends PageBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function title()
    {
        return 'Login now!';
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
        color: #444;
    }

EOSTYLE;

        return $style . parent::inlineStyle();
    }

    protected function generateBodyContents()
    {
        echo <<<EOCONTENTS
    <h3>Login</h3>
    <form method='post' action='SubmitLogin.php' name='login_form'>
       <div>
        <label>User Name:</label>
        <input type='text' name='user_name' size='20'>
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
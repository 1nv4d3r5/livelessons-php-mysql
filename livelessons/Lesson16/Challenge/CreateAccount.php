<?php

require_once('requires.php');
require_once('PhotoShareBase.php');


class CreateAccountPage extends PhotoShareBase
{
    public function __construct()
    {
        parent::__construct();
    }


    public function title()
    {
        return 'Create Account';
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

        if (User::amILoggedIn())
        {
            echo 'Sorry, you can\'t be logged in when viewing this page';
            return;
        }

        echo <<<EOCONTENTS
<h3>Create a New User Account</h3>
  <form method='post' action='SubmitAccountData.php' name='create_user_form'>
     <div>
       <label>User Name:</label>
       <input type='text' name='user_name' size='30'>
     </div>
     <div>
       <label>Full Name:</label>
       <input type='text' name='full_name' size='30'>
     </div>
     <div>
       <label>Password:</label>
       <input type='password' name='password1' size='20'>
     </div>
     <div>
       <label>Password (confirm):</label>
       <input type='password' name='password2' size='20'>
     </div>
     <div>
       <label>Email Address:</label>
       <input type='text' name='email_address' size='30'>
     </div>
     <div>
       <label>User Bio:</label>
       <textarea name='user_bio' rows='10' cols='40'></textarea>
     </div>
     <p><input type='submit' value='Create User'></p>
  </form>
            
EOCONTENTS;
    }

}



$page = new CreateAccountPage();
$page->processRequest();



?>
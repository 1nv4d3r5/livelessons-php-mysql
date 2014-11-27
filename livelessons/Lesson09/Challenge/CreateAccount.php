<?php

require_once('PageBase.php');


class CreateAccountPage extends PageBase
{
    public function title()
    {
        return 'Create Account';
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
     <p><input type='submit' value='Create User'></p>
  </form>
            
EOCONTENTS;
    }

}



$page = new CreateAccountPage();
$page->processRequest();



?>
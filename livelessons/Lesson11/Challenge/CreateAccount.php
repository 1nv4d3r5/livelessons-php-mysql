<?php

require_once('PageBase.php');


class CreateAccountPage extends VisualPageBase
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
        $bdayEditor = $this->generateBirthdayEditor('1990-01-01');

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
       <label>Gender:</label>
       <select name='gender'>
         <option value='male'>Male</option>
         <option value='female'>Female</option>
         <option value='unspecified'>Unspecified</option>
       </select>
     </div>
     <div>
       <label>Birthdate:</label>
{$bdayEditor}
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


    protected function generateBirthdayEditor($bd)
    {
        $parts = explode('-', $bd);
        if (count($parts) != 3)
            return "ERROR: Invalid birthdate specified";

        $year = "      <select style='width: 6em' name='byear'>\n";
        for ($x = 1998; $x > 1900; $x--)
        {
            $sel = ($parts[0] == $x) ? 'selected' : '';
            $year .= "         <option $sel value='$x'>$x</option>\n";
        }
        $year .= "       </select>\n";

        $month = "       <select style='width: 6em' name='bmonth'>\n";
        for ($x = 1; $x < 13; $x++)
        {
            $sel = ($parts[1] == $x) ? 'selected' : '';
            $month .= "         <option $sel value='$x'>$x</option>\n";
        }
        $month .= "       </select>\n";

        $day = "       <select style='width: 6em' name='bday'>\n";
        for ($x = 1; $x < 32; $x++)
        {
            $sel = ($parts[2] == $x) ? 'selected' : '';
            $day .= "         <option $sel value='$x'>$x</option>\n";
        }
        $day .= "       </select>\n";

        return "$year$month$day";
    }

    

}



$page = new CreateAccountPage();
$page->processRequest();



?>
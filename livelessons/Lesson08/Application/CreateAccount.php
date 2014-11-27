<?php



class CreateAccountPage
{
    public function __construct()
    {
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


    public function processRequest()
    {
        /**
         * first process any incoming POST data.
         */
        if (isset($_POST) and count($_POST) != 0)
            $this->processIncomingFormData();

        /**
         * Now emit page contents
         */
        $titleText = $this->title();
        $inlineStyle = $this->inlineStyle();

        $this->emitHeaders($titleText, $inlineStyle);

        echo "<body>\n";

        $this->generateBodyContents();

        echo "</body>\n";
        echo "</html>\n";

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


    protected function emitHeaders($titleText, $inlineStyle)
    {
        echo <<<EOHEADERS
<html>
<head>
  <title>{$titleText}</title>
  <style type='text/css' media='all'>
    body
    {
        font-family: Arial, Helvetica;
    }
    {$inlineStyle}
  </style>
</head>
            
EOHEADERS;
    }


    protected function processIncomingFormData()
    {
        // enter user page doesn't care about form data, ignore.
    }

}



$page = new CreateAccountPage();
$page->processRequest();



?>
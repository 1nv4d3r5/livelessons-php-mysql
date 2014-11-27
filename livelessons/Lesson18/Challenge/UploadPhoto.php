<?php

require_once('requires.php');
require_once('PhotoShareBase.php');


class UploadPhoto extends PhotoShareBase
{
    public function __construct()
    {
        parent::__construct();
    }


    public function title()
    {
        return 'Upload a photo!!';
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

        if (!User::amILoggedIn())
        {
            echo 'Sorry, you must be logged in when viewing this page';
            return;
        }

        if (isset($_GET['err']))
            $msg = "<p class='error'>An error occurred uploading your photo: {$_GET['err']}</p>\n";
        else
            $msg = '';

        echo <<<EOCONTENTS
<h3>Upload Photo!</h3>
  <form method='post' action='SubmitPhoto.php'
        enctype='multipart/form-data'
        name='upload_photo_form'>
     $msg
     <div>
       <label>Please Select a photo to upload:</label>
       <input type='file' name='upload_photo' size='30'>
     </div>
     <div>
       <label>Description:</label>
       <input type='text' name='description' size='30'>
     </div>
     <p><input type='submit' value='Submit'></p>
  </form>
            
EOCONTENTS;
    }

}



$page = new UploadPhoto();
$page->processRequest();



?>



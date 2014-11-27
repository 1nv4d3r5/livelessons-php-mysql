<?php

require_once('PageBase.php');


abstract class PhotoShareBase extends VisualPageBase
{
    public function inlineStyle()
    {
        return <<<EOM
    body
    {
      padding: 0;
      margin: 0;
    }
    #top_bar
    {
      padding: 5px;
      background-color: #f1edc6;
      border-bottom: 1px solid #888;
      min-height: 1em;
    }
    #login_info
    {
      float: right;
    }

EOM;
    }


    protected function generateBodyContents()
    {
        if (User::amILoggedIn())
        {
            $lun = htmlspecialchars(User::loggedInUserName());
            $li = "    <div id='login_info'>logged in as $lun</div\n";
        }
        else
            $li = '';

        echo <<<EOCON

  <div id='top_bar'> $li </div>

EOCON;
    }
}
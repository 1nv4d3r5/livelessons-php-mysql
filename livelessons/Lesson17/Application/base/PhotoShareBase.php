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
    #view_all_users
    {
      float: left;
    }
    #upload_now
    {
      margin-right: 1em;
      font-weight: bold;
      float: right;
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
            $li = "<div id='login_info'>$lun <a href='Logout.php'>[logout]</a></div\n";
            $up = "<div id='upload_now'><a href='UploadPhoto.php'>Upload a photo now!</a></div>\n";
        }
        else
        {
            $li = '';
            $up = '';
        }

        echo <<<EOCON

  <div id='top_bar'>
      <div id='view_all_users'>
         <a href='ViewAllUsers.php'>View All Users</a>
      </div>
      $li $up
  </div>

EOCON;
    }
}
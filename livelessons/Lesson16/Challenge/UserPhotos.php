<?php

define('PHOTOS_PER_PAGE', 5);

require_once('requires.php');
require_once('PhotoShareBase.php');
require_once('Photo.php');


class UserPhotos extends PhotoShareBase
{
    protected $m_page = 1;
    protected $m_userid = -1;

    public function __construct()
    {
        parent::__construct();

        $this->m_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->m_userid = isset($_GET['uid']) ? $_GET['uid'] : -1;
    }

    public function title()
    {
        return 'View Photos!';
    }


    public function inlineStyle()
    {
        $style = <<<EOM
    #photos
    {
      margin: 5px;
    }

    #photos .photo
    {
      margin-bottom: 20px;
      margin-left: 20px;
    }
    #photos .photo div
    {
      font-size: 10pt;
      margin-bottom: 5px;
      font-weight: bold;
      color: #888;
    }
    #photos img
    {
      max-width: 400px;
    }
    .photo .descr
    {
      float: left;
      padding: 10px;
    }
EOM;
        return parent::inlineStyle() . $style;
    }


    protected function generateBodyContents()
    {
        parent::generateBodyContents();

        if (!User::amILoggedIn())
        {
            echo "You have to be <a href='LoginPage.php'>logged</a> in to see this page, sorry";
            return;
        }

        $start = ($this->m_page - 1) * PHOTOS_PER_PAGE;

        // get photos and figure out next/prev stuff
        $photo_count = Photo::countPhotosForUser($this->m_userid);
        $photos = Photo::fetchPhotosForUser($this->m_userid, $start, PHOTOS_PER_PAGE);
        $have_next = (($this->m_page * PHOTOS_PER_PAGE) < $photo_count);
        $have_prev = ($this->m_page > 1);


        $u = User::loadUserById($this->m_userid);
        $un = htmlspecialchars($u->FullName);

        echo "  <div id='photos'>\n";
        echo "  <h3>Photos for $un</h3>\n";

        foreach ($photos as $photo)
        {
            $path = $photo->imageUrl();
            $desc = htmlspecialchars($photo->Description);
            echo <<<EOUSER

      <div class='photo'>
         <div>Uploaded on: {$photo->Uploaded}</div>
         <div style='float: left'><img src='$path'></div>
         <div class='descr'> $desc</div>
         <div style='clear: left':></div>
      </div>

EOUSER;
        }

        echo "  </div>  <!-- photos -->\n";
        $this->emitNextPrev($have_next, $have_prev);
    }


    protected function emitNextPrev($have_next, $have_prev)
    {
        if ($have_next)
        {
            $np = $this->m_page + 1;
            $next_link = "<a href='UserPhotos.php?uid={$this->m_userid}&page=$np'>Next &gt;&gt;</a>\n";
        }
        else
            $next_link = '';

        if ($have_prev)
        {
            $pp = $this->m_page - 1;
            $prev_link = "<a href='UserPhotos.php?uid={$this->m_userid}&page=$pp'>&lt;&lt; Prev</a>\n";
        }
        else
            $prev_link = '';


        echo "<p> {$prev_link} {$next_link} </p>\n";
    }

}



$page = new UserPhotos();
$page->processRequest();



?>
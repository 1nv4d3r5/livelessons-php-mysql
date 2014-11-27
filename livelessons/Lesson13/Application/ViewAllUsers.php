<?php

define('USERS_PER_PAGE', 5);

require_once('User.php');
require_once('PageBase.php');


class ViewAllUsers extends VisualPageBase
{
    protected $m_page = 1;

    public function __construct()
    {
        parent::__construct();

        $this->m_page = isset($_GET['page']) ? $_GET['page'] : 1;
    }

    public function title()
    {
        return 'View All Users';
    }


    public function inlineStyle()
    {
        return <<<EOM
    .user_name
    {
      float: left;
    }
    .user_name a
    {
      color: blue;
      text-decoration: none;
    }
    .user_name a:visited
    {
      color: blue;
      text-decoration: none;
    }
    .user_name a:hover
    {
      text-decoration: underline;
    }
    .full_name
    {
      margin-left: 20em;
    }
EOM;
    }


    protected function generateBodyContents()
    {
        $start = ($this->m_page - 1) * USERS_PER_PAGE;
        $users = User::listUsers($start, USERS_PER_PAGE);
        $user_count = User::countUsers();
        $have_next = (($this->m_page * USERS_PER_PAGE) <= $user_count);
        $have_prev = ($this->m_page > 1);


        echo "  <h3>PhotoShare Users</h3>\n";
        echo "  <div id='users'>\n";

        foreach ($users as $user)
        {
            $un = htmlspecialchars($user->Username);
            $fn = htmlspecialchars($user->FullName);

            echo <<<EOUSER

    <div class='user_name'><a href='UserProfile.php?id={$user->Userid}'>$un</a></div>
    <div class='full_name'>$fn</div>

EOUSER;
        }


        echo "  </div>  <!-- users -->\n";
        $this->emitNextPrev($have_next, $have_prev);
    }


    protected function emitNextPrev($have_next, $have_prev)
    {
        if ($have_next)
        {
            $np = $this->m_page + 1;
            $next_link = "<a href='ViewAllUsers.php?page=$np'>Next &gt;&gt;</a>\n";
        }
        else
            $next_link = '';

        if ($have_prev)
        {
            $pp = $this->m_page - 1;
            $prev_link = "<a href='ViewAllUsers.php?page=$pp'>&lt;&lt; Prev</a>\n";
        }
        else
            $prev_link = '';


        echo "<p> {$prev_link} {$next_link} </p>\n";
    }

}



$page = new ViewAllUsers();
$page->processRequest();



?>
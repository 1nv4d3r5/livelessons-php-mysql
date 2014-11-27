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
        $sort = $this->sortParam();
        $start = ($this->m_page - 1) * USERS_PER_PAGE;
        $users = User::listUsers($start, USERS_PER_PAGE, $sort);
        $user_count = User::countUsers();
        $have_next = (($this->m_page * USERS_PER_PAGE) <= $user_count);
        $have_prev = ($this->m_page > 1);

        echo <<<EOSORTS
  <div style='float: right'>
     Sort:
     <a href='ViewAllUsers.php?sort=asc'>Asc</a>
     <a href='ViewAllUsers.php?sort=desc'>Desc</a>
     <a href='ViewAllUsers.php?sort=none'>None</a>
  </div>
EOSORTS;

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


    protected function sortParam()
    {
        if (isset($_GET) and isset($_GET['sort']))
        {
            switch ($_GET['sort'])
            {
                case 'asc':
                    return User::USERLIST_SORTASC;
                case 'desc':
                    return User::USERLIST_SORTDESC;
                case 'none':
                    return User::USERLIST_NOSORT;
            }
        }

        return User::USERLIST_SORTASC;
    }

    protected function sortStringFromParam()
    {
        $sort = $this->sortParam();
        if ($sort == User::USERLIST_NOSORT)
            return 'none';
        else if ($sort == User::USERLIST_SORTASC)
            return 'asc';
        else
            return 'desc';
    }


    protected function emitNextPrev($have_next, $have_prev)
    {
        $sort = $this->sortStringFromParam();
        if ($have_next)
        {
            $np = $this->m_page + 1;
            $next_link = "<a href='ViewAllUsers.php?page=$np&sort=$sort'>Next &gt;&gt;</a>\n";
        }
        else
            $next_link = '';

        if ($have_prev)
        {
            $pp = $this->m_page - 1;
            $prev_link = "<a href='ViewAllUsers.php?page=$pp'&sort=$sort>&lt;&lt; Prev</a>\n";
        }
        else
            $prev_link = '';


        echo "<p> {$prev_link} {$next_link} </p>\n";
    }

}



$page = new ViewAllUsers();
$page->processRequest();



?>
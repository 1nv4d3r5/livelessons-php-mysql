<?php

define('USERS_PER_PAGE', 5);

require_once('requires.php');
require_once('PhotoShareBase.php');


class ViewAllUsers extends PhotoShareBase
{
    protected $m_page = 1;
    protected $m_search_text = '';

    public function __construct()
    {
        parent::__construct();

        $this->m_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->m_search_text = isset($_GET['biosearch']) ? $_GET['biosearch'] : '';
    }

    public function title()
    {
        return 'View All Users';
    }


    public function inlineStyle()
    {
        $style = <<<EOM
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
    .modify
    {
        font-size: 8pt;
    }
    #users
    {
      padding: 5px;
    }
    #biosearch
    {
      margin-top: 2em;
    }

EOM;
        return parent::inlineStyle() . $style;
    }


    protected function generateBodyContents()
    {
        parent::generateBodyContents();

        $start = ($this->m_page - 1) * USERS_PER_PAGE;

        if ($this->m_search_text != '')
        {
            $info = User::searchUserBios($this->m_search_text, $start, USERS_PER_PAGE); 
            $users = $info['users'];
            $user_count = $info['count'];
        }
        else
        {
            $users = User::listUsers($start, USERS_PER_PAGE);
            $user_count = User::countUsers();
        }

        $have_next = (($this->m_page * USERS_PER_PAGE) <= $user_count);
        $have_prev = ($this->m_page > 1);


        echo "  <div id='users'>\n";
        echo "  <h3>PhotoShare Users</h3>\n";

        foreach ($users as $user)
        {
            $un = htmlspecialchars($user->Username);
            $fn = htmlspecialchars($user->FullName);

            echo <<<EOUSER

    <div class='user_name'>
        <a class='modify' href='ModifyUser.php?id={$user->Userid}'>[edit]</a>&nbsp;
        <a href='UserProfile.php?id={$user->Userid}'>$un</a>
    </div>
    <div class='full_name'>$fn</div>

EOUSER;
        }

        echo <<<EOSEARCH
    <div id='biosearch'>
      <form action='' method='get' name='biosearch_form'>
        Search User Bios:
        <input type='text' name='biosearch' size='20'>
        <input type='submit' value='Search'>
      </form>
    </div>
    <div>
      <a href='ViewAllUsers.php'>View All</a>
    </div>


EOSEARCH;

        echo "  </div>  <!-- users -->\n";
        $this->emitNextPrev($have_next, $have_prev);
    }


    protected function emitNextPrev($have_next, $have_prev)
    {
        if ($this->m_search_text != '')
            $search = '&biosearch=' . urlencode($this->m_search_text);
        else
            $search = '';

        if ($have_next)
        {
            $np = $this->m_page + 1;
            $next_link = "<a href='ViewAllUsers.php?page=$np$search'>Next &gt;&gt;</a>\n";
        }
        else
            $next_link = '';

        if ($have_prev)
        {
            $pp = $this->m_page - 1;
            $prev_link = "<a href='ViewAllUsers.php?page=$pp$search'>&lt;&lt; Prev</a>\n";
        }
        else
            $prev_link = '';


        echo "<p> {$prev_link} {$next_link} </p>\n";
    }

}



$page = new ViewAllUsers();
$page->processRequest();



?>
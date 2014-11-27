<?php


require_once('requires.php');
require_once('PhotoShareBase.php');


class UserProfile extends PhotoShareBase
{
    protected $m_error;
    protected $m_userid = -1;

    public function __construct()
    {
        parent::__construct();
        if (isset($_GET))
        {
            if (isset($_GET['error']))
                $this->m_error = $_GET['error'];
            if (isset($_GET['id']))
                $this->m_userid = $_GET['id'];
        }
    }

    public function title()
    {
        return 'Your New User Account';
    }


    public function inlineStyle()
    {
        $style = <<<EOM
    .error_msg
    {
      color: red;
    }
    #profile
    {
      padding: 5px;
    }
    #profile h2
    {
      border-bottom: 1px solid #aaa;
      max-width: 400px;
    }

EOM;
        return parent::inlineStyle() . $style;
    }


    protected function generateBodyContents()
    {
        parent::generateBodyContents();

        if ($this->m_error != null)
        {
            echo <<<EOM
    <p class='error_msg'>{$this->m_error}</p>
    <p><a href='CreateAccount.php'>Go back</a> and try again.</p> 

EOM;
        }
        else if ($this->m_userid != -1)
        {
            $user = User::loadUserById($this->m_userid);

            echo "  <div id='profile'>\n";
            echo "  <h2>User Profile: </h2>\n";

            echo "  <pre>\n";
            echo $user;
            echo "  </pre>\n";
            echo "  </div>  <!-- profile -->\n";
        }
        else
        {
            echo <<<EOM
    <p> Please do not call this page directly.</p>
    <p>To see this page, first <a href='CreateAccount.php'>create an account</a></p>

EOM;
        }
    }

}



$page = new UserProfile();
$page->processRequest();



?>
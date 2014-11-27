<?php


require_once('requires.php');
require_once('PageBase.php');


class SubmitLogin extends RequestHandler
{
    public function __construct()
    {
    }


    protected function processIncomingFormData()
    {
        if (User::amILoggedIn())
        {
            // this is an error -- just ignore and redirect them to viewallusers.
            $this->redirectToPage('ViewALlUsers.php');
        }

        if (!isset($_POST['user_name']) or trim($_POST['user_name']) == ''
            or !isset($_POST['password']) or trim($_POST['password']) == '')
        {
            $this->redirectToPage('LoginPage.php?err=1');
        }

        try
        {
            $un = trim($_POST['user_name']);
            $pw = trim($_POST['password']);

            $u = User::loadUserByUsername($un);
            $u->login($pw);

            // if we're here, then they logged in correctly!
            $this->redirectToPage("UserProfile.php?id={$u->Userid}");
        }
        catch (Exception $e)
        {
            $this->redirectToPage('LoginPage.php?err=1');
        }
    }

}



$page = new SubmitLogin();
$page->processRequest();


?>





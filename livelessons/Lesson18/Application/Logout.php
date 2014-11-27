<?php

require_once('requires.php');
require_once('PageBase.php');


class Logout extends RequestHandler
{
    public function __construct()
    {
    }

    protected function processIncomingFormData()
    {
        if (!User::amILoggedIn())
        {
            // this is an error -- just ignore and redirect them to loginpage
            $this->redirectToPage('LoginPage.php');
        }

        // logout and redirect.
        $u = User::loadUserById(User::loggedInUserid());
        $u->logout();
        $this->redirectToPage('LoginPage.php');
    }

}



$page = new Logout();
$page->processRequest();


?>





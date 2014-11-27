<?php


require_once('User.php');
require_once('PageBase.php');


class SubmitAccountDataPage extends RequestHandler
{
    public function __construct()
    {
    }


    protected function processIncomingFormData()
    {
        if (!isset($_POST['user_name']) or trim($_POST['user_name']) == '')
            $errmsg = "You must specify a user name";
        else if (!isset($_POST['full_name']) or trim($_POST['full_name']) == '')
            $errmsg = 'You must specify a full name for your account';
        else if (!isset($_POST['email_address']) or trim($_POST['email_address']) == '')
            $errmsg = 'Please provide an email address';
        else if (!isset($_POST['password1']) or trim($_POST['password1']) != trim($_POST['password2']))
            $errmsg = 'The Passwords provide are either invalid or do not match';
        else
            $errmsg = null;


        if ($errmsg != null)
        {
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
        }

        try
        {
            $un = trim($_POST['user_name']);
            $fn = trim($_POST['full_name']);
            $pw1 = trim($_POST['password1']);
            $em = trim($_POST['email_address']);

            $new_user = new User($un, $fn, $pw1, $em);
            $serialized = urlencode(serialize($new_user));
            $this->redirectToPage("UserProfile.php?user_data={$serialized}");
        }
        catch (Exception $e)
        {
            $errmsg = "Oh noes!  An exception was thrown: " . get_class($e);
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
        }
    }

}



$page = new SubmitAccountDataPage();
$page->processRequest();


?>
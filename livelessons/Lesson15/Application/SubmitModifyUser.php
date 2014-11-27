<?php


require_once('requires.php');
require_once('PageBase.php');


class SubmitModifyUser extends RequestHandler
{
    public function __construct()
    {
    }


    protected function processIncomingFormData()
    {
        if (!isset($_POST['userid']) or (int)($_POST['userid']) <= 0)
            $errmsg = 'Invalid form data.';
        else if (!isset($_POST['full_name']) or trim($_POST['full_name']) == '')
            $errmsg = 'You must specify a full name for your account';
        else if (!isset($_POST['email_address']) or trim($_POST['email_address']) == '')
            $errmsg = 'Please provide an email address';
        else
            $errmsg = null;

        if ($errmsg != null)
        {
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
        }

        try
        {
            $fn = trim($_POST['full_name']);
            $em = trim($_POST['email_address']);
            $bio = trim($_POST['user_bio']);
            $userid = (int)$_POST['userid'];
            $u = User::loadUserByid($userid);

            $u->updateDetails($fn, $em, $bio);
            $this->redirectToPage("UserProfile.php?id={$u->Userid}");
        }
        catch (PSUsernameInUseException $e)
        {
            $errmsg = 'Sorry, that username is already in use.  Please choose another one. (Click the "Back" button to try again)';
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
        }
        catch (Exception $e)
        {
            $errmsg = "Oh noes!  An exception was thrown: " . get_class($e) . " \"" . $e->getMessage() . "\"";
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
        }
    }

}



$page = new SubmitModifyUser();
$page->processRequest();


?>
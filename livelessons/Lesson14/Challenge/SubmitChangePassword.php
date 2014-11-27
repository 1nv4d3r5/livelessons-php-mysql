<?php


require_once('User.php');
require_once('PageBase.php');


class PSPasswordsDontMatchException extends Exception { }



class SubmitChangePassword extends RequestHandler
{
    public function __construct()
    {
    }


    protected function processIncomingFormData()
    {
        if (!isset($_POST['userid']) or (int)($_POST['userid']) <= 0)
            $errmsg = 'Invalid form data.';
        else if (!isset($_POST['oldpw']) or !isset($_POST['newpw1']) or !isset($_POST['newpw2']))
            $errmsg = 'Invalid form data';
        else
            $errmsg = null;

        if ($errmsg != null)
        {
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
        }

        try
        {
            $userid = (int)$_POST['userid'];
            $u = User::loadUserByid($userid);

            if (md5($_POST['oldpw']) != $u->Password)
                throw new PSInvalidLoginException();

            if ($_POST['newpw1'] != $_POST['newpw2'])
                throw new PSPasswordsDontMatchException();

            $u->changePassword($_POST['newpw1']);
            $this->redirectToPage("UserProfile.php?id={$u->Userid}");
        }
        catch (PSLoginException $e)
        {
            $errmsg = 'Your current password is incorrect';
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
        }
        catch (PSPasswordsDontMatchException $e)
        {
            $errmsg = 'Sorry, the specified passwords don\'t match';
            $msg = urlencode($errmsg);
            $this->redirectToPage("UserProfile.php?error={$msg}");
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



$page = new SubmitChangePassword();
$page->processRequest();


?>
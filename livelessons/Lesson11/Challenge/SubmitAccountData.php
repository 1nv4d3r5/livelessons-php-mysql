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
        else if (!isset($_POST['gender'])
                 or ($_POST['gender'] != 'male' and $_POST['gender'] != 'female'
                     and $_POST['gender'] != 'unspecified'))
            $errmsg = 'Invalid Gender specified!';
        else
            $errmsg = null;

        $byear = isset($_POST['byear']) ? $_POST['byear'] : 'bad';
        $bmonth = isset($_POST['bmonth']) ? $_POST['bmonth'] : 'bad';
        $bday = isset($_POST['bday']) ? $_POST['bday'] : 'bad';

        /**
         * The checkdate function takes a date and verifies if it's valid or
         * not.  It's smart enough to handle things like leap years, etc.
         */
        if (checkdate((int)$bmonth, (int)$bday, (int)$byear) == false)
            $errmsg = 'Invalid Birthdate!!';

        /**
         * Print the error or redirect to the UserProfile.
         */
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
            $bdate = "$byear-$bmonth-$bday";
            $gender = $_POST['gender'];

            $new_user = new User($un, $fn, $pw1, $em, $bdate, $gender);
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
<?php

require_once('requires.php');
require_once('PageBase.php');
require_once('Photo.php');


class SubmitPhoto extends RequestHandler
{
    public function __construct()
    {
    }


    protected function processIncomingFormData()
    {
        if (!User::amILoggedIn())
        {
            echo "You have to be <a href='LoginPage.php'>logged</a> in to see this page, sorry";
            return;
        }

        try
        {
            // check params.
            if (!isset($_FILES['upload_photo']))
                $this->redirectToPage('UploadPhoto.php?err=form+incorrectly+submitted');
            if (($msg = $this->checkUploadError($_FILES['upload_photo'])) != null)
                $this->redirectToPage('UploadPhoto.php?err=' . urlencode($msg));


            // check the extension
            $ext = strtolower(pathinfo($_FILES['upload_photo']['name'], PATHINFO_EXTENSION));
            switch ($ext)
            {
                case 'bmp': case 'gif': case 'png': case 'jpg': case 'jpeg':
                    break; // okay
                default:
                    $this->redirectToPage('UploadPhoto.php?err=' . urlencode('invalid file type'));
            }

            // select a destination filename -- we'll pick one one for the user.
            $userid = User::loggedInUserid();
            $fn = md5('' . $userid . (string)time() . rand()) . '.' . $ext;
            move_uploaded_file($_FILES['upload_photo']['tmp_name'],
                               $_SERVER['DOCUMENT_ROOT'] . IMAGE_SUB_PATH . $fn);

            $desc = isset($_POST['description']) ? trim($_POST['description']) : '';

            // update the data model for this.
            Photo::addNewPhotoForUser($userid, $fn, $desc);

            // redirect to the user's photos page.
            $this->redirectToPage("UserPhotos.php?uid={$userid}");

        }
        catch (Exception $e)
        {
            $msg = 'Unexpected exception: ' . get_class($e) . " .... " . $e->getMessage();;
            $this->redirectToPage('UploadPhoto.php?err=' . urlencode($msg));
        }
    }


    protected function checkUploadError($fileinfo)
    {
        if (!isset($fileinfo['error']))
            throw new PSInvalidPhotoDataException();

        switch ($fileinfo['error'])
        {
            case UPLOAD_ERR_OK:
                return null;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'file is too large';
            case UPLOAD_ERR_NO_FILE:
                return 'no file received';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'server config error:  no tmp directory specified for file uploads';
            default:
                return 'whoa! completely unexpected error';
        }
    }



}



$page = new SubmitPhoto();
$page->processRequest();


?>





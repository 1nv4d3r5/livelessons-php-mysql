<?php

echo "a"; exit;

require_once('baseclasstesting.php');



class CreateAccountPage extends PageBase
{
    public function title()
    {
        return 'Create Account';
    }


    public function inlineStyle()
    {
        // etc.
    }


    protected function generateBodyContents()
    {
        echo 'moo cow!';
    }


}


$pg = new CreateAccountPage();
$pg->processRequest();


class SubmitAccountDataPage extends PageBase
{
    protected $m_error;
    protected $m_createdUser;

    protected function processIncomingFormData()
    {
        // do my own stuff in here.
    }


    public function title()
    {
        return 'Your New User Account';
    }


    public function inlineStyle()
    {
        // etc
    }

    protected function generateBodyContents()
    {
        // etc
    }
}




?>
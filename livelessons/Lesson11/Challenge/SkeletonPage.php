<?php



class PAGECLASSNAME
{
    public function __construct()
    {
        parent::__construct();
    }

    // mandatory
    public function title()
    {
        return 'PAGE TITLE';
    }

    // optional -- delete if you don't have any style.
    public function inlineStyle()
    {
        return '';
    }

    // mandatory
    protected function generateBodyContents()
    {
    }

}



$page = new PAGECLASSNAME();
$page->processRequest();



?>
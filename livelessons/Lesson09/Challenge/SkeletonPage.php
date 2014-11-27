<?php

require_once('PageBase.php');


class PAGECLASSNAME extends PageBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function title()
    {
        return 'PAGE TITLE';
    }

    protected function generateBodyContents()
    {
    }

    // feel free to implement:
    //   - processIncomingFormData
    //   - inlineStyle
}



$page = new PAGECLASSNAME();
$page->processRequest();



?>
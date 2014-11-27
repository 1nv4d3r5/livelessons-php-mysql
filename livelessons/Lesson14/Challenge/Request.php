<?php


abstract class RequestHandler
{
    public function __construct()
    {
    }


    public function processRequest()
    {
        /**
         * first process any incoming POST data.
         */
        $this->processIncomingFormData();
    }


    protected function processIncomingFormData()
    {
    }


    protected function redirectToPage($in_url, $in_contentType = 'text/html')
    {
        header("Location: $in_url");
        header("Content-Type: $in_contentType");
        exit;
    }

}



?>
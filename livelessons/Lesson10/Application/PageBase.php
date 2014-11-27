<?php

abstract class PageBase
{
    public function __construct()
    {
    }


    public abstract function title();
    protected abstract function generateBodyContents();

    public function inlineStyle()
    {
        return '';
    }

    public function processRequest()
    {
        /**
         * first process any incoming POST data.
         */
        $this->processIncomingFormData();

        /**
         * Now emit page contents
         */
        $titleText = $this->title();
        $inlineStyle = $this->inlineStyle();

        $this->emitHeaders($titleText, $inlineStyle);

        echo "<body>\n";

        $this->generateBodyContents();

        echo "</body>\n";
        echo "</html>\n";

    }


    protected function emitHeaders($titleText, $inlineStyle)
    {
        echo <<<EOHEADERS
<html>
<head>
  <title>{$titleText}</title>
  <style type='text/css' media='all'>
    body
    {
        font-family: Arial, Helvetica;
    }
    {$inlineStyle}
  </style>
</head>
            
EOHEADERS;
    }


    protected function processIncomingFormData()
    {
    }

}



?>
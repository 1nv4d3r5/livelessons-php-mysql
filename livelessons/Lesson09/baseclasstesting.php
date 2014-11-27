<?php


class PageBase
{
    public function __construct()
    {
    }

    public function processRequest()
    {
        /**
         * first process any incoming POST data.
         */
        if (isset($_POST) and count($_POST) != 0)
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
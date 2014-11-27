<?php

if (function_exists('xdebug_disable')) xdebug_disable();

set_error_handler('my_error_handler');



if (isset($_SERVER['WINDIR']))
    set_include_path(get_include_path() . ';base/;objdata/');
else
    set_include_path(get_include_path() . ':base/:objdata/');

ob_start();
session_start();



$x = 5 / 0;

require_once('User.php');


function my_error_handler($errno , $errstr, $errfile, $errline, $errcontext)
{
    $f = fopen('/tmp/logs', 'a');
    $message = "Error: $errno, $errfile (Line $errline), Message: $errstr\n";
    fwrite($f, $message);
    fclose($f);

    ob_clean();
    echo <<<EOM
<p>Oops, an unexpected error has occurred.  We have logged this error and have our programmers
look at it as soon as possible.  Sorry for the inconvenience!</p>
<p> Please try back in a little bit!</p>

EOM;

    exit;
} 

?>
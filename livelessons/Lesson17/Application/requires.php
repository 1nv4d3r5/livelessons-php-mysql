<?php

if (isset($_SERVER['WINDIR']))
    set_include_path(get_include_path() . ';base/;objdata/');
else
    set_include_path(get_include_path() . ':base/:objdata/');

ob_start();
session_start();

require_once('User.php');


?>
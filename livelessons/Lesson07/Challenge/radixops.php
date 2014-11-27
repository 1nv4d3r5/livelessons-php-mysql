<?php

define('INVALID_HEX_STRING', 'ERROR: This is not a valid hex string');
define('INVALID_OCT_STRING', 'ERROR: This is not a valid octal string');

function decimal_to_hex($dec, $add_0x = false)
{
	$chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

    if ($dec < 0)
    {
        $dec = -$dec;
        $neg = true;
    }
    else
        $neg = false;

	$result = '';

	while ($dec > 0)
    {
        $result = $chars[$dec % 16] . $result;
        $dec = (int)($dec / 16);
    }

    if ($add_0x == true)
        $result = '0x' . $result;

    if ($neg == true)
        $result = '-' . $result;

    return $result;	
}


function hex_to_decimal($hex)
{
    $hex = strtolower($hex);
	$hex = trim($hex);

    if (substr($hex, 0, 1) == '-')
    {
        $neg = true;
        $hex = substr($hex, 1);
    }
    else
        $neg = false;

	if (substr($hex, 0, 2) == '0x')
   		$hex = substr($hex, 2);

	$result = 0;
	while ($hex != '')
    {
        $char = substr($hex, 0, 1);
        if (ord($char) >= ord('a') and ord($char) <= ord('f'))
            $val = 10 + (ord($char) - ord('a'));
        else if (ord($char) >= ord('0') and ord($char) <= ord('9'))
            $val = ord($char) - ord('0');
        else
            return INVALID_HEX_STRING;

        $result = ($result * 16) + $val;
        $hex = substr($hex, 1);
    }

    if ($neg == true)
        $result = -$result;

    return $result;
}


function decimal_to_oct($dec, $add_0 = true)
{
	$chars = array('0', '1', '2', '3', '4', '5', '6', '7');

    if ($dec < 0)
    {
        $dec = -$dec;
        $neg = true;
    }
    else
        $neg = false;

	$result = '';

	while ($dec > 0)
    {
        $result = $chars[$dec % 8] . $result;
        $dec = (int)($dec / 8);
    }

    if ($add_0)                   // same as if ($add_0 == true)
        $result = '0' . $result;

    if ($neg == true)
        $result = '-' . $result;

    return $result;	
}


function oct_to_decimal($oct)
{
	$oct = trim($oct);

    if (substr($oct, 0, 1) == '-')
    {
        $neg = true;
        $oct = substr($oct, 1);
    }
    else
        $neg = false;

	if (substr($oct, 0, 1) == '0')
   		$oct = substr($oct, 1);

	$result = 0;
	while ($oct != '')
    {
        $char = substr($oct, 0, 1);

        if (ord($char) >= ord('0') and ord($char) <= ord('7'))
            $val = ord($char) - ord('0');
        else
            return INVALID_OCT_STRING;

        $result = ($result * 8) + $val;
        $oct = substr($oct, 1);
    }

    if ($neg == true)
        $result = -$result;

    return $result;
}


?>
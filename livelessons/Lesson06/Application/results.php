<?php

define('INVALID_INPUT', 'ERROR:  Invalid Input');
define('INVALID_OPERATOR', 'ERROR:  Invalid Operator');
define('INVALID_HEX_STRING', 'ERROR: This is not a valid hex string');


$start_again_radix = '';

if (isset($_POST['input1'])
    and isset($_POST['input2'])
    and isset($_POST['operator'])
    and isset($_POST['radix']))
{
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];
    $radix = $_POST['radix'];

    // convert the operands into decimal
    if ($radix == 'hex')
    {
        $input1 = hex_to_decimal($input1);
        $input2 = hex_to_decimal($input2);
    }

    $operator = $_POST['operator'];

    switch ($operator)
    {
        case 'add':
            $result = $input1 + $input2;
            break;
        case 'sub':
            $result = $input1 - $input2;
            break;
        case 'mult':
            $result = $input1 * $input2;
            break;
        case 'div':
            $result = $input1 / $input2;
            break;
        case 'modulus':
            $result = $input1 % $input2;
            break;
        case 'sqrt':
            $result = babylonian_square_root($input1);
            break;
        case 'power_of':
            $result = power_of($input1, $input2);
            break;
        default:
            $result = INVALID_OPERATOR;
            break;
    }

    if ($radix == 'hex')
    {
        $result = decimal_to_hex($result, true);
        $start_again_radix = '?hex';
    }
}
else
    $result = INVALID_INPUT;


function decimal_to_hex($dec, $add_0x = false)
{
	$chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

	$result = '';

	while ($dec > 0)
    {
        $result = $chars[$dec % 16] . $result;
        $dec = (int)($dec / 16);
    }

    if ($add_0x == true)
        $result = '0x' . $result;

    return $result;	
}


function hex_to_decimal($hex)
{
    $hex = strtolower($hex);
	$hex = trim($hex);

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

    return $result;
}


function power_of($base, $exponent)
{
    $result = $base;
    while ($exponent > 1)
    {
        $result = $result * $base;
        $exponent--;
    }

    return $result;
}



function babylonian_square_root($value)
{
    $value = abs($value);  // no negative sqrts!
    $guess = $value / 2;
    for ($x = 0; $x < 5; $x++)
        $guess = 0.5 * ($guess + ($value / $guess));

    return $guess;
}


?>
<html>
<head>
  <title>Results!</title>
</head>
<body>
   <h3>Your Results!</h3>
   <p> The final result is: <?= $result ?> </p>
   <p> <a href='calc.php<?= $start_again_radix ?>'>start again</a></p>
</body>
</html>




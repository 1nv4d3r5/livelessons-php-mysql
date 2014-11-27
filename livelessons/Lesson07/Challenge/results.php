<?php

require_once('radixops.php');
require_once('mathfuncs.php');

define('INVALID_INPUT', 'ERROR:  Invalid Input');
define('INVALID_OPERATOR', 'ERROR:  Invalid Operator');


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
    else if ($radix == 'oct')
    {
        $input1 = oct_to_decimal($input1);
        $input2 = oct_to_decimal($input2);
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
    else if ($radix == 'oct')
    {
        $result = decimal_to_oct($result, true);
        $start_again_radix = '?oct';
    }
}
else
    $result = INVALID_INPUT;


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




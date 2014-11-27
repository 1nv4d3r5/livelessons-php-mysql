<?php

define('INVALID_INPUT', 'ERROR:  Invalid Input');
define('INVALID_OPERATOR', 'ERROR:  Invalid Operator');


if (isset($_POST['input1'])
    and isset($_POST['input2'])
    and isset($_POST['operator']))
{
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];

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
        case 'factorial':
            $result = factorial($input1);
            break;

        default:
            $result = INVALID_OPERATOR;
            break;
    }
}
else
    $result = INVALID_INPUT;



function power_of($base, $exponent)
{
    if ($exponent == 0)
        return 1;

    $neg = ($exponent < 0);
    $exponent = abs($exponent);    // abs() returns the absolute value of an int

    $result = $base;
    while ($exponent > 1)
    {
        $result = $result * $base;
        $exponent--;
    }

    if ($neg)
        $result = 1 / $result;
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


function factorial($value)
{
    $result = 1;
    while ($value > 1)
    {
        $result *= $value;
        $value -= 1;
    }

    return $result;
}


?>
<html>
<head>
  <title>Results!</title>
</head>
<body>
   <h3>Your Results!</h3>
   <p> The final result is: <?= $result ?> </p>
   <p> <a href='calc.php'>start again</a></p>
</body>
</html>

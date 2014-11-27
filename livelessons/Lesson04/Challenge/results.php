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
        case 'idiv':
            $result = (int)($input1 / $input2);
            break;
        default:
            $result = INVALID_OPERATOR;
            break;
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
   <p> <a href='calc.php'>start again</a></p>
</body>
</html>

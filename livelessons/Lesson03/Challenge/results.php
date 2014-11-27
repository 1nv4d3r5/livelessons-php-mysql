<?php

$input1 = $_POST['input1'];
$input2 = $_POST['input2'];

$operator = $_POST['operator'];

if ($operator == 'add')
    $result = $input1 + $input2;
else if ($operator == 'sub')
    $result = $input1 - $input2;
else if ($operator == 'mult')
    $result = $input1 * $input2;
else if ($operator == 'div')
    $result = $input1 / $input2;
else if ($operator == 'modulus')
    $result = $input1 % $input2;
else
    $result = "ERROR";

?>
<html>
<head>
  <title>Results!</title>
  <style type="text/css" media="all">
    .result
    {
        font-family: courier new, courier;
        text-decoration: underline;
        color: red;
    }
  </style>
</head>
<body>
   <h3>Your Results!</h3>
   <p> The final result is: <span class='result'><?= $result ?></span> </p>
   <p> <a href='calc.php'>start again</a></p>
</body>
</html>

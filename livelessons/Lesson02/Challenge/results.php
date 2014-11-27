<?php
   $operand1 = $_POST['operand1'];
?>
<html>
<head>
  <title>Results!</title>
</head>
<body>
   <h3>Here are your results!</h3>
  <p> You gave us the value <?= $operand1 ?> </p>
  <p> <a href='calc.php'>start again</p>
</body>
</html>

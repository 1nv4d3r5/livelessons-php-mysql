<?php

  $hexselected = (isset($_GET) and isset($_GET['hex'])) ? 'checked' : '';
  $decselected = $hexselected == 'checked' ? '' : 'checked';
?>
<html>
<head>
  <title>This is a pretty basic calculator!</title>
  <style type='text/css' media='all'>
    #radix_box
    {
      width: 20em;
      margin-bottom: 0.5em;
    }
  </style>
</head>
<body>
   <h3>Calculate!</h3>
   <form method='post' action='results.php' name='calc_form'>
      <div id='radix_box'>
        <input type='radio' name='radix' value='dec' <?= $decselected ?> >Dec &nbsp;
        <input type='radio' name='radix' value='hex' <?= $hexselected ?> >Hex
      </div>
      <input type='text' name='input1' size='15'>
      <select name='operator'>
        <option value='add'>+</option>
        <option value='sub'>-</option>
        <option value='mult'>*</option>
        <option value='div'>/</option>
        <option value='modulus'>%</option>
        <option value='sqrt'>sqrt</option>
        <option value='power_of'>to the power of</option>
      </select>
      <input type='text' name='input2' size='15'>
      <input type='submit' value='Go!'>
   </form>
</body>
</html>



<html>
<head>
  <title>This is a pretty basic calculator!</title>
</head>
<body>
   <h3>Calculate!</h3>
   <form method='post' action='results.php' name='calc_form'>
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

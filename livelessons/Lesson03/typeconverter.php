<html>
<head>
  <title>Convert Strings to ... </title>
  <style type="text/css" media="all">
    .fixed
    {
        font-family: courier new, courier;
        text-decoration: underline;
    }
  </style>
</head>
<body>
<?php

$result = null;


if (isset($_POST))
{
    if (isset($_POST['value_to_convert']))
    {
        $value_to_convert = $_POST['value_to_convert'];

        if (isset($_POST['convert_to']))
        {
            $convert_to = $_POST['convert_to'];
            if ($convert_to == 'integer')
                $result = (int)$value_to_convert;
            else if ($convert_to == 'float')
                $result = (float)$value_to_convert;
            else if ($convert_to == 'boolean')
                $result = (boolean)$value_to_convert;
            else if ($convert_to == 'array')
                $result = (array)$value_to_convert;
            else
                $result = "ERROR";
        }
    }
}


if ($result !== null)
{
    $t = gettype($result);
    $v = var_export($result, true);

    echo <<<EOM
<h3>Your results</h3>

<p> You asked to convert <span class='fixed'>$value_to_convert</span>
    to the type <span class='fixed' >$convert_to</span>.</p>
<p> The resulting value is: </p>
<p style='font-size: 12pt'>($t) $v</p>

EOM;
}

?>

<form action='' method='post' name='type_conversion_form'>
  <div>
    Convert: <input type='text' size='20' name="value_to_convert"> to:
    <select name='convert_to'>
      <option value='integer'>integer</option>
      <option value='float'>float</option>
      <option value='boolean'>boolean</option>
      <option value='array'>array</option>
    </select>
  </div>
  <div>
    <input type='submit' value='Convert!'>
  </div>
</form>


</body>
</html>

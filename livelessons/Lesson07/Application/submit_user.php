<html>
<head>
  <title> Creating Account </title>
  <style type='text/css' media='all'>
    body
    {
      font-family: Arial, Helvetica;
    }
    .error_msg
    {
      color: red;
    }
    #details_header
    {
      border-bottom: 1px solid #aaa;
      max-width: 400px;
    }
  </style>
</head>
<body>
<?php

require_once('Users.php');


if (!isset($_POST['user_name']) or trim($_POST['user_name']) == '')
    $err = "You must specify a user name";
else if (!isset($_POST['full_name']) or trim($_POST['full_name']) == '')
    $err = 'You must specify a full name for your account';
else if (!isset($_POST['email_address']) or trim($_POST['email_address']) == '')
    $err = 'Please provide an email address';
else if (!isset($_POST['password1']) or trim($_POST['password1']) != trim($_POST['password2']))
    $err = 'The Passwords provide are either invalid or do not match';
else
    $err = null;

if ($err !== null)
{
    echo <<<EOM
    <p class='error_msg'>$err</p>

EOM;
}
else
{
    $un = $_POST['user_name'];
    $fn = $_POST['full_name'];
    $pw1 = $_POST['password1'];
    $em = $_POST['email_address'];

    $user = user_create($un, $fn, $pw1, $em);

    echo "<h3> Account created Successfully</h3>\n";
    echo "<div id='details_header'>Here are the account details: </div>\n";

    user_print($user);
}

?>

</body>
</html>

<?php
?>

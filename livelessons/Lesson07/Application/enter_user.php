<html>
<head>
  <title>Create new user</title>
  <style type='text/css' media='all'>
    body
    {
        font-family: Arial, Helvetica;
    }
    label
    {
        margin-top: 0.5em;
        display: block;
        font-family: Arial, Helvetica;
        font-size: 10pt;
        color:  #444;
    }
  </style>
</head>
<body>
<h3>Create a New User Account</h3>
  <form method='post' action='submit_user.php' name='create_user_form'>
     <div>
       <label>User Name:</label>
       <input type='text' name='user_name' size='30'>
     </div>
     <div>
       <label>Full Name:</label>
       <input type='text' name='full_name' size='30'>
     </div>
     <div>
       <label>Password:</label>
       <input type='password' name='password1' size='20'>
     </div>
     <div>
       <label>Password (confirm):</label>
       <input type='password' name='password2' size='20'>
     </div>
     <div>
       <label>Email Address:</label>
       <input type='text' name='email_address' size='30'>
     </div>
     <p><input type='submit' value='Create User'></p>
  </form>
</body>
</html>


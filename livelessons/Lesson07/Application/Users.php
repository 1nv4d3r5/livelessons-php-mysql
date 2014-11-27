<?php

define('INVALID_PASSWORD', 'ERROR: Invalid Password');
define('USER_ALREADY_LOGGED_IN', 'WARNING: User already logged in');
define('USER_NOT_LOGGED_IN', 'WARNING: User is not logged in');

/**
 * Users have the following fields:
 *
 * 'Username'
 * 'FullName'
 * 'Password';
 * 'EmailAddress'
 * 'LoggedIn' -- doesn't have to be set.
 */

function user_create($username, $fullname, $password, $email_address)
{
    return array('Username' => $username, 'FullName' => $fullname, 
                 'Password' => md5($password), 'EmailAddress' => $email_address);
}


function user_check_password($user, $password_to_check)
{
    if (md5($password_to_check) == $user['Password'])
        return true;
    else
        return false;
}


function user_update_details(&$user, $dets_to_update)
{
    foreach ($dets_to_update as $det => $newvalue)
    {
        if (isset($user[$det]) and $newvalue != '')
            $user[$det] = $newvalue;
        else
            return false;
    }

    return true;
}


function user_login(&$user, $password)
{
    if (!user_check_password($user, $password))
        return INVALID_PASSWORD;

    if (isset($user['LoggedIn']))
        return USER_ALREADY_LOGGED_IN;

    $user['LoggedIn'] = true;

    return true;
}


function user_print($user)
{
    foreach ($user as $field => $value)
    {
        if ($field == 'Password')
            $value = '*********';

        echo "<p><strong>$field</strong>: $value</p>\n";
    }
}


function user_logout(&$user)
{
    if (!isset($user['LoggedIn']))
        return USER_NOT_LOGGED_IN;

    unset($user['LoggedIn']);
    return true;
}




?>
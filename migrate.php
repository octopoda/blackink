<?php
    require_once('includes/require.php');

    global $db;

    $salt = 'b32de679e7b74563104e231ea0b0f0ce2dff3b1e';
    $hash = "12345";
    $password = sha1('Black ' . $salt .'Ink hashes'. $hash);
    //$db->query("INSERT INTO userSalts (user_id, salt) VALUES ('1', '{$salt}')");
    $db->query("UPDATE users SET password = '{$password}' WHERE user_id = 1");
    echo 'done';
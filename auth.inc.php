<?php

//FIXME make this not suck

session_start();
require 'config.inc.php';
$authorized = false;

if(isset($_GET['logout']) && ($_SESSION['auth'])) {
    $_SESSION['auth'] = null;
    session_destroy();
    echo "logging out...";
}

if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    $user = 'face';
    $pass = 'face';
    if (($user == $_SERVER['PHP_AUTH_USER']) && ($pass == ($_SERVER['PHP_AUTH_PW'])) && (!empty($_SESSION['auth']))) {
        $authorized = true;
    }
}

if (!$authorized) {
    header('WWW-Authenticate: Basic Realm="Login please"');
    header('HTTP/1.0 401 Unauthorized');
    $_SESSION['auth'] = true;
    print('Login now or forever hold your clicks...');
    exit;
}

?>

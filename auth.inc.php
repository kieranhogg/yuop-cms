<?php

require 'class/Auth.class.php';
require_once 'tbs/tbs_class.php';
session_start();

if (isset($_POST['username'])) {
    $user = $_POST['username'];
}

if (isset($_POST['password'])) {
    $pass = $_POST['password'];
}

if (!isset($require_login)) {
    $require_login = false;
}

//logout
if(isset($_GET['logout']) && (isset($_SESSION['auth']))) {
    echo 'logging out';
    $_SESSION['auth'] = null;
    $auth->destroy();
}
elseif ($require_login && $_SESSION['auth'] !== true) {
    if (isset($user) && isset($pass)) {
        $auth = new Auth($user, $pass, $db);
        if (!$auth->isAuth()) {
            $page_title = 'Error | ' . SITE_TITLE;
            $error_text = 'Login failed, check your details';
            $tbs = new clsTinyButStrong;
            $tbs->LoadTemplate('error.html');
            $tbs->Show();
            exit;
        }
    }
    else {
        $page_title = 'Login | ' . SITE_TITLE;
        $tbs = new clsTinyButStrong;
        $tbs->LoadTemplate('login.html');
        $tbs->Show(); 
    }
}
?>

<?php

function Authenticate($user, $pass)
{
    /***********************UDATE THIS FOR PRODUCTION *******************************/
    //require('../upload/priv/env_school.php');
    require('../upload/priv/dev.php');

    if ($user == $mgrUser && password_verify($pass, $mgrPassword)) {
            return 1;
        } else {
            return 0;
        }
}

function DoAuthCheck()
{
    if (!IsAuthenticated()) {
            $_SESSION['loginError'] = "You must login to continue";
            header("Location: login.php", true, 303);
            exit();
        }
}

function IsAuthenticated()
{
    return isset($_SESSION['validUser']);
}

function my_session_start($timeout = 6048000)
{
    ini_set('session.gc_maxlifetime', $timeout);
    session_start();

    if (isset($_SESSION['timeout_idle']) && $_SESSION['timeout_idle'] < time()) {
        session_destroy();
        session_start();
        session_regenerate_id();
        $_SESSION = array();
    }

    $_SESSION['timeout_idle'] = time() + $timeout;
}

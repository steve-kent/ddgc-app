<?php

function Authenticate($user, $pass)
{
    /***********************UDATE THIS FOR PRODUCTION *******************************/
    //require('../upload/priv/env_school.php');
    require('../priv/dev.php');

    if (strtolower($user) == strtolower($mgrUser) && password_verify($pass, $mgrPassword)) {
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
    session_set_cookie_params($timeout);
    session_start();

    if (isset($_SESSION['timeout_idle']) && $_SESSION['timeout_idle'] < time()) {
        session_destroy();
        session_start();
        session_regenerate_id();
        $_SESSION = array();
    }

    $_SESSION['timeout_idle'] = time() + $timeout;
}

function ShowHeaderButton()
{
    if (!isset($_SESSION)) 
    {
        my_session_start();
    }
    if (IsAuthenticated())
    {
        echo "<a href='edit_player.php'>Manage</a>";
    }
    else
    {
        echo "<a href='login.php'>Admin Login</a>";
    }
}

function ShowEditCardFooter($editLink)
{
    if (!isset($_SESSION)) 
    {
        my_session_start();
    }
    if (IsAuthenticated())
    {
        ?>
    <hr>
    <div class="card-footer">
        <div class="button button-secondary"><a href="<?=$editLink?>">Edit/Delete</a></div>
    </div>
    <?php
    }
}
?>
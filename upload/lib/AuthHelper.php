<?php


class AuthHelper
{


    public function Authinticate($user, $pass)
    {
        /***********************UDATE THIS FOR PRODUCTION *******************************/
        //require('../upload/priv/env_school.php');
        require('../upload/priv/dev.php');

        if($user == $mgrUser && password_verify($pass, $mgrPassword))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function IsAuthenticated()
    {
        return isset($_SESSION['validUser']);
    }
}
?>
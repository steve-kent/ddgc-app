<?php
class Player
{
    private $playerId = null;
    private $memberNumber = null;
    private $firstName = null;
    private $lastName = null;
    private $nickName = null;
    private $email = null;
    private $expires = null;
    private $oweShirt = 0;
    private $pdga = null;


    public function __set($name, $val)
    {
        $this->$name = $val;
    }

    public function __get($property)
    {
        return $this->$property;
    }
}
?>
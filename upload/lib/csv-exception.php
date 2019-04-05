<?php
    class CsvExceptoin extends Exception
    {
        function __toString()
        {
            return "CsvOpenException: ".$this->getCode().": ".$this->getMessage()."<br/> in file "
            .$this->getFile()." on line ".$this->getLine()."<br/>";            
        }
    }
?>
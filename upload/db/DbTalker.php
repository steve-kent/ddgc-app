<?php



class DbTalker
{
    // Make DB connection with credentials in include file.
    private function Connect()
    {
        /***********************UDATE THIS FOR PRODUCTION *******************************/
        require('../priv/dev.php');
        $conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);
        if (mysqli_connect_errno())
        {
            echo $conn->error;
        }
        return $conn;
    }

    // Returns an array of all Names and NickNames
    public function GetNamesAndNicks()
    {
        $conn =  $this->Connect();
        $nameList = [];
        $query = "SELECT FirstName, LastName, NickName
                    FROM players";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($firstName, $lastName, $nickName);

        while($stmt->fetch())
        {
            array_push($nameList, trim($firstName . " ". $lastName));
            if (!is_null($nickName) || !$nickName == "")
            {
                array_push($nameList, trim($nickName));
            }
        }

        $stmt->free_result();
        $conn->close();

        return $nameList;
    }
    
}

?>
<?php



class DbTalker
{
    // Make DB connection with credentials in include file.
    private function Connect()
    {
        /***********************UDATE THIS FOR PRODUCTION *******************************/
        require('../upload/priv/dev.php');
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

    //Returns course by course name
    public function GetCourseByName($courseName)
    {
        $course = [];
        $conn =  $this->Connect();
        $query = "SELECT * 
                    FROM courses
                    WHERE CourseName = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('s', $courseName);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($coursePar);
                $stmt->fetch();
                $course = $coursePar;
            }
        }       
        $stmt->free_result();
        $conn->close();
        return $course;
    }

    //Returns par for the course by course name
    public function GetCourseIdByCourseName($courseName)
    {
        $id = 0;
        $conn =  $this->Connect();
        $query = "SELECT CoursePar 
                    FROM courses
                    WHERE CourseName = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('s', $courseName);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($CourseId);
                $stmt->fetch();
                $id = $CourseId;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $id;
    }



    //Returns playerId by player first and last name
    public function GetPlayerIdByFullName($firstName, $lastName)
    {
        $id = 0;
        $conn =  $this->Connect();
        $query = "SELECT PlayerId 
                    FROM players
                    WHERE FirstName = ? 
                    AND LastName = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('ss', $firstName, $lastName);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($playerID);
                $id = $playerID;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $id;     
    }

    //Returns playerId by player nickname
    public function GetPlayerByNickname($nickName)
    {
        $player = 0;
        $conn =  $this->Connect();
        $query = "SELECT PlayerId 
                    FROM players
                    WHERE NickName = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('s', $nickName);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($playerID);
                $stmt->fetch();
                $player = $playerID;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $player;      
    }

    // Returns the last 5 scores for the player and course passed in
    public function GetLast5Scores($playerId, $CourseId)
    {
        $scores = [];
        $conn =  $this->Connect();
        $query = "SELECT RawScore 
                    FROM scores AS s, rounds AS r
                    WHERE s.PlayerId = ?
                    AND s.CourseId = ?
                    AND s.RoundID = r.RoundId
                    ORDER BY rounds.RoundDate
                    LIMIT 5";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('ii', $playerId, $CourseId);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($score);
                while($stmt->fetch())
                {
                    array_push($scores, $score);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $scores;   
    }

    // Create a new round and return it's ID
    public function CreateRound($courseId, $RoundDate)
    {
        $roundId = 0;
        $conn =  $this->Connect();
        $query = "INSERT INTO rounds (CourseID, RoundDate, RoundDateEntered)
                  VALUES (?,?,?)";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('sss', $courseId, $RoundDate, CURRENT_TIMESTAMP);
            if($stmt->execute())
            {
                $roundId = $stmt->affected_rows > 0 ? $conn->insert_id : 0;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $roundId;
    }


}
?>
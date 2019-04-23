<?php



class DbTalker
{
    // Make DB connection with credentials in include file.
    private function Connect()
    {
        /***********************UDATE THIS FOR PRODUCTION *******************************/
        //require('../upload/priv/env_school.php');
        if (!defined('ROOT_PATH'))
        define('ROOT_PATH', dirname(__DIR__) . '/');
        require(ROOT_PATH . '../upload/priv/dev.php');
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

    //Returns all Rows from the players table
    public function GetAllPlayers()
    {
        $players = [];
        $conn =  $this->Connect();
        $query = "SELECT *
                    FROM players";
        if ($stmt = $conn->prepare($query))
        {
            if ($stmt->execute())
            {
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc())
                {
                    array_push($players, $row);
                }
            }
        }       
        $stmt->free_result();
        $conn->close();
        return $players;
    }

    //Returns handicap round info to be displayed
    public function GetHandicapRound($roundId)
    {
        $roundInfo = [];
        $conn =  $this->Connect();
        $query = "SELECT p.FirstName, p.LastName, s.RawScore, s.Handicap, s.NetScore
                    FROM scores as s, players as p
                    WHERE s.roundId = ?
                    AND s.PlayerID = p.PlayerID
                    Order By -s.NetScore DESC";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('s', $roundId);
            if ($stmt->execute())
            {
                $stmt->store_result();
                $stmt->bind_result($first, $last, $raw, $handi, $net);
                while ($stmt->fetch())
                {
                    $score = [$first ." ". $last, $raw, $handi, $net];
                    array_push($roundInfo, $score);
                }
            }
        }       
        $stmt->free_result();
        $conn->close();
        return $roundInfo;
    }

    //Returns array of course names
    public function GetCourseNames()
    {
        $conn =  $this->Connect();
        $courseList = [];
        $query = "SELECT CourseName
                    FROM courses";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($courseName);

        while($stmt->fetch())
        {
            array_push($courseList, $courseName);
        }

        $stmt->free_result();
        $conn->close();

        return $courseList;
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
            if ($stmt->execute())
            {
                $result = $stmt->get_result();
                $course = $result->fetch_assoc();
            }
        }       
        $stmt->free_result();
        $conn->close();
        return $course;
    }

    //Returns player by player first and last name
    public function GetPlayerByFullName($firstName, $lastName)
    {
        $player = [];
        $conn =  $this->Connect();
        $query = "SELECT * 
                    FROM players
                    WHERE FirstName = ? 
                    AND LastName = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('ss', $firstName, $lastName);
            if ($stmt->execute())
            {
                $result = $stmt->get_result();
                $player = $result->fetch_assoc();                
            }
        }
        $stmt->free_result();
        $conn->close();
        return $player;     
    }

    //Returns player by PlayerID
    public function GetPlayerById($playerId)
    {
        $player = [];
        $conn =  $this->Connect();
        $query = "SELECT * 
                    FROM players
                    WHERE PlayerID = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('i', $playerId);
            if ($stmt->execute())
            {
                $result = $stmt->get_result();
                $player = $result->fetch_assoc();       
            }
        }
        $stmt->free_result();
        $conn->close();
        return $player;      
    }

    //Returns player by player nickname
    public function GetPlayerByNickname($nickName)
    {
        $player = [];
        $conn =  $this->Connect();
        $query = "SELECT * 
                    FROM players
                    WHERE NickName = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('s', $nickName);
            if ($stmt->execute())
            {
                $result = $stmt->get_result();
                $player = $result->fetch_assoc();                
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
        $query = "SELECT s.RawScore 
                FROM scores AS s, rounds AS r
                WHERE s.PlayerID = ?
                AND r.CourseID = ?
                AND s.RoundID = r.RoundId
                ORDER BY r.RoundDate, s.RoundID DESC
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
            $stmt->free_result();
        }
        $conn->close();
        return $scores;   
    }

    // Create a new round and return it's ID
    public function AddRound($courseId, $roundDate)
    {
        $roundId = 0;
        $curTime = date("Y-m-d");
        $conn =  $this->Connect();
        $query = "INSERT INTO rounds (CourseID, RoundDate, RoundDateEntered)
                  VALUES (?,?,?)";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('sss', $courseId, $roundDate, $curTime);
            if($stmt->execute())
            {
                $roundId = $stmt->affected_rows > 0 ? $conn->insert_id : 0;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $roundId;
    }

        // Create new scorecard link to round in DB
        public function AddScorecare($roundId, $fileName)
        {
            $scorecardId = 0;
            $conn =  $this->Connect();
            $query = "INSERT INTO scorecards (RoundID, ImgName)
                      VALUES (?,?)";
            if ($stmt = $conn->prepare($query))
            {
                $stmt->bind_param('is', $roundId, $fileName);
                if($stmt->execute())
                {
                    $scorecardId = $stmt->affected_rows > 0 ? $conn->insert_id : 0;
                }
            }
            $stmt->free_result();
            $conn->close();
            return $scorecardId;
        }

            // Returns the last 5 scores for the player and course passed in
    public function GetsSorecards($roundId)
    {
        $scorecards = [];
        $conn =  $this->Connect();
        $query = "SELECT ImgName 
                FROM scorecards
                WHERE RoundID = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('i', $roundId);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($scorecardImg);
                while($stmt->fetch())
                {
                    array_push($scorecards, $scorecardImg);
                }
            }
            $stmt->free_result();
        }
        $conn->close();
        return $scorecards;   
    }

    // Add a new entry in the score table
    public function AddScore($roundId, $playerId, $rawScore, $handicap, $netScore)
    {
        $scoreId = 0;
        $conn =  $this->Connect();
        $query = "INSERT INTO scores (RoundID, PlayerID, RawScore, Handicap, NetScore)
                  VALUES (?,?,?,?,?)";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('iiiii', $roundId, $playerId, $rawScore, $handicap, $netScore);
            if($stmt->execute())
            {
                $roundId = $stmt->affected_rows > 0 ? $conn->insert_id : 0;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $roundId;
    }
    
    // returns array with round date and course name
    public function GetRoundCourseAndDate($roundId)
    {
        $courseAndDate = [];
        $conn =  $this->Connect();
        $query = "SELECT r.RoundDate, c.CourseName 
                FROM rounds AS r, courses AS c
                WHERE r.RoundID = ?
                AND r.CourseID = c.CourseID";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('i', $roundId);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($roundDate, $courseName);
                while($stmt->fetch())
                {
                    $courseAndDate = [$roundDate, $courseName];
                }
            }
            $stmt->free_result();
        }
        $conn->close();
        return $courseAndDate; 
    }

    //Get 50 most recent rounds
    public function Get50Rounds($offset)
    {
        $rounds = [];
        $conn =  $this->Connect();
        $query = "SELECT r.RoundID, r.RoundDate, c.CourseName 
                FROM rounds AS r, courses AS c
                WHERE r.CourseID = c.CourseID
                ORDER BY r.RoundDate DESC, r.RoundID DESC
                LIMIT ?, 50";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('i', $offset);
            if ($result = $stmt->execute())
            {
                $stmt->bind_result($roundId, $roundDate, $courseName);
                while($stmt->fetch())
                {
                    $round = [$roundId, $roundDate, $courseName];
                    array_push($rounds, $round);
                }
            }
            $stmt->free_result();
        }
        $conn->close();
        return $rounds; 
    }

    // Add a new player to the players table
    public function AddPlayer($player)
    {
        $playerId = 0;
        $conn =  $this->Connect();
        $query = "INSERT INTO players (MemberNumber, FirstName, LastName, NickName, Email, Expires, OweShirt, PDGA)
                  VALUES (?,?,?,?,?,?,?,?)";
        if ($stmt = $conn->prepare($query))
        {
            echo "STMTTTTTTTTTTTT    ";
                var_dump($player);
            $stmt->bind_param('isssssii', $player->memberNumber, $player->firstName, $player->lastName, $player->nickName, 
                                        $player->email, $player->expires, $player->oweShirt, $player->pdga);
            if($stmt->execute())
            {
                
                $playerId = $stmt->affected_rows > 0 ? $conn->insert_id : 0;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $playerId;
    }

    // Update a player to the players table
    public function UpdatePlayer($player)
    {
        $playerId = 0;
        $conn =  $this->Connect();
        $query = "UPDATE players 
                  SET MemberNumber = ?, FirstName = ?, LastName = ?, NickName = ?, Email = ?, Expires = ?, OweShirt = ?, PDGA = ?
                  WHERE PlayerID = ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('isssssiii', $player->memberNumber, $player->firstName, $player->lastName, $player->nickName, 
                                        $player->email, $player->expires, $player->oweShirt, $player->pdga, $player->playerId);
            if($stmt->execute())
            {
                $playerId = $player->playerId;
            }

        }
        $stmt->free_result();
        $conn->close();
        return $playerId;
    }

    // Returns the next available member number to be assigned to a new member
    public function GetNextMemberNumber()
    {
        $nextMemNum = 0;
        $conn =  $this->Connect();
        $query = "SELECT MAX(MemberNumber) 
                    FROM players";
        if ($stmt = $conn->prepare($query))
        {
            if ($stmt->execute())
            {
                $stmt->bind_result($maxNum);
                $stmt->fetch();  
                $nextMemNum = $maxNum ? $maxNum + 1 : 0;              
            }
        }
        $stmt->free_result();
        $conn->close();
        return $nextMemNum;      
    }

    // Get all players that have a memberNumber
    public function GetAllMembers()
    {
        $zero = 0;
        $players = [];
        $conn =  $this->Connect();
        $query = "SELECT *
                    FROM players
                    WHERE MemberNumber > ?";
        if ($stmt = $conn->prepare($query))
        {
            $stmt->bind_param('i',$zero);
            if ($stmt->execute())
            {
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc())
                {
                    array_push($players, $row);
                }
            }
        }       
        $stmt->free_result();
        $conn->close();
        return $players;
    }


}
?>
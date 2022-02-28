<?php



class DbTalker
{
    // Make DB connection with credentials in include file.
    private function Connect()
    {
        /***********************UPDATE THIS FOR PRODUCTION *******************************/
        //require('../upload/priv/env_school.php');
        if (!defined('ROOT_PATH'))
            define('ROOT_PATH', dirname(__DIR__) . '/');
        require(ROOT_PATH . 'priv/dev.php');
        $conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);
        if (mysqli_connect_errno()) {
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

        while ($stmt->fetch()) {
            array_push($nameList, trim($firstName . " " . $lastName));
            if (!is_null($nickName) || !$nickName == "") {
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
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $roundId);   /// TODO: Should be i instead of s??
            if ($stmt->execute()) {
                $stmt->store_result();
                $stmt->bind_result($first, $last, $raw, $handi, $net);
                while ($stmt->fetch()) {
                    $score = [$first . " " . $last, $raw, $handi, $net];
                    array_push($roundInfo, $score);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $roundInfo;
    }

    //Returns handicap round info with score id for administration
    public function GetHandicapRoundWithScoreId($roundId)
    {
        $roundInfo = [];
        $conn =  $this->Connect();
        $query = "SELECT s.scoreId, p.FirstName, p.LastName, s.RawScore, s.Handicap, s.NetScore
                    FROM scores as s, players as p
                    WHERE s.roundId = ?
                    AND s.PlayerID = p.PlayerID
                    Order By -s.NetScore DESC";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $roundId);   /// TODO: Should be i instead of s??
            if ($stmt->execute()) {
                $stmt->store_result();
                $stmt->bind_result($scoreId, $first, $last, $raw, $handi, $net);
                while ($stmt->fetch()) {
                    $score = [$scoreId, $first . " " . $last, $raw, $handi, $net];
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

        while ($stmt->fetch()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $courseName);
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('ss', $firstName, $lastName);
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $playerId);
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $nickName);
            if ($stmt->execute()) {
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
                ORDER BY r.RoundDate DESC, s.RoundID DESC
                LIMIT 5";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('ii', $playerId, $CourseId);
            if ($result = $stmt->execute()) {
                $stmt->bind_result($score);
                while ($stmt->fetch()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('sss', $courseId, $roundDate, $curTime);
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('is', $roundId, $fileName);
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $roundId);
            if ($result = $stmt->execute()) {
                $stmt->bind_result($scorecardImg);
                while ($stmt->fetch()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('iiiii', $roundId, $playerId, $rawScore, $handicap, $netScore);
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $roundId);
            if ($result = $stmt->execute()) {
                $stmt->bind_result($roundDate, $courseName);
                while ($stmt->fetch()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $offset);
            if ($result = $stmt->execute()) {
                $stmt->bind_result($roundId, $roundDate, $courseName);
                while ($stmt->fetch()) {
                    $date = date_create($roundDate);
                    $dateString = date_format($date, "F jS Y");

                    $round = [$roundId, $dateString, $courseName];
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param(
                'isssssii',
                $player->memberNumber,
                $player->firstName,
                $player->lastName,
                $player->nickName,
                $player->email,
                $player->expires,
                $player->oweShirt,
                $player->pdga
            );
            if ($stmt->execute()) {

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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param(
                'isssssiii',
                $player->memberNumber,
                $player->firstName,
                $player->lastName,
                $player->nickName,
                $player->email,
                $player->expires,
                $player->oweShirt,
                $player->pdga,
                $player->playerId
            );
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
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
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $zero);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($players, $row);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $players;
    }

    // returns array with round date and course name
    public function GetHandicapsDataByCourseId($courseID)
    {
        $handicapsData = [];
        $conn =  $this->Connect();
        $query = "select p.firstName, p.lastName, p.nickName, SUBSTRING_INDEX(GROUP_CONCAT(s.rawscore ORDER BY r.roundId DESC),',',5) lastScores
        from scores as s, players as p, rounds as r
        where r.courseId = ?
        AND p.playerId = s.playerId
        AND r.roundId = s.roundId
        group by s.playerid";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $courseID);
            if ($result = $stmt->execute()) {
                $stmt->bind_result($firstName, $lastName, $nickName, $scores);
                while ($stmt->fetch()) {
                    $playerData = [$firstName, $lastName, $nickName, $scores];
                    array_push($handicapsData, $playerData);
                }
            }
            $stmt->free_result();
        }
        $conn->close();
        return $handicapsData;
    }

    // Get round info for single player's round
    public function GetHandicapScoreInfo($scoreId)
    {
        $scoreInfo = [];
        $conn =  $this->Connect();
        $query = "SELECT p.FirstName, p.LastName, s.RawScore, s.Handicap, s.NetScore
                FROM scores as s, players as p
                WHERE s.ScoreId = ?
                AND s.PlayerID = p.PlayerID";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $scoreId);
            if ($stmt->execute()) {
                $stmt->store_result();
                $stmt->bind_result($first, $last, $raw, $handi, $net);
                while ($stmt->fetch()) {
                    $scoreInfo = [$first . " " . $last, $raw, $handi, $net];
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $scoreInfo;
    }

    // Update the score to match the data passed in
    public function UpdateScore($scoreId, $rawScore, $handicap, $netScore)
    {
        $roundId = 0;
        $conn =  $this->Connect();
        $query = "UPDATE scores 
                  SET RawScore = ?, Handicap = ?, NetScore = ?
                  WHERE ScoreID = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('iiii', $rawScore, $handicap, $netScore, $scoreId);
            if ($stmt->execute()) {
                $roundId = $this->GetRoundIdByScoreId($scoreId);
            }
        }
        $stmt->free_result();
        $conn->close();
        return $roundId;
    }

    // Returns RoundId associated with ScoreId passed in
    public function GetRoundIdByScoreId($scoreId)
    {
        $roundId = 0;
        $conn =  $this->Connect();
        $query = "SELECT RoundId 
                    FROM scores
                    WHERE ScoreId = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $scoreId);
            if ($stmt->execute()) {
                $stmt->bind_result($theRound);
                $stmt->fetch();
                $roundId = $theRound;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $roundId;
    }

    // Returns 1 if the delete is successful
    public function DeleteScoreById($scoreId)
    {
        $result = 0;
        $conn =  $this->Connect();
        $query = "Delete 
                    FROM scores
                    WHERE ScoreId = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $scoreId);
            if ($stmt->execute()) {
                $result = 1;
            }
        }
        $stmt->close();
        $conn->close();
        return $result;
    }

    // Returns players Name and expiration of everyone owed a shirt
    public function GetOwedShirts()
    {
        $owedShirtInfo = [];
        $conn =  $this->Connect();
        $query = "SELECT PlayerId, MemberNumber, FirstName, LastName, Expires 
        FROM players 
        WHERE OweShirt = 1 
        ORDER BY Expires DESC";
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
                $stmt->store_result();
                $stmt->bind_result($playerId, $memberNumber, $first, $last, $expires);
                while ($stmt->fetch()) {
                    $memberInfo = [$playerId, $first . " " . $last, $memberNumber, $expires];
                    array_push($owedShirtInfo, $memberInfo);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $owedShirtInfo;
    }

    // Returns all active members and their emails addresses
    public function GetAllMembersAndEmails()
    {
        $returnData = [];
        $conn =  $this->Connect();
        $query = "SELECT PlayerId, FirstName, LastName, Email
        FROM players 
        WHERE MemberNumber > 0 
        AND Expires >= CURDATE()
        ORDER BY Email DESC, MemberNumber";
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
                $stmt->store_result();
                $stmt->bind_result($playerId, $first, $last, $email);
                while ($stmt->fetch()) {
                    $memberInfo = [$playerId, $first . " " . $last, $email];
                    array_push($returnData, $memberInfo);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $returnData;
    }

    // Get Members expiring this month.
    public function GetExpiringMembers($expiringMonth, $expiringYear)
    {
        $returnData = [];
        $conn =  $this->Connect();
        $query = "SELECT MemberNumber, FirstName, LastName, Expires,Email
        FROM players 
        WHERE MemberNumber > 0
        AND MONTH(Expires) = ?
        AND YEAR(Expires) = ?
        ORDER BY Email DESC, MemberNumber";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('ss', $expiringMonth, $expiringYear);
            if ($stmt->execute()) {
                $stmt->store_result();
                $stmt->bind_result($memberNumber, $first, $last, $email, $expires);
                while ($stmt->fetch()) {
                    $memberInfo = [$memberNumber, $first . " " . $last, $email, $expires];
                    array_push($returnData, $memberInfo);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $returnData;
    }

    // Gets event types
    public function GetEventTypes()
    {
        $eventTypes = [];
        $conn =  $this->Connect();
        $query = "SELECT *
                    FROM eventtypes";
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($eventTypes, $row);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $eventTypes;
    }

    // Gets all events ordered by event type ID
    public function GetAllEvents()
    {
        $events = [];
        $conn =  $this->Connect();
        $query = "SELECT a.EventName, a.EventInformation, a.LastUpdated, b.EventTypeName, a.EventDate, a.EventID, a.EventLink
            FROM events a
            JOIN eventtypes b ON a.EventTypeID = b.EventTypeID
            ORDER BY b.EventTypeID DESC, a.EventDate DESC";
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($events, $row);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $events;
    }

    public function AddEvent($eventName, $eventDate, $eventInfo, $eventLink)
    {
        $UPCOMING_EVENT_TYPE_ID = 1;

        $eventId = 0;
        $curTime = date("Y-m-d");
        $conn =  $this->Connect();
        $query = "INSERT INTO events (EventName, EventInformation, LastUpdated, EventTypeID, EventDate, EventLink)
                  VALUES (?,?,?,?,?,?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('ssssss', $eventName, $eventInfo, $curTime, $UPCOMING_EVENT_TYPE_ID, $eventDate, $eventLink);
            if ($stmt->execute()) {
                $eventId = $stmt->affected_rows > 0 ? $conn->insert_id : 0;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $eventId;
    }

    // Returns event by eventID
    public function GetEventById($eventId)
    {
        $event = [];
        $conn =  $this->Connect();
        $query = "SELECT * 
                        FROM events
                        WHERE EventID = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $eventId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $event = $result->fetch_assoc();
            }
        }
        $stmt->free_result();
        $conn->close();
        return $event;
    }

    // Returns 1 if the delete is successful
    public function DeleteEventById($eventId)
    {
        $result = 0;
        $conn =  $this->Connect();
        $query = "Delete 
                    FROM events
                    WHERE EventID = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $eventId);
            if ($stmt->execute()) {
                $result = 1;
            }
        }
        $stmt->close();
        $conn->close();
        return $result;
    }

    // Update an event
    public function UpdateEvent($eventId, $eventName, $eventDate, $eventInfo, $eventLink)
    {
        $result = 0;
        $curTime = date("Y-m-d");
        $conn =  $this->Connect();
        $query = "UPDATE events 
                      SET EventName = ?, EventDate = ?, EventInformation = ?, LastUpdated = ?, EventLink = ?
                      WHERE eventID = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('sssssi', $eventName, $eventDate, $eventInfo, $curTime, $eventLink, $eventId);
            if ($stmt->execute()) {
                $result = 1;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $result;
    }

    // Gets all announcements ordered by event type ID
    public function GetAllAnnouncements()
    {
        $events = [];
        $conn =  $this->Connect();
        $query = "SELECT *
            FROM announcements
            ORDER BY AnnouncementUpdated DESC, AnnouncementID DESC";
        if ($stmt = $conn->prepare($query)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($events, $row);
                }
            }
        }
        $stmt->free_result();
        $conn->close();
        return $events;
    }

    public function AddAnnouncement($announcementTitle, $announcementInformation, $announcementLink)
    {
        $eventId = 0;
        $curTime = date("Y-m-d");
        $conn =  $this->Connect();
        $query = "INSERT INTO announcements (AnnouncementTitle, AnnouncementInformation, AnnouncementLink, AnnouncementUpdated)
                  VALUES (?,?,?,?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('ssss', $announcementTitle, $announcementInformation, $announcementLink, $curTime);
            if ($stmt->execute()) {
                $eventId = $stmt->affected_rows > 0 ? $conn->insert_id : 0;
            }
        }
        $stmt->free_result();
        $conn->close();
        return $eventId;
    }

        // Returns Announcement by AnnouncementID
        public function GetAnnouncementById($announcementId)
        {
            $announcement = [];
            $conn =  $this->Connect();
            $query = "SELECT * 
                            FROM announcements
                            WHERE AnnouncementID = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param('i', $announcementId);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $announcement = $result->fetch_assoc();
                }
            }
            $stmt->free_result();
            $conn->close();
            return $announcement;
        }
    
        // Returns 1 if the delete is successful
        public function DeleteAnnouncementById($announcementId)
        {
            $result = 0;
            $conn =  $this->Connect();
            $query = "Delete 
                        FROM announcements
                        WHERE AnnouncementID = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param('i', $announcementId);
                if ($stmt->execute()) {
                    $result = 1;
                }
            }
            $stmt->close();
            $conn->close();
            return $result;
        }
    
        // Update an announcement
        public function UpdateAnnouncement($announcementId, $announcementTitle, $announcementInformation, $announcementLink)
        {
            $result = 0;
            $curTime = date("Y-m-d");
            $conn =  $this->Connect();
            $query = "UPDATE announcements 
                          SET AnnouncementTitle = ?, AnnouncementInformation = ?, AnnouncementLink = ?, AnnouncementUpdated = ?
                          WHERE AnnouncementId = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param('ssssi', $announcementTitle, $announcementInformation, $announcementLink, $curTime, $announcementId);
                if ($stmt->execute()) {
                    $result = 1;
                }
            }
            $stmt->free_result();
            $conn->close();
            return $result;
        }
}

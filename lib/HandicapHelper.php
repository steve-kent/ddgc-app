<?php
if (!defined('ROOT_PATH'))
define('ROOT_PATH', dirname(__DIR__) . '/');
require_once(ROOT_PATH . "db/DbTalker.php");
require_once(ROOT_PATH . "lib/validator.php");
require_once(ROOT_PATH . "lib/PlayerHelper.php");

Class HandicapHelper
{
        // Get the current handicap for the player on the course passed in
        public function GetHandicap($playerId, $courseId)
        {
            if ($playerId && $courseId)
            {
                return $this->CalculateHandicap($playerId, $courseId); 
            }
            else
            {
                return "Error retrieving handicap";
            }
        }

        // Submit scores for a new handicap round
        public function ScoreRound($courseName, $roundDate, $players, $scores, $files)
        {
            $dbTalker = new DbTalker();
            if(!V_Date($roundDate) || !V_Selection($courseName, $dbTalker->GetCourseNames()))
            {
                echo "Course $courseName -- Date $roundDate";
                echo "Invalid Course Name or Date Selection";
            }
            $course = $dbTalker->GetCourseByName($courseName);
            $roundId = $this->AddRound($course['CourseID'], $roundDate);
            if(!$roundId)
            {
                echo "FAILURE ADD NEW ROUND!";
                return 0;
            }
            for($i = 0; $i < count($players); $i++)
            {
                if (!empty(trim($players[$i])))
                {
                    $playerId = $this->GetPlayerId($players[$i]);
                    if(is_numeric($scores[$i]))
                    {
                        $scoreId = $this->AddScore($course, $playerId, $roundId, intval($scores[$i]));
                        if(!$scoreId)
                        {
                            echo "FAILED to score round for $players[$i] $scores[$i]";
                        }
                    }
                }
            }
            $this->AddImages($files, $roundId);
            return $roundId;
        }



        // Add a new round of handicaps
        private function AddRound($courseId, $roundDate)
        {
            $dbTalker = new DbTalker();
            return $dbTalker->AddRound($courseId, $roundDate);
        }

        // Add score for player and round to the database return ScoreID or 0 if fails
        private function AddScore($course, $playerId, $roundId, $rawScore)
        {
            if (!$playerId || !$course['CourseID'] || !$roundId)
            {
                return 0;
            }
            $handicap = $this->CalculateHandicap($playerId, $course);
            if(!is_numeric($handicap))
            {
                $handicap = NULL;
                $netScore = NULL;
            }
            else
            {
                $netScore = $rawScore + $handicap;
            }       
            $dbTalker = new DbTalker();
            return $dbTalker->AddScore($roundId, $playerId, $rawScore, $handicap, $netScore);

        }

        //Adds score for a player for the roundId passed in
        public function InsertScore($courseName, $roundId, $player, $score)
        {
            $dbTalker = new DbTalker();
            $course = $dbTalker->GetCourseByName($courseName);
            if (!empty(trim($player)))
            {
                $playerId = $this->GetPlayerId($player);
                if(is_numeric($score))
                {
                    $scoreId = $this->AddScore($course, $playerId, $roundId, intval($score));
                    if(!$scoreId)
                    {
                        echo "FAILED to add score round for $player $score";
                    }
                }
            }

            return $roundId;
        }

        // return the player handicap or "Establishing" if player hasn't played 5 rounds
        private function CalculateHandicap($playerId, $course)
        {
            $scores= [];
            $dbTalker = new DbTalker();
            $scores = $dbTalker->GetLast5Scores($playerId, $course['CourseID']);
            $coursePar = $course['CoursePar'];
            if (count($scores) >= 3 || ($course['CourseID'] == 3 && count($scores) >= 1))
            {
                //handicap formula
                return round(($coursePar - (array_sum($scores) / count($scores))) * 0.8);
            }
            else
            {
                return "Est";
            }
        }

        // Returns the playerId by name or nickname
        public function GetPlayerId($playerName)
        {
            $playerId = 0;
            $dbTalker = new DbTalker();
            $firstLast = explode(' ', $playerName, 2);
            if($firstLast[0] && $firstLast[1])
            {
                $playerId = $dbTalker->GetPlayerByFullName($firstLast[0], $firstLast[1])['PlayerID'] ?: 0;
            }

            if(!$playerId)
            {
                $playerId = $dbTalker->GetPlayerByNickname($playerName)['PlayerID'] ?: 0;
            }
            return $playerId;
        }

        // Get handicap round data to display
        public function GetHandicapRound($roundId)
        {
            if($roundId > 0 && is_numeric($roundId))
            {
                $dbTalker = new DbTalker();
                $roundData = $dbTalker->GetHandicapRound($roundId);
                $roundData = $this->UpdateEstablishing($roundData);
                return $roundData;
            }
        }

        // Get handicap round data to display with scoreId to link
        public function GetLinkedHandicapRound($roundId)
        {
            if($roundId > 0 && is_numeric($roundId))
            {
                $dbTalker = new DbTalker();
                $roundData = $dbTalker->GetHandicapRoundWithScoreId($roundId);
                $roundData = $this->UpdateEstablishing($roundData);
                return $roundData;
            }
        }

        // returns array with round date and course name
        public function GetRoundCourseAndDate($roundId)
        {
            if($roundId > 0 && is_numeric($roundId))
            {
                $dbTalker = new DbTalker();
                return $dbTalker->GetRoundCourseAndDate($roundId);
            }
        }

        // Updates null handicap and net score in handicap data to say "Establishing"
        private function UpdateEstablishing($handicapArray)
        {
            // Use this so that it works for linked or unlinked
            $lastIndex = count($handicapArray[0]) - 1;
            
            foreach($handicapArray as &$score) // make score s reference variable
            {
                if(is_null($score[$lastIndex]))
                {
                    $score[$lastIndex - 1] = "Est";
                    $score[$lastIndex] = "Est";
                } 
            }
            return $handicapArray;
        }

        //Get 50 rounds
    public function Get50Rounds($offset)
    {
        if(!is_numeric($offset) || $offset < 0)
        {
            $offset = 0;
        }
        $dbTalker = new DbTalker();
        return $dbTalker->Get50Rounds($offset);

    }

    //Add Images to the round
    private function AddImages($files, $roundId)
    {
        if($roundId && count($files) > 0 )
        {
            for($i = 0; $i < count($files['name']); $i++)
            {
                $this->AddImageFile($files, $roundId, $i);
            }
        }
    }

    //Add uploaded files to DB
    private function AddImageFile($files, $roundId, $i)
    {
        $target_dir = "../public_html/scorecards/";
        $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
        $fileName = time() . $i . "." . $ext;
        $target_file = $target_dir . $fileName;
        if($files["size"][$i] > 5000000)
        {
            echo "File is too large";
            return 0;
        }

        if(is_uploaded_file($files['tmp_name'][$i]))
        {
            if(move_uploaded_file($files['tmp_name'][$i], $target_file))
            {
                $dbTalker = new DbTalker();
                $dbTalker->AddScorecare($roundId, "/scorecards/" . $fileName);
            }
        }

        
    }

    //Returns array of scorecards links
    public function GetScorecards($roundId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetsSorecards($roundId);
    }

    //Returns 2 deminisional array with handicap info
    public function GetHandicapTableInfo($courseId)
    {
        $tableData = [];
        $dbTalker = new DbTalker();

        $course = $dbTalker->GetCourseById($courseId);
        $coursePar = $course['CoursePar'];

        $rawData = $dbTalker->GetHandicapsDataByCourseId($courseId);
        foreach($rawData as $player)
        {
            $row = [];
            $name = !empty(trim($player[0]." ".$player[1])) ? $player[0]." ".$player[1] : $player[2];
            array_push($row, $name); 
            $scores = explode (",", $player[3]); 
            for($i = 0; $i < 5; $i++)
                {
                    array_push($row, array_key_exists($i, $scores) ? $scores[$i] : "");
                }
                $total = array_sum($scores) / count($scores);
                array_push($row, round($total, 2));
                array_push($row, round($coursePar - $total, 2));
                array_push($row, round(($coursePar - $total) * 0.8, 2));
                array_push($row, round(($coursePar - $total) * 0.8) + 0);  // Added + 0 to prevent some handis showing as "-0"

                array_push($tableData, $row);
            } 
        
        return $tableData;
    }


    public function GetHandicapScoreInfo($scoreId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetHandicapScoreInfo($scoreId);
    }

    // Updates round score of a player. returns the roundId that the score was associated with
    public function UpdateScore($scoreId, $rawScore, $handicap, $netScore)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->UpdateScore($scoreId, $rawScore, $handicap, $netScore);
    }
    
    // Returns RoundId associated with ScoreId passed in
    public function GetRoundIdByScoreId($scoreId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetRoundIdByScoreId($scoreId);
    }

    // Returns roundId of the round the score was in if delete is successful
    public function DeteleScoreById($scoreId)
    {
        $roundId = $this->GetRoundIdByScoreId($scoreId);
        $dbTalker = new DbTalker();
        if($dbTalker->DeleteScoreById($scoreId))
        { 
            return $roundId;
        }
        else
        {
            return 0;
        }
    }

}
?>
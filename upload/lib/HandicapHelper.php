<?php
require_once("../upload/db/DbTalker.php");
require_once("../upload/lib/validator.php");

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
        public function ScoreRound($courseName, $roundDate, $players, $scores)
        {
            $dbTalker = new DbTalker();
            if(!Validator::V_Date($roundDate) || !Validator::V_Selection($courseName, $dbTalker->GetCourseNames()))
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
                $playerId = $this->GetPlayerId($players[$i]);
                $scoreId = $this->AddScore($course, $playerId, $roundId, intval($scores[$i]));
                if(!$scoreId)
                {
                    echo "FAILED to score round for $players[$i] $scores[$i]";
                }
            }
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

        // return the player handicap or "Establishing" if player hasn't played 5 rounds
        private function CalculateHandicap($playerId, $course)
        {
            $scores= [];
            $dbTalker = new DbTalker();
            $scores = $dbTalker->GetLast5Scores($playerId, $course['CourseID']);
            $coursePar = $course['CoursePar'];
            if (count($scores) == 5)
            {
                //handicap formula
                return round(($coursePar - (array_sum($scores) / 5)) * 0.8);
            }
            else
            {
                return "Establishing";
            }
        }

        // Returns the playerId by name or nickname
        private function GetPlayerId($playerName)
        {
            $dbTalker = new DbTalker();
            $firstLast = explode(' ', $playerName, 2);
            if($firstLast[0] && $firstLast[1])
            {
                if($playerId = $dbTalker->GetPlayerByFullName($firstLast[0], $firstLast[1])['PlayerID'])
                {
                    return $playerId;
                }
            }
            else
            {
                return $dbTalker->GetPlayerByNickname($playerName)['PlayerID'] ?: 0;
            }
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
            foreach($handicapArray as &$score) // make score s reference variable
            {
                if(is_null($score[2]))
                {
                    $score[2] = "Est";
                    $score[3] = "Est";
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
}

?>
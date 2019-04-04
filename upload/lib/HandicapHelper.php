<?php
require("../upload/db/DbTalker.php");

Class HandicapHelper
{
        // Get the current handicap for the player on the course passed in
        public function GetHandicap($courseName, $playerName)
        {
            $dbTalker = new DbTalker();
            $coursePar = $dbTalker->GetParByCourseName($courseName);
            $playerId = $this->GetPlayerId($playerName);
            $courseId = $dbTalker->GetCourseIdByCourseName($courseName);
            return $this->calculateHandicap($playerId, $courseId);           
    
        }

        // return the player handicap or zero if player hasn't played 5 rounds
        private function calculateHandicap($playerId, $courseId)
        {
            $scores= [];
            $dbTalker = new DbTalker();
            $scores = $dbTalker->GetLast5Scores($playerId, $courseId);
            return count($scores) < 5 ? 0 : array_sum($scores) / 5;
        }

        // Returns the playerId by name or nickname
        private function GetPlayerId($playerName)
        {
            $dbTalker = new DbTalker();
            $firstLast = explode(' ', $playerName, 2);
            if($firstLast[0] && $firstLast[1])
            {
                if($playerId = $dbTalker->GetPlayerByFullName($firstLast[0], $firstLast[1]))
                {
                    return $playerId;
                }
            }
            else
            {
                return $dbTalker->GetPlayerByNickname($playerName);
            }

        }
}

?>
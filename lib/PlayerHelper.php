<?php
if (!defined('ROOT_PATH'))
    define('ROOT_PATH', dirname(__DIR__) . '/');
require_once(ROOT_PATH . "db/DbTalker.php");
require_once(ROOT_PATH . "lib/validator.php");
class PlayerHelper
{
    // Vaildiate the data and add the new player to the DB
    public function AddPlayer($player)
    {
        if ($player->expires && !V_Date($player->expires)) {
            return 0;
        }

        if ($this->IsMember($player->expires)) {
            $player->memberNumber = $this->GetNextMemberNumber();
        }

        $dbTalker = new DbTalker();
        return $dbTalker->AddPlayer($player);
    }

    //Validate the data and update the player
    public function UpdatePlayer($player)
    {
        if ($this->IsMember($player->expires) && !$player->memberNumber) {
            $player->memberNumber = $this->GetNextMemberNumber();
        }

        $dbTalker = new DbTalker();
        return $dbTalker->updatePlayer($player);
    }

    // returns the next available member number for a new club member
    public function GetNextMemberNumber()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetNextMemberNumber() ?: 0;
    }

    // returns true if the $expireDate is later than today
    public function IsMember($expireDate)
    {
        return new DateTime($expireDate) > new DateTime();
    }

    // Returns any array of members: Every member's member number, full name or nickname, and the date their membership exires or "Expired if their membership is expired.
    public function GetMembersTableData()
    {
        $tableData = [];
        $members = $this->GetAllMembers() ?: [];
        foreach ($members as $member) {
            $thisMem = [$member['MemberNumber'], $this->NameOrNick($member), $this->IsMember($member['Expires']) ? $member['Expires'] : "Expired"];
            array_push($tableData, $thisMem);
        }
        return $tableData;
    }

    // Returns array of all members and all information stored about them in the Players table
    public function GetAllMembers()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetAllMembers();
    }

    // Returns array of all players and all information stored about them in the Players table
    public function GetAllPlayers()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetAllPlayers();
    }

    // Returns an array with the playerId and Player's full name or nickname
    public function GetPlayerListAndId()
    {
        $tableData = [];
        $members = $this->GetAllPlayers() ?: [];
        foreach ($members as $member) {
            $thisMem = [$member['PlayerID'], $this->NameOrNick($member)];
            array_push($tableData, $thisMem);
        }
        return $tableData;
    }


    // Returns player's full name or nickname if they don't have a registered name
    private function NameOrNick($member)
    {
        if (trim($member['FirstName'] . $member['LastName']) == "") {
            return $member['NickName'];
        }

        return $member['FirstName'] . " " . $member['LastName'];
    }

    // Returns a player by the playerid passed
    public function GetPlayerById($playerId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetPlayerById($playerId) ?: 0;
    }

    //Returns a list of people who are owed shirts
    public function GetOwedShirts()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetOwedShirts();
    }

    // Returns all active members and their email address
    public function GetEmailAddresses()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetAllMembersAndEmails();
    }

    public function GetMembersWithoutEMails()
    {
        $playerList = '';
        $dbTalker = new DbTalker();
        $playerData = $dbTalker->GetAllMembersAndEmails();
        foreach ($playerData as $player) {
            if (empty($player[2])) {
                $playerList .= $player[1] . ', ';
            }
        }

        return $playerList;
    }

    public function GetMembersEmails()
    {
        $playerList = '';
        $dbTalker = new DbTalker();
        $playerData = $dbTalker->GetAllMembersAndEmails();
        foreach ($playerData as $player) {
            if (!empty($player[2])) {
                $playerList .= $player[2] . ', ';
            }
        }
        return $playerList;
    }

    public function GetExpiringMembers($expireDate)
    {
        $date = strtotime($expireDate);
        $month = date("m", $date);
        $year = date("Y", $date);
        $dbTalker = new DbTalker();
        return $dbTalker->GetExpiringMembers($month, $year);
    }
}

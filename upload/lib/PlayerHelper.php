<?php 
require_once("../upload/db/DbTalker.php");
require_once("../upload/lib/validator.php");
class PlayerHelper
{
    public function AddPlayer($player)
    {
        if(!Validator::V_Date($player->expires))
        {
            return 0;
        }   
        
        if($this->IsMember($player->expires))
        {
            $player->memberNumber = $this->GetNextMemberNumber();
        }

        $dbTalker = new DbTalker();
        return $dbTalker->AddPlayer($player);
    }

    private function GetNextMemberNumber()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetNextMemberNumber() ?: 0;
    }

    private function IsMember($expireDate)
    {
        return new DateTime($expireDate) > new DateTime();
    }

    public function GetMembersTableData()
    {
        $tableData = [];
        $members = $this->GetAllMembers() ?: [];
        foreach($members as $member)
        {
            $thisMem = [$member['MemberNumber'], $this->NameOrNick($member), $this->IsMember($member['Expires']) ? $member['Expires'] : "Expired"];
            array_push($tableData, $thisMem);
        }
        return $tableData;
    }

    public function GetAllMembers()
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetAllMembers();
    }

    private function NameOrNick($member)
    {
        if(trim($member['FirstName'].$member['LastName']) == "")
        {
            return $member['NickName'];
        }
        
        return $member['FirstName']. " ".$member['LastName'];
    }

    public function GetPlayerById($playerId)
    {
        $dbTalker = new DbTalker();
        return $dbTalker->GetPlayerById($playerId) ?: 0;
    }

}
?>
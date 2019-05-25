<?php
require_once('TableMaker.php');

class LinkedTableMaker extends TableMaker
{
    protected $rowLink = "";
    protected $classes = "tablemaker LinkedTableMaker";

    // Create the start of the HTML table
    protected function StartTable()
    {
        $this->tagId = $this->tagId == "" ? "" : "id='" . $this->tagId . "'";
        $this->returnContent = "<table $this->tagId class='$this->classes'>";
        $this->returnContent .= "<caption>$this->caption</caption>";
    }

    
    // Write the row of the table that is passed in
    protected function WriteRow($row)
    {
        $columnCount = count($this->headers)+1;
        // Use 0th index of $row array as link ID
        $this->returnContent .= "<tr class='pointer' onclick=\"location.href='$this->rowLink$row[0]'\">";
        for($i = 1; $i < $columnCount; $i++)
        {
            $colData = FormatOutput($row[$i]);
            $this->returnContent .= "<td>$row[$i]</td>";
        }
        $this->returnContent .= "</tr>";
    }
}
?>
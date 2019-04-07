<?php
require('TableMaker.php');

class LinkedTableMaker extends TableMaker
{
    protected $rowLink = "";

    // Create the start of the HTML table
    protected function StartTable()
    {
        $this->returnContent = "<table class='tablemaker LinkedTableMaker'>";
        $this->returnContent .= "<caption>$this->caption</caption>";
    }

    
    // Write the row of the table that is passed in
    protected function WriteRow($row)
    {
        //'$this->rowLink$row[0]'
        $columnCount = count($this->headers)+1;
        $this->returnContent .= "<tr class='pointer' onclick=\"location.href='$this->rowLink$row[0]'\">";
        for($i = 1; $i < $columnCount; $i++)
        {
            $colData = Validator::FormatOutput($row[$i]);
            $this->returnContent .= "<td>$row[$i]</td>";
        }
        $this->returnContent .= "</a></tr>";
    }
}
?>
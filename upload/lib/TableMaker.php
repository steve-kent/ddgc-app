<?php
require('validator.php');

class TableMaker
{
    private $headers;
    private $data;
    private $caption;
    public $returnContent = "";

    // Setter for private variables
    public function __set($name, $val)
    {
        $this->$name = $val;
    }

    // Create the start of the HTML table
    private function StartTable()
    {
        $this->returnContent = "<table class='tablemaker csv_tablermaker'>";
        $this->returnContent .= "<caption>$this->caption</caption>";
    }

    // close the html table
    private function CloseTable()
    {
        $this->returnContent .= "</table>";
    }

    // Create the html table
    private function CreateTable()
    {
        $this->WriteTableHeader();
        for($row = 0; $row < count($data); $row++)
        {
            $this->WriteRow(explode(",",$data[$row]));
        }
    }

    // Write the row of the table that is passed in
    private function WriteRow($row)
    {
        $this->returnContent .= "<tr>";
        foreach($data as $colData)
        {
            $colData = Validator::FormatOutput($colData);
            $this->returnContent .= "<td>$colData</td>";
        }
        $this->returnContent .= "</tr>";
    }

        // Write the row of the table that is passed in as the table header
        private function WriteTableHeader()
        {
            $this->returnContent .= "<thead><tr>";
            foreach($headers as $colData)
            {
                $colData = Validator::FormatOutput($colData);
                $this->returnContent .= "<th>$colData</th>";
            }
            $this->returnContent .= "</tr></thead>";
        }

    // Create the table and return the html to the caller
    public function GetTable()
    {
        $this->StartTable();
        $this->MakeTable();
        $this->CloseTable();
        return $this->returnContent;
    }
}
?>
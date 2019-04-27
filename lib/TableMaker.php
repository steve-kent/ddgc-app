<?php
require_once('validator.php');

class TableMaker
{
    protected $headers;
    protected $data;
    protected $caption;
    protected $tagId = "";
    protected $classes = "tablemaker";
    public $returnContent = "";

    // Setter for private variables
    public function __set($name, $val)
    {
        $this->$name = $val;
    }

    // Create the start of the HTML table
    protected function StartTable()
    {
        $this->tagId = $this->tagId == "" ? "" : "id='" . $this->tagId . "'";
        $this->returnContent = "<table $this->tagId class='$this->classes'>";
        $this->returnContent .= "<caption>$this->caption</caption>";
    }

    // close the html table
    protected function CloseTable()
    {
        $this->returnContent .= "</table>";
    }

    // Create the html table
    protected function CreateTable()
    {
        $this->WriteTableHeader();
        foreach($this->data as $row)
        {
            $this->WriteRow($row);
        }
    }

    // Write the row of the table that is passed in
    protected function WriteRow($row)
    {
        $this->returnContent .= "<tr>";
        foreach($row as $colData)
        {
            $colData = FormatOutput($colData);
            $this->returnContent .= "<td>$colData</td>";
        }
        $this->returnContent .= "</tr>";
    }

    // Write the row of the table that is passed in as the table header
    protected function WriteTableHeader()
    {
        $this->returnContent .= "<thead><tr>";
        foreach($this->headers as $colData)
        {
            $colData = FormatOutput($colData);
            $this->returnContent .= "<th>$colData</th>";
        }
        $this->returnContent .= "</tr></thead>";
    }

    // Create the table and return the html to the caller
    public function GetTable()
    {
        $this->StartTable();
        $this->CreateTable();
        $this->CloseTable();
        return $this->returnContent;
    }
}
?>
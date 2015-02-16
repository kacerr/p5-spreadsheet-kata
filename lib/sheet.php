<?php
class Sheet {

  protected $rows, $columns;
  protected $_cells;

  function __construct($rows = 10, $columns = 8) {
    $this->rows = $rows;
    $this->columns = $columns;
    $this->_cells = Array();

    for ($i=0; $i<$columns; $i++) {
      $this->_cells[$i] = Array();
      for ($j=0; $j<$rows; $j++) {
        $this->_cells[$i][$j] = new Cell("");
      }
    }
  } 

  function getRows(){
    return $this->rows;
  }

  function getColumns(){
    return $this->columns;
  }

  function getCell($column, $row){
    $targetRow = $row - 1;
    $targetColumn = ord(strtoupper($column))-65;

    # throw an exception if out of range
    # echo $column, $row,$targetColumn, $targetRow, "<br>";
    return $this->_cells[$targetColumn][$targetRow];
  }

  function toString() {
    return print_r($this->_cells, true);
  }

  function toHTML($evalExpressions=false) {
    $out = "";
    $out .= "<table>";
    # label row
    $out .= "<thead style='background-color: lightgrey;'>";
    $out .= "<td>&nbsp;</td>";
    for ($i=0; $i<$this->columns; $i++) {
      $out .= "<td>" . chr(65+$i) . "</td>";
    }
    $out .= "</thead>";

    # sheet content with line label as a first cell in table
    for ($i=0; $i<$this->rows; $i++) {
      $out .= "<tr>";
      $out .= "<td>$i</td>";
      for ($j=0; $j<$this->columns; $j++) {
        $targetColumn = chr(65+$j);
        $out .= "<td>";
        if (!$evalExpressions) {
          $out .="  <input type=text name=\"" . $targetColumn . ($i+1) . "\" value=\"" . $this->getCell($targetColumn, $i + 1)->getValue() . "\">";
        } else {
          $out .= "<div style='width:100px; font-size:10px;'>" . $this->getCell($targetColumn, $i + 1)->evalContent() . "</div>";
        }
        $out .="</td>";
      }
      $out .= "</tr>";
    }
    $out .= "</table>";
    return($out);
  }
}
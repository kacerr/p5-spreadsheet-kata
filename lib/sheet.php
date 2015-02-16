<?php
class Sheet {

  protected $rows, $columns;
  protected $_cells;

  function __construct($rows = 10, $columns = 8) {
    $this->rows = $rows;
    $this->columns = $columns;
    $this->_cells = Array();

    for ($i=0; $i<$rows; $i++) {
      $this->_cells[$i] = Array();
      for ($j=0; $j<$columns; $j++) {
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

  function getCell($row, $column){
    $targetRow = $row - 1;
    $targetColumn = ord(strtoupper($column))-65;

    # throw an exception if out of range
    return $this->_cells[$targetRow][$targetColumn];
  }

  function toString() {
    return print_r($this->_cells, true);
  }

  function toHTML() {
    $out = "";
    $out .= "<table>";
    # label row
    $out .= "<tr>";
    $out .= "<td>&nbsp;</td>";
    for ($i=0; $i<$this->columns; $i++) {
      $out .= "<td>" . chr(65+$i) . "</td>";
    }
    $out .= "</tr>";

    # sheet content with line label as a first cell in table
    for ($i=0; $i<$this->rows; $i++) {
      $out .= "<tr>";
      $out .= "<td>$i</td>";
      for ($j=0; $j<$this->columns; $j++) {
        $targetColumn = chr(65+$j);
        $out .= "<td><input type=text name=\"" . ($i+1) . $targetColumn . "\" value=\"" . $this->getCell($i + 1, $targetColumn)->getValue() . "\"></td>";
      }
      $out .= "</tr>";
    }
    $out .= "</table>";
    return($out);
  }
}
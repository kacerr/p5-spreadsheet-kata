<?php
class Sheet {

  protected $rows, $columns;
  protected $_cells;

  function __construct($columns = 8, $rows = 10) {
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

  function getCell($str) {
    # expects string in a format A1 or H7 or X23
    preg_match('/([A-Z]+)([0-9]+)/', $str, $matches);
    if (count($matches)>0) {
      return $this->_getCell($matches[1], $matches[2]);
    }
    return null;
  }

  private function _getCell($column, $row){
    $targetRow = $row - 1;
    $targetColumn = ord(strtoupper($column))-65;

    # throw an exception if out of range
    return $this->_cells[$targetColumn][$targetRow];
  }

  function evalContent($column, $row) {
    $cellValue = $this->_getCell($column, $row)->getValue();
    preg_match('/=(SUM|MIN|MAX)\(([A-Z]{1})([0-9]+):([A-Z]{1})([0-9]+)\)/', $cellValue, $matches);
    if (count($matches)==6) {
      return($this->evalRange($matches[1], $matches[2], $matches[3], $matches[4], $matches[5]));
    };
    return($cellValue);
  }

  function evalRange($operation, $startColumn, $startRow, $endColumn, $endRow) {
    $range = $this->getFlattenedRange($startColumn, $startRow, $endColumn, $endRow);
    switch ($operation) {
      case "SUM": 
        return array_sum($range);
      case "MAX":
        return max($range);
      case "MIN":
        return min($range);
      default:
        return "unknown formula";
    }
    #return "${operation} on range ${startColumn}${startRow}:${endColumn}{$endRow}";
  }

  private function getFlattenedRange($startColumn, $startRow, $endColumn, $endRow) {
    $out = Array();
    for ($i=ord(strtoupper($startColumn)); $i<=ord(strtoupper($endColumn));$i++) 
      for ($j=$startRow; $j<=$endRow;$j++) {
        if (is_numeric($this->_getCell(chr($i), $j)->getValue()))
        $out[] = $this->_getCell(chr($i), $j)->getValue();
      }
    return $out;
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
      $out .= "<td>" . ($i+1) . "</td>";
      for ($j=0; $j<$this->columns; $j++) {
        $targetColumn = chr(65+$j);
        $out .= "<td>";
        if (!$evalExpressions) {
          $out .="  <input type=text name=\"" . $targetColumn . ($i+1) . "\" value=\"" . $this->_getCell($targetColumn, $i + 1)->getValue() . "\">";
        } else {
          $out .= "<div style='width:100px; font-size:10px;'>" . $this->evalContent($targetColumn, $i + 1) . "</div>";
        }
        $out .="</td>";
      }
      $out .= "</tr>";
    }
    $out .= "</table>";
    return($out);
  }
}
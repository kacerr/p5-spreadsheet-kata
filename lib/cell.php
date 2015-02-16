<?php

class Cell {
  protected $value;
  
  function __construct($value) {
    $this->value = $value;
  }

  function getValue() {
    # over here we'll have some evaluation later
    return $this->value;
  }

  function evalContent() {
    preg_match('/=(SUM|MIN|MAX)\(([A-Z]{1})([0-9]+):([A-Z]{1})([0-9]+)\)/', $this->value, $matches);
    if (count($matches)==6) {
      return($this->evalRange($matches[1], $matches[2], $matches[3], $matches[4], $matches[5]));
    };
    return($this->getValue());
  }

  function evalRange($operation, $startColumn, $startRow, $endColumn, $endRow) {
    return "${operation} on range ${startColumn}${startRow}:${endColumn}{$endRow}";
  }

  function getValueAsString() {
    return (string) $this->value;
  }

  function setValue($value) {
    $this->value = $value;
  }

  function emptyMe() {
    $this->value = null;
  }
}
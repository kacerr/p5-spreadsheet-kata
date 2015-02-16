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
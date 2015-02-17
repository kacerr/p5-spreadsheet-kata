<?php
require_once __DIR__ . "/../lib/cell.php";


class CellTest extends PHPUnit_Framework_TestCase {

  public function testValueCanBeReadFromCell() {
    $cell = new Cell('initial value');
    $this->assertEquals('initial value', $cell->getValue());
  }

  public function testValueCanBeAssignedToCell() {
    $cell = new Cell('initial value');
    $this->assertEquals('initial value', $cell->getValue());

    $cell->setValue('new value');
    $this->assertEquals('new value', $cell->getValue());
  }

  public function testCellCanBeEmptied() {
    $cell = new Cell('initial value');
    $cell->emptyMe();
    $this->assertEquals('', $cell->getValue());
  }

  public function testItReturnsStringRepresentationOfCellContent() {
    $cell = new Cell(1991);
    $this->assertSame('1991', $cell->getValueAsString());
  }

}

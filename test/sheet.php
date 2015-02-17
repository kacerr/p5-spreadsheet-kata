<?php
require_once __DIR__ . "/../lib/cell.php";
require_once __DIR__ . "/../lib/sheet.php";


class SheetTest extends PHPUnit_Framework_TestCase {

  public function testSheetCanBeCreated() {
    $cell = new Sheet(5,5);
  }

  public function testSheetHasProperDimensions() {
    $sheet = new Sheet(3,6);
    $this->assertEquals($sheet->getColumns(), 3);
    $this->assertEquals($sheet->getRows(), 6);
  }

  public function testAccessCellByColumnAndRow() {
    # meaning we can get cell using A1 or D7
    $sheet = new Sheet(3,6);
    $sheet->getCell("B2")->setValue(666);
    $this->assertEquals($sheet->getCell("B2")->getValue(), 666);
  }

  public function testCalculatesSumOverARange() {
    $sheet = new Sheet(3,6);
    $sheet->getCell("A1")->setValue(-10.4);
    $sheet->getCell("B1")->setValue(132);
    $sheet->getCell("B2")->setValue(56.123);
    $sheet->getCell("C3")->setValue(-1.045);
    # this one won't be int the range
    $sheet->getCell("C6")->setValue(1044);

    $this->assertEquals($sheet->evalRange("SUM", "A", 1, "C", 3), (-10.4 + 132 + 56.123 - 1.045));
  }

  public function testCalculatesMinOverARange() {
    $sheet = new Sheet(3,6);
    $sheet->getCell("A1")->setValue(-10.4);
    $sheet->getCell("B1")->setValue(132);
    $sheet->getCell("B2")->setValue(56.123);
    $sheet->getCell("C3")->setValue(-1.045);
    # this one won't be int the range
    $sheet->getCell("C6")->setValue(-1044);

    $this->assertEquals($sheet->evalRange("MIN", "A", 1, "C", 3), -10.4);
  }

  public function testCalculatesMaxOverARange() {
    $sheet = new Sheet(3,6);
    $sheet->getCell("A1")->setValue(-10.4);
    $sheet->getCell("B1")->setValue(132);
    $sheet->getCell("B2")->setValue(56.123);
    $sheet->getCell("C3")->setValue(-1.045);
    # this one won't be int the range
    $sheet->getCell("C6")->setValue(1044);

    $this->assertEquals($sheet->evalRange("MAX", "A", 1, "C", 3), 132);
  }

  public function testEvalsCellWithFormulaInside() {
    $sheet = new Sheet(3,6);
    $sheet->getCell("A1")->setValue(-10.4);
    $sheet->getCell("B1")->setValue(132);
    $sheet->getCell("B2")->setValue(56.123);
    $sheet->getCell("C3")->setValue(-1.045);
    # this one won't be int the range
    $sheet->getCell("C6")->setValue("=MAX(A1:C3)");

    $this->assertEquals($sheet->evalContent("C", 6), 132);
  }

}

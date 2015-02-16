<?php

require ("lib/cell.php");
require ("lib/sheet.php");

$oSheet = new Sheet();

for ($i=0; $i<$oSheet->getRows(); $i++) 
  for ($j=0; $j<$oSheet->getColumns(); $j++) {
    $oSheet->getCell($i + 1, chr($j+65))->setValue( ($i+1) . chr($j+65));
  } 


echo $oSheet->toHTML();

#echo "<br><br>";
#echo "<pre>" . print_r($oSheet->toString(), true) . "</pre>";
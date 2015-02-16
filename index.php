<?php

require ("lib/cell.php");
require ("lib/sheet.php");

$oSheet = new Sheet();

if (!isset($_REQUEST['action']) || $_REQUEST['action']=='reset' || $_REQUEST['action']==null) {
  for ($i=0; $i<$oSheet->getRows(); $i++) 
    for ($j=0; $j<$oSheet->getColumns(); $j++) {
      # echo $i, $j, "<br>";
      $oSheet->getCell(chr($j+65), $i + 1)->setValue( chr($j+65) . ($i+1));
    } 
} else {
  # loop through data received in post and set cell values
  foreach ($_POST as $key => $value) {
    #echo "${key}:: ${key[0]}: ${key[1]} <br>";
    preg_match('/([A-Z]+)([0-9]+)/', $key, $matches);
    if (count($matches)>0) {
      $oSheet->getCell($matches[1], $matches[2])->setValue($value);
    }
  }
}

echo "<form method='post' id='main-form'>";
echo $oSheet->toHTML();
echo "<input type=submit value='update'>";
echo "<button onclick=\"if (confirm('do you really want to reset the spreadsheet?')) { document.getElementById('hdn-action').value='reset'; document.getElementById('main-form').submit();}\">Reset</button>";
echo "<input type=hidden id='hdn-action' name='action' value='update'>";
echo "</form>";

echo "<br><br>";
echo "<h4>Evaluated formulaes </h4>";
echo $oSheet->toHTML(true);

# echo "<pre>" . print_r($oSheet->toString(), true) . "</pre>";
<?php
error_reporting(E_ERROR | E_PARSE);
$table = file_get_contents('https://www.rechtsanwaelte.at/buergerservice/servicecorner/rechtsanwalt-finden/?tx_rafinden_simplesearch%5Blid%5D=11298&tx_rafinden_simplesearch%5Baction%5D=show&tx_rafinden_simplesearch%5Bcontroller%5D=LawyerSearch&cHash=7121967595cd32a23c51845094d9471f');
//$table = file_get_contents('https://en.wikipedia.org/wiki/Sugar_Ray_Robinson');
$dom = new DOMDocument;

$dom->loadHTML($table);
$dom->preserveWhiteSpace = false;
$tables = $dom->getElementsByTagName('table');
$rows = $tables->item(0)->getElementsByTagName('tr'); 


$num = 0 ;

 foreach ($rows as $row) {
	 
	 
	 
	 if($num == 1 ){
	 
      /*** get each column by tag name ***/ 
      $cols = $row->getElementsByTagName('td');
      
      /*** echo the values ***/ 
      echo 'Name: '.$cols->item(0)->nodeValue.'<br />'; 
      echo 'Address: '.$cols->item(1)->nodeValue.'<br />'; 
      echo '<hr />';
	 }
	 
	 $num++;
   }
 
 
 
 $array = Array (
        0 => Array (
                0 => "How was the Food?",
                1 => 3,
                2 => 4 
        ),
        1 => Array (
                0 => "How was the first party of the semester?",
                1 => 2,
                2 => 4,
                3 => 0 
        ) 
);

header("Content-Disposition: attachment; filename=\"data.xls\"");
header("Content-Type: application/vnd.ms-excel;");
header("Pragma: no-cache");
header("Expires: 0");
$out = fopen("php://output", 'w');
foreach ($array as $data)
{
    fputcsv($out, $data,"\t");
}
fclose($out);



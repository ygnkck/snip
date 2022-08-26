<?php
error_reporting(E_ERROR | E_PARSE);
$table = file_get_contents('https://www.rechtsanwaelte.at/buergerservice/servicecorner/rechtsanwalt-finden/?tx_rafinden_simplesearch%5Blid%5D=11298&tx_rafinden_simplesearch%5Baction%5D=show&tx_rafinden_simplesearch%5Bcontroller%5D=LawyerSearch&cHash=7121967595cd32a23c51845094d9471f');
//$table = file_get_contents('https://en.wikipedia.org/wiki/Sugar_Ray_Robinson');

//$table = file_get_contents('https://www.rechtsanwaelte.at/buergerservice/servicecorner/rechtsanwalt-finden/?tx_rafinden_simplesearch%5Blid%5D=6649&tx_rafinden_simplesearch%5Baction%5D=show&tx_rafinden_simplesearch%5Bcontroller%5D=LawyerSearch&cHash=c43d6a4765b19a2562518d141c939551');

$dom = new DOMDocument;

$dom->loadHTML($table);
$dom->preserveWhiteSpace = false;
$tables = $dom->getElementsByTagName('table');
$rows = $tables->item(0)->getElementsByTagName('tr');


$xpath  = new DOMXPath($dom);
$classname1 = 'lastname';
$classname2 = 'lawywer-search';
$classname3 = 'email';
$results1 = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), ' $classname1 ')]");
$results2 = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), ' $classname2 ')]");
$results3 = $xpath->query("//*[@class and contains(concat(' ', normalize-space(@class), ' '), ' $classname3 ')]");
$results4 = $dom->getElementById('tm')->textContent;

 if ($results1->length > 0) {
         $name = $results1->item(0)->nodeValue; 
    }
	

 foreach ($results2 as $row) {
	 
	 
      /*** get each column by tag name ***/ 
      $cols = $row->getElementsByTagName('li');
      
      /*** echo the values ***/ 
      $string1 =  $cols->item(0)->nodeValue;
	  
	  $tel=str_replace('Telefon:', '', $string1);
	
      $string2 =  $cols->item(1)->nodeValue;
	  
	  $mobile=str_replace('Mobilnummer:', '', $string2);
	  
	  $string3 =  $cols->item(2)->nodeValue;
	  
	  $email=str_replace('E-mail:', '', $string3);
	  
	  $string4 =  $cols->item(3)->nodeValue;
	  
	  $web=str_replace('Web:', '', $string4);
	  
   }
   

 $array = array(
      array(
				'Name' => trim($name),
				'Address' => trim($results4),
                'Telephone' => trim($tel),
                'Mobile' => trim($mobile),
                'Email' => trim($email),
				'Web'	=> trim($web)
                
            )
      
    );


$fileName = "export_data" . rand(1,100) . ".xls";
if ($array) {
    function filterData(&$str) {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    $flag = false;
    foreach($array as $row) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($row, 'filterData');
        echo implode("\t", array_values($row)) . "\n";
    }
    exit;            
}

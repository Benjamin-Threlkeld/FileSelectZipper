<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// This script is to scan a dir an add all files to json array for storage
$array = [];

$directory = "./files/zipable/";
// create a handler to the directory
$dirhandler = opendir($directory);

// read all the files from directory
$numFiles = 0;
while ($fileName = readdir($dirhandler)) {
	if ($fileName != '.' && $fileName != '..') {
		if (substr($fileName,0,8) == 'teaching') {
			$fileDate = new DateTime(substr($fileName,-12,-4));
			#echo substr($fileName,-12,-4);
			$fileDate = $fileDate->format('Y:m:d');
		} else {
			$fileDate = NULL;
		}

		$array[$numFiles] = array(
			'id' => $numFiles,
			'name' => $fileName,
			'size' => filesize($directory.$fileName),
			'date' => $fileDate
		);
		$numFiles++;
	}   
}
closedir($dirhandler);


echo '<pre>';
echo 'array<br />';
print_r($array);
echo "<br />----------------------------------<br/>\n";
print(json_encode($array, JSON_PRETTY_PRINT));
echo '</pre>'
?>
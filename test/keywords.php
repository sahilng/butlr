<?php

function getValueForKeyword($keyword, $filepath) {
	if (($handle = fopen($filepath, 'r')) !== false) {
		while (($data = fgetcsv($handle, 0, ',', '"')) !== false) {
			$last = count($data) - 1;
			$value = $data[$last];
			for ($i = 0; $i < $last; $i++) {
				if ($data[$i] === $keyword) {
					return $value;
				}
			}
		}
		fclose($handle);
	}
}

function printKeywords($filepath) {
	if (($handle = fopen($filepath, 'r')) !== false) {
		while (($data = fgetcsv($handle, 0, ',', '"')) !== false) {
			 echo $data[0] . ", ";
		}
		fclose($handle);
	}
}

function printKeywordsList($filepath) {
	$string = "";
	if (($handle = fopen($filepath, 'r')) !== false) {
		while (($data = fgetcsv($handle, 0, ',', '"')) !== false) {
			 $string .= $data[0] . ", ";
		}
		fclose($handle);
	}
	
	$len = strlen($string) - 2;
	
	if ($len > 0) {
		echo substr($string, 0,  $len);
	}
}

function printKeywordsTable($filepath) {
	if (($handle = fopen($filepath, 'r')) !== false) {
		while (($data = fgetcsv($handle, 0, ',', '"')) !== false) {
			echo "<tr><td class=returnField style='color:#66FF66'>$data[0]</td></tr>";
		}
		fclose($handle);
	}
}

?>
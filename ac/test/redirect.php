<?php

require "keywords.php";
//require "donate.php";
require "convert.php";

function toArray($input) {
	$input = addslashes($input);
	//strip apos slashes
	$input = str_replace(chr(0xC2).chr(0xA0), " ", $input);
	$r = utf8_decode('Â');
	$input = str_replace($r,'', $input);

	if(strpos($input, '"') !== FALSE){
		if(strpos($input, "'") !== FALSE){
			$input = stripAposSlashes($input);
		}
	}

	//$input = addslashes($input) for when it comes from input form
	return str_getcsv($input,' ','\"','\\');
	
}


function redirect($location, $same_window = false) {
	$location = substr($location, 10);
	header("Location: " . $location);
}

//removes backslash from before ' within the enclosure
function stripAposSlashes($query){
	$aposIndex = strpos($query, "'");
	$quotIndex = strpos($query, '"');

	$subQuery = substr($query, $quotIndex+1);
	$subQuery = substr($subQuery, 0, strlen($subQuery)-2);


	$strippedSubQuery = stripslashes($subQuery);

	$query = str_replace($subQuery, $strippedSubQuery, $query);

	return $query;
}


function getResult($input) {

	$query = toArray($input);

	if($query[0] === "open") {
		$keyword_path = "keywords/keywords_open.txt";
		$value = getValueForKeyword($query[1], $keyword_path);

		if (isset($value)) {
			redirect($value, true);
		} elseif(strpos($query[1], '.') !== FALSE){
			if(strpos($query[1], 'http://') !== FALSE){
				redirect("Location: " . $query[1], true);
			}
			else{
				redirect("Location: http://" . $query[1], true);
			}
		} else {
			echo "<span id=error>Error: '" . $query[1] . "' is not a valid URL or accepted keyword.</span>";
		}
	} elseif($query[0] === "search") {
		echo "searching";
		if($query[1] === "weather") {
			if($query[2] === "for") {
				$weather = "http://www.wunderground.com/cgi-bin/findweather/hdfForecast?query=" . $query[3];
				redirect('Location: ' . stripslashes($weather), true);
			}
		}
		else {
			$keyword_path = "keywords/keywords_search.txt";
			$value = getValueForKeyword($query[1], $keyword_path);

			if (isset($value)) {
				
				$query[2] = str_replace('"', '', $query[2]);
				$query[2] = str_replace("'", "", $query[2]);
				
				redirect($value . $query[2], true);
			} else {
				echo "Error: unknown \"search\" command specified. Available commands:<br />";
				echo "weather for \"[location]\"<br />";
				echo "directions from \"[start_addr]\" to \"[end_addr]\":<br />";
				echo "delivery to \"[street_addr]\" \"[city]\" \"[zip_code]\"<br />";
				printKeywordsList($keyword_path);
			}
		}

	} elseif($query[0] === "donate") {
		donate($query[1]);
    } elseif ($query[0] === "convert") {
		if (isset($query[3])
				&& strcasecmp($query[1], "this") == 0
				&& strcasecmp($query[2], "to") == 0) {
			if (isset($_FILES["userfile"])) {
				if ($_FILES["userfile"]["error"] === UPLOAD_ERR_OK) {
					echo convert($_FILES["userfile"]["tmp_name"], $query[3]);
				} else {
					echo "Error: File upload failed. " . uploadErrorCodeToMessage($_FILES["userfile"]["error"]);
				}
			} else {
				echo "Error: No file uploaded.";
			}
		} else {
		echo "Command Format Error";
		}
	} else{
		echo "<tr><td class=returnField>Error: Invalid input \"" . $query[0] . "\"</td></tr>";
		echo "<tr><td class=returnField>Type \"help\" for a list of commands</td></tr>";
	}
}

$myquery = $_POST['formToSubmit'];

getResult($myquery);


//RIP Syntax Class

?>

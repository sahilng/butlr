<?php

require "keywords.php";
require "translate.php";
require "convert.php";
require "delivery.php";
require "donate.php";

function toArray($input) {
	//strip apos slashes
	$input = str_replace(chr(0xC2).chr(0xA0), " ", $input);
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
	header("Location: redirect.php?url=" . urlencode($location));
	// if ($same_window) {
	//	header("Location: " . $location);
	// } else {
		// echo "<script type='text/javascript'> window.location = \"$location\"; </script>";
		// echo "<script language='javascript'> window.open('" . $location . "', '_blank') </script>";
	// }
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
			// redirect($value, true);
		} else {
			echo "Error: unknown \"open\" commands specified. Available commands:<br />";
			echoKeywords($keyword_path);
		}
	} elseif($query[0] === "search") {
		if($query[1] === "weather") {
			if($query[2] === "for") {
				// $weather = "http://www.wunderground.com/cgi-bin/findweather/hdfForecast?query=" . $query[3];
				// redirect('Location: ' . stripslashes($weather), true);
			} else {
				echo "Error: incorrect syntax for \"search weather\". Valid syntax:<br />";
				echo "search weather for \"[location]\"<br />";
			}
		} elseif($query[1] === "directions") {
			if($query[2] === "from" && $query[4] === "to") {
				$start = $query[3];
				$end = $query[5];
				echo("<script type='text/javascript'>calcRoute(" . $start . "," . $end . ");</script>");
			} else {
				echo "Error: incorrect syntax for \"search directions\". Valid syntax:<br />";
				echo "search directions from \"[start_addr]\" to \"[end_addr]\":<br />";
			}
		} elseif($query[1] === "delivery") {
			if($query[2] === "to") {
				$address = $query[3];
				//echo $address;
				$city = $query[4];
				//echo $city;
				$zip = trim($query[5],'"');
				//echo $zip;

				$restaurantArray = getDeliveryList($address, $city, $zip);
				echo "<h1>Restaurants that deliver to you:</h1>";
				foreach($restaurantArray as $restaurant) {
					echo $restaurant["na"] . " Tel: " . $restaurant["cs_phone"] . "<br>";
				}
			} else {
				echo "Error: incorrect syntax for \"search delivery\". Valid syntax:<br />";
				echo "delivery to \"[street_addr]\" \"[city]\" \"[zip_code]\"<br />";
			}
		} else {
			$keyword_path = "keywords/keywords_search.txt";
			$value = getValueForKeyword($query[1], $keyword_path);

			if (isset($value)) {
				// redirect($value . $query[2], true);
			} else {
				echo "Error: unknown \"search\" command specified. Available commands:<br />";
				echo "weather for \"[location]\"<br />";
				echo "directions from \"[start_addr]\" to \"[end_addr]\":<br />";
				echo "delivery to \"[street_addr]\" \"[city]\" \"[zip_code]\"<br />";
				echoKeywords($keyword_path);
			}
		}
	} elseif($query[0] === "translate") {
		if($query[1] === "from" && $query[3] === "to") {
			$from = $query[2];
			$to = $query[4];

			if(strpos($query[5], '"') !== FALSE){
				$totranslate = trim($query[5], '\"');
			}
			elseif(strpos($query[5], "'") !== FALSE){
				$totranslate = trim($query[5], "'");
			}
			else{
				$totranslate = $query[5];
			}

			echo translate($totranslate, $from, $to);
		} else {
			echo "Error: incorrect syntax for \"translate\". Valid syntax:<br />";
			echo "translate from [from_language] to [to_language] \"[text_to_translate]\"";
		}
	} elseif($query[0] === "convert") {
		if($query[1] === "this" && $query[2] === "to") {
			if (isset($_FILES["userfile"])) {
				if ($_FILES["userfile"]["error"] === UPLOAD_ERR_OK) {
					$to = $query[3];
					convert($_FILES["userfile"]["tmp_name"], $to);
				} else {
					echo "Error: File upload failed. " . uploadErrorCodeToMessage($_FILES["userfile"]["error"]);
				}
			} else {
				echo "Error: No file uploaded.";
			}
		} else {
			echo "Error: incorrect syntax for \"convert\". Valid syntax:<br />";
			echo "convert this to [target_file_format]";
		}
	} elseif($query[0] === "calculate") {

		require_once "eos.class.php";
		$equation = $query[1];
		$eq = new eqEOS();
		$result = $eq->solveIF($equation);
		echo $result;
	} elseif($query[0] === "donate") {
		donate($query[1]);
	} elseif($query[0] === "about") {
		echo "Co-Founders: Sahil, Stan, Cavan";
	} 
	else {
		echo "Error: Invalid input " . $query[0];
	}
}

//RIP Syntax Class

?>

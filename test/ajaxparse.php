<?php

require "keywords.php";
require "help.php";
require "translate.php";
require "delivery.php";
require "dictionary.php";

function toArray($input) {
	//strip apos slashes
	$input = str_replace(chr(0xC2).chr(0xA0), " ", $input);
	if (strpos($input, '"') !== FALSE) {
		if (strpos($input, "'") !== FALSE) {
			$input = stripAposSlashes($input);
		}
	}

	//$input = addslashes($input) for when it comes from input form
	return str_getcsv($input,' ','\"','\\');
}


//removes backslash from before ' within the enclosure
function stripAposSlashes($query) {
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

	$command0 = strtolower($query[0]);

	/*
	 if ($query[0] === "open") {
	$keyword_path = "keywords/keywords_open.txt";
	$value = getValueForKeyword($query[1], $keyword_path);

	if (isset($value)) {
	// redirect($value, true);
	} else {
	echo "<tr><td class=returnField>Error: unknown \"open\" commands specified. Available commands:</td></tr>";
	echoKeywords($keyword_path);
	}
	} elseif ($query[0] === "search") {
	if ($query[1] === "weather") {
	if (isset($query[2]) && $query[2] === "for") {
	// $weather = "http://www.wunderground.com/cgi-bin/findweather/hdfForecast?query=" . $query[3];
	// redirect('Location: ' . stripslashes($weather), true);
	} else {
	echo "<tr><td class=returnField>Error: incorrect syntax for \"search weather\". Valid syntax:</td></tr>";
	echo "<tr><td class=returnField>search weather for \"[location]\"</td></tr>>";
	}
	} elseif ($query[1] === "directions") {
	if (isset($query[2]) && $query[2] === "from" && $query[4] === "to") {
	$start = $query[3];
	$end = $query[5];
	echo "<script type='text/javascript'>calcRoute(" . $start . "," . $end . ");</script>";
	echo "<tr><td class=returnField><div id=directionsPanel></div></td></tr>";
	} else {
	echo "<tr><td class=returnField>Error: incorrect syntax for \"search directions\". Valid syntax:</td></tr>>";
	echo "<tr><td class=returnField>search directions from \"[start_addr]\" to \"[end_addr]\":</td></tr>";
	}
	} else
		} else {
	$keyword_path = "keywords/keywords_search.txt";
	$value = getValueForKeyword($query[1], $keyword_path);

	if (isset($value)) {
	// redirect($value . $query[2], true);
	} else {
	echo "<tr><td class=returnField>Error: unknown \"search\" command specified. Available commands:</td></tr>";
	echo "<tr><td class=returnField>weather for \"[location]\"</td></tr>";
	echo "<tr><td class=returnField>directions from \"[start_addr]\" to \"[end_addr]\":</td></tr>";
	echo "<tr><td class=returnField>delivery to \"[street_addr]\" \"[city]\" \"[zip_code]\"</td></tr>";
	echoKeywords($keyword_path);
	}
	}
	} else */
	if ($command0 === "help") {
		if (isset($query[2])) {
			printCommandHelp($query[1] . " " . $query[2]);
		} elseif (isset($query[1])) {

			printCommandHelp($query[1]);

		} else {
			printHelp();

		}
	} elseif ($command0 === "search") {
		if (strcasecmp($query[1], "delivery") == 0) {
			if (isset($query[2]) && strcasecmp($query[2], "to") == 0) {
				$address = $query[3];
				$city = $query[4];
				$zip = trim($query[5],'"');

				$restaurantArray = getDeliveryList($address, $city, $zip);
				echo "<table><th class=returnField>Restaurants that deliver to you:</th>";
				foreach($restaurantArray as $restaurant) {
					echo "<tr><td class=returnField style='font-size:2em;'>" . $restaurant["na"] . "&nbsp;&nbsp;" . "<span class=green>" . $restaurant["cs_phone"] . "</span></td></tr>";
				}
				echo "</table>";
			} else {
				printErrorSyntax("search delivery");
			}
		} else {
			printErrorSyntax("search");
			echo "<tr><td class=returnField>Available search sites:</td></tr>";
			echo "<tr><td class=returnField>";
			printKeywordsList("keywords/keywords_search.txt");
			echo "</td></tr>";
		}
	} elseif ($command0 === "translate") {
		if (isset($query[5])
				&& strcasecmp($query[1], "from") == 0
				&& strcasecmp($query[3], "to") == 0) {
			$keywords_path = "keywords/keywords_translate.txt";
			$from = getValueForKeyword(strtolower($query[2]), $keywords_path);
			if (isset($from)) {
				$to = getValueForKeyword(strtolower($query[4]), $keywords_path);
				if (isset($to)) {
					if (strpos($query[5], '"') !== FALSE) {
						$totranslate = trim($query[5], '"');
					} elseif (strpos($query[5], "'") !== FALSE) {
						$totranslate = trim($query[5], "'");
					} else {
						$totranslate = $query[5];
					}
					echo "<tr><td class=returnField>" . translate($totranslate, $from, $to) . "</td></tr>";
				} else {
					echo "<tr><td class=returnField style='color:#FF3333'>Error: unknown language \"" . $query[4] . "\"</td></tr>";
					echo "<tr><td class=returnField>Available languages:</td></tr>";
					printKeywordsTable($keywords_path);
				}
			} else {
				echo "<tr><td class=returnField style='color:#FF3333'>Error: unknown language \"" . $query[2] . "\"</td></tr>";

				echo "<tr><td class=returnField>Available languages:</td></tr>";

				printKeywordsTable($keywords_path);
			}
		} else {
			printErrorSyntax("translate");
		}
	} elseif ($command0 === "convert") {
			printErrorSyntax("convert");
	} 
	elseif ($command0 === "define") {
		if (isset($query[1])) {
			printDefinition($query[1]);
		} else {
			printErrorSyntax("define");
		}
	} elseif ($command0 === "calculate") {
		require_once "eos.class.php";
		if (isset($query[1])) {
			$eq = new eqEOS();
			echo "<tr><td class=returnField>" . $eq->solveif ($query[1]) . "</td></tr>";
		} else {
			printErrorSyntax("calculate");
		}
	} elseif($command0 === "headlines"){
		require_once "headlines.php";
		$limit = 10;
		$numShown = 5;
		$headlines = getHeadlines($limit);
		$urls = $headlines[0];
		$titles = $headlines[1];
		for($x = 0; $x < $numShown; $x++){
		if(strpos($urls[$x],'www.') == false)
		{
			$numShown+=1;
		}
		else
		{
            $class = ($x % 2 == 0 ? "headlines" : "headlines-b");
			echo "<tr><td class='returnField " . $class . "'><a href=" . $urls[$x] . ">";
			echo $titles[$x];
			echo "</td></tr>";
			}
		}
	
	} elseif ($command0 === "about") {
		echo "<tr><td class=returnField>Founders: Sahil, Stan, Cavan</td></tr>";
	} elseif ($command0 === "<3") {
		echo "<tr><td class=returnField>We love you too.</td></tr>";
	} else {
		printErrorCommandNotFound($command0);
	}
}

//RIP Syntax Class

?>

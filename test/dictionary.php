<?php 

function printDefinition($word) {
	$word = strtolower($word);

	$start ="<tr><td class=returnField>def: <span style='color:white;'>";
	$end = "</span></td></tr>";

	if ($word === "butlr") {
		echo $start . "This amazing website." . $end;
	} else {
		$url = "http://www.dictionaryapi.com/api/v1/references/collegiate/xml/" . $word . "?key=0356f432-713f-4873-bd2e-89cf3853cc76";

		$xml = simplexml_load_file($url);

		if (isset($xml->entry)) {
			$def1 = $xml->entry->def->dt;
			$def1 = substr($def1, 1);
			$containsLetter  = preg_match('/[a-zA-Z]/',$def1);
			
			
			if ($containsLetter) {
				if (isset($xml->entry->def->dt->fw)) {
					$def1 .= $xml->entry->def->dt->fw;
				}
				echo $start . $def1 . $end;
			} elseif (isset($xml->entry->def->dt->sx)) {
				$toReturn = "";
				foreach($xml->entry->def->dt->sx as $sx) {
					$toReturn .= $sx . ", ";
				}
				echo $start . substr($toReturn, 0, strlen($toReturn)-2) . $end;
			} else {
				echo "<tr><td class=returnField style='color:#FF3333'>Error: unknown word \"$word\"</td></tr>";
			}
		} else {
			echo "<tr><td class=returnField style='color:#FF3333'>Error: unknown word \"$word\"</td></tr>";
		}
	}
}


?>

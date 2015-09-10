
<?php 

function translate($text, $from, $to){

	//text to translate
	$toTranslate = $text;
	//from language (ISO 3-letter)
	$fromLanguage = $from;
	//to language (ISO 3-letter)
	$toLanguage = $to;


	// create curl resource
	$ch = curl_init("https://api.beglobal.com/translate");

	// set url
	//$data = array("text" => "hello" , "from" => "eng", "to" => "fra");
	$data = array();
	$data["text"] = $toTranslate;
	$data["from"] = $fromLanguage;
	$data["to"] = $toLanguage;
	 
	 
	$data_string = json_encode($data);
	 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'Authorization: BeGlobal apiKey=cuIikYrlDzQwgSr31zBj7w%3D%3D'
	));

	// $output contains the output string
	$json = curl_exec($ch);

	// close curl resource to free up system resources
	curl_close($ch);
	 
	$jsonArray = json_decode($json, true);

	return $jsonArray["translation"];
		
}

?>

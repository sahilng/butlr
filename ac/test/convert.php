<?php

function uploadErrorCodeToMessage($code) {

	switch ($code) {

		case UPLOAD_ERR_INI_SIZE:

			$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";

			break;

		case UPLOAD_ERR_FORM_SIZE:

			$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";

			break;

		case UPLOAD_ERR_PARTIAL:

			$message = "The uploaded file was only partially uploaded";

			break;

		case UPLOAD_ERR_NO_FILE:

			$message = "No file was uploaded";

			break;

		case UPLOAD_ERR_NO_TMP_DIR:

			$message = "Missing a temporary folder";

			break;

		case UPLOAD_ERR_CANT_WRITE:

			$message = "Failed to write file to disk";

			break;

		case UPLOAD_ERR_EXTENSION:

			$message = "File upload stopped by extension";

			break;



		default:

			$message = "Unknown upload error";

			break;

	}

	return $message;

}

function convert($file, $format) {

	$target_value = str_getcsv(getValueForKeyword(strtolower($format), "keywords/keywords_convert.txt"), ',', '"', '\\');

	
	
	if (isset($target_value)) {
		$target_type = $target_value[0];
		$target_method = $target_value[1];
		$key = "6fc9711626e1821f073ae7190e17a113";
		
		$request["queue"] = <<<QUEUE
<?xml version='1.0'?>
	<queue>
		<apiKey>$key</apiKey>
	</queue>
QUEUE;
		$token_h = curl_init("http://api.online-convert.com/request-token");
		curl_setopt($token_h, CURLOPT_CONNECTTIMEOUT, 30);

		curl_setopt($token_h, CURLOPT_HEADER, 0);

		curl_setopt($token_h, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

		curl_setopt($token_h, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($token_h, CURLOPT_POSTFIELDS, $request);

		$response = new SimpleXMLElement(curl_exec($token_h));
		curl_close($token_h);

		if ($response->status->code == 400) {
			$token = $response->params->token;
			$request["queue"] = <<<QUEUE
<?xml version='1.0'?>
	<queue>
		<token>$token</token>
		<targetType>$target_type</targetType>
		<targetMethod>$target_method</targetMethod>
		<testMode>true</testMode>
	</queue>
QUEUE;
			$request["file"] = "@$file";
			$convert_h = curl_init($response->params->server . "/queue-insert");
			curl_setopt($convert_h, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($convert_h, CURLOPT_HEADER, 0);

			curl_setopt($convert_h, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

			curl_setopt($convert_h, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($convert_h, CURLOPT_POSTFIELDS, $request);
			$response = new SimpleXMLElement(curl_exec($convert_h));
			curl_close($convert_h);

			if ($response->status->code == 0) {
				$hash = $response->params->hash;
				
				$code = "0";
				do {
					$code = pollStatus($token, $hash, $key);
					if ($code == "101" || $code == "102" || $code == "103" || $code == "104") {
						sleep(10);
					} else {
						echo "Error: processing file failed. Code: " . $code;
						break;
					}
				} while ($code != "100");
			} else {
				echo $response->status->message;
			}
		} else {
			echo "Error: conversion token retrieval failed.";
		}
	} else {
		echo "Error: Invalid format specified.";
	} 
}

function pollStatus($token, $hash, $key) {

	$request["queue"] = <<<QUEUE

<?xml version='1.0'?>

	<queue>

		<token>$token</token>

		<hash>$hash</hash>

	</queue>

QUEUE;

	$status_h = curl_init("http://api.online-convert.com/queue-status");
	curl_setopt($status_h, CURLOPT_CONNECTTIMEOUT, 30);

	curl_setopt($status_h, CURLOPT_HEADER, 0);

	curl_setopt($status_h, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

	curl_setopt($status_h, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($status_h, CURLOPT_POSTFIELDS, $request);

	$response = new SimpleXMLElement(curl_exec($status_h));

	
	$code = $response->status->code;
	if ($code == "100") {

		redirect("Location: " . $response->params->directDownload, true);
	}
	return $code;

}

/*
function requestDelete($key, $hash) {

	$request["queue"] = <<<QUEUE

<?xml version='1.0'?>

	<queue>

		<apiKey>$key</apiKey>

		<hash>$hash</hash>

		<method>deleteFile</method>

	</queue>

QUEUE;



	$delete_h = curl_init("http://api.online-convert.com/queue-manager");

	curl_setopt($delete_h, CURLOPT_HEADER, 0);

	curl_setopt($delete_h, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

	curl_setopt($delete_h, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($delete_h, CURLOPT_POSTFIELDS, $request);

	curl_exec($delete_h);

}
*/


?>

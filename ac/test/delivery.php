<?php 

	function getDeliveryList($addr, $city, $zip){
		
			$dt = "ASAP";
		
	
	        // create curl resource 
	        $ch = curl_init("https://r-test.ordr.in/dl/" . $dt . "/" . $zip . "/" . $city . "/" . $addr); 

	        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-NAAMA-CLIENT-AUTHENTICATION: id="SQ-rieXMjSWG0uxRezMX4DgycVswDGVOCABVqZ46EkY", version="1"',
				));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	
	        // $output contains the output string 
	        $json = curl_exec($ch); 
			$json = json_decode($json, true);
			
	        // close curl resource to free up system resources 
	        curl_close($ch);
	        
	        return $json;
	        
	}
	
/*
	$restaurantArray = getDeliveryList("60 Anderson Ave", "Englewood Cliffs", "07632");
	echo "<h1>Restaurants that deliver to you:</h1>";
	foreach($restaurantArray as $restaurant){
		echo $restaurant["na"] . "<br>";
	}
*/

?>

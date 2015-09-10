
<?php 

	function getPopular(){
		
			$dt = "ASAP";
		
	
	        // create curl resource 
	        $ch = curl_init("http://api.nytimes.com/svc/mostpopular/v2/mostshared/all-sections/1.sphp?api-key=5f41d074f92770b086e519ee7201a87c:10:68964136"); 

	        
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	
	        // $output contains the output string 
	        $sphp = curl_exec($ch); 
			$unsphp = unserialize($sphp);
	        // close curl resource to free up system resources 
	        curl_close($ch);
	        
	        return $unsphp;
	        
	}
	
/*
	$restaurantArray = getDeliveryList("60 Anderson Ave", "Englewood Cliffs", "07632");
	echo "<h1>Restaurants that deliver to you:</h1>";
	foreach($restaurantArray as $restaurant){
		echo $restaurant["na"] . "<br>";
	}
*/

function getHeadlines($limit){
	$urls = array();
	$titles = array();

	$x = 0;
	$articles = getPopular();
	if(is_array($articles)){
		$results = $articles["results"];
		foreach($results as $result){
			if($x < $limit){
				array_push($urls, $result["url"]);
				array_push($titles, $result["title"]);
				$x++;
			}
		}
	}
	return array($urls, $titles);
}


?>

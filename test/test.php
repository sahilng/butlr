<html>
<head>
<link rel="stylesheet" type="text/css" href="test/style.css">
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBj__-0AYaODLE892n4ryU9AsXKdUH3cno&sensor=false">
</script>
<script type="text/javascript"
      src="directions.js">
</script>


</head>
<body>
<div id="returnContent">
<?php

require "parse.php";

$query = $_POST['input'];
getResult(strtolower(addslashes($query)));

?>
</div>

<div id="directionsPanel">
</div>
</body>
</html>
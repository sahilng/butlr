
<?php

require "ajaxparse.php";

$query = $_POST['input'];
getResult(addslashes($query));

?>

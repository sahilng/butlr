<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8" author="Sahil, Cavan, Stan" />
<title>butlr</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script
	src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"
	type="text/javascript"></script>
	
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.js" type="text/javascript"></script>
</head>

<body onunload="">
	<div id="tophalf">

	<div id="logo">
    <p>butlr</p>
   </div>
	</div>
	<div id="bottomhalf">

	<div id="commandbox"  class="shadow">
		<table id="tableId">
		<tbody>
			
			</tbody>
		</table>
	</div>
	</div>
<form id="form" method="post" action="test/redirect.php" onsubmit="return copyContent()">
    <textarea id="editing" name="formToSubmit" style="display:none"></textarea>
        <input type="submit" value="Send" style="display:none" name="send" />

</form>

</body>
<script src="js/ajax.js"></script>
<script src="js/ff.js"></script>


<script type="text/javascript">
    function copyContent () {
$("#editing").html(document.getElementById("editable").textContent);
   return true;

}
</script>
</html>



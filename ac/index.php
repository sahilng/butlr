<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8" author="Sahil, Cavan, Stan" />
<title>butlr - a commandline for the web</title>
<meta name="description" content="butlr is a command line for the web. Use butlr's easy-to-use syntax and useful features to navigate the web.">

<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script
	src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"
	type="text/javascript"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>		
<script src="js/autocomplete.js"></script>

</head>

<?php

if(isset($_SERVER['HTTP_USER_AGENT'])){
    $agent = $_SERVER['HTTP_USER_AGENT'];
    
}

if(strlen(strstr($agent,"Firefox")) > 0 ){ 

  echo '<body onbeforeunload="">';

} else if(strlen(strstr($agent,"Safari")) > 0 ){

	echo "<script type='text/javascript'>";
	echo "
	$(window).bind('pageshow', function(event) {
    if (event.originalEvent.persisted) {
        window.location.reload() 
    }
	});";
	echo "\n</script>";
	echo "\n\n<body>";
	

} else{
	
	echo '<body onunload="">';
	
}


?>

	<div id="tophalf">
		
		<a href='../'><span class="staticMenuLink" id="homeLink"><span class="menuLinkText">home</span></span></a>		
		<a href="../docs"><span class="staticMenuLink" id="docsLink"><span class="menuLinkText">docs</span></span></a>
		<a href="../ac"><span class="staticMenuLink current" id="acLink"><span class="menuLinkText">Syntax Helper</span></span></a>

		<a href="https://www.facebook.com/pages/Butlr/668778913166047?ref=hl"><span class="hoverMenuLink" id="fbLink"><span class="menuLinkText">facebook</span></span></a>
		<a href="http://www.twitter.com/butlr_dev"><span class="hoverMenuLink" id="twitterLink"><span class="menuLinkText">twitter</span></span></a>

	
		<div id="logo">
	    <p><a href='#' onclick='location.reload(true); return false;'>butlr</a></p> 
	    </div>
    </div>
    
	<div id="bottomhalf">

	<div id="commandbox"  class="shadow">
		<table id="tableId">
			<form id="form" method="post" action="test/redirect.php" onsubmit="return copyContent()" enctype="multipart/form-data">
    <textarea id="editing" name="formToSubmit" style="display:none"></textarea>
    <input name="userfile" type="file" style="display:none" id="file" />
        <input type="submit" value="Send" style="display:none" name="send" />

</form>
		<tbody>
		
			</tbody>
		</table>
	</div>
	</div>


</body>

<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48300891-1', 'butlr.me');
  ga('send', 'pageview');

</script>
<!--<script src="js/chooser.js"></script>-->
<script src="js/ff.js"></script>
<script src="js/cookies.js"></script>
<script type="text/javascript">
</script>
<script src="js/ajax.js"></script>
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBj__-0AYaODLE892n4ryU9AsXKdUH3cno&sensor=false">
</script>
<script type="text/javascript"
      src="test/directions.js">
</script>
<script type="text/javascript">
    function copyContent () {
$("#editing").html(document.getElementById("editable").textContent);
   return true;

}
</script>
</html>

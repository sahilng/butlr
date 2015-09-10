	document.getElementById("file").onchange = function() {
	
    document.getElementById("form").submit();
     addNewQueryBox();
    
};
function addNewQueryBox()
{
$('#editable').removeAttr('contenteditable').removeAttr('autofocus').blur();
        $('#editable').removeAttr('id');
        $("#tableId > tbody").append("<div class=\"queryBox\" id=\"editable\" contenteditable=\"true\" autofocus>");
        elem = document.getElementById("editable");
		$('#tableId').find('br').remove();
		$("#editable").focus();
}
function checkKeyword(keyword)
{
var convertOptions = new Array("jpg","png","gif","bmp","ico","tif","tga","svg","wbmp","webp","eps","exr","aax","aiff",
"flac","m4a","mp3","ogg","opus","wav","wma","doc","docx","flash","html","odt","pdf","rtf","txt","avi","mp4","mov",
"wmv","ogv","flv","mkv","3g2","3gp","azw","azw3","epub","fb2","lit","lrf","mobi");
var contains = $.inArray(keyword, convertOptions);
if(contains > 0)
{
return true;
}			
else
{
return false;
}
}
	function getResponse(){

		
		var entry = document.getElementById("editable").textContent;
		var firstSpace = entry.indexOf(" ");
		if(entry.indexOf("convert")>=0)
		{
		firstSpace = 7;
		}
	
		var firstWord = entry.substring(0,firstSpace);
		console.log(firstWord);
		var thirdWord ="";
		if(entry.indexOf(" ",firstSpace+1) >= 0)
		{
		var secondSpace = entry.indexOf(" ",firstSpace+1);
		var secondWord = entry.substring(firstSpace+1,secondSpace);
		var thirdWord = entry.substring(secondSpace+1,entry.indexOf(" ",secondSpace+1));
		var fourthWord = entry.substring(entry.indexOf(" ",secondSpace+1)+1);
		}
		else
		{
				var secondWord = entry.substring(firstSpace+1);

		}
		console.log(secondWord);
		    if(firstWord == "open" || firstWord == "search" || firstWord == "donate" )
			{
			
			 if(secondWord != "directions" && secondWord != "delivery")
      {
		  $( "#form" ).submit();
		}
		else
		{
		noRedirect();
		}
			
			}
			else if(firstWord == "convert")
			{
			  if(secondWord == "this" && thirdWord == "to" )
			  {
			  		if(checkKeyword(fourthWord))
			  		{
			$("tbody").empty();  
			$("#editing").val(entry);
			$("#file").show();
			$("#editable").hide();
			}
			else
			{
			 					noRedirect();

			}
			}
			else
			{
			noRedirect();
			}
			}
			else
			{
			noRedirect();
			}
		
	}
	function noRedirect() {
	    var entry = document.getElementById("editable").textContent;
			 $('#tableId > tbody').append("<img src=\"img/716.gif\" id=\"loading\">");

	    var hr = new XMLHttpRequest();


	    var url = "test/ajaxtest.php";
	    var vars = "input=" + entry;
	    entry = encodeURIComponent(entry);
	    hr.open("POST", url, true);

	    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


	    hr.onreadystatechange = function() {


	        if (hr.readyState == 4 && hr.status == 200) {
	            var return_data = hr.responseText;
	            $('#tableId > tbody').append(return_data);
	            console.log( $(".loading"));
	            $("#loading").remove();
	            addNewQueryBox();


	        }
	    }

	    hr.send("input=" + entry);


	}
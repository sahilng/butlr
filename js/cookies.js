function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

console.log(readCookie('mypopup'));
var visited = readCookie('mypopup');

if ($.browser.mozilla) {
	$("#tableId > tbody").append("<div class=\"queryBox\" id=\"editable\" contenteditable=\"true\" spellcheck=\"false\" autofocus>");
}
else{	
console.log(visited == undefined);
	if (visited == undefined || !visited ) {
	  	console.log("a");

	    $("#tableId > tbody").append("<div class=\"queryBox\" data-ph=\"enter help to begin\" id=\"editable\" contenteditable=\"true\" spellcheck=\"false\" autofocus>");
	    createCookie('mypopup','no', 1);
	  
	} else{
	    $("#tableId > tbody").append("<div class=\"queryBox\" data-ph=\"enter a command\" id=\"editable\" contenteditable=\"true\" spellcheck=\"false\" autofocus>");
	}
}
        		$("#editable").focus();

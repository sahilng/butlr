var tlCom = new Array("help","define","open", "translate", "convert", "calculate", "search", "donate","headlines","about");
var openOpt = new Array("reddit","facebook", "fb", "twitter", "google", "yahoo", "bing", "cnn", "bbc", "npr", "nytimes", "nyt", "wsj");
var searchOpt = new Array("google", "youtube", "yt", "wolframalpha", "wolfram", "directions","delivery", "weather");
var translateOpt = new Array();
var donateOpt = new Array();
var aboutOpt = new Array();
var calculateOpt = new Array();
var convertOpt = new Array("this");
var convertOpt2 = new Array("to");
var badCodes = new Array(37,39,224,17,18,91);

var spaces = 0;
var totQuery = new Array();

$("#editable").focus();
$(document).keydown(function (e) {
        elem = document.getElementById("editable");
		   cursorPos=document.getSelection().extentOffset;

  if (e.keyCode == 13) {
  e.preventDefault();
    if(totQuery[0] == "open" || (totQuery[0] == "search") || totQuery[0] == "donate")
    {
      if(totQuery[1] != "directions" && totQuery[1] != "delivery")
      {
		  $( "#form" ).submit();
		}
		else
		{
		       getResponse();

		}
		
	}
	else {	
	
       getResponse();
       }
       }
       else if(e.keyCode == 8)
{
 var numSpace = 0;


        var content = $('#editable').html();
        var temp = 0;


        tempContent = content;
		tempContent = tempContent.replace(/&nbsp;/g,' ');
        while (tempContent.indexOf(" ", temp) >= 0) {
            tempContent = content.replace(/<(?:.|\n)*?>/gm, '');
            numSpace++;
            temp = tempContent.indexOf(" ", temp) + 1;

        }
        temp = 0;
        
        if (numSpace == 0) {
            $("#editable").html("");

            checkContent = content + String.fromCharCode(e.keyCode).toLowerCase();
            if (checkContent.indexOf(" ") >= 0) {
                checkContent = checkContent.substring(0, checkContent.length - 2);

            }

            var contains = $.inArray(checkContent, tlCom)

            if (contains >= 0) {
                $("#editable").append("<span class=blue>" + content + "</span>");
                totQuery[0] = checkContent;
            } else {
                $("#editable").append(content);
            }

        } else {
            var breakPos = content.indexOf("&nbsp;");
            var lastSpan = content.lastIndexOf("class=");

            if (breakPos >= 0) {
                var pos = content.indexOf("&nbsp;", content.indexOf(">", lastSpan));

            } else {
                var pos = content.indexOf(" ", content.indexOf(">", lastSpan));
            }

            if (e.keyCode == 8) {

                var checkSyntax = content.substring(pos + 1, content.indexOf("<", pos) - 1);

                if (checkSyntax.indexOf("&nbsp") >= 0) {
                    checkSyntax = checkSyntax.substring(0, checkSyntax.indexOf("&nbsp"));
                }
            } else if (e.keyCode == 32) {
                var checkSyntax = content.substring(pos + 1, content.indexOf("<", pos));

            } else {
                var checkSyntax = content.substring(pos + 1, content.indexOf("<", pos)) + String.fromCharCode(e.keyCode).toLowerCase();
            }

            var newSyntax = content.substring(pos);
            checkSyntax = checkSyntax.substring(5);
            content = content.substring(0, pos);

            $("#editable").html("");
            $('#edittable').empty();
            if (numSpace == 1) {
                if (totQuery[0] != null) {
				var checkArray;
					if(totQuery[0] == "open") checkArray = openOpt;
					if(totQuery[0] == "search") checkArray = searchOpt;
					if(totQuery[0] == "calculate") 
					if(totQuery[0] == "translate") checkArray = translateOpt;
					if(totQuery[0] == "convert") checkArray = convertOpt;
					if(totQuery[0] == "donate") checkArray = donateOpt;
					if(totQuery[0] == "about")  checkArray = calculateOpt;



					  
                    var contains = $.inArray(checkSyntax,checkArray);
                    if (contains >= 0) {
                        $("#editable").append(content + "<span class=green>" + newSyntax + "</span>");
						totQuery[1] = checkSyntax;

                    } else {
                        var spanCheck = content.substring(content.lastIndexOf("<span class=") + 13, pos - 2);
                        if (spanCheck.indexOf("white") >= 0) {
                            $("#editable").append(content + newSyntax);

                        } else {
                            $("#editable").append(content + "<span class=white>" + newSyntax + "</span>");
                        }

                    }
                }  else {
				$("#editable").append(content + newSyntax );

                }

            }
            
			else
            {
			 $("#editable").append(content + newSyntax );	  
            }
        }
        

        elem = document.getElementById("editable");
        setEndOfContenteditable(elem,cursorPos);
}
});

$(document).keypress(function (e) {
    var numSpace = 0;
            elem = document.getElementById("editable");

   cursorPos=document.getSelection().extentOffset;
   console.log(cursorPos);
         
        var content = $('#editable').html();
        var temp = 0;


        tempContent = content;
		tempContent = tempContent.replace(/&nbsp;/g,' ');
        while (tempContent.indexOf(" ", temp) >= 0) {
            tempContent = content.replace(/<(?:.|\n)*?>/gm, '');
            numSpace++;
            temp = tempContent.indexOf(" ", temp) + 1;

        }
        temp = 0;
        
        if (numSpace == 0) {
            $("#editable").html("");

            checkContent = content + String.fromCharCode(e.keyCode).toLowerCase();
            if (checkContent.indexOf(" ") >= 0) {
                checkContent = checkContent.substring(0, checkContent.length - 2);

            }

            var contains = $.inArray(checkContent, tlCom)

            if (contains >= 0) {
                $("#editable").append("<span class=blue>" + content + "</span>");
                totQuery[0] = checkContent;
            } else {
                $("#editable").append(content);
            }

        } else {
            var breakPos = content.indexOf("&nbsp;");
            var lastSpan = content.lastIndexOf("class=");

            if (breakPos >= 0) {
                var pos = content.indexOf("&nbsp;", content.indexOf(">", lastSpan));

            } else {
                var pos = content.indexOf(" ", content.indexOf(">", lastSpan));
            }

            if (e.keyCode == 8) {

                var checkSyntax = content.substring(pos + 1, content.indexOf("<", pos) - 1);

                if (checkSyntax.indexOf("&nbsp") >= 0) {
                    checkSyntax = checkSyntax.substring(0, checkSyntax.indexOf("&nbsp"));
                }
            } else if (e.keyCode == 32) {
                var checkSyntax = content.substring(pos + 1, content.indexOf("<", pos));

            } else {
                var checkSyntax = content.substring(pos + 1, content.indexOf("<", pos)) + String.fromCharCode(e.keyCode).toLowerCase();
            }

            var newSyntax = content.substring(pos);
            checkSyntax = checkSyntax.substring(5);
            content = content.substring(0, pos);

            $("#editable").html("");
            $('#edittable').empty();
            if (numSpace == 1) {
                if (totQuery[0] != null) {
				var checkArray;
					if(totQuery[0] == "open") checkArray = openOpt;
					if(totQuery[0] == "search") checkArray = searchOpt;
					if(totQuery[0] == "calculate") 
					if(totQuery[0] == "translate") checkArray = translateOpt;
					if(totQuery[0] == "convert") checkArray = convertOpt;
					if(totQuery[0] == "donate") checkArray = donateOpt;
					if(totQuery[0] == "about")  checkArray = calculateOpt;



					  
                    var contains = $.inArray(checkSyntax,checkArray);
                    if (contains >= 0) {
                        $("#editable").append(content + "<span class=green>" + newSyntax + "</span>");
						totQuery[1] = checkSyntax;

                    } else {
                        var spanCheck = content.substring(content.lastIndexOf("<span class=") + 13, pos - 2);
                        if (spanCheck.indexOf("white") >= 0) {
                            $("#editable").append(content + newSyntax);

                        } else {
                            $("#editable").append(content + "<span class=white>" + newSyntax + "</span>");
                        }

                    }
                }  else {
				$("#editable").append(content + newSyntax );

                }

            }
            
			else
            {
			 $("#editable").append(content + newSyntax );	  
            }
        }
        
		
        setEndOfContenteditable(elem, cursorPos);

    
});
function getCaretPosition(editableDiv) {
    var caretPos = 0, containerEl = null, sel, range;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount) {
            range = sel.getRangeAt(0);
            if (range.commonAncestorContainer.parentNode == editableDiv) {
                caretPos = range.endOffset;
            }
        }
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        if (range.parentElement() == editableDiv) {
            var tempEl = document.createElement("span");
            editableDiv.insertBefore(tempEl, editableDiv.firstChild);
            var tempRange = range.duplicate();
            tempRange.moveToElementText(tempEl);
            tempRange.setEndPoint("EndToEnd", range);
            caretPos = tempRange.text.length;
        }
    }
    return caretPos;
}
function setEndOfContenteditable(contentEditableElement, cursorPos)
{
    var range,selection;
    if(document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
    {
        range = document.createRange();//Create a range (a range is a like the selection but invisible)
        range.selectNodeContents(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        selection = window.getSelection();//get the selection object (allows you to change selection)
        selection.removeAllRanges();//remove any selections already made
        selection.addRange(range);//make the range you have just created the visible selection
    }
    else if(document.selection)//IE 8 and lower
    { 
        range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
        range.moveToElementText(contentEditableElement);//Select the entire contents of the element with the range
        range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
        range.select();//Select the range (make it the visible selection
    }
}
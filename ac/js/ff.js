   			window.onunload = "";
        		$("#editable").focus();

var tlCom = new Array("help","define","open", "translate", "convert", "calculate", "search", "donate","about");
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
$(document).keydown(function (e) {

console.log($("#editable").text());
if (e.keyCode == 13) {
    getResponse();
    }
});

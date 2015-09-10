
 if ( $.browser.webkit )
 {
 $('body').after('<script type="text/javascript" src="js/butlr.js"></script>');
}
else
{
 $('body').after('<script type="text/javascript" src="js/ff.js"></script>');

}
$(function() {
var tlCom = new Array("help","define","open", "translate", "convert", "calculate", "search", "donate","about");
  $.fn.val = $.fn.html;
  var availableTags = tlCom;
  $("#editable").autocomplete({
      source: availableTags
  });
  
});
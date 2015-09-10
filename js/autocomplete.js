	$(function() {
		
				
		var availableTags = [
				"open",
				"search",
				"translate",
				"define",
				"calculate",
				"about",
				"help"
				
			];
					
		function split( val ) {
	      return val.split( /\s/ );
	    }
	    function extractLast( term ) {
	      return split( term ).pop();
	    }
	 
	    $( "#editable" )
	      // don't navigate away from the field on tab when selecting an item
	      .bind( "keydown", function( event ) {
	        if ( event.keyCode === $.ui.keyCode.TAB &&
	            $( this ).data( "ui-autocomplete" ).menu.active ) {
	          event.preventDefault();
	        }
	      })
	      .autocomplete({
	        minLength: 0,
	        source: function( request, response ) {
	          // delegate back to autocomplete, but extract the last term
	          response( $.ui.autocomplete.filter(
	            getTags(), extractLast( request.term ) ) );

	        },
	        /*
			select: function( event, ui ) {
	          var terms = split( this.value );
	          // remove the current input
	          terms.pop();
	          // add the selected item
	          terms.push( ui.item.value );
	          // add placeholder to get the comma-and-space at the end
	          terms.push( "" );
	          this.value = terms.join( ", " );
	          return false;
	        }
*/
	      });
	});
	
	function returnTokens(){
		//var tokens = document.getElementById("editable").innerHTML.replace(/<(?:.|\n)*?>/gm, '').replace(" ","&nbsp;").replace(" ", "&nbsp;").split('&nbsp;');
		var html = document.getElementById("editable").innerHTML;
		html = html.replace("nbsp","");
		html = html.replace("&","");
		html = html.replace(";"," ");
		var tokens = html.match(/(?:[^\s"]+|"[^"]*")+/g);
		return tokens;
	}
	
	function getTags(){
		//var tokens = document.getElementById("editable").innerHTML.replace(/<(?:.|\n)*?>/gm, '').replace(" ","&nbsp;").replace(' ', "&nbsp;").split('&nbsp;');
		var html = document.getElementById("editable").innerHTML;
		html = html.replace("nbsp","");
		html = html.replace("&","");
		html = html.replace(";"," ");
		var tokens = html.match(/(?:[^\s"]+|"[^"]*")+/g);
		
		var x = 1;
		var browser=navigator.userAgent.toLowerCase();
		if(browser.indexOf('firefox') > -1) {
				var index = tokens.indexOf("<br>");
						if (index > -1) {
								tokens.splice(index, 1);
						}
		}

		
		if(tokens == null){
			return [
				/*
"open",
				"search",
				"translate",
				"define",
				"calculate",
				"about",
				"help"
*/
				
			];
		}
		else{
		if(tokens.length == x){
			if(tokens[0] === "<br>"){
				return [
				/*
"open",
				"search",
				"translate",
				"define",
				"calculate",
				"about",
				"help"
*/	
				];
			}
			else if(tokens[0] === "open"){
				return ["facebook","twitter","google","yahoo","bing","cnn","nyt","wsj","reddit","netflix","amazon","diagnoser","docs"];
			}
			else if(tokens[0] === "search"){
				return ["google","youtube","delivery","weather","wolframalpha","pandora","wikipedia"];
			}
			else if(tokens[0] === "define"){
				return ["[enter a word to define and press enter]"];
			}
			else if(tokens[0] === "translate"){
				return ["from"];
			}
			else if(tokens[0] === "calculate"){
				return ["[enter arithmetic to calculate (in quotes) and press enter]"]
			}
			else if(tokens[0] === "donate"){
				return ["[enter an amount and press enter]"];
			}
			else if(tokens[0] === "help"){
				return ["[press enter or specify a command]"];
			}
		}
		else if(tokens.length == x+1){
			if(tokens[0] === "open"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "search"){
				if(tokens[1] === "delivery"){
					return ["to"];
				}
				else if(tokens[1] === "weather"){
					return ["for"];
				}
				else{
					return ["[enter words to search (in quotes if more than one word) and press enter]"]
				}
			}
			else if(tokens[0] === "define"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "translate"){
				return ["[type the language to translate from]"];
			}
			else if(tokens[0] === "calculate"){
				return ["[press enter]"]
			}
			else if(tokens[0] === "donate"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "help"){
				return ["[press enter]"];
			}
		}
		else if(tokens.length == x+2){
			if(tokens[0] === "open"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "search"){
				if(tokens[1] === "delivery"){
					return ["[type (in quotes) the street address]"];
				}
				else if(tokens[1] === "weather"){
					return ["[type (in quotes) the location to search and press enter]"];
				}
				else{
					return ["[press enter]"]
				}
			}
			else if(tokens[0] === "define"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "translate"){
				return ["to"];
			}
			else if(tokens[0] === "calculate"){
				return ["[press enter]"]
			}
			else if(tokens[0] === "donate"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "help"){
				return ["[press enter]"];
			}
		}
		else if(tokens.length == x+3){
			if(tokens[0] === "open"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "search"){
				if(tokens[1] === "delivery"){
					return ["[type (in quotes) the city name]"];
				}
				else if(tokens[1] === "weather"){
					return ["[press enter]"];
				}
				else{
					return ["[press enter]"]
				}
			}
			else if(tokens[0] === "define"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "translate"){
				return ["[type the language to translate to]"];
			}
			else if(tokens[0] === "calculate"){
				return ["[press enter]"]
			}
			else if(tokens[0] === "donate"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "help"){
				return ["[press enter]"];
			}
		}
		else if(tokens.length == x+4){
			if(tokens[0] === "open"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "search"){
				if(tokens[1] === "delivery"){
					return ["[type (in quotes) the zip code and press enter]"];
				}
				else if(tokens[1] === "weather"){
					return ["[press enter]"];
				}
				else{
					return ["[press enter]"]
				}
			}
			else if(tokens[0] === "define"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "translate"){
				return ["[type (in quotes) the phrase to translate and press enter]"];
			}
			else if(tokens[0] === "calculate"){
				return ["[press enter]"]
			}
			else if(tokens[0] === "donate"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "help"){
				return ["[press enter]"];
			}
		}
		else if(tokens.length == x+5){
			if(tokens[0] === "open"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "search"){
				if(tokens[1] === "delivery"){
					return ["[press enter]"];
				}
				else if(tokens[1] === "weather"){
					return ["[press enter]"];
				}
				else{
					return ["[press enter]"]
				}
			}
			else if(tokens[0] === "define"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "translate"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "calculate"){
				return ["[press enter]"]
			}
			else if(tokens[0] === "donate"){
				return ["[press enter]"];
			}
			else if(tokens[0] === "help"){
				return ["[press enter]"];
			}
		}
		else if(tokens.length > x+5){
			return ["[press enter]"];
		}
		else{
			return [
				/*
"open",
				"search",
				"translate",
				"define",
				"calculate",
				"about",
				"help"
*/
				
			];
		}
	  }
	 }
	
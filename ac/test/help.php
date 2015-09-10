<?php

function printSyntax($command) {
	$syntax = "";

	switch($command) {
		case "open":
			$syntax = "open [site_to_open]";
			break;
		case "search":
			$syntax = "search [site_to_search] \"[search_terms]\"";
			break;
		case "search delivery":
			$syntax = "search delivery to \"[street_addr]\" \"[city]\" \"[zip_code]\"";
			break;
		case "search directions":
			$syntax = "search directions from \"[start_location]\" to \"[end_location]\"";
			break;
		case "search weather":
			$syntax = "search weather for \"[location]\"";
			break;
        case "convert":
			$syntax = "convert this to [target_file_format]";
			break;
        case "headlines":
            $syntax = "headlines";
            break;
		case "define":
			$syntax = "define [word_to_define]";
			break;
		case "translate":
			$syntax = "translate from [from_language] to [to_language] \"[text_to_translate]\"";
			break;
		case "calculate":
			$syntax = "calculate \"[expression]\"";
			break;
		case "donate":
			$syntax = "donate [amount_to_donate]";
			break;
		case "about":
			$syntax = "about";
			break;
		case "help":
			$syntax = "help [command]";
			break;
		default:
			return;
	}

	echo "<tr><td class=returnField style='color:#66FFFF'>$syntax</td></tr>";
}

function printCommandHelp($command) {
	$command = strtolower($command);
	printSyntax($command);

	switch($command) {
		case "open":
			echo "<tr><td class=returnField>Opens the specified site. Available sites:</td></tr>";
			echo "<tr><td class=returnField style='color:#66FF66'>";
			printKeywordsList("keywords/keywords_open.txt");
			echo "</td></tr>";
			break;
		case "search":
			echo "<tr><td class=returnField>Searches the specified site with the given search terms.</td></tr>";
			printQuoteSensitive();
			echo "<tr><td class=returnField>Available sites:</td></tr>";
			echo "<tr><td class=returnField style='color:#99FF99'>delivery, directions, weather</td></tr>";
			echo "<tr><td class=returnField style='color:#66FF66'>";
			printKeywordsList("keywords/keywords_search.txt");
			echo "</td></tr>";
			break;
		case "search delivery":
			echo "<tr><td class=returnField>Searches near the specified address for restaurants that deliver there.</td></tr>";
			printQuoteSensitive();
			break;
		case "search directions":
			echo "<tr><td class=returnField>Searches driving directions from the start location to the end location.</td></tr>";
			printQuoteSensitive();
			break;
		case "search weather":
			echo "<tr><td class=returnField>Searches current weather for the specified location.</td></tr>";
			printQuoteSensitive();
			break;
        case "convert":
			echo "<tr><td class=returnField>Converts the uploaded file to the specified format.</td></tr>";
            echo "<tr><td class=returnField>Available formats:</td></tr>";
            echo "<tr><td class=returnField><span style='color:#6699CC'>Images: </span><span style='color:#66FF66'>";
            printKeywordsList("keywords/keywords_convert_image.txt");
            echo "</span></td></tr>";
            echo "<tr><td class=returnField><span style='color:#6699CC'>Audio: </span><span style='color:#66FF66'>";
            printKeywordsList("keywords/keywords_convert_audio.txt");
            echo "</span></td></tr>";
            echo "<tr><td class=returnField><span style='color:#6699CC'>Video: </span><span style='color:#66FF66'>";
            printKeywordsList("keywords/keywords_convert_video.txt");
            echo "</span></td></tr>";
            echo "<tr><td class=returnField><span style='color:#6699CC'>Documents: </span><span style='color:#66FF66'>";
            printKeywordsList("keywords/keywords_convert_document.txt");
            echo "</span></td></tr>";
            echo "<tr><td class=returnField><span style='color:#6699CC'>eBooks: </span><span style='color:#66FF66'>";
            printKeywordsList("keywords/keywords_convert_ebook.txt");
            echo "</span></td></tr>";
            echo "<tr><td class=returnField><span style='color:#6699CC'>Archives: </span><span style='color:#66FF66'>";
            printKeywordsList("keywords/keywords_convert_archive.txt");
            echo "</span></td></tr>";
			break;
        case "headlines":
            echo "<tr><td class=returnField>Gets the five most-shared articles from the New York Times.</tr></td>";
            break;
		case "define":
			echo "<tr><td class=returnField>Displays the definition of the specified word.</td></tr>";
			break;
		case "translate":
			echo "<tr><td class=returnField>Translates the specified text from the first language to the second.</td></tr>";
			printQuoteSensitive();
			echo "<tr><td class=returnField>Available languages:</td></tr>";
			echo "<tr><td class=returnField style='color:#66FF66'>";
			printKeywordsList("keywords/keywords_translate.txt");
			echo "</td></tr>";
			break;
		case "calculate":
			echo "<tr><td class=returnField>Calculates the specified expression.</td></tr>";
			printQuoteSensitive();
			break;
		case "donate":
			echo "<tr><td class=returnField>Donates the specified amount to butlr.</td></tr>";
			echo "<tr><td class=returnField>Thank you for your support!</td></tr>";
			break;
		case "about":
			echo "<tr><td class=returnField>About butlr and the people behind it.</td></tr>";
			break;
		case "help":
			echo "<tr><td class=returnField>Displays help about the specified command.</td></tr>";
			break;
		default:
			printErrorCommandNotFound($command);
			return;
	}
}

function printErrorSyntax($command) {
	echo "<tr><td class=returnField style='color:#FF3333'>Error: incorrect syntax for \"$command\".</td></tr>";
	echo "<tr><td class=returnField>Did you forget some quotes around a parameter? Valid syntax:</td></tr>";
	printSyntax($command);
}

function printErrorCommandNotFound($command) {
	echo "<tr><td class=returnField style='color:#FF3333'>Error: command \"$command\" not found.</td></tr>";
	echo "<tr><td class=returnField>Type \"help\" to view a list of commands.</td></tr>";
}

function printHelp() {
	echo "<tr><td class=returnField>Type \"help [command] \" to view help on a specific command.</td></tr>";
	echo "<tr><td class=returnField>[example] is a parameter you should fill in (without brackets).</td></tr>";
	echo "<tr><td class=returnField>Available commands:</td></tr>";
	echo "<tr><td class=returnField style='color:#66FF66'>";
	printKeywordsList("keywords/keywords.txt");
	echo "</td></tr>";
}

function printQuoteSensitive() {
	echo "<tr><td class=returnField style='color:#ffab00'>This command is quote-sensitive: don't forget the quotes when necessary!</td></tr>";
}

?>
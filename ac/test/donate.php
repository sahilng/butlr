<!DOCTYPE html>
<html>
<head>
<title>Error</title>
<link rel="stylesheet" type="text" href="donatestyle.css">
</head>
</html>
<body>



<?php

function donate($amount) {
	$amount = str_replace('$', '', str_replace(',', '', $amount));
	if (strlen($amount) > 0 && preg_match("#^([0-9]*)(\.[0-9]{0,2})?$#", $amount)) {
		$amount = (float) $amount;
		if ($amount > 0.00) {
			$key = "sBmKewnu+SQfi8P35uvl1aLnt+vgGqhhygP0kNBZVHV0b6P1k9";
			$secret = "bVZURLT+yPbTGDxVJyRU80HKrGvBcrgdSs9UcqUHs2J79H8Ljp";
	
			$request = <<<JSON
{
	"Key": "$key",
	"Secret": "$secret",
	"AllowFundingSources": "true",
	"AllowGuestCheckout": "true",
	"AdditionalFundingSources": "true",
	"Redirect": "http://www.butlr.me/butlr_private/test/",
	"Callback": "http://www.butlr.me/butlr_private/test/",
	"PurchaseOrder": {
		"DestinationId": "812-339-4897",
		"Shipping": 0.00,
		"Tax": 0.00,
		"Total": $amount,
		"Notes": "Thank you for donating to butlr!",
		"OrderItems": [
			{
				"Description": "Thank you for donating to butlr!",
				"Name": "Donation to butlr",
				"Price": $amount,
				"Quantity": 1
			}
		]
	}
}
JSON;
			$ch = curl_init("https://www.dwolla.com/payment/request");
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
			$response = json_decode(curl_exec($ch), true);
			curl_close($ch);
	
			$checkoutID = $response["CheckoutId"];
			if(isset($checkoutID)) {
				redirect("Location: https://www.dwolla.com/payment/checkout/$checkoutID", true);
			} else {
				echo "<div id=error>Error getting checkout information</div>";
			}
		} else {
			"<div id=error>Error: amount must be greater than $0.00</div>";
		}
	} else {
		echo "<div id=error>Error: amount must be in format 123.45 or $123.45</div>";
	}
}

?>


</body>
</html>
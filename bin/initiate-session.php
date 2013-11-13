<?php

require __DIR__ . "/../src/Document.php";
require __DIR__ . "/../src/Session.php";
require __DIR__ . "/../src/Client.php";

// Check for session file parameter
if (!isset($argv[1])) {
	fprintf(STDERR, "Usage: " . __FILE__ . ": <session-file>\n");
	exit(1);
}

// Create session and client
$session = new \Epsi\BIA\Session();
$client = new \Epsi\BIA\Client($session);

// Step 1 - Enter registration number
fprintf(STDOUT, "Enter registration number: ");
$registrationNumber = (int)fgets(STDIN);
$indices = $client->enterRegistrationNumber('74388799');

// Ask about PIN number digits and phone number
$nth = [1 => "st", 2 => "nd", 3 => "rd", 4 => "th", 5 => "th"];
$digits = [ ];
for ($i = 1; $i <= 3; ++$i) {
	fprintf(STDOUT, "Enter {$indices[$i - 1]}{$nth[$indices[$i - 1]]} digit of your PIN number: ");
	$digits[$i] = (int)fgets(STDIN);
}
fprintf(STDOUT, "Enter 4 last digits of your phone number: ");
$phoneNumber = (int)fgets(STDIN);

// Step 2 - Enter PIN digits and phone number
$client->enterPinDigitsAndPhoneNumber($digits[1], $digits[2], $digits[3], $phoneNumber);

// Save session
$session->save($argv[1]);

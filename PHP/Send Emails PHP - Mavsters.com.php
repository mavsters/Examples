<?php 
//GLOBALS
global $emails;
global $char;
global $email;
global $nickname;
global $priority;
global $subject;
global $message;

//Config	
	//Main
	$from = 	"no-reply@mavsters.com";//Main Mail
	$nickname =	"Mavsters.com";		 	//Name to show
	
	//Contacts
	$emails =	array(
					"youremailaddress@yourdomain.com",
					"email1@example.com"
					);
	//Characters
	$char =		"iso-8859-1"; //iso-8859-1 or uft-8

	//Priority of message
	$priority =	1; //Values: 1 = High, 3 = Normal, 5 = Low

	//Mail
	$subject =	"New Post by Mavsters.com (Nuevo Post)";
	$message =	"This is a Test";

	//Call the method: sendEMails(); for send the emails
	
	
function sendEMails(){
	// Cabecera que especifica que es un HMTL
		$headers = "MIME-Version: 1.0"."\n";
        $headers .= "Content-Type: text/html; charset=\"".$GLOBALS['char']."\""."\n";
		$headers .="From:  ".$GLOBALS['nickname']." <".$GLOBALS['from'].">". "\r\n";
        $headers .= getPriority();
		//Send
		foreach($GLOBALS['emails'] as $email) {
			mail($email, $GLOBALS['subject'], $GLOBALS['message'], $headers);
		}

}
function getPriority(){
	/*
	"X-Priority" (values: 1 to 5- from the highest[1] to lowest[5]),
	"X-MSMail-Priority" (values: High, Normal, or Low),
	"Importance" (values: High, Normal, or Low).
	*/
	$temp="";
	$tempTwo="";
	switch($GLOBALS['priority']){
		case 1:
			$temp =	"1 (Highest)";
			$tempTwo =	"High";
		break;
		case 3:
			$temp =	"3 (Normal)";
			$tempTwo =	"Normal";
		break;
		case 5:
			$temp =	"5 (Lowest)";
			$tempTwo =	"Low";
		break;
	}
        $headers = "X-Priority:".$temp."\n";
        $headers .= "X-MSMail-Priority:".$tempTwo."\n";
        $headers .= "Importance: ".$tempTwo."\n";
		return $headers;
}
<?php 
//GLOBALS
global $DB_NAME;
global $DB_PASSWORD; 
global $DB_HOST; 
global $DB_USER; 
global $DB_QUERY; 
global $Host; 
global $LocationPost; 
global $Title; 
global $Description; 
global $NameFile;
	
//Config
	//Data Base
	$DB_NAME =		'NameDatabase';
	$DB_PASSWORD =	'PasswordDataBase';
	$DB_HOST =		'localhost';
	$DB_USER =		'UserDataBase';
	$DB_QUERY =		"SELECT `title`,`description`,`linkURL` FROM `feed` ORDER BY `fullDate` DESC";
	//Host and Posts
	$Host 	 =		"//".$_SERVER['HTTP_HOST']."/";
	$LocationPost =	"post/";
	//Description Web
	$Title	 =		"Rsss - Feed Mavsters.com";
	$Description =	"Mira todas las publicaciones de Mavsters.com, View all posts by Mavsters.com";
	//Name File
	$NameFile	 =	"rss.xml";
	//Start
	start();
	
	
//Process
function start(){
	$rss="<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
	$rss.='<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
	$rss.='<atom:link href="'.$GLOBALS['Host'].$GLOBALS['NameFile'].'" rel="self" type="application/rss+xml" />';
	$rss.='<channel><title>'.$GLOBALS['Title'].'</title><link>'.$GLOBALS['Host'].'</link><description>'.$GLOBALS['Description'].'</description>';
	$rss.= getAllContent();
	$rss.='</channel></rss>';
	writeAndOpen($rss);
}

function getAllContent(){
	$temp="";
	$result = resultPosts();
	while($datesQuery = mysqli_fetch_array($result)){		
		$temp.="<item>";
		$temp.=' <title>'.$datesQuery['title'].'</title>';
		$temp.='<link>'.$GLOBALS['Host'].$GLOBALS['locationPost'].$datesQuery['linkURL'].'?lang=es</link> ';
		$temp.='<description>'.htmlspecialchars($datesQuery['description'], ENT_QUOTES).'</description> ';	
		$temp.="</item>";
	}
return $temp;
}

function resultPosts(){
	$connection = mysqli_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_NAME']);
	if($connection === false) {
		mysqli_connect_error(); 
	}
	$result= mysqli_query($connection, $GLOBALS['DB_QUERY']) or die(mysql_error());
return $result;
}

function writeAndOpen($rss){
	$file = fopen($GLOBALS['NameFile'], "w+");
	fwrite($file, $rss);
	fclose($file);
	header('Location: '.$GLOBALS['NameFile']); 
}
?>
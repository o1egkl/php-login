<?php
define("API_KEY","");
define("HTTP_SERVER_HOST","localhost");
define("DB_HOST","ec2-107-22-166-233.compute-1.amazonaws.com");
define("DB_NAME", "d7u117at9rn0sp");
define("DB_USER", "jfzwjoocgyrjpc");
define("DB_PASS", "1THGeXjCzH2fiJ9e2zYqJidTkP");
function is_bot(){
	$botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
		"looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
		"Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
		"crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
		"msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
		"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
		"Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
		"Butterfly","Twitturls","Me.dium","Twiceler","Purebot","facebookexternalhit",
		"Yandex","CatchBot","W3C_Validator","Jigsaw","PostRank","Purebot","Twitterbot",
		"Voyager","zelist");

	foreach($botlist as $bot){
		if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false)
		return true;	// Is a bot
	}
	return false;	// Not a bot
}

// get ip
$ip = $_SERVER['REMOTE_ADDR'];
$query_string = $_SERVER['QUERY_STRING'];
$http_referer = $_SERVER['HTTP_REFERER'];
$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
$remote_host = $_SERVER['REMOTE_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$ff = explode('/',$_SERVER['REQUEST_URI']);
$page = $_GET['page'];

// check if it's a bot
if (is_bot())
	$isbot = 1;
else
	$isbot = 0;

// get country and city


include('ip2locationlite.class.php');
//Load the class
$ipLite = new ip2location_lite;
$ipLite->setKey('API_KEY');
 
//Get errors and locations
$locations = $ipLite->getCity($ip);
$errors = $ipLite->getError();
 
//Getting the result
if (!empty($locations) && is_array($locations)) {
  foreach ($locations as $field => $val) {
  	if ($field == 'countryName')
  		$country = $val;
    if ($field == 'cityName')
  		$city = $val;
  }
}

// insert into db
date_default_timezone_set('Asia/Jerusalem');
$date = date("Y-m-d");
$time = date("H:i:s");

$query = "insert into `tracker` (`country`,`city`,`date`, `time`, `ip`, `query_string`, `http_referer`, `http_user_agent`, `isbot`, `page`) 
values ('$country','$city','$date', '$time', '$ip', '$query_string', '$http_referer' ,'$http_user_agent' , $isbot, '$page')";



//pdo
$db_connection =  new PDO('pgsql:host='.DB_HOST.';port=5432;dbname='.DB_NAME.';', DB_USER, DB_PASS);

// if no connection errors (= working database connection)
$sql = "select distinct ip from tracker";
$result = $db_connection->exec($query);
echo $query;

?>
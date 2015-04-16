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
function get_ip() {

	//Just get the headers if we can or else use the SERVER global
	if ( function_exists( 'apache_request_headers' ) ) {

		$headers = apache_request_headers();

	} else {

		$headers = $_SERVER;

	}

	//Get the forwarded IP if it exists
	if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

		$the_ip = $headers['X-Forwarded-For'];

	} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
	) {

		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];

	} else {
			
		$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );

	}

	return $the_ip;

}
// get ip
$ip =  get_ip();
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

$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$city = $details->city;
$country = $details->country;

// insert into db
date_default_timezone_set('Asia/Jerusalem');
$date = date("Y-m-d");
$time = date("H:i:s");

$query = "insert into tracker (country,city,date,time, ip,query_string, http_referer, http_user_agent, isbot, page) 
values ('$country','$city','$date', '$time', '$ip', '$query_string', '$http_referer' ,'$http_user_agent' , $isbot, '$page')";



//pdo
$db_connection =  new PDO('pgsql:host='.DB_HOST.';port=5432;dbname='.DB_NAME.';', DB_USER, DB_PASS);
$result = $db_connection->exec($query);
// if no connection errors (= working database connection)
$sql = "select distinct ip from tracker";
$result = $db_connection->query($sql);
echo $query;

?>
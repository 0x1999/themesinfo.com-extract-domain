<?php
if(!@$argv[1]){
	print "
_______          ____ ________  ________  ________ 
\   _  \ ___  __/_   /   __   \/   __   \/   __   \
/  /_\  \\\  \/  /|   \____    /\____    /\____    /
\  \_/   \>    < |   |  /    /    /    /    /    / 
 \_____  /__/\_ \|___| /____/    /____/    /____/  
       \/      \/                                  
Author	: 0x1999
Date	: 4 September 2018
Name 	: Themesinfo.com domain extractor
Usage 	: php $argv[0] [t/p] [link]
Ex	: php $argv[0] t https://themesinfo.com/betheme-wordpress-template-bq
";
	die;
}
$link=$argv[2];
$opt=$argv[1];
$url=file_get_contents($link);
if($opt == "t"){
	$tp=str_replace(" ", "",ambilKata($url,"Theme Used on:</td><td class=\"theme_td2\">","websites</td>"));
	$tm=str_replace(" ", "",ambilKata($url,"Theme Name:</td><td class=\"theme_td2 text_bold\">","</td></tr><tr><td class=\"theme_td\">"));
	$p=round($tp/24);
	echo "
	Link		: $link
	Theme Name	: $tm
	Total Domain	: $tp
	Total Page	: $p
	";
	foreach (range(1,$p) as $d) {
		ambilDomain($link."/$d/",$tm);
		echo "\r\n-------------------------------------\r\n";
		echo "Total Domain : $tp\r\n";
		echo "Grabbing $tm > $tm.txt\r\n";
		echo "Page $d - $p Done\r\n";
		echo "\r\n-------------------------------------\r\n";
	}
}elseif($opt == "p"){
	$tp=str_replace(" ", "",ambilKata($url,"<span class=\"photo-cnt plugin_title_img\"><span><b>","websites</b>"));
	$tm=str_replace(" ", "",ambilKata($url,"<title>Free WordPress ","plugin by"));
	$p=round($tp/24);
	echo "
	Link		: $link
	Plugin Name	: $tm
	Total Domain	: $tp
	Total Page	: $p
	";
	foreach (range(1,$p) as $d) {
		ambilDomain($link."/$d/",$tm);
		echo "\r\n-------------------------------------\r\n";
		echo "Total Domain : $tp\r\n";
		echo "Grabbing $tm > $tm.txt\r\n";
		echo "Page $d - $p Done\r\n";
		echo "\r\n-------------------------------------\r\n";
	}
}else{
	echo "KONTOL";
}
function ambilKata($param, $kata1, $kata2)
{
    if (strpos($param, $kata1) === false) {
        return false;
    }
    if (strpos($param, $kata2) === false) {
        return false;
    }
    $start  = strpos($param, $kata1) + strlen($kata1);
    $end    = strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}
function ambilDomain($url,$nam)
{
    $urlArray = array();
    $ch       = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $regex  = '|<h2 class="theme_web_h2">(.*?)</h2>|';
    preg_match_all($regex, $result, $parts);
    $links = $parts[1];
    foreach ($links as $link) {
        array_push($urlArray, $link);
    }
    curl_close($ch);
    foreach ($urlArray as $value) {
    	$f=fopen("$nam.txt", "a");
    	fwrite($f, "http://$value/\r\n");
    	fclose($f);
        echo "http://$value\r\n";
    }
}
?>

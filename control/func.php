<?php
function urlEncrypt($str, $secret_key='secret_key', $secret_iv='#@$%^&*()_+=-'){
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 32);

	return str_replace("=", "", base64_encode(
		openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
	);
}


function urlDecrypt($str, $secret_key='secret_key', $secret_iv='#@$%^&*()_+=-')
{
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 32);

	return openssl_decrypt(
		base64_decode($str), "AES-256-CBC", $key, 0, $iv
	);
}

function str_replace_first($search, $replace, $subject)
{
	$search = '/'.preg_quote($search, '/').'/';
	return preg_replace($search, $replace, $subject, 1);
}

function grequests($url,$header) {
	$ch = curl_init();
	$timeout = 10;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function EthPrice2() {
	$url="https://pro-api.coinmarketcap.com/v1/tools/price-conversion";
	$content="?symbol=ETH&amount=1&convert=USD";
	$url.=$content;
	$header=array(
		"Content-type: application/json",
		"X-CMC_PRO_API_KEY: [API_KEY]",
	);
	$result=grequests($url,$header);
	$res=json_decode($result,true);
	return $res['data']['quote']['USD']['price'];
}

function BNBPrice2() {
	$url="https://pro-api.coinmarketcap.com/v1/tools/price-conversion";
	$content="?symbol=BNB&amount=1&convert=USD";
	$url.=$content;
	$header=array(
		"Content-type: application/json",
		"X-CMC_PRO_API_KEY: [API_KEY]",
	);
	$result=grequests($url,$header);
	$res=json_decode($result,true);
	return $res['data']['quote']['USD']['price'];
}

include "./control/func_tran.php";
function tran( $value, $change=array() ){
	$result = $value;

	if($_SESSION['loc']=='en'){
		$result = tran_en($value);
	}

	if( isset($change[1]) ){
		$result = str_replace($change[0], $change[1], $result);
	}

	return $result;
}

require_once './control/vendor/google-api-client/vendor/autoload.php';
function google_sign_tool(){
    $clientID = '';
	$clientSecret = '';
	$redirectUri = '';

	$client = new Google_Client();
	$client->setClientId($clientID);
	$client->setClientSecret($clientSecret);
	$client->setRedirectUri($redirectUri);
	$client->addScope("email");

    return $client;
}

function apple_sign_link(){
	return '';
}

function getAppleSecret(){
	$r = '{"code":"100"}';
	$debug = true;
	$cmd = 'node jwt_signer.js';

	if($debug){
		$cmd .= " 2>&1";
	}

	$r = shell_exec($cmd);
	$r = json_decode($r, true);
	return $r;
}

function post($url, $fields = array()){
    $post_field_string = http_build_query($fields, '', '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
    curl_setopt($ch, CURLOPT_POST, true);
    $response = curl_exec($ch);
    curl_close ($ch);
    return $response;
}

function call_get($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

function urlToArr($url){
	$json = file_get_contents($url);
    $obj = json_decode($json, true);
    return $obj;
}


function generateRandomString($length = 10) {
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function valid_number($input){    
    $input = strval($input);
    return (bool) preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $input);
}


function mobile_device_check(){
    if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
        $device = "ios";
    } else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
        $device = "ios";
    } else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
        $device = "android";
    } else {
        $device = "None";
    }

    return $device;
}

function cre_codes($key='M'){
	$code = $key."_".rand(100,999)."_".time();

	return $code;
}


function mobileEncrypt($value, $secret_key='secret_key', $secret_iv='#@%^&*()_+=-'){
	$key = substr(hash('sha256', $secret_key), 0, 32);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	return openssl_encrypt($value, 'AES-256-CBC', $key, 0, $iv);
}


function mobileDecrypt($value, $secret_key='secret_key', $secret_iv='#@%^&*()_+=-'){
	$key = substr(hash('sha256', $secret_key), 0, 32);
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	return openssl_decrypt($value, 'AES-256-CBC', $key, 0, $iv);
}


function get_protocol(){
	$isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
	$protocol = "http://";
	if($isSecure){
		$protocol = "https://";
	}
	
	return $protocol;
}

function asset($loc = '') {
	$temp = $_SERVER['HTTP_HOST']."/";
	$protocol = get_protocol();

	$url = $protocol.$temp."assets/".$loc;
	return $url;
}

function getRootUrl(){
	$temp = $_SERVER['HTTP_HOST'];
	$protocol = get_protocol();
	
	$url = $protocol.$temp;
	return $url;
}

function creExcel($arr){

	require_once('./control/vendor/PhpSpreadsheet/vendor/autoload.php');
		
	$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
	$writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

	$sheet = $spreadsheet->getActiveSheet();

	$sheet->fromArray($arr, NULL, 'A1');

	$file_name = generateRandomString(5).'_'.time().'.xlsx';

	$writer->save('./assets/admin/files/'.$file_name);

	return $_SERVER["SCRIPT_URI"].'assets/admin/files/'.$file_name;

}

function hashCheck($hash){
    $check = substr($hash,0,2);
    if($check != "0x"){
        return false;
    }

    $pattern = '/^[a-zA-Z0-9]{66}$/';
    if(!preg_match($pattern ,$hash)){
        return false;
    }

    return true;
}
?>
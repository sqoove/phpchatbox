<?php
/**
 * Set Json Header
*/
header('Content-Type: application/json');

/**
 * Define $token
*/
$token = '<TELEGRAM_TOKEN>';

/**
 * Define $chatid
*/
$chatid = '<TELEGRAM_CHATID>';

/**
 * Define $data
*/
$data = json_decode(file_get_contents('php://input'), true);

/**
 * Define $text
*/
$text = trim($data['message'] ?? '');

/**
 * Define $visitorid
*/
$visitorid = preg_replace('/[^a-z0-9]/i', '', $data['visitorId'] ?? '');

/**
 * Return response
*/
if($text && $visitorid) 
{
    $msg = "[ID:".$visitorid."]\n".$text;
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?".http_build_query(['chat_id' => $chatid, 'text' => $msg]));
    echo json_encode(array());
} 
else 
{
    echo json_encode(['reply' => null]);
}

?>
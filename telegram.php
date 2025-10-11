<?php
/**
 * Define $input
*/
$input = json_decode(file_get_contents('php://input'), true);
file_put_contents("debug.json", json_encode($input, JSON_PRETTY_PRINT));

/**
 * Define $text
*/
$text = $input['message']['text'] ?? '';

/**
 * Define $reply
*/
$reply = $input['message']['reply_to_message']['text'] ?? '';

/**
 * Define $visitorid
*/
$visitorid = null;

/**
 * Define $matches
*/
$matches = [];

/**
 * Pregmatch $visitorid
*/
if(preg_match('/^\[ID:([a-z0-9]+)\]/i', $reply, $matches)) 
{
    $visitorid = $matches[1];
}
elseif(preg_match('/^\[ID:([a-z0-9]+)\]/i', $text, $matches)) 
{
    $visitorid = $matches[1];
}

/**
 * Return response
*/
if($visitorid && $text) 
{
    $log = ['visitor_id' => $visitorid, 'message' => $text, 'timestamp' => time()];
    file_put_contents(__DIR__."/reply-$visitorid.json", json_encode($log));
}

?>
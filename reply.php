<?php
/**
 * Set Json Header
*/
header('Content-Type: application/json');

/**
 * Define $visitorid
*/
$visitorid = preg_replace('/[^a-z0-9]/i', '', $_GET['id'] ?? '');

/**
 * Define $filename
*/
$filename = __DIR__."/reply-$visitorid.json";

/**
 * Return response
*/
if($visitorid && file_exists($filename)) 
{
    $reply = json_decode(file_get_contents($filename), true);
    echo json_encode(['reply' => $reply['message'] ?? null, 'timestamp' => isset($reply['timestamp']) ? (int)$reply['timestamp'] : 0]);
} 
else 
{
    echo json_encode(['reply' => null, 'timestamp' => 0]);
}

?>
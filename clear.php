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
$filename = __DIR__ . "/reply-$visitorid.json";

/**
 * Unlink $filename
*/
if($visitorid && file_exists($filename)) 
{
    unlink($filename);
    echo json_encode(['cleared' => true]);
} 
else 
{
    echo json_encode(['cleared' => false]);
}

?>
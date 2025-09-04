<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Nicht eingeloggt.']);
    exit;
}

// Liest die rohen POST-Daten, da wir ein JSON-Objekt senden
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Ungültige Daten.']);
    exit;
}

$username = $_SESSION['username'];
$dataFile = '../users/' . $username . '/data.json';

file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);
?>
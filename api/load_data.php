<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'Nicht eingeloggt.']);
    exit;
}

$username = $_SESSION['username'];
$dataFile = '../users/' . $username . '/data.json';

if (file_exists($dataFile)) {
    echo file_get_contents($dataFile);
} else {
    echo json_encode([]); // Leeres Array, wenn keine Daten da sind
}
?>
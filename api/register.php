<?php
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Benutzername und Passwort sind erforderlich.']);
    exit;
}

// Sicherheits-Check: Nur alphanumerische Zeichen für den Benutzernamen erlauben
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    echo json_encode(['success' => false, 'message' => 'Benutzername darf nur Buchstaben, Zahlen und Unterstriche enthalten.']);
    exit;
}

$userDir = '../users/' . $username;

if (is_dir($userDir)) {
    echo json_encode(['success' => false, 'message' => 'Benutzername bereits vergeben.']);
    exit;
}

// Ordner für den Nutzer erstellen
mkdir($userDir, 0775);

// Passwort sicher hashen und in einer Datei speichern
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
file_put_contents($userDir . '/user.json', json_encode(['password' => $hashedPassword]));

// Leere Datendatei für Trades erstellen
file_put_contents($userDir . '/data.json', json_encode([]));

echo json_encode(['success' => true]);
?>
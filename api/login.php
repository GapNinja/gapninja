<?php
session_start();
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Benutzername und Passwort sind erforderlich.']);
    exit;
}

$userFile = '../users/' . $username . '/user.json';

if (!file_exists($userFile)) {
    echo json_encode(['success' => false, 'message' => 'Benutzername oder Passwort falsch.']);
    exit;
}

$userData = json_decode(file_get_contents($userFile), true);
$hashedPassword = $userData['password'];

if (password_verify($password, $hashedPassword)) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Benutzername oder Passwort falsch.']);
}
?>
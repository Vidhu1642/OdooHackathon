<?php
require_once 'config.php';

$action = $_REQUEST['action'] ?? '';
$input = getJsonBody();

switch ($action) {
    case 'register':
        $fullName = trim($input['full_name'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');

        if (!$fullName || !$email || !$password) {
            jsonResponse(['success' => false, 'message' => 'Full name, email, and password are required.'], 400);
        }

        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            jsonResponse(['success' => false, 'message' => 'Email already registered.'], 409);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password_hash, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())');
        $stmt->execute([$fullName, $email, $passwordHash]);

        $_SESSION['user_id'] = (int)$pdo->lastInsertId();
        jsonResponse(['success' => true, 'message' => 'Registration completed.', 'user_id' => $_SESSION['user_id']]);
        break;

    case 'login':
        $email = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');

        if (!$email || !$password) {
            jsonResponse(['success' => false, 'message' => 'Email and password are required.'], 400);
        }

        $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            jsonResponse(['success' => false, 'message' => 'Invalid email or password.'], 401);
        }

        $_SESSION['user_id'] = (int)$user['id'];
        jsonResponse(['success' => true, 'message' => 'Login successful.', 'user_id' => $_SESSION['user_id']]);
        break;

    case 'logout':
        session_destroy();
        jsonResponse(['success' => true, 'message' => 'Logged out successfully.']);
        break;

    case 'status':
        if (!empty($_SESSION['user_id'])) {
            jsonResponse(['success' => true, 'authenticated' => true, 'user_id' => $_SESSION['user_id']]);
        }
        jsonResponse(['success' => true, 'authenticated' => false]);
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Unknown auth action.'], 400);
}

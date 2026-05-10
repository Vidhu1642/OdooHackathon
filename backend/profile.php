<?php
require_once 'config.php';
requireLogin();
$input = getJsonBody();
$action = $_REQUEST['action'] ?? 'load';
$userId = currentUserId();

switch ($action) {
    case 'load':
        $stmt = $pdo->prepare('SELECT id, full_name, email, phone, language, bio, avatar, public_profile, email_notifications, dark_mode FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        jsonResponse(['success' => true, 'profile' => $stmt->fetch()]);
        break;

    case 'update':
        $stmt = $pdo->prepare('UPDATE users SET full_name = ?, phone = ?, language = ?, bio = ?, public_profile = ?, email_notifications = ?, dark_mode = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([
            $input['full_name'] ?? null,
            $input['phone'] ?? null,
            $input['language'] ?? 'English',
            $input['bio'] ?? null,
            !empty($input['public_profile']) ? 1 : 0,
            !empty($input['email_notifications']) ? 1 : 0,
            !empty($input['dark_mode']) ? 1 : 0,
            $userId
        ]);
        jsonResponse(['success' => true, 'message' => 'Profile updated successfully.']);
        break;

    case 'delete':
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        session_destroy();
        jsonResponse(['success' => true, 'message' => 'Account deleted successfully.']);
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Unknown profile action.'], 400);
}

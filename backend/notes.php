<?php
require_once 'config.php';
requireLogin();
$input = getJsonBody();
$action = $_REQUEST['action'] ?? 'list';
$userId = currentUserId();

switch ($action) {
    case 'create':
        $title = trim($input['title'] ?? '');
        if (!$title) {
            jsonResponse(['success' => false, 'message' => 'Note title is required.'], 400);
        }

        $stmt = $pdo->prepare('INSERT INTO notes (user_id, trip_id, title, body, tag, last_edited)
            VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $userId,
            $input['trip_id'] ?: null,
            $title,
            $input['body'] ?? null,
            $input['tag'] ?? null
        ]);

        jsonResponse(['success' => true, 'message' => 'Note created successfully.', 'note_id' => $pdo->lastInsertId()]);
        break;

    case 'list':
        $stmt = $pdo->prepare('SELECT * FROM notes WHERE user_id = ? ORDER BY last_edited DESC');
        $stmt->execute([$userId]);
        jsonResponse(['success' => true, 'notes' => $stmt->fetchAll()]);
        break;

    case 'get':
        $noteId = intval($_REQUEST['note_id'] ?? 0);
        $stmt = $pdo->prepare('SELECT * FROM notes WHERE id = ? AND user_id = ?');
        $stmt->execute([$noteId, $userId]);
        jsonResponse(['success' => true, 'note' => $stmt->fetch()]);
        break;

    case 'update':
        $noteId = intval($input['note_id'] ?? 0);
        if (!$noteId) {
            jsonResponse(['success' => false, 'message' => 'Note ID is required.'], 400);
        }

        $stmt = $pdo->prepare('UPDATE notes SET title = ?, body = ?, tag = ?, last_edited = NOW() WHERE id = ? AND user_id = ?');
        $stmt->execute([
            $input['title'] ?? null,
            $input['body'] ?? null,
            $input['tag'] ?? null,
            $noteId,
            $userId
        ]);

        jsonResponse(['success' => true, 'message' => 'Note updated successfully.']);
        break;

    case 'delete':
        $noteId = intval($input['note_id'] ?? 0);
        if (!$noteId) {
            jsonResponse(['success' => false, 'message' => 'Note ID is required.'], 400);
        }

        $stmt = $pdo->prepare('DELETE FROM notes WHERE id = ? AND user_id = ?');
        $stmt->execute([$noteId, $userId]);

        jsonResponse(['success' => true, 'message' => 'Note deleted successfully.']);
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Unknown note action.'], 400);
}

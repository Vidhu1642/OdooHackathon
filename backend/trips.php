<?php
require_once 'config.php';
requireLogin();
$input = getJsonBody();
$action = $_REQUEST['action'] ?? 'list';
$userId = currentUserId();

switch ($action) {
    case 'create':
        $name = trim($input['name'] ?? '');
        if (!$name) {
            jsonResponse(['success' => false, 'message' => 'Trip name is required.'], 400);
        }

        $stmt = $pdo->prepare('INSERT INTO trips (user_id, name, destination, start_date, end_date, travelers, budget, description, cover_photo, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
        $stmt->execute([
            $userId,
            $name,
            $input['destination'] ?? null,
            $input['start_date'] ?: null,
            $input['end_date'] ?: null,
            intval($input['travelers'] ?? 1),
            floatval($input['budget'] ?? 0),
            $input['description'] ?? null,
            $input['cover_photo'] ?? null,
            $input['status'] ?? 'Upcoming'
        ]);

        jsonResponse(['success' => true, 'message' => 'Trip created successfully.', 'trip_id' => $pdo->lastInsertId()]);
        break;

    case 'list':
        $stmt = $pdo->prepare('SELECT * FROM trips WHERE user_id = ? ORDER BY updated_at DESC');
        $stmt->execute([$userId]);
        jsonResponse(['success' => true, 'trips' => $stmt->fetchAll()]);
        break;

    case 'get':
        $tripId = intval($_REQUEST['trip_id'] ?? 0);
        $stmt = $pdo->prepare('SELECT * FROM trips WHERE id = ? AND user_id = ?');
        $stmt->execute([$tripId, $userId]);
        $trip = $stmt->fetch();
        jsonResponse(['success' => true, 'trip' => $trip]);
        break;

    case 'update':
        $tripId = intval($input['trip_id'] ?? 0);
        if (!$tripId) {
            jsonResponse(['success' => false, 'message' => 'Trip ID is required.'], 400);
        }

        $stmt = $pdo->prepare('UPDATE trips SET name = ?, destination = ?, start_date = ?, end_date = ?, travelers = ?, budget = ?, description = ?, cover_photo = ?, status = ?, updated_at = NOW() WHERE id = ? AND user_id = ?');
        $stmt->execute([
            $input['name'] ?? null,
            $input['destination'] ?? null,
            $input['start_date'] ?: null,
            $input['end_date'] ?: null,
            intval($input['travelers'] ?? 1),
            floatval($input['budget'] ?? 0),
            $input['description'] ?? null,
            $input['cover_photo'] ?? null,
            $input['status'] ?? 'Upcoming',
            $tripId,
            $userId
        ]);

        jsonResponse(['success' => true, 'message' => 'Trip updated successfully.']);
        break;

    case 'delete':
        $tripId = intval($input['trip_id'] ?? 0);
        if (!$tripId) {
            jsonResponse(['success' => false, 'message' => 'Trip ID is required.'], 400);
        }

        $stmt = $pdo->prepare('DELETE FROM trips WHERE id = ? AND user_id = ?');
        $stmt->execute([$tripId, $userId]);

        jsonResponse(['success' => true, 'message' => 'Trip deleted successfully.']);
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Unknown trip action.'], 400);
}

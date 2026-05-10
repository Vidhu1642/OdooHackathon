<?php
require_once 'config.php';
requireLogin();
$input = getJsonBody();
$action = $_REQUEST['action'] ?? 'get';
$userId = currentUserId();

switch ($action) {
    case 'save':
        $tripId = !empty($input['trip_id']) ? intval($input['trip_id']) : null;
        $stmt = $pdo->prepare('SELECT id FROM budgets WHERE user_id = ? AND trip_id = ?');
        $stmt->execute([$userId, $tripId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $stmt = $pdo->prepare('UPDATE budgets SET total_budget = ?, spent_amount = ?, notes = ?, updated_at = NOW() WHERE id = ?');
            $stmt->execute([
                floatval($input['total_budget'] ?? 0),
                floatval($input['spent_amount'] ?? 0),
                $input['notes'] ?? null,
                $existing['id']
            ]);
            jsonResponse(['success' => true, 'message' => 'Budget updated successfully.']);
            break;
        }

        $stmt = $pdo->prepare('INSERT INTO budgets (user_id, trip_id, total_budget, spent_amount, notes, updated_at) VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $userId,
            $tripId,
            floatval($input['total_budget'] ?? 0),
            floatval($input['spent_amount'] ?? 0),
            $input['notes'] ?? null
        ]);
        jsonResponse(['success' => true, 'message' => 'Budget saved successfully.', 'budget_id' => $pdo->lastInsertId()]);
        break;

    case 'get':
        $tripId = !empty($_REQUEST['trip_id']) ? intval($_REQUEST['trip_id']) : null;
        $stmt = $pdo->prepare('SELECT * FROM budgets WHERE user_id = ? AND trip_id = ?');
        $stmt->execute([$userId, $tripId]);
        jsonResponse(['success' => true, 'budget' => $stmt->fetch()]);
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Unknown budget action.'], 400);
}

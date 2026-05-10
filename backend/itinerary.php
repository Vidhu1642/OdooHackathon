<?php
require_once 'config.php';
requireLogin();
$input = getJsonBody();
$action = $_REQUEST['action'] ?? 'load';
$userId = currentUserId();

switch ($action) {
    case 'save':
        $tripId = !empty($input['trip_id']) ? intval($input['trip_id']) : null;
        $title = trim($input['title'] ?? '');
        $summary = trim($input['summary'] ?? '');
        $publicToken = bin2hex(random_bytes(16));

        $stmt = $pdo->prepare('INSERT INTO itineraries (user_id, trip_id, title, summary, public_token, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');
        $stmt->execute([$userId, $tripId, $title, $summary, $publicToken]);
        $itineraryId = intval($pdo->lastInsertId());

        if (!empty($input['stops']) && is_array($input['stops'])) {
            $order = 0;
            $stopStmt = $pdo->prepare('INSERT INTO itinerary_stops (itinerary_id, city, arrival_date, departure_date, ordering) VALUES (?, ?, ?, ?, ?)');
            $activityStmt = $pdo->prepare('INSERT INTO itinerary_activities (stop_id, title, description, duration, cost, ordering) VALUES (?, ?, ?, ?, ?, ?)');
            foreach ($input['stops'] as $stop) {
                $stopStmt->execute([
                    $itineraryId,
                    $stop['city'] ?? '',
                    $stop['arrival_date'] ?: null,
                    $stop['departure_date'] ?: null,
                    $order
                ]);
                $stopId = intval($pdo->lastInsertId());
                if (!empty($stop['activities']) && is_array($stop['activities'])) {
                    $activityOrder = 0;
                    foreach ($stop['activities'] as $activity) {
                        $activityStmt->execute([
                            $stopId,
                            $activity['title'] ?? '',
                            $activity['description'] ?? null,
                            $activity['duration'] ?? null,
                            floatval($activity['cost'] ?? 0),
                            $activityOrder
                        ]);
                        $activityOrder++;
                    }
                }
                $order++;
            }
        }

        jsonResponse(['success' => true, 'message' => 'Itinerary saved successfully.', 'itinerary_id' => $itineraryId, 'public_token' => $publicToken]);
        break;

    case 'load':
        $itineraryId = intval($_REQUEST['itinerary_id'] ?? 0);
        $stmt = $pdo->prepare('SELECT * FROM itineraries WHERE id = ? AND user_id = ?');
        $stmt->execute([$itineraryId, $userId]);
        $itinerary = $stmt->fetch();
        if (!$itinerary) {
            jsonResponse(['success' => false, 'message' => 'Itinerary not found.'], 404);
        }
        $stops = $pdo->prepare('SELECT * FROM itinerary_stops WHERE itinerary_id = ? ORDER BY ordering ASC');
        $stops->execute([$itineraryId]);
        $stops = $stops->fetchAll();
        foreach ($stops as &$stop) {
            $activities = $pdo->prepare('SELECT * FROM itinerary_activities WHERE stop_id = ? ORDER BY ordering ASC');
            $activities->execute([$stop['id']]);
            $stop['activities'] = $activities->fetchAll();
        }
        jsonResponse(['success' => true, 'itinerary' => $itinerary, 'stops' => $stops]);
        break;

    case 'share':
        $token = trim($_REQUEST['token'] ?? '');
        if (!$token) {
            jsonResponse(['success' => false, 'message' => 'Token required.'], 400);
        }
        $stmt = $pdo->prepare('SELECT * FROM itineraries WHERE public_token = ?');
        $stmt->execute([$token]);
        $itinerary = $stmt->fetch();
        if (!$itinerary) {
            jsonResponse(['success' => false, 'message' => 'Public itinerary not found.'], 404);
        }
        $stops = $pdo->prepare('SELECT * FROM itinerary_stops WHERE itinerary_id = ? ORDER BY ordering ASC');
        $stops->execute([$itinerary['id']]);
        $stops = $stops->fetchAll();
        foreach ($stops as &$stop) {
            $activities = $pdo->prepare('SELECT * FROM itinerary_activities WHERE stop_id = ? ORDER BY ordering ASC');
            $activities->execute([$stop['id']]);
            $stop['activities'] = $activities->fetchAll();
        }
        jsonResponse(['success' => true, 'itinerary' => $itinerary, 'stops' => $stops]);
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Unknown itinerary action.'], 400);
}

<?php
require_once 'config.php';
requireLogin();

$action = $_REQUEST['action'] ?? 'stats';

if ($action === 'delete_user') {
    $input = getJsonBody();
    $userId = intval($input['user_id'] ?? 0);
    if (!$userId) {
        jsonResponse(['success' => false, 'message' => 'User ID is required.'], 400);
    }
    if ($userId === intval(currentUserId())) {
        jsonResponse(['success' => false, 'message' => 'You cannot delete your own account from admin.'], 400);
    }
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    jsonResponse(['success' => true, 'message' => 'User deleted successfully.']);
}

$stmt = $pdo->query('SELECT COUNT(*) AS total_users FROM users');
$users = $stmt->fetch();
$stmt = $pdo->query('SELECT COUNT(*) AS total_trips FROM trips');
$trips = $stmt->fetch();
$stmt = $pdo->query('SELECT COUNT(*) AS total_itineraries FROM itineraries');
$itineraries = $stmt->fetch();
$stmt = $pdo->query('SELECT COUNT(*) AS total_notes FROM notes');
$notes = $stmt->fetch();
$stmt = $pdo->query('SELECT SUM(budget) AS total_budget FROM trips');
$totalBudget = $stmt->fetch();
$stmt = $pdo->query('SELECT location, COUNT(*) AS count FROM activities_catalog GROUP BY location ORDER BY count DESC LIMIT 10');
$popularLocations = $stmt->fetchAll();
$stmt = $pdo->query('
    SELECT u.id, u.full_name AS name, u.email, COUNT(t.id) AS trip_count
    FROM users u
    LEFT JOIN trips t ON t.user_id = u.id
    GROUP BY u.id, u.full_name, u.email
    ORDER BY u.updated_at DESC
    LIMIT 20
');
$recentUsers = $stmt->fetchAll();

jsonResponse([
    'success' => true,
    'users' => array_map(function ($user) {
        $user['active'] = true;
        $user['trip_count'] = intval($user['trip_count']);
        return $user;
    }, $recentUsers),
    'stats' => [
        'users' => intval($users['total_users']),
        'trips' => intval($trips['total_trips']),
        'itineraries' => intval($itineraries['total_itineraries']),
        'notes' => intval($notes['total_notes']),
        'total_budget' => floatval($totalBudget['total_budget']),
        'popular_locations' => $popularLocations
    ]
]);

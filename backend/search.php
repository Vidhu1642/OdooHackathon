<?php
require_once 'config.php';
requireLogin();
$query = trim($_REQUEST['q'] ?? '');
$userId = currentUserId();

$results = [
    'trips' => [],
    'activities' => []
];

if ($query !== '') {
    $stmt = $pdo->prepare('SELECT * FROM trips WHERE user_id = ? AND (name LIKE ? OR destination LIKE ? OR description LIKE ?) ORDER BY updated_at DESC');
    $term = "%$query%";
    $stmt->execute([$userId, $term, $term, $term]);
    $results['trips'] = $stmt->fetchAll();

    $stmt = $pdo->prepare('SELECT * FROM activities_catalog WHERE name LIKE ? OR category LIKE ? OR location LIKE ? OR description LIKE ? ORDER BY created_at DESC LIMIT 50');
    $stmt->execute([$term, $term, $term, $term]);
    $results['activities'] = $stmt->fetchAll();
}

jsonResponse(['success' => true, 'results' => $results]);

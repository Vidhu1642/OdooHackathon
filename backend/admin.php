<?php
require_once 'config.php';
requireLogin();

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

jsonResponse([
    'success' => true,
    'stats' => [
        'users' => intval($users['total_users']),
        'trips' => intval($trips['total_trips']),
        'itineraries' => intval($itineraries['total_itineraries']),
        'notes' => intval($notes['total_notes']),
        'total_budget' => floatval($totalBudget['total_budget']),
        'popular_locations' => $popularLocations
    ]
]);

<?php
/**
 * Search Suggestion API Handler
 * Returns categorized autocomplete results for properties, services, pros, and cities.
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../data.php';

header('Content-Type: application/json; charset=utf-8');

$query = trim($_GET['q'] ?? '');
$type = strtolower(trim($_GET['type'] ?? 'all'));

if (strlen($query) < 1) {
    echo json_encode([
        'query' => $query,
        'properties' => [],
        'services' => [],
        'professionals' => [],
        'cities' => [],
    ]);
    exit;
}

$qLower = mb_strtolower($query);

// 1. Search Properties
$allProps = properties();
$matchedProps = [];
foreach ($allProps as $p) {
    $searchable = mb_strtolower($p['title'] . ' ' . $p['location'] . ' ' . $p['city'] . ' ' . $p['type'] . ' ' . $p['furnishing'] . ' ' . implode(' ', $p['amenities']));
    
    // Check tab filter if specified
    if ($type === 'buy' && strtolower($p['listing']) !== 'buy') {
        continue;
    }
    if ($type === 'rent' && strtolower($p['listing']) !== 'rent') {
        continue;
    }

    if (str_contains($searchable, $qLower)) {
        $matchedProps[] = [
            'id' => $p['id'],
            'title' => $p['title'],
            'location' => $p['location'],
            'city' => $p['city'],
            'priceLabel' => $p['priceLabel'],
            'listing' => $p['listing'],
            'type' => $p['type'],
            'image' => $p['image'],
            'url' => url('/properties?q=' . rawurlencode($p['title']) . '&listing=' . rawurlencode($p['listing'])),
        ];
    }
}

// 2. Search Services
$allServices = service_categories();
$matchedServices = [];
foreach ($allServices as $s) {
    $searchable = mb_strtolower($s['name'] . ' ' . $s['id']);
    if (str_contains($searchable, $qLower)) {
        $matchedServices[] = [
            'id' => $s['id'],
            'name' => $s['name'],
            'icon' => $s['icon'],
            'start' => $s['start'],
            'rating' => $s['rating'],
            'image' => $s['image'] ?? '',
            'url' => url('/services?q=' . rawurlencode($s['name'])),
        ];
    }
}

// 3. Search Professionals
$allPros = professionals();
$matchedPros = [];
foreach ($allPros as $pr) {
    $searchable = mb_strtolower($pr['name'] . ' ' . $pr['role'] . ' ' . $pr['location'] . ' ' . implode(' ', $pr['skills']));
    if (str_contains($searchable, $qLower)) {
        $matchedPros[] = [
            'id' => $pr['id'],
            'name' => $pr['name'],
            'role' => $pr['role'],
            'location' => $pr['location'],
            'avatar' => $pr['avatar'] ?? '',
            'rating' => $pr['rating'],
            'url' => url('/professionals?q=' . rawurlencode($pr['name'])),
        ];
    }
}

// 4. Search Cities / Locations
$allCities = cities();
$matchedCities = [];
foreach ($allCities as $c) {
    if (str_contains(mb_strtolower($c), $qLower)) {
        $matchedCities[] = [
            'name' => $c,
            'url' => url('/properties?city=' . rawurlencode($c)),
        ];
    }
}

echo json_encode([
    'query' => $query,
    'properties' => array_slice($matchedProps, 0, 4),
    'services' => array_slice($matchedServices, 0, 3),
    'professionals' => array_slice($matchedPros, 0, 3),
    'cities' => array_slice($matchedCities, 0, 3),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

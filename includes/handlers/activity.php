<?php
/**
 * User Activity API Handler — Favorites and Bookings
 */
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json; charset=utf-8');

$action = trim($_GET['action'] ?? '');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$raw = preg_replace('/^\xEF\xBB\xBF/', '', (string)$raw);
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

// --------------------------------------------------------------------------
// TOGGLE FAVORITE PROPERTY
// --------------------------------------------------------------------------
if ($action === 'toggle-favorite') {
    if (!is_logged_in()) {
        http_response_code(401);
        echo json_encode([
            'success'       => false,
            'requires_auth' => true,
            'message'       => 'Please sign in or create an account to save properties to your dashboard.',
            'redirect'      => '/login'
        ]);
        exit;
    }

    $propId = trim((string)($data['prop_id'] ?? ''));
    if ($propId === '') {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => 'Invalid property ID']);
        exit;
    }

    $res = toggle_user_saved_property($propId);
    echo json_encode([
        'success' => true,
        'saved'   => $res['saved'],
        'count'   => $res['count'],
        'message' => $res['saved'] ? 'Property added to your Saved Homes!' : 'Property removed from Saved Homes.'
    ]);
    exit;
}

// --------------------------------------------------------------------------
// ADD SERVICE BOOKING OR VISIT REQUEST
// --------------------------------------------------------------------------
if ($action === 'add-booking') {
    $booking = add_user_booking([
        'prop_id'  => $data['prop_id'] ?? null,
        'title'    => trim((string)($data['title'] ?? 'Site Visit Request')),
        'type'     => trim((string)($data['type'] ?? 'site_visit')),
        'location' => trim((string)($data['location'] ?? 'Delhi NCR')),
        'date'     => trim((string)($data['date'] ?? date('Y-m-d'))),
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Request registered and added to your dashboard!',
        'booking' => $booking
    ]);
    exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Unknown action']);

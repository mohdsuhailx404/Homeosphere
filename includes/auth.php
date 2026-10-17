<?php
/**
 * Homeosphere - Authentication & User Session Manager
 */

if (session_status() === PHP_SESSION_NONE) {
    if (is_dir('/tmp') && is_writable('/tmp')) {
        @session_save_path('/tmp');
    }
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    @session_start();
}

/**
 * Get the currently logged-in user array, or null if guest.
 */
function current_user(): ?array {
    return $_SESSION['homeosphere_user'] ?? null;
}

/**
 * Check if a user is currently logged in.
 */
function is_logged_in(): bool {
    return current_user() !== null;
}

/**
 * Log in a user and set their session state.
 */
function login_user(array $user): void {
    $_SESSION['homeosphere_user'] = [
        'id'         => $user['id'] ?? ('usr_' . time() . '_' . bin2hex(random_bytes(3))),
        'name'       => trim($user['name'] ?? 'Homeosphere User'),
        'email'      => strtolower(trim($user['email'] ?? '')),
        'phone'      => trim($user['phone'] ?? ''),
        'role'       => strtolower(trim($user['role'] ?? 'seeker')),
        'city'       => trim($user['city'] ?? 'Delhi NCR'),
        'created_at' => $user['created_at'] ?? date('Y-m-d H:i:s'),
    ];
}

/**
 * Log out the current user and clear their session.
 */
function logout_user(): void {
    unset($_SESSION['homeosphere_user']);
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }
}

/**
 * Format a human-friendly role label.
 */
function role_label(string $role): string {
    switch (strtolower(trim($role))) {
        case 'professional':
        case 'pro':
            return 'Verified Professional';
        case 'owner':
        case 'seller':
        case 'landlord':
            return 'Property Owner';
        case 'seeker':
        case 'buyer':
        case 'tenant':
        default:
            return 'Home Seeker';
    }
}

/**
 * Get monogram initials for the user's avatar circle (single letter of first name).
 */
function user_initials(string $name): string {
    $name = trim($name);
    if ($name === '') return 'U';
    return strtoupper(mb_substr($name, 0, 1));
}

/**
 * Retrieve user activity (saved properties & bookings)
 */
function get_user_activity(?string $userId = null): array {
    if (!$userId) {
        $u = current_user();
        if (!$u) return ['saved_properties' => [], 'bookings' => []];
        $userId = $u['id'];
    }
    $file = __DIR__ . '/../data/user_activity.json';
    if (!file_exists($file)) return ['saved_properties' => [], 'bookings' => []];
    $all = json_decode((string)@file_get_contents($file), true) ?: [];
    return $all[$userId] ?? ['saved_properties' => [], 'bookings' => []];
}

/**
 * Save updated user activity
 */
function save_user_activity(string $userId, array $data): void {
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) @mkdir($dir, 0777, true);
    $file = $dir . '/user_activity.json';
    $all = [];
    if (file_exists($file)) {
        $all = json_decode((string)@file_get_contents($file), true) ?: [];
    }
    $all[$userId] = $data;
    @file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT));
}

/**
 * Check if current user has saved a specific property ID
 */
function user_has_saved_property(string $propId): bool {
    if (!is_logged_in()) return false;
    $act = get_user_activity();
    return in_array((string)$propId, array_map('strval', $act['saved_properties'] ?? []));
}

/**
 * Toggle saving a property for the current user
 */
function toggle_user_saved_property(string $propId): array {
    $u = current_user();
    if (!$u) return ['saved' => false, 'count' => 0, 'error' => 'Not authenticated'];
    $act = get_user_activity($u['id']);
    $saved = array_map('strval', $act['saved_properties'] ?? []);
    $strId = (string)$propId;
    if (in_array($strId, $saved)) {
        $saved = array_values(array_diff($saved, [$strId]));
        $isNowSaved = false;
    } else {
        $saved[] = $strId;
        $isNowSaved = true;
    }
    $act['saved_properties'] = $saved;
    save_user_activity($u['id'], $act);
    return ['saved' => $isNowSaved, 'count' => count($saved)];
}

/**
 * Add a booking or visit request for the user
 */
function add_user_booking(array $booking): array {
    $u = current_user();
    $userId = $u ? $u['id'] : ('guest_' . session_id());
    $act = get_user_activity($userId);
    $bookings = $act['bookings'] ?? [];
    $newBooking = [
        'id'          => 'bk_' . time() . '_' . bin2hex(random_bytes(2)),
        'prop_id'     => $booking['prop_id'] ?? null,
        'title'       => $booking['title'] ?? 'Service Request',
        'type'        => $booking['type'] ?? 'site_visit',
        'location'    => $booking['location'] ?? 'Delhi NCR',
        'date'        => $booking['date'] ?? date('Y-m-d'),
        'status'      => 'Scheduled',
        'specialist'  => 'Assigned Homeosphere Advisor',
        'created_at'  => date('Y-m-d H:i:s'),
    ];
    array_unshift($bookings, $newBooking);
    $act['bookings'] = $bookings;
    save_user_activity($userId, $act);
    return $newBooking;
}

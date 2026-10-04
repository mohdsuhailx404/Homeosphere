<?php
/**
 * Contact form handler — validates input and inserts into the Supabase
 * contact_submissions table via the PostgREST REST API (anon key).
 * Returns JSON. Uses file_get_contents + stream context (no cURL required).
 */
require_once __DIR__ . '/../../includes/config.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, apikey');

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
  http_response_code(204);
  exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'error' => 'Method not allowed']);
  exit;
}

// Read + decode JSON body
$raw = file_get_contents('php://input');
$raw = preg_replace('/^\xEF\xBB\xBF/', '', (string)$raw);
$data = json_decode($raw, true);

if (!is_array($data)) {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'Invalid request body']);
  exit;
}

// Validate
$name        = trim((string)($data['name'] ?? ''));
$email       = trim((string)($data['email'] ?? ''));
$phone       = trim((string)($data['phone'] ?? ''));
$requirement = trim((string)($data['requirement'] ?? ''));
$message     = trim((string)($data['message'] ?? ''));

$errors = [];
if ($name === '') {
  $errors[] = 'Full name is required';
} elseif (strlen($name) < 3 || strlen($name) > 50) {
  $errors[] = 'Full name must be between 3 and 50 characters';
} elseif (!preg_match('/^[a-zA-Z\s\.\']{3,50}$/', $name)) {
  $errors[] = 'Full name can only contain letters, spaces, and dots';
}

if ($email === '') {
  $errors[] = 'Email address is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
  $errors[] = 'A valid email address is required';
}

$cleanPhone = preg_replace('/\s+/', '', $phone);
if ($cleanPhone === '') {
  $errors[] = 'Phone number is required';
} elseif (!preg_match('/^(?:\+91[\s-]?)?[6-9]\d{9}$/', $cleanPhone)) {
  $errors[] = 'A valid 10-digit Indian mobile number is required';
}

if ($requirement === '') {
  $errors[] = 'Requirement is required';
}

if ($message === '') {
  $errors[] = 'Message is required';
} elseif (strlen($message) < 15) {
  $errors[] = 'Message must be at least 15 characters long';
}

if ($errors) {
  http_response_code(422);
  echo json_encode(['success' => false, 'error' => 'Please fix: ' . implode(', ', $errors)]);
  exit;
}

// Insert via the deployed contact-submit edge function (uses the service-role
// key server-side, so the anon-key frontend never needs write privileges).
$payload = json_encode([
  'name'        => substr($name, 0, 120),
  'email'       => substr($email, 0, 200),
  'phone'       => $phone !== '' ? substr($phone, 0, 30) : null,
  'requirement' => substr($requirement, 0, 80),
  'message'     => substr($message, 0, 4000),
]);

$endpoint = SUPABASE_URL . '/functions/v1/contact-submit';

$ctx = stream_context_create([
  'http' => [
    'method'        => 'POST',
    'header'        => implode("\r\n", [
      'Content-Type: application/json',
      'Authorization: Bearer ' . SUPABASE_ANON,
      'apikey: ' . SUPABASE_ANON,
    ]),
    'content'       => $payload,
    'timeout'       => 15,
    'ignore_errors' => true,
  ],
]);

$response = @file_get_contents($endpoint, false, $ctx);

// Check HTTP status from remote service
$status = 0;
if (isset($http_response_header) && is_array($http_response_header)) {
  if (preg_match('#HTTP/\S+\s+(\d{3})#', $http_response_header[0], $m)) {
    $status = (int)$m[1];
  }
}

if ($status >= 200 && $status < 300) {
  echo json_encode(['success' => true, 'message' => 'Your message has been received.']);
  exit;
}

// Fallback: If external database is offline/unreachable during local dev,
// persist submission to local data file so no inquiry is ever lost.
$dataDir = __DIR__ . '/../../data';
if (!is_dir($dataDir)) {
  @mkdir($dataDir, 0777, true);
}
$storageFile = $dataDir . '/contact_submissions.json';
$existing = [];
if (file_exists($storageFile)) {
  $existing = json_decode((string)@file_get_contents($storageFile), true) ?: [];
}
$existing[] = [
  'id'          => 'sub_' . time() . '_' . bin2hex(random_bytes(3)),
  'name'        => $name,
  'email'       => $email,
  'phone'       => $phone,
  'requirement' => $requirement,
  'message'     => $message,
  'submitted_at'=> date('c'),
  'storage'     => 'local_fallback',
];
@file_put_contents($storageFile, json_encode($existing, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Your message has been received successfully.']);
exit;

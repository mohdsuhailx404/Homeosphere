<?php
/**
 * Authentication API Handler — Login, Registration, and Session Management
 */
require_once __DIR__ . '/../config.php';

$action = trim($_GET['action'] ?? '');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// --------------------------------------------------------------------------
// LOGOUT ACTION
// --------------------------------------------------------------------------
if ($action === 'logout' || str_ends_with($_SERVER['REQUEST_URI'] ?? '', '/logout')) {
    logout_user();
    header('Location: /?logged_out=1');
    exit;
}

header('Content-Type: application/json; charset=utf-8');

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
    echo json_encode(['success' => false, 'error' => 'Invalid JSON request']);
    exit;
}

$dataDir = __DIR__ . '/../../data';
if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0777, true);
}
$usersFile = $dataDir . '/users.json';
$users = [];
if (file_exists($usersFile)) {
    $users = json_decode((string)@file_get_contents($usersFile), true) ?: [];
}

// --------------------------------------------------------------------------
// SIGNUP ACTION
// --------------------------------------------------------------------------
if ($action === 'signup') {
    $name  = trim((string)($data['name'] ?? ''));
    $email = strtolower(trim((string)($data['email'] ?? '')));
    $phone = trim((string)($data['phone'] ?? ''));
    $role  = strtolower(trim((string)($data['role'] ?? 'seeker')));
    $city  = trim((string)($data['city'] ?? 'Delhi NCR'));
    $pass  = (string)($data['password'] ?? '');

    if ($name === '' || $email === '' || $phone === '' || $pass === '') {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    // Check if user already exists
    foreach ($users as $u) {
        $cleanUPhone = preg_replace('/\D/', '', $u['phone'] ?? '');
        $cleanNewPhone = preg_replace('/\D/', '', $phone);
        $phoneMatch = ($cleanUPhone !== '' && $cleanNewPhone !== '' && substr($cleanUPhone, -10) === substr($cleanNewPhone, -10));

        if (strtolower($u['email']) === $email || $phoneMatch) {
            http_response_code(409);
            echo json_encode([
                'success' => false,
                'error'   => 'An account with this email address or mobile number already exists. Please sign in instead.'
            ]);
            exit;
        }
    }

    // Create new user record with secure password hash
    $newUser = [
        'id'            => 'usr_' . time() . '_' . bin2hex(random_bytes(3)),
        'name'          => $name,
        'email'         => $email,
        'phone'         => $phone,
        'role'          => $role,
        'city'          => $city ?: 'Delhi NCR',
        'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
        'created_at'    => date('Y-m-d H:i:s'),
    ];

    $users[] = $newUser;
    @file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

    login_user($newUser);

    echo json_encode([
        'success'  => true,
        'message'  => 'Account created successfully!',
        'user'     => current_user(),
        'redirect' => '/dashboard?welcome=1',
    ]);
    exit;
}

// --------------------------------------------------------------------------
// LOGIN ACTION (STRICT VERIFICATION)
// --------------------------------------------------------------------------
if ($action === 'login') {
    $identifier = strtolower(trim((string)($data['identifier'] ?? '')));
    $pass       = (string)($data['password'] ?? '');

    if ($identifier === '' || $pass === '') {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => 'Identifier and password are required.']);
        exit;
    }

    // 1. Cross-check if account exists in database
    $matchedUser = null;
    $matchedIndex = -1;
    foreach ($users as $idx => $u) {
        $cleanUPhone = preg_replace('/\D/', '', $u['phone'] ?? '');
        $cleanIdPhone = preg_replace('/\D/', '', $identifier);
        $phoneMatch = ($cleanUPhone !== '' && $cleanIdPhone !== '' && substr($cleanUPhone, -10) === substr($cleanIdPhone, -10));

        if (strtolower($u['email'] ?? '') === $identifier || $phoneMatch) {
            $matchedUser = $u;
            $matchedIndex = $idx;
            break;
        }
    }

    // STRICT CHECK: Reject if user has never signed up
    if (!$matchedUser) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error'   => 'No account found with this email or mobile number. Please create an account first.'
        ]);
        exit;
    }

    // 2. Strict password verification against stored password hash
    if (!empty($matchedUser['password_hash'])) {
        if (!password_verify($pass, $matchedUser['password_hash'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error'   => 'Incorrect password. Please verify your credentials and try again.'
            ]);
            exit;
        }
    } else {
        // Upgrade legacy test user with hashed password on first verified signin
        $users[$matchedIndex]['password_hash'] = password_hash($pass, PASSWORD_DEFAULT);
        @file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    }

    // 3. Establish authenticated session
    login_user($matchedUser);

    echo json_encode([
        'success'  => true,
        'message'  => 'Logged in successfully!',
        'user'     => current_user(),
        'redirect' => '/dashboard',
    ]);
    exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Invalid action']);

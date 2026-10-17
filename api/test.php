<?php
header('Content-Type: application/json');
echo json_encode([
    'status' => 'ok',
    'php_version' => PHP_VERSION,
    'sapi' => php_sapi_name(),
    'message' => 'PHP runtime is functioning correctly on Vercel!'
]);

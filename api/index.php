<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Ensure sessions use /tmp in serverless Lambda environments
if (is_dir('/tmp') && is_writable('/tmp')) {
    session_save_path('/tmp');
}

register_shutdown_function(function() {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: text/html; charset=utf-8');
        echo "<h2>Homeosphere Server Error</h2>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($err['message']) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($err['file']) . " (Line " . $err['line'] . ")</p>";
    }
});

try {
    // Set working directory to the project root
    $rootDir = dirname(__DIR__);
    chdir($rootDir);

    // Forward all requests to the application router
    require_once $rootDir . '/router.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h2>Homeosphere Uncaught Exception</h2>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

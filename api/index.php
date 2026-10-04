<?php
// Set working directory to the project root
chdir(dirname(__DIR__));

// Forward all requests to the application router
require __DIR__ . '/../router.php';

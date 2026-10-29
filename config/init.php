<?php
    declare(strict_types=1);

    ini_set(option:'display_errors', value: 1);
    ini_set(option:'display_startup_errors', value: 1);
    error_reporting(error_level: E_ALL);

    require_once __DIR__ . '/../auth.php';
    require_once __DIR__ . '/pdo.php';
    require_once __DIR__ . '/../includes/utils.php';

?>
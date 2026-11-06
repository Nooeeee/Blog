<?php
require_once __DIR__ . '/../config/init.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /TPBlog/admin/index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: /TPBlog/admin/index.php');
    exit;
}

deleteCategory($id);

header('Location: /TPBlog/admin/index.php');
exit;
?>

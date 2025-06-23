<?php
require 'components/connection.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die('Product ID not provided.');
}
$stmt = $pdo->prepare("DELETE FROM Products WHERE id = ?");
if ($stmt->execute([$id])) {
    header("Location: index.php?deleted=1");
    exit;
} else {
    die('Failed to delete product.');
}

?>
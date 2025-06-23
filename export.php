<?php
require 'components/connection.php';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="products.csv"');
header('Pragma: no-cache');
header('Expires: 0');

$output = fopen('php://output', 'w');
// CSV column headers
fputcsv($output, ['ID', 'Name', 'Price', 'Quantity' ]);

$stmt = $pdo->query("SELECT * FROM products");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [$row['id'], $row['name'], $row['price'], $row['quantity']]);
}

fclose($output);
exit;
?>
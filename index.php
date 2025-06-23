<?php
// connect database
require 'components/connection.php';

// search functionality
$search = $_GET['search'] ?? '';
$sql = "SELECT COUNT(*) FROM products WHERE name LIKE ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$search%"]);
$total = $stmt->fetchColumn();

$limit = 10;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

// Fetch products with pagination 
$sql = "SELECT * FROM  products WHERE name LIKE ? LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$search%"]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="header">
        <h1 class="heading">Product List</h1>
        <form class="search-form" method="GET" action="">
            <input class="serach-input" type="text" name="search" placeholder="Search by name" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </section>

    <div class="flex-btn">
        <a href="add.php" class="btn">Add Product</a>
        <a href="export.php" class="btn">Export to Excel</a>
        <a href="import.php" class="btn">Upload from Excel</a>
    </div>
    <table border="1" cellpadding="5" cellspacing="0" style="backdrop-filter: blur(5px);">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td style="margin-left: 20px;">
                            <a class="btn" href="edit.php?id=<?= $product['id'] ?>">Edit</a> |
                            <a class="btn" href="delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Are Sure Delete This Product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <div class="empty"><p>No products found.</p></div>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
    // Pagination Links
    $totalPages = ceil($total / $limit);
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='?search=$search&page=$i'>$i</a>";
    }
    ?>
</body>

</html>
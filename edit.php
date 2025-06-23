<?php
// connect database
require "components/connection.php";

// Get Product ID from URl
$id = $_GET['id'] ?? null;
if (!$id) {
    die('Product ID not provided');
}

// Fetch existing product data
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die('Product not found.');
}

$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];
$errors = [];

// Hnadle from submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    // Validation
    if ($name === '') $errors[] = 'Name is required';
    if ($price === '' || !is_numeric($price)) $errors[] = 'Valid price is required';
    if ($quantity === '' || !is_numeric($quantity)) $errors[] = 'Valid quantityb is required';

    // show errors
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?");
        if ($stmt->execute([$name, $price, $quantity, $id])) {

            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Failed to update product";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="post-editer">
        <div class="heading">
            <h1>Edit Product</h1>
        </div>
        <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach ?>
            </ul>
        <?php endif; ?>
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" class="register">
                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                <div class="input-field">
                    <p>product name <span>*</span></p>
                    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="box">
                </div>
                <div class="input-field">
                    <p>product price <span>*</span></p>
                    <input type="number" name="price" value="<?= htmlspecialchars($price) ?>" class="box">
                </div>
                <div class="input-field">
                    <p>product quantity <span>*</span></p>
                    <input type="number" name="quantity" value="<?= htmlspecialchars($quantity) ?>" class="box" min="0" max="9999999999" maxlength="10">
                </div>
                <div class="flex-btn" style="text-align: center;">
                    <button class="btn" style="width: 30%;"><a style="text-decoration: none; color: rgba(0, 0, 0, 0.72);" href="index.php">Back to List</a></button>
                    <input style="width: 30%;" type="submit" name="delete_product" value="delete product" class="btn">
                    <input style="width: 30%;" type="submit" name="update" value="update product" class="btn" onclick="return confirm('Product updated successfully! ')">
                </div>
            </form>
        </div>
    </section>
</body>

</html>
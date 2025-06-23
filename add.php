<?php
require 'components/connection.php';


$name = $price = $quantity = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    // Validation
    if ($name === '') $errors[] = 'Name is required';
    if ($price === '' || !is_numeric($price)) $errors[] = 'Valid price is required';
    if ($quantity === '' || !is_numeric($quantity)) $errors[] = 'Valid quantity is required';

    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $price, $quantity])) {
            header("location: index.php");
            exit;
        } else {
            $errors[] = 'Failed to add product.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="post-editer">
        <div class="heading">
            <h1>Add Product</h1>
        </div>
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data" class="register">
                <div class="input-field">
                    <p>product name <span>*</span> </p>
                    <input type="text" name="name" maxlength="100" value="<?= htmlspecialchars($name) ?>" placeholder="add product name" required class="box">
                </div>
                <div class="input-field">
                    <p>product price <span>*</span> </p>
                    <input type="number" name="price" maxlength="100" value="<?= htmlspecialchars($name) ?>" placeholder="add product price" required class="box">
                </div>
                <div class="input-field">
                    <p>product quantity <span>*</span> </p>
                    <input type="number" name="quantity" min="1" max="10" value="<?= htmlspecialchars($quantity) ?>" placeholder="add product quantity" required class="box">
                </div>
                <div class="flex-btn" style="justify-content: space-between;">
                    <button class="btn" style="width: 30%;"><a style="text-decoration: none; color: rgba(0, 0, 0, 0.72);" href="index.php">Back to List</a></button>
                    <button type="submit" class="btn" style="width: 30%;">Add Product</button>
                </div>
            </form>
        </div>

    </section>
</body>

</html>
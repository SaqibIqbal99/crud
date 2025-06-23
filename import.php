<?php
require 'components/connection.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file =  $_FILES['csv_file']['tmp_name'];
    if (($handle = fopen($file, 'r')) !== false) {
        // Skip the header row
        fgetcsv($handle);

        $stmt = $pdo->prepare("INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $name = trim($data[0]);
            $price = trim($data[1]);
            $quantity = trim($data[2]);
            


            if ($name !== '' && is_numeric($price) && is_numeric($quantity)) {
                $stmt->execute([$name, $price, $quantity]);
                header("Location: index.php");
            }
        }
        fclose($handle);
        $success = "Products imported successfully.";
    } else {
        $error = "Failed to read the uploaded file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Products</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="post-editer">
    <h1 class="heading">Upload CSV File</h1>
    <?php if ($success) {
        echo "<script> alert ('Products imported successfully.')</script>";
    }
    ?>
    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>


    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">

            <div class="flex-btn" style="text-align: center; justify-content: center;">
                <div class="input-field">
                    <p>Select CSV File <span>*</span> </p>
                    <input width="30%" type="file" name="csv_file" accept=".csv" required class="btn"><br><br>
                    <button href="index.php" style="width: 30%;" type="submit" class="btn">Upload</button><br><br>
                    <button class="btn" style="width: 70%;"><a style="text-decoration: none; color: rgba(0, 0, 0, 0.72);" href="index.php">Back to List</a></button>
                </div>
            </div>
        </form>
    </div>
</section>
</body>
</html>
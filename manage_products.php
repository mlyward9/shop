<?php
session_start();
require 'db.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Fetch all products along with their associated shop
$query = "
    SELECT p.id, p.user_id, p.product_name, p.product_description, p.price, p.product_image, p.created_at, s.shop_name
    FROM products p
    JOIN shops s ON p.shop_id = s.id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="manage_products.css"> <!-- Link to external CSS -->
</head>
<body>
    <h1>Manage Products</h1>
    
    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Shop</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_description']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td>
                        <img src="uploads/<?php echo $product['product_image']; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" width="50" height="50">
                    </td>
                    <td><?php echo htmlspecialchars($product['shop_name']); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                        <a href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

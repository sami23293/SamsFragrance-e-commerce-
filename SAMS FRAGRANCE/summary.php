<?php
// 1. Database connection
$conn = new mysqli("localhost", "root", "", "sams");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get the order details 
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$order = null;

if ($order_id) {
    $stmt = $conn->prepare("
        SELECT o.full_name, o.phone_number, o.wilaya_id, o.delivery_method, o.commune, o.address,
               o.total_price, o.quantity, p.name AS perfume_name, p.size_ml, v.price AS perfume_price
        FROM orders o
        JOIN perfumes p ON o.perfume_id = p.id
        JOIN variants v ON o.perfume_id = v.perfume_id
        WHERE o.id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($order = $result->fetch_assoc()) {
        $stmt->close();
    } else {
        die("Order not found.");
    }
} else {
    die("Invalid order ID.");
}

//   wilaya name
$wilaya_name = '';
if ($order['wilaya_id']) {
    $stmt = $conn->prepare("SELECT name FROM wilayas WHERE id = ?");
    $stmt->bind_param("i", $order['wilaya_id']);
    $stmt->execute();
    $stmt->bind_result($wilaya_name);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="order-summary-container">
        <h2>Order Summary</h2>
        <div class="order-details">
            <h3>Perfume Details</h3>
            <p><strong>Perfume:</strong> <?= htmlspecialchars($order['perfume_name']) ?> (<?= htmlspecialchars($order['size_ml']) ?> ml)</p>
            <p><strong>Price per Unit:</strong> DA <?= number_format($order['perfume_price'], 2) ?></p>
            <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
            <p><strong>Total Price:</strong> DA <?= number_format($order['total_price'], 2) ?></p>
        </div>

        <div class="delivery-details">
            <h3>Delivery Details</h3>
            <p><strong>Wilaya:</strong> <?= htmlspecialchars($wilaya_name) ?></p>
            <p><strong>Delivery Method:</strong> <?= htmlspecialchars($order['delivery_method']) ?></p>

            <?php if ($order['delivery_method'] === 'depot') : ?>
                <p><strong>Commune:</strong> <?= htmlspecialchars($order['commune']) ?></p>
            <?php else: ?>
                <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
            <?php endif; ?>
        </div>

        <div class="customer-details">
            <h3>Customer Information</h3>
            <p><strong>Full Name:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
            <p><strong>Phone Number:</strong> <?= htmlspecialchars($order['phone_number']) ?></p>
        </div>
        <div class="back-to-home">
            <a href="index.php"><button>Go Back to Home</button></a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>

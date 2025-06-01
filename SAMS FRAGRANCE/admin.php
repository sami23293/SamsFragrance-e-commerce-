<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "sams");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle single order delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    // First delete order_items for this order
    $stmt_items = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt_items->bind_param("i", $delete_id);
    $stmt_items->execute();
    $stmt_items->close();

    // Then delete the order itself
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Order deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting order: " . $stmt->error;
        $_SESSION['message_type'] = "error";
    }
    $stmt->close();
    header("Location: admin.php");
    exit();
}


// Handle delete all
if (isset($_GET['delete_all'])) {
    $conn->query("DELETE FROM order_items");
    $conn->query("DELETE FROM orders");
    header("Location: admin.php");
    exit();
}

// Fetch all orders with their items and perfume info
$sql = "
SELECT 
    o.id AS order_id,
    o.full_name,
    o.phone_number,
    o.address,
    o.wilaya_id,
    w.name AS wilaya_name,
    o.commune,
    o.delivery_method,
    o.total_price,
    o.created_at,
    oi.variant_id,
    oi.quantity,
    v.size_ml,
    v.price AS unit_price,
    p.name AS perfume_name,
    p.image AS perfume_image,
    p.category
FROM orders o
LEFT JOIN wilayas w ON o.wilaya_id = w.id
LEFT JOIN order_items oi ON o.id = oi.order_id
LEFT JOIN variants v ON oi.variant_id = v.id
LEFT JOIN perfumes p ON v.perfume_id = p.id
ORDER BY o.created_at DESC, o.id DESC
";
$result = $conn->query($sql);

// Group orders by order_id
$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $oid = $row['order_id'];
        if (!isset($orders[$oid])) {
            $orders[$oid] = [
                'order_id' => $oid,
                'full_name' => $row['full_name'],
                'phone_number' => $row['phone_number'],
                'address' => $row['address'],
                'wilaya_id' => $row['wilaya_id'],
                'wilaya_name' => $row['wilaya_name'],
                'commune' => $row['commune'],
                'delivery_method' => $row['delivery_method'],
                'total_price' => $row['total_price'],
                'created_at' => $row['created_at'],
                'items' => []
            ];
        }
        // Only add item if it exists (may be null if no items)
        if ($row['variant_id']) {
            $orders[$oid]['items'][] = [
                'perfume_name' => $row['perfume_name'],
                'category' => $row['category'],
                'size_ml' => $row['size_ml'],
                'unit_price' => $row['unit_price'],
                'quantity' => $row['quantity'],
                'perfume_image' => $row['perfume_image']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f7f6f2;
            color: #232323;
            margin: 0;
            padding: 0;
        }
        .admin-header {
            background: #fff;
            border-bottom: 1.5px solid #ececec;
            box-shadow: 0 2px 12px rgba(191,161,108,0.04);
            padding: 18px 0 12px 0;
            text-align: center;
        }
        .admin-header h2 {
            margin: 0;
            color: #bfa16c;
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            letter-spacing: 1px;
        }
        .logout-btn {
            float: right;
            margin: 10px 30px 0 0;
            color: #fff;
            background: #bfa16c;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background: #a88b4a;
        }
        .container {
            max-width: 1100px;
            margin: 36px auto 36px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(191,161,108,0.07);
            padding: 32px 24px 24px 24px;
        }
        .message {
            padding: 12px 18px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 1.08rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(191,161,108,0.08);
        }
        .success {
            background-color: #f6fff2;
            color: #388e3c;
            border-left: 5px solid #388e3c;
        }
        .error {
            background-color: #fff4f4;
            color: #e53935;
            border-left: 5px solid #e53935;
        }
        .delete-all-button-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .delete-all-button {
            color: #fff;
            background: #bfa16c;
            border: none;
            padding: 12px 28px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 700;
            margin-top: 18px;
            transition: background 0.2s;
        }
        .delete-all-button:hover {
            background: #a88b4a;
        }
        .order-block {
            border-bottom: 1.5px solid #ececec;
            margin-bottom: 32px;
            padding-bottom: 24px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        .order-info {
            font-size: 1.08rem;
            font-weight: 600;
        }
        .order-date {
            color: #888;
            font-size: 0.98rem;
            font-weight: 500;
        }
        .order-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
            background: #faf8f2;
            border-radius: 8px;
            overflow: hidden;
        }
        .order-items-table th, .order-items-table td {
            padding: 8px 10px;
            text-align: left;
        }
        .order-items-table th {
            background: #f7ecd2;
            color: #bfa16c;
            font-weight: 700;
            font-size: 1.01rem;
            letter-spacing: 0.5px;
        }
        .order-items-table td {
            background: #fff;
            font-size: 0.98rem;
        }
        .order-items-table img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            border-radius: 6px;
            background: #fafafa;
            border: 1px solid #eee;
        }
        .delete-button {
            color: #fff;
            background: #e53935;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .delete-button:hover {
            background: #b71c1c;
        }
        .order-total {
            font-size: 1.13rem;
            font-weight: 700;
            color: #bfa16c;
            text-align: right;
            margin-top: 8px;
        }
        @media (max-width: 900px) {
            .container { padding: 10px 2vw 10px 2vw; }
            .order-header { flex-direction: column; gap: 8px; }
            .logout-btn { float: none; display: block; margin: 10px auto 0 auto; }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <a href="admin.php?logout=true" class="logout-btn" onclick="return confirm('Are you sure you want to log out?');">Logout</a>
        <h2>Orders Dashboard</h2>
    </div>
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message <?= htmlspecialchars($_SESSION['message_type']) ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <?php if (count($orders) > 0): ?>
            <div class="delete-all-button-container">
                <button class="delete-all-button" onclick="confirmDeleteAll()">Delete All Orders</button>
            </div>
            <?php foreach ($orders as $order): ?>
                <div class="order-block">
                    <div class="order-header">
                        <div class="order-info">
                            <span>Order #<?= htmlspecialchars($order['order_id']) ?></span> |
                            <span><?= htmlspecialchars($order['full_name']) ?></span> |
                            <span><?= htmlspecialchars($order['phone_number']) ?></span>
                            <?php if ($order['address']): ?>
                                | <span><?= htmlspecialchars($order['address']) ?></span>
                            <?php endif; ?>
                            <?php if ($order['commune']): ?>
                                | <span><?= htmlspecialchars($order['commune']) ?></span>
                            <?php endif; ?>
                            | <span><?= htmlspecialchars($order['wilaya_name']) ?></span>
                            | <span><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $order['delivery_method']))) ?></span>
                        </div>
                        <div class="order-date">
                            <?= htmlspecialchars($order['created_at']) ?>
                        </div>
                    </div>
                    <table class="order-items-table">
                        <thead>
                            <tr>
                                <th>Perfume</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['perfume_name']) ?></td>
                                    <td><?= htmlspecialchars($item['category']) ?></td>
                                    <td><?= htmlspecialchars($item['size_ml']) ?> ml</td>
                                    <td><?= number_format($item['unit_price'], 2) ?> DZD</td>
                                    <td><?= (int)$item['quantity'] ?></td>
                                    <td>
                                        <?php if ($item['perfume_image']): ?>
                                            <img src="<?= htmlspecialchars($item['perfume_image']) ?>" alt="Perfume">
                                        <?php else: ?>
                                            <span style="color:#aaa;">No image</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="order-total">
                        Total: <?= number_format($order['total_price'], 2) ?> DZD
                        <button class="delete-button" onclick="confirmDelete(<?= (int)$order['order_id'] ?>)">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No orders yet.</p>
            <button class="delete-all-button" style="display: none;" disabled>Delete All Orders</button>
        <?php endif; ?>
    </div>
    <script>
        function confirmDelete(orderId) {
            if (confirm('Are you sure you want to delete this order?')) {
                window.location.href = 'admin.php?delete_id=' + orderId;
            }
        }
        function confirmDeleteAll() {
            if (confirm('Are you sure you want to delete all orders?')) {
                window.location.href = 'admin.php?delete_all=true';
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>
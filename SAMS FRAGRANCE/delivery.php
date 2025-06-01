<?php
$conn = new mysqli("localhost", "root", "", "sams");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['wilaya_id']) || !isset($_GET['method'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$wilaya_id = (int) $_GET['wilaya_id'];
$method = $_GET['method'] === 'house_delivery' ? 'price_home' : 'price_depot';

$stmt = $conn->prepare("SELECT $method AS price FROM wilayas WHERE id = ?");
$stmt->bind_param("i", $wilaya_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['price' => (float) $row['price']]);
} else {
    echo json_encode(['price' => 0]);
}
$stmt->close();
$conn->close();
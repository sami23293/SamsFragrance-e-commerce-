<?php
$conn = new mysqli("localhost", "root", "", "sams");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$term = $_GET['term'] ?? '';

if (!$term) {
  echo json_encode([]);
  exit;
}

$term = "%" . $term . "%"; 

$sql = "SELECT id, name FROM perfumes WHERE name LIKE ? LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $term);
$stmt->execute();
$result = $stmt->get_result();

$perfumes = [];
while ($row = $result->fetch_assoc()) {
  $perfumes[] = $row;
}

echo json_encode($perfumes);
$stmt->close();
$conn->close();
?>

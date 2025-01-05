<?php
// business_details.php
include 'db.php';

$business_id = $_GET['business_id'] ?? 0;

$sql = "SELECT s.service_name, s.price FROM services s WHERE s.business_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $business_id);
$stmt->execute();

$result = $stmt->get_result();
$services = [];

while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Details</title>
</head>
<body>
    <h2>Services</h2>
    <ul>
        <?php foreach ($services as $service): ?>
            <li><?= htmlspecialchars($service['service_name']) ?> - $<?= htmlspecialchars($service['price']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

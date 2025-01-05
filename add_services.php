<?php
// add_service.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $business_id = $_POST['business_id'];
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO services (business_id, service_name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $business_id, $service_name, $price);

    if ($stmt->execute()) {
        echo "Service added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

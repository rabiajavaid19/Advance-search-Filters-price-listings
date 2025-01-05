<?php
// search.php
include 'db.php';

// Get filter inputs
$location = $_GET['location'] ?? '';
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 1000000;
$popularity = $_GET['popularity'] ?? 0;

// SQL query with filters
$sql = "SELECT b.id, b.name, b.location, b.popularity, s.service_name, s.price 
        FROM businesses b 
        JOIN services s ON b.id = s.business_id 
        WHERE (b.location LIKE ?) 
          AND (s.price BETWEEN ? AND ?) 
          AND (b.popularity >= ?)";

$stmt = $conn->prepare($sql);
$search_location = "%{$location}%";
$stmt->bind_param("sddi", $search_location, $min_price, $max_price, $popularity);
$stmt->execute();

$result = $stmt->get_result();

$businesses = [];
while ($row = $result->fetch_assoc()) {
    $businesses[] = $row;
}

$stmt->close();
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($businesses);
?>

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// SQL to retrieve products and their images
$sql = "
SELECT p.id, p.name, p.price, p.description, p.kms_per_charge, p.discount, p.is_popular, p.is_vehicle, pi.image_url
FROM products p
LEFT JOIN product_images pi ON p.id = pi.product_id
";

$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $product_id = $row['id'];
        if (!isset($products[$product_id])) {
            $products[$product_id] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'description' => $row['description'],
                'kms_per_charge' => $row['kms_per_charge'],
                'discount' => $row['discount'],
                'is_popular' => $row['is_popular'],
                'is_vehicle' => $row['is_vehicle'],
                'images' => []
            ];
        }
        $products[$product_id]['images'][] = $row['image_url'];
    }
}

// Reindex array to remove gaps in keys
$products = array_values($products);

echo json_encode($products);
?>

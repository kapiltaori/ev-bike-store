<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// SQL to retrieve products, their images, and colors
$sql = "
SELECT p.id, p.name, p.price, p.description, p.kms_per_charge, p.discount, p.is_popular, p.is_vehicle,
GROUP_CONCAT(DISTINCT pi.image_url) as images,
GROUP_CONCAT(DISTINCT pc.color) as colors
FROM products p
LEFT JOIN product_images pi ON p.id = pi.product_id
LEFT JOIN product_colors pc ON pi.color_id = pc.id
GROUP BY p.id, p.name
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
                'images' => explode(',', $row['images']),
                'colors' => explode(',', $row['colors'])
            ];
        }
    }
}

// Reindex array to remove gaps in keys
$products = array_values($products);

echo json_encode($products);
?>

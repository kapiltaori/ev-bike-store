<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // SQL to retrieve product, its images, and colors by ID
    $sql = "
    SELECT p.id, p.name, p.price, p.description, p.kms_per_charge, p.discount, p.is_popular, p.is_vehicle, pi.image_url, pc.color, pc.color_code,p.top_speed,p.full_charge_in_hrs,p.panel, p.battery,p.battery_warranty
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id
    LEFT JOIN product_colors pc ON pi.color_id = pc.id
    WHERE p.id = $product_id
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = [
            'id' => '',
            'name' => '',
            'price' => '',
            'description' => '',
            'kms_per_charge' => '',
            'discount' => '',
            'is_popular' => '',
            'is_vehicle' => '',
            'top_speed' => '',
            'full_charge_in_hrs' => '',
            'battery' => '',
            'battery_warranty' => '',
            'panel' => '',
            'images' => [],
            'colors' => []
        ];

        $tempColors = [];

        while ($row = $result->fetch_assoc()) {
            if ($product['id'] === '') {
                $product['id'] = $row['id'];
                $product['name'] = $row['name'];
                $product['price'] = $row['price'];
                $product['description'] = $row['description'];
                $product['kms_per_charge'] = $row['kms_per_charge'];
                $product['discount'] = $row['discount'];
                $product['is_popular'] = $row['is_popular'];
                $product['is_vehicle'] = $row['is_vehicle'];
                $product['top_speed'] =  $row['top_speed'];
                $product['full_charge_in_hrs'] =  $row['full_charge_in_hrs'];
                $product['battery'] = $row['battery'];
                $product['panel'] = $row['panel'];
                $product['battery_warranty'] = $row['battery_warranty'];
            }

            $color = $row['color'];
            $color_code = $row['color_code'];

            if (!isset($tempColors[$color])) {
                $tempColors[$color] = [
                    'color' => $color,
                    'color_code' => $row['color_code'],
                    'images' => []
                ];
            }

            $tempColors[$color]['images'][] = $row['image_url'];
        }

        $product['colors'] = array_values($tempColors);

        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid product ID']);
}

$conn->close();
?>

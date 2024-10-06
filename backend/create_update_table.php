<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "battreev";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}

// SQL to create or update tables
$sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mobileNumber VARCHAR(15) NOT NULL,
    date DATE NOT NULL,
    address TEXT NOT NULL,
    isBooking BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    panel VARCHAR(100),
    kms_per_charge INT(3),
    full_charge_in_hrs INT(3),
    top_speed INT(3),
    motor VARCHAR(100),
    battery_warranty VARCHAR(100),
    battery VARCHAR(100),
    description TEXT,
    discount DECIMAL(5, 2) DEFAULT 0,
    is_popular BOOLEAN NOT NULL DEFAULT 0,
    is_vehicle BOOLEAN NOT NULL DEFAULT 1,
    is_product_launching BOOLEAN NOT NULL DEFAULT 0,
    launching_date DATE
);

CREATE TABLE IF NOT EXISTS product_colors (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    color VARCHAR(50) NOT NULL,
    color_code VARCHAR(50) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS product_images (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    color_id INT(11),
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (color_id) REFERENCES product_colors(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS enquiry (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mobile_no VARCHAR(15) NOT NULL,
    message TEXT NOT NULL,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

// Execute the queries
if ($conn->multi_query($sql) === TRUE) {
    do {
        // Store the result set
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    echo "Tables created or updated successfully.\n";
} else {
    echo "Error creating or updating tables: " . $conn->error . "\n";
}

// Insert static data into products table
$sql = "INSERT INTO products (name, price, panel, kms_per_charge, full_charge_in_hrs, top_speed, motor, battery_warranty, battery, description, discount, is_popular, is_vehicle, is_product_launching, launching_date) VALUES
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 10, true, true, true, '2024-12-01'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 15, true, true, false, '2024-09-01'),
('Loev', 59900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 5, true, true, false, '2024-09-01'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 20, true, true, false, '2024-09-01')
";

if ($conn->query($sql) === TRUE) {
    echo "Products inserted successfully.\n";
} else {
    echo "Error inserting products: " . $conn->error . "\n";
}

// Insert static data into product_images table
$sql = "INSERT INTO product_colors (product_id, color, color_code) VALUES
(1, 'Black', '#000000'),
(1, 'Red', '#dd3333'),
(1, 'Orange', '#ff9999'),
(1, 'Blue', '#333399'),
(1, 'Silver', '#666666'),
(1, 'White', '#ffffff'),
(1, 'Yellow', '#ffcc33'),
(2, 'Midnight Black', '#0d0d0d'),
(2, 'Candy Red', '#960007'),
(2, 'Ice Blue', '#c3eafa'),
(2, 'Pearl White', '#ffffff'),
(2, 'Ecru Yellow', '#f3e193'),
(2, 'Stormy Grey', '#41464b'),
(2, 'Oxford Blue', '#112c56'),
(2, 'Blazing Bronze', '#b28066'),
(2, 'Hunter Green', '#60746e'),
(2, 'Cosmic Blue', '#08486c'),
(2, 'Gunmetal Black', '#282a2e'),
(3, 'Black', '#000000'),
(3, 'Yellow', '#ffcc33'),
(3, 'White', '#ffffff'),
(3, 'Silver', '#666666'),
(3, 'Red', '#dd3333'),
(3, 'Grey', '#d3d3d3'),
(3, 'Blue', '#333399'),
(4, 'Midnight Black', '#0d0d0d'),
(4, 'Candy Red', '#960007'),
(4, 'Ice Blue', '#c3eafa'),
(4, 'Pearl White', '#ffffff'),
(4, 'Ecru Yellow', '#f3e193'),
(4, 'Stormy Grey', '#41464b'),
(4, 'Oxford Blue', '#112c56'),
(4, 'Blazing Bronze', '#b28066'),
(4, 'Hunter Green', '#60746e'),
(4, 'Cosmic Blue', '#08486c'),
(4, 'Gunmetal Black', '#282a2e')
";

if ($conn->query($sql) === TRUE) {
    echo "Product colors inserted successfully.\n";
} else {
    echo "Error inserting product colors: " . $conn->error . "\n";
}


// Insert static data into product_images table
$sql = "INSERT INTO product_images (product_id, color_id, image_url) VALUES
(1, 1, 'products/one/one_black.png'),
(1, 2, 'products/one/one_red.png'),
(1, 3, 'products/one/one_orange.png'),
(1, 4, 'products/one/one_blue.png'),
(1, 5, 'products/one/one_silver.png'),
(1, 6, 'products/one/one_white.png'),
(1, 7, 'products/one/one_yellow.png'),
(2, 8, 'products/epic/epic_midnight_black.png'),
(2, 9, 'products/epic/epic_candy_red.png'),
(2, 10, 'products/epic/epic_ice_blue.png'),
(2, 11, 'products/epic/epic_pearl_white.png'),
(2, 12, 'products/epic/epic_ecru_yellow.png'),
(2, 13, 'products/epic/epic_stormy_grey.png'),
(2, 14, 'products/epic/epic_oxford_blue.png'),
(2, 15, 'products/epic/epic_blazing_bronze.png'),
(2, 16, 'products/epic/epic_hunter_green.png'),
(2, 17, 'products/epic/epic_cosmic_blue.png'),
(2, 18, 'products/epic/epic_gunmetal_black.png'),
(3, 19, 'products/loev/loev_black.png'),
(3, 20, 'products/loev/loev_yellow.png'),
(3, 21, 'products/loev/loev_white.png'),
(3, 22, 'products/loev/loev_silver.png'),
(3, 23, 'products/loev/loev_red.png'),
(3, 24, 'products/loev/loev_grey.png'),
(3, 25, 'products/loev/loev_blue.png'),
(4, 26, 'products/storie/storie_midnight_black.png'),
(4, 27, 'products/storie/storie_candy_red.png'),
(4, 28, 'products/storie/storie_ice_blue.png'),
(4, 29, 'products/storie/storie_pearl_white.png'),
(4, 30, 'products/storie/storie_ecru_yellow.png'),
(4, 31, 'products/storie/storie_stormy_grey.png'),
(4, 32, 'products/storie/storie_oxford_blue.png'),
(4, 33, 'products/storie/storie_blazing_bronze.png'),
(4, 34, 'products/storie/storie_hunter_green.png'),
(4, 35, 'products/storie/storie_cosmic_blue.png'),
(4, 36, 'products/storie/storie_gunmetal_black.png')";


if ($conn->query($sql) === TRUE) {
    echo "Product images inserted successfully.\n";
} else {
    echo "Error inserting product images: " . $conn->error . "\n";
}

$conn->close();
?>

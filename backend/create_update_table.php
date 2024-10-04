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
    launching_date DATE,
    color VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS product_images (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
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
$sql = "INSERT INTO products (name, price, panel, kms_per_charge, full_charge_in_hrs, top_speed, motor, battery_warranty, battery, description, discount, is_popular, is_vehicle, is_product_launching, launching_date, color) VALUES
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, true, true, true, '2024-12-01', 'Black'),
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 50, true, true, false, '2024-09-01', 'Red'),
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 50, false, true, false, '2024-09-01', 'Orange'),
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'Blue'),
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'Silver'),
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'White'),
('One', 73900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LPF/MNC', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'Silver'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, true, true, false, '2024-09-01', 'Midnight Black'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, true, true, false, '2024-09-01', 'Candy Red'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'Ice Blue'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'Pearl White'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'Ecru Yellow'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger,Keyless Ignition', 0, false, true, false, '2024-09-01', 'Stormy Grey'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Oxford Blue'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 50, false, true, false, '2024-09-01', 'Blazing Bronze'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10, false, true, false, '2024-09-01', 'Hunter Green'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10, false, true, false, '2024-09-01', 'Cosmic Blue'),
('Epic', 94900, 'Metal', 103, 5, 65, 'Lucas TVS BLDC Hub', '3 years or 30,000 Kms', 'Lithium Ion (NMC)', 'Detachable Lithium Ion (NMC) Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Gunmetal Black'),
('Loev', 59900, 'Metal', 150, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, true, true, false, '2024-09-01', 'Black'),
('Loev', 59900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, true, true, false, '2024-09-01', 'Yellow'),
('Loev', 59900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'White'),
('Loev', 59900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 50, false, true, false, '2024-09-01', 'Silver'),
('Loev', 59900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Red'),
('Loev', 59900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10.00, false, true, false, '2024-09-01', 'Grey'),
('Loev', 59900, 'Metal', 120, 5, 60, 'BLDC Hub Motor', '2 years', 'LFO/NMC/Graphene', 'Detachable LFO/NMC Battery, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10.00, false, true, false, '2024-09-01', 'Blue'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, true, true, false, '2024-09-01', 'Midnight Black'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, true, true, false, '2024-09-01', 'Candy Red'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Ice Blue'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Pearl White'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10, false, true, false, '2024-09-01', 'Ecru Yellow'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10, false, true, false, '2024-09-01', 'Stormy Grey'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Oxford Blue'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Blazing Bronze'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10, false, true, false, '2024-09-01', 'Hunter Green'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 10, false, true, false, '2024-09-01', 'Cosmic Blue'),
('Storie', 114999, 'Metal', 150, 5, 75, 'BLDC Hub Motor', '3 years', '2kW IP67-rated Locus TVS hub motor', 'Navigation Assist, Call Alerts, Bluetooth Connectivity, Detachable 2kW IP67-rated Locus TVS hub motor, USB Charger, Remote Key & Anti Theft Alarm, Projector LED Head Lamp, LED Tail Lamp, USB charger, Keyless Ignition', 0, false, true, false, '2024-09-01', 'Gunmetal Black')
";

if ($conn->query($sql) === TRUE) {
    echo "Products inserted successfully.\n";
} else {
    echo "Error inserting products: " . $conn->error . "\n";
}

// Insert static data into product_images table
$sql = "INSERT INTO product_images (product_id, image_url) VALUES
(1, 'images/bike_model_x_1.jpg'),
(1, 'images/bike_model_x_2.jpg'),
(1, 'images/bike_model_x_3.jpg'),
(2, 'images/scooter_model_y_1.jpg'),
(3, 'images/bike_model_z_1.jpg'),
(3, 'images/bike_model_z_2.jpg')";

if ($conn->query($sql) === TRUE) {
    echo "Product images inserted successfully.\n";
} else {
    echo "Error inserting product images: " . $conn->error . "\n";
}

$conn->close();
?>

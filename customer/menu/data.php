<?php
include "../../includes/db.php";

// Sample menu items with image URLs
$items = [
    ["Espresso", "Rich and bold espresso shot", 80.00, "https://upload.wikimedia.org/wikipedia/commons/4/45/A_small_cup_of_coffee.JPG", "Coffee"],
    ["Cappuccino", "Espresso with steamed milk & foam", 150.00, "https://upload.wikimedia.org/wikipedia/commons/c/c8/Cappuccino_at_Sightglass_Coffee.jpg", "Coffee"],
    ["Latte", "Smooth latte with a touch of milk", 160.00, "https://upload.wikimedia.org/wikipedia/commons/7/7a/Caff%C3%A8_Latte_at_Sightglass_Coffee.jpg", "Coffee"],
    ["Blueberry Muffin", "Freshly baked muffin with blueberries", 90.00, "https://upload.wikimedia.org/wikipedia/commons/b/b4/Blueberry_muffin_-_Evan_Swigart.jpg", "Bakery"],
    ["Croissant", "Buttery and flaky croissant", 70.00, "https://upload.wikimedia.org/wikipedia/commons/f/f5/Croissant-Petr_Kratochvil.jpg", "Bakery"]
];

foreach ($items as $item) {
    $name = $conn->real_escape_string($item[0]);
    $description = $conn->real_escape_string($item[1]);
    $price = $item[2];
    $image_url = $conn->real_escape_string($item[3]);
    $category = $conn->real_escape_string($item[4]);

    $sql = "INSERT INTO menu_items (name, description, price, image_url, category) 
            VALUES ('$name', '$description', '$price', '$image_url', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo "$name added successfully!<br>";
    } else {
        echo "Error adding $name: " . $conn->error . "<br>";
    }
}

$conn->close();
?>

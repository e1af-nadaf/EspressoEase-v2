<?php
include "../../includes/db.php";
include "../../includes/boilerplate.php";

$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);
?>

<div class="menu-container">
  <h1>Our Menu</h1>
  <div class="menu-grid">
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "
        <div class='menu-card'>
          <img src='{$row['image_url']}' alt='{$row['name']}'>
          <h2>{$row['name']}</h2>
          <p class='description'>{$row['description']}</p>
          <p class='price'>₹{$row['price']}</p>
          <button class='add-to-cart'>Add to Cart</button>
        </div>";
      }
    } else {
      echo "<p>No items available.</p>";
    }
    ?>
  </div>
</div>

<?php include "../../includes/footer.php" ?>
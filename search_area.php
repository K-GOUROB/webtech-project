<?php
@include 'config.php';

$area = $_GET['area'];

if ($area != '') {
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE area LIKE ?");
    $select_products->execute(['%' . $area . '%']);
} else {
    $select_products = $conn->prepare("SELECT * FROM `products`");
    $select_products->execute();
}

if ($select_products->rowCount() > 0) {
    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        // Output your product box here
    }
} else {
    echo '<p class="empty">No products found for the specified area!</p>';
}
?>

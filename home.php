<?php

@include 'config.php';

session_start();

$user_id = null;

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>
<section class="home"></section>

<section>


    <!--About-->

    <div class="about container" id="About">
        <div class="about_main">

            <div class="about_image">
                <img src="../final/images/bagura_doi.jpg" alt="about_image">
            </div>

            <div class="about_text">
                <h1><span>About</span>Us</h1>
                <h3>Why Choose us?</h3>
                <p>
                    Mishti Bilash is an online shop of sweetmeats.
                    Through this website, People all around Bangladesh can order traditional sweets of the country and take home delivery with ease and reliance.
                    In this project, we tried to develop a user-friendly E-commerce platform focusing on sweetmeats.
                    Customers can view, and order sweets of different culture and tradition of Bangladesh.
                </p>
            </div>

        </div>



    </div>



</section>

<section class="home-category">

   <h1 class="title">Shop by District</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/" alt="">
         <h3>fruits</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=fruits" class="btn">fruits</a>
      </div>

      <div class="box">
         <img src="images/" alt="">
         <h3>meat</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=meat" class="btn">meat</a>
      </div>

      <div class="box">
         <img src="images/" alt="">
         <h3>vegitables</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=vegitables" class="btn">vegitables</a>
      </div>

      <div class="box">
         <img src="images/" alt="">
         <h3>fish</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=fish" class="btn">fish</a>
      </div>

   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>

<section>
   
<div class="menu" id="Menu">
        <h1>Popular<span>Sweets</span></h1>

        <div class="menu_box">
            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/rosmali.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Rosomalai</h2>
                    <p>
                        Rosomalai dessert is the heritage of the Comilla district. Interestingly, Rosomalai was initially called ‘kheerbhog’.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/balishmisti.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Balish Misti </h2>
                    <p>
                        Try Balish Misti, the renowned sweet of Netrokona. The Bengali terms ‘Balish’ and ‘Misti’ refers to ‘pillow’ and ‘sweet’ respectively.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/chanarpolao.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Chhanar Polau</h2>
                    <p>
                        If you love the less sweet desserts, don’t miss the Chhanar Polau! Produced from the local cow-milk with high-quality sugar this dessert tastes comparatively less sweet
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/comcom.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Porrabarri ChomChom</h2>
                    <p>
                        In the 19th century, Joshoroth Haloi first made ChomChom with pure cow-milk and sugar using the water of Dhaleshwori River of Tangail.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/kachagolla.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Kachagolla </h2>
                    <p>
                        Natore’s famous traditional sweet ‘Kachagolla’ is a kind of dry sweet. The Bengali term, ‘Golla’ refers to circle/round. Interestingly,kachagolla is not a round-shaped sweet though its name suggests.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/parasandesh.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div class="menu_info">
                    <h2>Pera Sandesh </h2>
                    <p>
                        Naogaon’s ‘Pera Sandesh’ has a unique taste. It is a light brown colored sweet. According to hearsay, Mohendri Das first made Sandesh.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/sandesh.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Sandesh</h2>
                    <p>
                        The Sandesh sweet of Satkhhera district is famous around the country. This mouthwatering sweet is produced from pure chhana,extracted from local cow-milk.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/chhanamukhi.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Chhanamukhi </h2>
                    <p>
                        It is the renowned sweet of Brahmmanbaria District. Each piece of Chhanamukhi sweet has a small square-shaped figure bearing a firm surface.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>

            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/chanarpolao.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Rasamanjari</h2>
                    <p>
                        In 1940, Ramesh Chandra Ghosh first made the ‘Rasamanjari’ in Gaibandha. Later, its fame spread throughout the country and this desert became the traditional sweet of Gaibandha district.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>

            </div>
            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/bagura_doi.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Bogurar Special Doi</h2>
                    <p>
                        Curd of Bogra (Bengali: বগুড়ার দই) is a special kind of yoghurt which is found only in Bogra. It is a traditional food of Bangladesh and popular all over the world.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>
            </div>
            <div class="menu_card">

                <div class="menu_image">
                    <img src="../final/images/chanarpolao.jpg">
                </div>

                <div class="small_card">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <div class="menu_info">
                    <h2>Sabitri</h2>
                    <p>
                        The sabitri are representing the century-old tradition of the Meherpur district. The extraordinary
                        characteristic of the sweet is that their flavor
                        would remain unchanged for about a week in normal weather.
                    </p>
                    <h3>00.00</h3>
                    <div class="menu_icon">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                </div>
            </div>

        </div>
</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio officia aliquam quis saepe? Quia, libero.</p>
      <a href="contact.php" class="btn">contact us</a>
   </div>

</section>



<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
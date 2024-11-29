<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="heading">quick view</h1>

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="stock" value="<?= $fetch_product['stock']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <span style="font-size: 14px;">Category: </span><span style="font-size: 14px; text-decoration: underline"><?= $fetch_product['category']; ?></span>
            <div class="flex">
               <div class="price" style="color:orange; font-weight: bold"><span>₱ </span><?= $fetch_product['price']; ?></div>
               <div class="price" style="color:orange; font-weight: bold"><span style="color:">Stock: </span><?= $fetch_product['stock']; ?></div>
               <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">

               <!-- <label for="sct">Select Color</label>
               <select name="sct" id="sct">
                 <option value="Red">Red</option>
                 <option value="Blue">Blue</option>
                 <option value="White">White</option>
                 <option value="Black">Black</option>
               </select> -->

            </div>
            <div class="details"><?= $fetch_product['details']; ?></div>
            <?php
            if($fetch_product['discount_qnty'] != "0"){
       ?>
               <p style="font-size: 12px; font-style: italic; color: green; margin-top: 10px; margin-bottom: 10px; font-weight: bold;">Discount Available: Avail minimum of <?= $fetch_product['discount_qnty']; ?> pcs. of <?= $fetch_product['name']; ?> and get lowest price up to Php <?= $fetch_product['discount_price']; ?> per item</p>
      <?php
            }
      ?>
            <div class="flex-btn">
               <style type="text/css">
                  .blue {
                     filter: invert(1);
                     color: #000;
                  }
               </style>
               <a href="shop.php" class="btn btn-secondary" style="background-color: blue;">Back to Shop</a>
               <a href="chat.php" class="btn btn-secondary" style="background-color: blue;">Chat now</a>
               <input type="submit" value="add to cart" class="btn blue"  name="add_to_cart"> 
               <!-- <input class="option-btn blue" type="submit" name="add_to_wishlist" value="add to wishlist"> -->
            </div>
         </div>
      </div>
   </form>
   
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
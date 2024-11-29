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
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style4.css">

   <style type="text/css">

      .heading {
         font-size: 3rem;
         text-align: left;
      }

      .home-bg{
         /* filter: invert(1); */
      }

      .home-bg img {
         /* filter: invert(100%); */
      }

      .home-bg .content {
         /* filter: invert(100%); */
      }

      .announcements {
   padding: 20px;
   background-color: #f9f9f9;
}

.announcements .heading {
   font-size: 2.5rem;
   margin-bottom: 20px;
   text-align: center;
}

.announcement-list {
   display: flex;
   flex-direction: column;
   gap: 20px;
}

.announcement-item {
   background-color: #fff;
   padding: 15px;
   border-radius: 10px;
   box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.announcement-item h3 {
   font-size: 1.8rem;
   margin-bottom: 10px;
}

.announcement-item p {
   font-size: 1.2rem;
   color: #666;
}

   </style>
   

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider" >
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">

         <?php
            // Fetch current data from `cms_tb`
            $select_cms = $conn->prepare("SELECT * FROM `cms_tb` LIMIT 1");
            $select_cms->execute();
            $cms_data = $select_cms->fetch(PDO::FETCH_ASSOC);

            $home_details = '';
            $about_details = '';

            if($cms_data) {
               $home_details = $cms_data['home_details'];
               $about_details = $cms_data['about_details'];
            }
         ?>
         
         <div class="image" style="height: 500px;">       

         <div class="content" style="background-color: rgba(255, 255, 255, 0.3); width: 420px; text-align: center; padding: 30px; border-radius: 20px;">
         <img src="img/logo_1.PNG" alt="" style="margin-top: -100px; width: 280px;"> 
         <p style="color: #ffaa00; margin-top: -70px; font-size: 45px; font-weight: bold;"><?php echo $home_details;?> </p>
            <!-- <span style="color: black; font-weight: bold;">"Fill Your Thirsty."</span><br> -->
            <a href="shop.php" class="btn" style="background: #1775bb;">order now</a>
         </div>
         </div>
      </div>


   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<!-- <section class="category">

   <h1 class="heading">Shop by Category</h1>

   <div class="swiper category-slider">

      <div class="swipper swiper-wrapper">

         <a href="category.php?category=laptop" class="swiper-slide slide">
            <img src="images/icon-1.png" alt="">
            <img src="images/concreting-and-masonry.jpg">
            <h3>Concreting and Masonry</h3>
         </a>

         <a href="category.php?category=tv" class="swiper-slide slide">
            <img src="images/marine-plywood-local.jpg" alt="">
            <h3>Marine Plywood Local</h3>
         </a>

         <a href="category.php?category=camera" class="swiper-slide slide">
            <img src="images/PAINTING-SUPPLIES.jpg" alt="">
            <h3>Painting Supplies</h3>
         </a>

         <a href="category.php?category=mouse" class="swiper-slide slide">
            <img src="images/pvc-pipe-1.jpg" alt="">
            <h3>PVC Pipe</h3>
         </a>

         <a href="category.php?category=fridge" class="swiper-slide slide">
            <img src="images/rebars.jpg" alt="">
            <h3>Rebars</h3>
         </a>

         <a href="category.php?category=washing" class="swiper-slide slide">
            <img src="images/ROOFING.jpg" alt="">
            <h3>Roofing</h3>
         </a>

         <a href="category.php?category=smartphone" class="swiper-slide slide">
            <img src="images/STEEL.jpg" alt="">
            <h3>Steel</h3>
         </a>

         <a href="category.php?category=watch" class="swiper-slide slide">
            <img src="images/hafele-door-knob.jpg" alt="">
            <h3>Door Knob</h3>
         </a>

      </div>

   <div class="swiper-pagination"></div>

   </div>

</section> -->

<section class="home-products">

   <h1 class="heading">latest products</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 3"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="stock" value="<?= $fetch_product['stock']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <!-- <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button> -->
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>₱ </span><?= $fetch_product['price']; ?><span>.00</span></div>
         <span style="font-size: 16px; margin-right: -120px;">Qty: </span><input type="number" name="qty" class="qty" min="1" max="<?= $fetch_product['stock']; ?>" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <span style="font-size: 16px;">Note: </span><input type="text" name="note" style="font-size: 14px; border-style: solid; border-color: #f2f2f2; width: 100%;">
      <?php
            if($fetch_product['stock'] <= 0){
               echo '<input type="submit" value="out of stock" class="btn" name="add_to_cart" style="background-color: #f2f2f2; color: #666666; cursor: default;" disabled>';
            }
            else{
               echo '<input type="submit" value="add to cart" class="btn" name="add_to_cart" style="filter: invert(1);color: #000;">';
            }
         ?>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>





<section class="announcements">
   <h1 class="heading">Announcements</h1>

   <div class="announcement-list">
      <?php
      // Fetch announcements from `announcements_tb`
      $select_announcements = $conn->prepare("SELECT * FROM `announcements_tb` ORDER BY created_at DESC");
      $select_announcements->execute();
      if($select_announcements->rowCount() > 0){
         while($fetch_announcement = $select_announcements->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="announcement-item">
         <h3><?php echo htmlspecialchars($fetch_announcement['title']); ?></h3>
         <p><?php echo htmlspecialchars($fetch_announcement['content']); ?></p>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No announcements available at the moment!</p>';
      }
      ?>
   </div>
</section>


<br><hr><br>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
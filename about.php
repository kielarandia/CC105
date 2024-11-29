<?php

// Include the database connection file
include 'components/connect.php';

// Start a session to keep track of the user information
session_start();

// Check if the user is logged in and store their user ID
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];  // User ID is available from session
}else{
   $user_id = '';  // If no user is logged in, set user_id as empty
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Meta tags for character encoding and responsive design -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- External Swiper CSS for creating the reviews slider -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- Font Awesome CDN for using icons such as stars in reviews -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link to custom CSS file for page styling -->
   <link rel="stylesheet" href="css/style.css">

   <!-- Internal CSS for custom styling of the heading -->
   <style type="text/css">
      .heading {
         font-size: 3rem;  /* Set font size for the heading */
         text-align: left;  /* Align text to the left */
      }
   </style>

</head>
<body>
   
<!-- Include user header (navigation bar) -->
<?php include 'components/user_header.php'; ?>

<!-- About Section displaying company information -->
<section class="about">
<br><br>
   <div class="row">

      <div class="image">
         <!-- Display company logo with rounded borders -->
         <img src="img/logo_1.PNG" style="width: 300px; float: right; margin-right: 70px; border-radius: 50%;" alt="">
      </div>
      
      <?php
            // Fetch company information (about us) from database
            $select_cms = $conn->prepare("SELECT * FROM `cms_tb` LIMIT 1");
            $select_cms->execute();
            $cms_data = $select_cms->fetch(PDO::FETCH_ASSOC);  // Get the data from the database

            // Initialize variables to store fetched data
            $home_details = '';
            $about_details = '';

            // If data is found in the database, assign it to variables
            if($cms_data) {
               $home_details = $cms_data['home_details'];
               $about_details = $cms_data['about_details'];
            }
         ?>
         
      <div class="content">
         <h3>ESCALANTE GARMENTS TRADING</h3>
         <!-- Display company "About Us" section content -->
         <p><?php echo  $about_details; ?></p>
         <!-- Link to contact us page -->
         <a href="contact.php" class="btn" style="background: #1775bb;">contact us</a>
      </div>

   </div>

</section>

<!-- Reviews Section displaying customer testimonials -->
<section class="reviews">
   
   <h1 class="heading">Client's Reviews</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">
      <!-- Each customer review is a swiper slide -->
      <div class="swiper-slide slide">
         <img src="img/ezekiel(1).png" alt="">
         <p>"Escalante Garments Trading has transformed my wardrobe! Every piece I’ve bought is well-crafted, stylish, and incredibly comfortable. They truly understand what quality means."</p>
         <div class="stars">
            <!-- Displaying star ratings for the review -->
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>   
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ezekiel Arandia</h3>
      </div>

      <!-- Additional customer reviews can be added in similar format -->
      <div class="swiper-slide slide">
         <img src="img/myca(1).png" alt="">
         <p>"I've shopped at many stores, but Escalante Garments Trading stands out for both quality and style. Each item feels like it’s made just for me, with a perfect fit and elegant design."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Myca Manalo</h3>
      </div>

      <!-- Example with an absolute file path (local path should be avoided) -->
      <div class="swiper-slide slide">
         <img src="img/PAUL (1).png" alt="">
         <p>"The customer service at Escalante Garments Trading is exceptional! They go above and beyond to ensure I'm satisfied with each purchase. The quality is unbeatable – I know I'm getting the best every time."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>   
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Paul Valdez</h3>
      </div>

      <!-- More reviews can be added here following the same format -->
      <div class="swiper-slide slide">
         <img src="images/download (2).png" alt="">
         <p>"I’m so impressed by the craftsmanship of Escalante Garments Trading! The clothes are comfortable and durable, with a great selection of designs that keep me coming back."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Edrian Faderon</h3>
      </div>

      <!-- Example of another review -->
      <div class="swiper-slide slide">
         <img src="img/download (3).png" alt="">
         <p>"Escalante Garments Trading has become my go-to for reliable, stylish clothing. Whether it’s for home or work, I trust them for quality that lasts and a fit that always feels right."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Kimberly Nacorda</h3>
      </div>

   </div>

   <!-- Pagination controls for the swiper slider -->
   <div class="swiper-pagination"></div>

   </div>

</section>

<!-- Footer of the website -->
<?php include 'components/footer.php'; ?>

<!-- Swiper JS script for enabling the slider functionality -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- Link to custom JS script file for additional functionality -->
<script src="js/script.js"></script>

<script>
// Initialize the Swiper slider for the reviews section
var swiper = new Swiper(".reviews-slider", {
   loop:true,  // Enable looping of slides
   spaceBetween: 20,  // Space between slides
   pagination: {
      el: ".swiper-pagination",  // Element for pagination controls
      clickable:true,  // Allow clicking on pagination
   },
   breakpoints: {
      0: {
        slidesPerView:1,  // Show 1 slide on mobile
      },
      768: {
        slidesPerView: 2,  // Show 2 slides on tablets
      },
      991: {
        slidesPerView: 3,  // Show 3 slides on larger screens
      },
   },
});
</script>

</body>
</html>

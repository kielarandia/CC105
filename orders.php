<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body style="text-transform: capitalize;">
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
               // Calculate the due date if the payment method is 'credit'
               if($fetch_orders['method'] == 'credit'){
                  $placed_on = new DateTime($fetch_orders['placed_on']);
                  $due_date = $placed_on->modify('+3 days')->format('Y-m-d');
               }
   ?>
   <div class="box">
      <p>order id #: <span><?= $fetch_orders['order_id']; ?></span></p>
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <?php if($fetch_orders['method'] == 'credit'){ ?>
         <p>due date : <span><?= $due_date; ?></span></p>
      <?php } ?>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>₱ <?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>product tatus : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else if($fetch_orders['payment_status'] == 'completed'){ echo 'green'; }else{echo 'orange';} ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
            }
         }else{
            echo '<p class="empty">no orders placed yet!</p>';
         }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>

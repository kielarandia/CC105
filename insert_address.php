<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

// INSERT DATA FROM CART TO ORDER DETAILS
$insert_order_details = $conn->prepare("INSERT INTO `address`(user_id, `address`) VALUES(?,?)");
$insert_order_details->execute([$user_id, $address]);
echo '<script>alert("Delivery Address Added Successfully!");</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Delivery Address</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'components/user_header.php'; ?>
<section class="form-container">
   <form action="" method="post">
      <h3>Add Delivery Address</h3>
      <input type="text" name="address" placeholder="Add New Address" class="box">
      <input type="submit" value="Submit" class="btn" name="submit" style="background: #239ae0;">
   </form>
</section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
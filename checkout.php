<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);

   if(isset($_POST['reference_no'])){
      $reference_no = $_POST['reference_no'];
      $reference_no = filter_var($reference_no, FILTER_SANITIZE_STRING);
   }
   else{
      $reference_no = "";
   }
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];
   $date = date('Y-m-d');

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){
      // GENERATE order_id using last row number in order table
      $gen_sql = "SELECT MAX(id) AS max_value FROM orders";
      $gen_result = $conn->query($gen_sql);
      
      if ($gen_result->rowCount() > 0) {
            // Fetch the result as an associative array
            while ($gen_row = $gen_result->fetch(PDO::FETCH_ASSOC)) {
               $order_details_id = $gen_row['max_value'] + 1;
            }
      }

      // SELECT ALL FROM CART
      $sql_cart = "SELECT * FROM cart WHERE `status`= 1";
      $result_cart = $conn->query($sql_cart);
      
      if ($result_cart->rowCount() > 0) {
          while ($row_cart = $result_cart->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $row_cart["user_id"];
            $pid = $row_cart["pid"];
            $prd_name = $row_cart["name"];
            $prd_price = $row_cart["price"];
            $prd_qnty = $row_cart["quantity"];
            $note = $row_cart["note"];

            // INSERT DATA FROM CART TO ORDER DETAILS
            $insert_order_details = $conn->prepare("INSERT INTO `order_details`(order_id, user_id, pid, name, price, quantity, note) VALUES(?,?,?,?,?,?,?)");
            $insert_order_details->execute([$order_details_id, $user_id, $pid, $prd_name, $prd_price, $prd_qnty, $note]);
          }
      }

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, order_id, reference_no) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $date, $order_details_id, $reference_no]);
      
      if($reference_no != ""){
         //SEND EMAIL NOTIF IF GCASH
         $admin_email = "admin@gmail.com";
         $subject = "E-ORCON: GCASH PAYMENT RECEIVED";
         $message2 = "You have received Php $total_price.00 to your gcash account from $name as a payment for product orders. Transaction Reference Number: $reference_no.";
         $sender = "From: e-orcon@admin.com";
         mail($admin_email, $subject, $message2, $sender);
      }

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ? AND `status` = ?");
      $delete_cart->execute([$user_id, 1]);
      $message[] = 'Order placed successfully!';
   }else{
      $message[] = 'Cart is empty!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST" id="payment-form">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $nt1 = "";
         $nt2 = "";
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND status = ?");
         $select_cart->execute([$user_id, 1]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               if($fetch_cart['note'] != ""){
                  $nt1 = "(";
                  $nt2 = ")";
               }
               else{
                  $nt1 = "";
                  $nt2 = "";
               }
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].' '.$nt1.' '. $fetch_cart['note'].''.$nt2.' ) - ';
               $total_products = implode($cart_items);

               $prd_qnty2 = $fetch_cart['quantity'];
               $prd_id2 = $fetch_cart['pid'];
   
               $select_prd = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
               $select_prd->execute([$prd_id2]);
               if($select_prd->rowCount() > 0){
                  while($fetch_prd = $select_prd->fetch(PDO::FETCH_ASSOC)){
                     $disc_qnty = $fetch_prd['discount_qnty'];
                     $disc_price = $fetch_prd['discount_price'];
                  }
               }
      ?>
      <?php 
            if($disc_qnty != "0" && $prd_qnty2 >= $disc_qnty){
               $check_discounted = true;
               $result_price = $disc_price;
            }
            else{
               $check_discounted = false;
               $result_price = $fetch_cart['price'];
            }
            ?>

            <p><img src="uploaded_img/<?=$fetch_cart['image']; ?>" alt="" style="width: 70px; height: 60px;"> <?= $fetch_cart['name']; ?> <span>(<?= '₱'.$result_price.'.00 x '. $fetch_cart['quantity']; ?>)</span> </p>
         
         <?php
                  $grand_total += ($result_price * $fetch_cart['quantity']) + 70;
                  if($check_discounted){
                     echo '<p style="color: green; font-size: 12px; margin-top: 5px;">Discounted!</p>';
                  }
         }

         }else{
            echo '<p class="success" style="color: #5cb85c; font-weight: bold;" >You have successfully placed your order. Status can be seen in your order list</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <?php
            if($select_cart->rowCount() > 0){
               echo '<div class="grand-total">Total Payment : <span>₱'.$grand_total.'.00</span></div>';
            }
         ?>
      </div>

      <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
               // Check if the "selected-method" POST variable is set
               if (isset($_POST["selected-method"])) {
                  $selectedMethod = $_POST["selected-method"];
                  if($selectedMethod == "cash on delivery"){
                     $cod_selected = "selected";
                     $gcash_selected = "";
                     $credit_selected = "";
                  }
                  else if($selectedMethod == "gcash"){
                     $gcash_selected = "selected";
                     $cod_selected = "";
                     $credit_selected = "";
                  }
                  else{
                     $gcash_selected = "";
                     $cod_selected = "";
                     $credit_selected = "selected";
                  }
               }
               else{
                  $cod_selected = "";
                  $gcash_selected = "";
                  $credit_selected = "";
               }
            }
            else{
               $cod_selected = "";
               $gcash_selected = "";
               $credit_selected = "";
            }
         ?>

      <h3>Place Your Orders</h3>
         <?php
             $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
             $select_user->execute([$user_id]);
             if($select_user->rowCount() > 0){
                while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){
                   $user_address = $fetch_user['Address'];
                   $user_email = $fetch_user['email'];
                   $user_name = $fetch_user['name'];
                   $user_contact = $fetch_user['Contact_Number'];
                }
             }
         ?>
      <div class="flex">
      <div class="inputBox">
            <span>Payment Option :</span>
            <select name="method" class="box" id="payment-method" required>
               <option value="cash on delivery" <?php echo $cod_selected;?>>Cash On Delivery</option>
               <option value="gcash" <?php echo $gcash_selected; ?>>Gcash</option>
            </select>
         </div>

         <div class="inputBox">
            <span>Your Fullname :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" value="<?php echo $user_name;?>" required>
         </div>
         <div class="inputBox">
            <span>Your Number :</span>
            <input type="text" name="number" placeholder="enter your number" class="box" value="<?php echo $user_contact;?>" required>
         </div>
         <div class="inputBox">
            <span>Your Email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" value="<?php echo $user_email;?>" required>
         </div>
         <div class="inputBox">
            <span>Select Your Delivery Address :</span>
            <select name="address" class="box" required>
   <?php
   // Fetch main address from users table
   $select_main_address = $conn->prepare("SELECT `Address` FROM `users` WHERE `id` = ?");
   $select_main_address->execute([$user_id]);
   if($select_main_address->rowCount() > 0){
      $fetch_main_address = $select_main_address->fetch(PDO::FETCH_ASSOC);
      ?>
         <option><?php echo $fetch_main_address['Address']; ?> (Main Address)</option>
      <?php
   }

   // Fetch additional addresses from address table
   $select_additional_addresses = $conn->prepare("SELECT `address` FROM `address` WHERE `user_id` = ?");
   $select_additional_addresses->execute([$user_id]);
   if($select_additional_addresses->rowCount() > 0){
      while($fetch_address = $select_additional_addresses->fetch(PDO::FETCH_ASSOC)){
         ?>
            <option><?php echo $fetch_address['address']; ?></option>
         <?php
      }
   }
   ?>
</select>

         </div>
         <!-- <div class="inputBox">
            <span>Address Line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="e.g. city" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" placeholder="e.g. country" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Zip Code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div> -->
      </div><br><br>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // Check if the "selected-method" POST variable is set
         if (isset($_POST["selected-method"])) {
            $selectedMethod = $_POST["selected-method"];
            if($selectedMethod == "gcash")
            {
               $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
               $select_admin->execute([1]);
               $row = $select_admin->fetch(PDO::FETCH_ASSOC);

               if($select_admin->rowCount() > 0){
                  $gcash_qr = $row['gcash_qr'];
                  $gcash_name = $row['account_name'];
                  $gcash_num = $row['gcash_number'];
               }
      ?>
               <center>
               <h3 style="font-weight: bold;">SCAN TO PAY<h3>
               <img src="gcash_code/<?php echo $gcash_qr; ?>" style="width: 300px; height: 300px;" alt=""><br><br>
               <?php
               if($select_cart->rowCount() > 0){
                  echo '<p style="font-size: 24px; color: orange;">Total Payment : ₱'.$grand_total.'</p>';
               }?><br>
               <p style="font-weight: bold; font-size:20px;">GCASH #: <?php echo $gcash_name; ?></p>
               <p style="font-size: 16px;"><?php echo $gcash_num; ?></p><br>
               <input name="reference_no" type="text" style="font-size: 18px; width: 30%; padding: 5px;" placeholder="Input your reference number..." required maxlength="13" pattern="\d{13}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" title="Please enter exactly 13 digits."><br>

               <span style="font-size: 10px; font-style: italic;">Note: Saved the screenshot or proof of your payment and present it for verification.</span>
               </center>  
               <?php 
               }
            }
         }
      ?>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order" style="filter: invert(1);color: #000;">

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script>
    document.getElementById("payment-method").addEventListener("change", function() {
        // Get the selected value from the dropdown
        var selectedValue = this.value;

        // Create a hidden input element to store the selected value
        var hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "selected-method";
        hiddenInput.value = selectedValue;

        // Append the hidden input to the form
        document.getElementById("payment-form").appendChild(hiddenInput);

        // Submit the form
        document.getElementById("payment-form").submit();
    });
</script>

<script src="js/script.js"></script>

</body>
</html>
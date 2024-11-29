<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $randomNumber = random_int(10000, 99999);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $contact = $_POST['contact'];
   $contact = filter_var($contact, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{         
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password, code, Address, Contact_Number) VALUES(?,?,?,?,?,?)");
         $insert_user->execute([$name, $email, $cpass, $randomNumber, $address, $contact]);

         // $insert_address = $conn->prepare("INSERT INTO `address`(user_id, address) VALUES(?,?)");
         // $insert_address->execute([$user_id_2, $address]);

         $subject = "Water Refilling Station: Your Order Status";
         $message = "Account created Successfully! Here is your verification code: $randomNumber";
         $sender = "From: admin@gmail.com";
         mail($email, $subject, $message, $sender);
         echo "<script>alert('Account created successfully!');</script>";
         echo "<script>window.location.href = 'verification.php'</script>";
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   <style type="text/css">
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: sans-serif;
      }

      body {
         width: 100%;
         height: 100vh;
         background: url(img/bg_5.jpg);
         background-position: center center;
         background-repeat: no-repeat;
         background-size: cover;
         display: flex;
         justify-content: center;
         align-items: center;
      }

      .bg-overlay {
         position: fixed;
         top: 0;
         left: 0;

         width: 100%;
         height: 100vh;
         z-index: -1;

      }

      header {
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 70px;
         background: rgba(0, 0, 0, 0.3);
         display: flex;
         align-items: center;
         padding: 25px;
         box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .2);
         z-index: 999;
      }

      header a {
         text-decoration: none;
         font-size: 1.5rem;
         font-weight: 400;
         color: #f1f1f1;
         transition: ease-in-out 0.3s;
      }

      header a:hover {
         opacity: 0.7;
      }

      .form-container {
         width: 100%;
         height: 100vh;
         display: flex;
         justify-content: center;
         align-items: center;
      }

      form {
         position: relative;
         padding: 18px 25px;
         display: flex;
         justify-content: center;
         align-items: center;
         flex-direction: column;
         border-radius: 8px;
      }

      form h3 {
         font-size: 1.5rem;
         font-weight: 500;
         text-transform: uppercase;
         color: #f1f1f1;
         margin-bottom: 20px;
         text-shadow: 2px 3px 3px rgba(0, 0, 0, .4);
      }

      form input {
         border: none;
         outline: none;
         width: 300px;
         padding: 12px 18px;
         margin-bottom: 7px;
         font-size: 1rem;
         border-radius: 8px;
         text-align: left;
      }

      form input[type="submit"] {
         text-align: center;
         text-transform: uppercase;
         background: #27AFE0;
         cursor: pointer;
         transition: ease-in-out 0.3s;
         margin-bottom: 20px;
         color: #f1f1f1;
         box-shadow: 0 3px 5px 0px rgba(0, 0, 0, .3);
      }

      form input[type="submit"]:hover {
         opacity: 0.7;
         transform: scale(0.98);
      }

      form p {
         color: #f1f1f1;
         font-size: 1rem;
      }

      form a {
         text-decoration: none;
         font-size: 1.1rem;
         text-transform: uppercase;
         padding: 4px;
         margin-top: 5px;
         border-bottom: 2px solid #f1f1f1;
         color: #f1f1f1;
         transition: ease-in-out 0.3s;
         text-shadow: 2px 3px 3px rgba(0, 0, 0, .4);
      }

      form a:hover {
         opacity: 0.7;
         transform: scale(1.05);
      }

      .message {
         position: fixed;
         bottom: 6em;
         z-index: 100;
         padding: 8px 18px;
         background: #282828;
         color: #fff;
         border-radius: 8px;
         display: flex;
         justify-content: center;
         align-items: center;
         text-transform: uppercase;
         font-size: .8em;
         user-select: none;
         pointer-events: none;
      }
   </style>

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
      </div>
      ';
   }
}
?>

   <div class="bg-overlay"></div>
   <header>
	<a href="index.php" class="logo"><img src="img/logo_1.png" style="width: 55px; height: 55px; margin-right: 60px; float: right;" alt=""></a>
   <p style="color: #ffcc00; font-size: 28px; font-weight: bold; margin-left:-40px;">ESCALANTE GARMENTS TRADING</p>
</header>
   <section class="form-container">
   <form action="" method="post" style="background-color: rgba(128, 128, 128, 0.5); border-radius: 20px; padding: 40px;">
         <h3 style="color: ; font-weight: bold;">register now</h3>
         <input type="text" name="name" required placeholder="Fullname" maxlength="20"  class="box">
         <input type="email" name="email" required placeholder="Email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="Confirm Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="text" name="contact" class="box" placeholder="Enter Your Contact Number" required>
         <input type="text" name="address" class="box" placeholder="Enter Your Delivery Address" required>
         <input type="submit" value="SIGN-UP" class="btn" name="submit" style="background: red;">
         <p>Already have an account?</p>
         <a href="user_login.php" class="option-btn">login now</a>
      </form>
   </section>
   <script src="js/script.js"></script>
   <script type="text/javascript">

   </script>

</body>
</html>
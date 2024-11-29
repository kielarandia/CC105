<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body style="
   position: relative;
   background: url(./img/bg_5.jpg) no-repeat;
   background-position: center;
   background-size: 100%;
">
   
<?php include 'components/user_header.php'; ?>
<div style="
   position: absolute;
   width: 100%;
   height: 100vh;
   z-index: -1;
   background: #262626;
   opacity: 0.5;
"></div>
<section class="contact">

   <form action="" method="post" style="background: rgba(0, 0, 0, .6)">
      <h3 style="color: #f1f1f1">GET IN TOUCH</h3>
      <input type="text" name="name" placeholder="Fullname" required maxlength="30" class="box">
      <input type="email" name="email" placeholder="Email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="99999999999" placeholder="Phone Number" required onkeypress="if(this.value.length == 11) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Type Message Here...." cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn" style="background: red;">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html
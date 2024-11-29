<?php
include 'components/connect.php';
session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

// Check if the request was sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isChecked = $_POST['isChecked'];
    $itemId = $_POST['itemId'];
    
    if ($isChecked == 1) {
        $update_cart = $conn->prepare("UPDATE `cart` SET status = ? WHERE user_id = ? AND pid = ?");
        $update_cart->execute([1, $user_id, $itemId]);
    } else {
        $update_cart = $conn->prepare("UPDATE `cart` SET status = ? WHERE user_id = ? AND pid = ?");
        $update_cart->execute([0, $user_id, $itemId]);
    }
}
?>
<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];


if (!isset($user_id)) {
   header('location:login.php');
}

// kota prov jl kode

if (isset($_POST['order_btn'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   // $nomor = mysqli_real_escape_string($conn, $_POST['nomor']);
   $kurir = mysqli_real_escape_string($conn, $_POST['kurir']);
   $address = mysqli_real_escape_string($conn, $_POST['road'] . ', ' . $_POST['nomor'] . ', ' . $_POST['city'] . ', ' . $_POST['prov'] . ', ' . $_POST['pos_code']);
   $placed_on = date('d-M-Y');
   // $end_on = date('d-M-Y', time() + 7 * 24 * 60 * 60);

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if (mysqli_num_rows($cart_query) > 0) {
      while ($cart_item = mysqli_fetch_assoc($cart_query)) {
         $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ', $cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND kurir = '$kurir' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if ($cart_total == 0) {
      $message[] = 'your cart is empty';
   } else {
      if (mysqli_num_rows($order_query) > 0) {
         $message[] = 'order already placed!';
      } else {
         mysqli_query($conn, "INSERT INTO `orders`(user_id, jenis, name, number, email, method, address, kurir, total_products, total_price, placed_on) VALUES('$user_id', 'beli', '$name', '$number', '$email', '$method', '$address', '$kurir', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         // CODE ADDED: Update product stock
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed'); // CODE ADDED
         if (mysqli_num_rows($cart_query) > 0) { // CODE ADDED
            while ($cart_item = mysqli_fetch_assoc($cart_query)) { // CODE ADDED
               $product_id = $cart_item['product_id']; // CODE ADDED
               $quantity = $cart_item['quantity']; // CODE ADDED
               // Debugging statement
               error_log("Updating stock for product ID: $product_id with quantity: $quantity"); // CODE ADDED
               mysqli_query($conn, "UPDATE `products` SET stock = stock - $quantity WHERE id = '$product_id'") or die('query failed'); // CODE ADDED
            } // CODE ADDED
         } // CODE ADDED
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>checkout</h3>
      <p> <a href="home.php">home</a> / checkout </p>
   </div>

   <section class="display-order">

      <?php
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select_cart) > 0) {
         while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
      ?>
            <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo ' x ' . $fetch_cart['quantity']; ?>)</span> </p>
      <?php
         }
      } else {
         echo '<p class="empty">your cart is empty</p>';
      }
      ?>
      <!-- <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div> -->

   </section>

   <section class="checkout">

      <form action="" method="post">
         <h3>masukkan data diri</h3>
         <div class="flex">
            <div class="inputBox">
               <span>Nama :</span>
               <input type="text" name="name" required placeholder="masukkan namamu">
            </div>
            <div class="inputBox">
               <span>Nomor Telp :</span>
               <input type="number" name="number" required placeholder="masukkan nomor telp">
            </div>
            <div class="inputBox">
               <span>Email :</span>
               <input type="email" name="email" required placeholder="masukkan email">
            </div>
            <div class="inputBox">
               <span>payment method :</span>
               <select name="method">
                  <option value="COD">COD</option>
                  <option value="credit card">credit card</option>
                  <option value="debit card">debit card</option>
                  <option value="paylater">paylater</option>
               </select>
            </div>
            <div class="inputBox">
               <span>Nomor Rumah</span>
               <input type="number" min="0" name="nomor" required placeholder="35">
            </div>
            <div class="inputBox">
               <span>Kurir :</span>
               <select name="kurir">
                  <option value="cash on delivery">JNE</option>
                  <option value="credit card">J&T</option>
                  <option value="paypal">Pos Indonesia</option>
                  <option value="paytm">Gojek</option>
               </select>
            </div>
            <div class="inputBox">
               <span>Kota :</span>
               <input type="text" name="city" required placeholder="Semarang">
            </div>
            <div class="inputBox">
               <span>Provinsi :</span>
               <input type="text" name="prov" required placeholder="Jawa Tengah">
            </div>
            <div class="inputBox">
               <span>Jalan :</span>
               <input type="text" name="road" required placeholder="Jl. Pemuda">
            </div>
            <div class="inputBox">
               <span>Kode Pos :</span>
               <input type="number" min="0" maxlength="5" name="pos_code" required placeholder="132564">
            </div>
         </div>
         <input type="submit" value="order now" class="btn" name="order_btn">
      </form>

   </section>









   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['update_cart'])) {
   $cart_id = $_POST['cart_id'];
   // $cart_quantity = $_POST['cart_quantity'];
   // mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'Kerangjang telah terupdate!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

if (isset($_POST['order_btn'])) {

   $name = $_SESSION['user_name'];
   // $number = $_POST['number'];
   // $email = mysqli_real_escape_string($conn, $_POST['email']);
   // $method = mysqli_real_escape_string($conn, $_POST['method']);
   // $address = mysqli_real_escape_string($conn, 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
   $placed_on = date('d-M-Y');
   $end_on = date('d-M-Y', time() + 7 * 24 * 60 * 60);

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if (mysqli_num_rows($cart_query) > 0) {
      while ($cart_item = mysqli_fetch_assoc($cart_query)) {
         $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
         // $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $cart_item['quantity'];
      }
   }

   $total_products = implode(', ', $cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if ($cart_total == 0) {
      $message[] = 'your cart is empty';
   } else {
      if (mysqli_num_rows($order_query) > 0) {
         $message[] = 'order already placed!';
      } else {
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, total_products, total_price, placed_on, end_on) VALUES('$user_id', '$name', '$total_products', '$cart_total', '$placed_on', '$end_on')") or die('query failed');
         $message[] = 'order placed successfully!';
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
   <title>Keranjang</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Keranjang</h3>
      <p> <a href="home.php">home</a> / Keranjang </p>
   </div>

   <section class="shopping-cart">

      <h1 class="title">products added</h1>

      <div class="box-container">
         <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
         ?>
               <div class="box">
                  <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                  <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_cart['name']; ?></div>
                  <!-- <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div> -->
                  <form action="" method="post">
                     <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                     <!-- <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>"> -->
                     <!-- <input type="submit" name="update_cart" value="update" class="option-btn"> -->
                  </form>
                  <!-- <div class="sub-total"> sub total : <span>$<?php echo $sub_total += 1; ?>/-</span> </div> -->
                  <?php $sub_total += 1; ?>
               </div>
         <?php
               $grand_total += $sub_total;
            }
         } else {
            echo '<p class="empty">your cart is empty</p>';
         }
         ?>
      </div>

      <div style="margin-top: 2rem; text-align:center;">
         <a href="cart.php?delete_all" class="delete-btn" onclick="return confirm('delete all from cart?');">delete all</a>
      </div>

      <div class="cart-total">
         <!-- <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p> -->
         <div class="flex">
            <a href="shop.php" class="option-btn">Cari Buku</a>
            <form action="" method="post">
               <input type="submit" value="order now" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" name="order_btn">
            </form>
            <!-- <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Pinjam Sekarang</a> -->
         </div>
      </div>

   </section>








   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
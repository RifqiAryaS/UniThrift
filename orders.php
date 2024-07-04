<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['selesai-btn'])) {

   $order_update_id = $_POST['order_id'];
   $berakhir = $_POST['end'];
   // $update_status = $_POST['update_payment'];
   if (strtotime($berakhir) > time()) {
      mysqli_query($conn, "UPDATE `orders` SET payment_status = 'compleated' WHERE id = '$order_update_id'") or die('query failed');
   } else {
      mysqli_query($conn, "UPDATE `orders` SET payment_status = 'late' WHERE id = '$order_update_id'") or die('query failed');
   }
   $message[] = 'status has been updated!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>transaksi</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>transaksi</h3>
      <p> <a href="home.php">home</a> / transaksi </p>
   </div>

   <section class="placed-orders">

      <h1 class="title">daftar transaksi</h1>

      <div class="box-container">

         <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if (mysqli_num_rows($order_query) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
         ?>
               <div class="box">
                  <p> status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                      echo 'red';
                                                   } else {
                                                      echo 'green';
                                                   } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                  <p> jenis : <span><?php echo $fetch_orders['jenis']; ?></span> </p>
                  <p> name : <span><?php echo $_SESSION['user_name']; ?></span> </p>
                  <p> nama produk : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                  <?php if ($fetch_orders['tukar_id']  == 1) { ?>
                     <p> tukar ke : <span><?php echo $fetch_orders['target_name']; ?></span> </p>
                  <?php } ?>
                  <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                  <!-- <p> ends on : <span><?php //echo $fetch_orders['end_on']; 
                                             ?></span></p>
                  <p> denda : <span style="color: red;"><?php if ($fetch_orders['payment_status'] == 'pending') {
                                                            if (strtotime($fetch_orders['end_on']) > time()) {
                                                               echo '';
                                                            } else {
                                                               echo 'RP 20.000';
                                                            }
                                                         } else {
                                                            echo '';
                                                         }; ?></span></p> -->
                  <!-- <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                  <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                  <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
                  <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                  <p> your orders : <span><?php echo $fetch_orders['total_products']; ?></span> </p> -->
                  <!-- <p> total price : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p> -->
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                     <!-- <input type="hidden" name="end" value="<?php echo $fetch_orders['end_on']; ?>"> -->
                     <?php if ($fetch_orders['payment_status'] == 'pending') { ?>
                        <!-- <input type="submit" id="selesai" value="selesai" name="selesai-btn" class="option-btn" style="background-color: green;"><?php } ?> -->
                  </form>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">belum ada pesanan!</p>';
         }
         ?>
      </div>

   </section>








   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>
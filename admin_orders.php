<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_POST['update_order'])) {

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
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

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="orders">

      <h1 class="title">daftar transaksi</h1>

      <div class="box-container">
         <?php
         $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
         if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
         ?>
               <div class="box">
                  <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
                  <p> jenis : <span><?php echo $fetch_orders['jenis']; ?></span> </p>
                  <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                  <!-- <p> ends on : <span><?php echo $fetch_orders['end_on']; ?></span></p> -->
                  <p> nama : <span><?php echo $fetch_orders['name']; ?></span> </p>
                  <?php if ($fetch_orders['tukar_id']  == 0) { ?>
                     <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                     <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                     <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
                  <?php } ?>
                  <?php if ($fetch_orders['tukar_id']  == 1) { ?>
                     <p> tukar : <span><?php echo $fetch_orders['target_name']; ?></span> </p>
                  <?php } ?>
                  <p> produk : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                  <?php if ($fetch_orders['tukar_id']  == 0) { ?>
                     <p> total price : <span>Rp. <?php echo $fetch_orders['total_price']; ?></span> </p>
                     <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                  <?php } ?>
                  <p> status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                      echo 'red';
                                                   } else {
                                                      echo 'green';
                                                   } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                     <?php if ($fetch_orders['payment_status'] != 'completed' and $fetch_orders['payment_status'] != 'aproved') { ?>
                        <select name="update_payment">
                           <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                           <option value="pending">pending</option>
                           <?php if ($fetch_orders['tukar_id']  == 0) { ?>
                              <option value="completed">completed</option>
                           <?php } ?>
                           <?php if ($fetch_orders['tukar_id']  == 1) { ?>
                              <option value="aproved">aproved</option>
                           <?php } ?>
                           <?php if ($fetch_orders['tukar_id']  == 1) { ?>
                              <option value="reject">reject</option>
                           <?php } ?>
                        </select>
                        <input type="submit" value="update" name="update_order" class="option-btn">
                     <?php } ?>
                     <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('hapus data ini?');" class="delete-btn">delete</a>
                  </form>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">belum ada order!</p>';
         }
         ?>
      </div>

   </section>










   <!-- custom admin js file link  -->
   <script src="js/admin_script.js"></script>

</body>

</html>
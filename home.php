<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_name'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   // $product_quantity = $_POST['product_quantity'];

   $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE name = '$product_name'") or die('query failed');
   if (mysqli_num_rows($select_product) > 0) {
      $fetch_product = mysqli_fetch_assoc($select_product);
      $product_id = $fetch_product['user_id'];

      // Query untuk memeriksa apakah produk dengan nama dan ID penjual yang sama sudah ada di dalam cart
      $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id' AND name = '$product_name'") or die('query failed');

      if (mysqli_num_rows($check_cart_numbers) > 0) {
         $message[] = 'produk sudah ada di keranjang!';
      } else {
         mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, product_id) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_id')") or die('query failed');
         $message[] = 'produk ditambahkan ke keranjang!';
      }
   } else {
      $message[] = 'produk tidak ditemukan!';
   }
}

if (isset($_POST['tukar_product'])) {

   $update_p_id = $_POST['update_p_id'];
   $placed_on = date('d-M-Y');
   $old_name = $_POST['old_name'];
   //$tukar_name = $_POST['tukar_name'];
   $tukar_produk = $_POST['tukar_name'];
   // $image = $_FILES['image']['name'];
   // $image_size = $_FILES['image']['size'];
   // $image_tmp_name = $_FILES['image']['tmp_name'];
   // $image_folder = 'uploaded_img/' . $image;
   //$update_price = $_POST['update_price'];
   //$update_stock = $_POST['update_stock'];

   mysqli_query($conn, "INSERT INTO `orders`(user_id, jenis, name, total_products, placed_on, tukar_id, target_name) VALUES('$user_id', 'tukar', '$username', '$tukar_produk', '$placed_on', 1, '$old_name')") or die('query failed');
   $message[] = 'produk diproses ke penjual!';

   // if (mysqli_num_rows($select_product_name) > 0) {
   //    $error_msg[] = 'nama produk sudah ada';
   // } else {
   //    if ($image_size > 2000000) {
   //       $warning_msg[] = 'ukuran file terlalu besar';
   //    } else {
   //       $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, stock, image, user_id) VALUES('$name', $price, $stock, '$image', '$admin_id')") or die('query failed');

   //       if ($add_product_query) {
   //          move_uploaded_file($image_tmp_name, $image_folder);
   //          $success_msg[] = 'produk berhasil ditambah!';
   //       } else {
   //          $error_msg[] = 'produk tidak dapat ditambah!';
   //       }
   //    }
   // }

   // $update_image = $_FILES['update_image']['name'];
   // $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   // $update_image_size = $_FILES['update_image']['size'];
   // $update_folder = 'uploaded_img/' . $update_image;
   // $update_old_image = $_POST['update_old_image'];

   // if (!empty($update_image)) {
   //    if ($update_image_size > 2000000) {
   //       $message[] = 'ukuran file terlalu besar';
   //    } else {
   //       mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
   //       move_uploaded_file($update_image_tmp_name, $update_folder);
   //       unlink('uploaded_img/' . $update_old_image);
   //    }
   // }

   header('location:home.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <section class="home">

      <div class="content">
         <!-- <h3>Belanja dimanapun kapanpun</h3> -->
         <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p> -->
         <!-- <a href="about.php" class="white-btn">discover more</a> -->
      </div>

   </section>

   <section class="products">

      <h1 class="title">terakhir ditambah</h1>

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <form action="" method="post" class="box">
                  <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                  <?php if ($fetch_products['stock'] > 9) { ?>
                     <span class="stock" style="color: green;"><i class="fas fa-check"></i> Stock Tersedia</span>
                  <?php } elseif ($fetch_products['stock'] == 0) { ?>
                     <span class="stock" style="color: red;"><i class="fas fa-times"></i> Barang Habis</span>
                  <?php } else { ?>
                     <span class="stock" style="color: red;">buruan tingggal <?= $fetch_products['stock']; ?></span>
                  <?php } ?>
                  <div class="name"><?php echo $fetch_products['name']; ?></div>
                  <div class="price">RP. <?php echo $fetch_products['price']; ?>/-</div>
                  <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                  <?php if ($fetch_products['stock'] > 0) { ?>
                     <input type="submit" value="add to cart" name="add_to_cart" class="btn <?php echo ($fetch_products['stock'] > 1) ? '' : 'disabled'; ?>">
                     <a href="home.php?tukar=<?php echo $fetch_products['id']; ?>" class="option-btn">tukar</a><?php } ?>
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>


      <div class="load-more" style="margin-top: 2rem; text-align:center">
         <a href="shop.php" class="option-btn">load more</a>
      </div>

   </section>

   <section class="tukar-product-form">

      <?php
      if (isset($_GET['tukar'])) {
         $update_id = $_GET['tukar'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
      ?>
               <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                  <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                  <input type="hidden" name="old_name" value="<?php echo $fetch_update['name']; ?>">
                  <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                  <input type="text" name="tukar_name" class="box" required placeholder="masukkan nama produk yang akan ditukar">
                  <!-- <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price"> -->
                  <!-- <input type="number" name="update_stock" value="<?php echo $fetch_update['stock']; ?>" min="0" class="box" required placeholder="enter product stock"> -->
                  <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                  <input type="submit" value="tukar" name="tukar_product" class="btn">
                  <input type="reset" value="cancel" id="close-tukar" class="option-btn">
               </form>
      <?php
            }
         }
      } else {
         echo '<script>document.querySelector(".tukar-product-form").style.display = "none";</script>';
      }
      ?>

   </section>


   <!-- <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/about-img.jpg" alt="">
         </div>

         <div class="content">
            <h3>about us</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
            <a href="about.php" class="btn">read more</a>
         </div>

      </div>

   </section> -->

   <!-- <section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section> -->





   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <?php include 'alert.php'; ?>

</body>

</html>
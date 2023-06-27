<?php

include 'config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {
      $message[] = 'User sudah ada!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Password tidak sama!';
      } else {
         mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$cpass')") or die('query failed');
         $message[] = 'Daftar Sukses!';
         header('location:login.php');
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

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>



   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <div class="form-container">

      <div class="row d-flex align-items-center justify-content-center h-100">
         <img src="images/bukucoy.jpg" width="460" height="440" padding alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: Right;">
      </div>

      <form action="" method="post">
         <h3>daftar</h3>
         <input type="text" name="name" placeholder="Masukkan Nama" required class="box">
         <input type="email" name="email" placeholder="Masukkan Email" required class="box">
         <input type="password" name="password" placeholder="Masukkan Password" required class="box">
         <input type="password" name="cpassword" placeholder="Konfirmasi Password" required class="box">

         <input type="submit" name="submit" value="Daftar" class="btn">
         <p>Sudah punya akun? <a href="login.php">login sekarang</a></p>
      </form>

   </div>

</body>

</html>
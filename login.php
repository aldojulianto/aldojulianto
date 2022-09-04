<?php 
include("koneksi.php"); 
session_start();


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/fonts/icomoon/style.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Login Page || Toko Murah</title>
</head>

<body>
  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('assets/img/udang-bg.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="bg-dark text-white row align-items-center justify-content-center">
          <div class="col-md-7">
            
            <h3 style="text-align: center;">LOGIN PEGAWAI <strong>TOKO MURAH</strong></h3>
            
            
            <!-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> -->
            <br>
            <form action="#" method="post">
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Username" name="user">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="pass">
              </div>

              <input type="submit" name="login" value="Log In" class="btn btn-block btn-danger">
              <br>
 


            </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href );}</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>

  <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($koneksi,$_POST['user']);
      $mypasswordawal = mysqli_real_escape_string($koneksi,$_POST['pass']);
      $mypassword = md5($mypasswordawal);
      
      $sql = "SELECT * FROM login WHERE user = '$myusername' and pass = '$mypassword'";
      $result = mysqli_query($koneksi,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['user'];
      
      $count = mysqli_num_rows($result);
      $count2=1;
      
 

      if($count == 1) {
        //  session_register("myusername");
        $_SESSION['login_user'] = $myusername;
        echo "login berhasil";
        if($row['level']=='admin')
        {echo "<script>Swal.fire({position: 'top-end',icon: 'success',title: 'Selamat Datang Admin',showConfirmButton: false,timer: 1500})</script>";
          header('location:admin/manajemen/home.php');} 
        else if($row['level']=='kasir')
        { echo "<script>Swal.fire({position: 'top-end',icon: 'success',title: 'Selamat Datang Kasir',showConfirmButton: false,timer: 1500})</script>";
          header('location:kasir/transaksi.php');}
      }else{echo "<script>Swal.fire('Password atau Username Salah!', '', 'error')</script>";}}

      
  ?>
</body>

</html>
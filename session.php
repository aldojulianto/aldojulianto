<?php
   include('koneksi.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($koneksi,"select user from login where user = '$user_check' ");
   $ses_sql2 = mysqli_query($koneksi,"select id_login from login where user = '$user_check' ");
   $settingdb = mysqli_query($koneksi, "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $row2 = mysqli_fetch_array($ses_sql2,MYSQLI_ASSOC);
   
   $login_session = $row['user'];
   $id_login = $row2['id_login'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>
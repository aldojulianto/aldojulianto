<?php
include('../../session.php');
include "../../koneksi.php";



$idn=$_GET['baris'];
    $hapus=mysqli_query($koneksi,"Delete from kategori where id_kategori=$idn");
    $_SESSION['sukses'] ="Data Berhasil Dihapus";
    header("location:kategori.php");
?>
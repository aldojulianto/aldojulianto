<?php
include('../../session.php');
include "../../koneksi.php";



$idn=$_GET['baris'];
    $hapus=mysqli_query($koneksi,"Delete from pembelian where id_pembelian=$idn");
    $_SESSION['sukses'] ="Data Berhasil Dihapus";
    header("location:daftarpesanan.php");
?>
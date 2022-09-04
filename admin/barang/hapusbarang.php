<?php
include('../../session.php');
include "../../koneksi.php";



$idn=$_GET['baris'];
    $hapus=mysqli_query($koneksi,"Delete from barang where id_barcode=$idn");
    $_SESSION['sukses'] ="Data Berhasil Dihapus";
    header("location:barang.php");
?>
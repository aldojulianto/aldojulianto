<?php
include('../../session.php');
include "../../koneksi.php";



$idn=$_GET['baris'];
    $hapus=mysqli_query($koneksi,"Delete from supplier where kode_supplier='$idn';");
    $_SESSION['sukses'] ="Data Berhasil Dihapus";
    header("location:supplier.php");
?>
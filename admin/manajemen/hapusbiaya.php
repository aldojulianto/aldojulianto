<?php
include('../../session.php');
include "../../koneksi.php";



$idn=$_GET['baris'];
    $hapus=mysqli_query($koneksi,"Delete from biaya where id_biaya=$idn");
    $_SESSION['sukses'] ="Data Berhasil Dihapus";
    header("location:biaya.php");
?>
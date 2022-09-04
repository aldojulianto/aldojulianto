<?php
    include('../../session.php');
    include "../../koneksi.php";
    
$kode=$_GET['baris'];

mysqli_query($koneksi,"UPDATE `pembelian` SET `tanggal_diterima`=CURRENT_TIMESTAMP(),`aktif`=0 WHERE id_pembelian=$kode");
header("location:daftarpesanan.php");


?>
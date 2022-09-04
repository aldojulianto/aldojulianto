<?php
include('../session.php');
include "../koneksi.php";


$idn=$_GET['baris'];
    mysqli_query($koneksi,"UPDATE `pembelian` SET `status`=1 WHERE id_pembelian=$idn;");
    //ambil jumlah barang
    $data=mysqli_query($koneksi,"select id_barcode from pembelian where id_pembelian=$idn;");

    while($a = mysqli_fetch_array($data)){
        $barcode=$a['id_barcode'];
        $data2=mysqli_query($koneksi,"select stok from barang where id_barcode=$barcode;");
        while($b = mysqli_fetch_array($data2)){
            $stoksekarang=$b['stok'];
        }
        $data3=mysqli_query($koneksi,"select jumlah from pembelian where id_pembelian=$idn and id_barcode=$barcode;");
        while($c = mysqli_fetch_array($data3)){
            $stokpesanan=$c['jumlah'];
        }
        $stokupdate=$stoksekarang+$stokpesanan;

        mysqli_query($koneksi,"UPDATE `pembelian` SET `status`=1,`tanggal_diterima`=current_timestamp() WHERE id_pembelian=$idn;");
        mysqli_query($koneksi,"UPDATE `barang` SET `stok`=$stokupdate,`tgl_update`=current_timestamp() WHERE id_barcode=$barcode;");

    }

    

    $_SESSION['sukses'] ="Barang Berhasil Diterima";
    header("location:terimapesanan.php");
?>
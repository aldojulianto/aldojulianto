<?php 
include "../../koneksi.php";
include "../../session.php";

$id=$_GET['id'];
$idbr=$_GET['idbr'];
$kode=$_GET['kode'];


echo $kode;
    
    $query="delete from pembelian where id_pembelian='$id' and id_barcode='$idbr'";

    if (mysqli_query($koneksi, $query)) {
        echo '<script>alert("Barang telah dihapus")</script>';
        header("location:listbarangpesanan.php?kode=$kode");
      } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
      }

    // echo $id." ".$idbr." ".$idmb." ".$jml." ".$tot;

?>
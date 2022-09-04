<?php 
include "../koneksi.php";
include "../session.php";

$id=$_GET['id'];
$idbr=$_GET['idbr'];
$stokb=$_GET['stok'];

$data=mysqli_query($koneksi,"select stok from barang where id_barcode=$idbr");
while($a = mysqli_fetch_array($data)){
  $stoka=$a['stok'];
}
$totalstok=$stoka+$stokb;

    
    $query="delete from transaksi where id_transaksi='$id' and id_barcode='$idbr'";

    if (mysqli_query($koneksi, $query)) {
        mysqli_query($koneksi,"UPDATE `barang` SET `stok`=$totalstok WHERE id_barcode=$idbr;");
        echo '<script>alert("Barang telah dihapus")</script>';
        header("location:transaksi.php");
      } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
      }

    // echo $id." ".$idbr." ".$idmb." ".$jml." ".$tot;






?>
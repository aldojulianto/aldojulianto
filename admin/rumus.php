<?php
    // include('../../session.php');
    // include "../../koneksi.php";

//D= PENJUALAN
//S= BIAYA PENGIRIMAN
//H= PENGELUARAN SEWA PER TAHUN
//L= LEAD TIME WAKTU PEMESANAN BARANG
//Q= EOQ
// $d=1;$s=1;$h=1;$l=1;$q=1;



function hitungeoq($d, $s, $h){
    $hitung=round(sqrt((2*$d*$s)/($h)));
    return $hitung;
}
function hitungbiaya($h, $q, $s, $d){
    $hitung=round(($h*$q/2)+($s*$d/$q));
    return $hitung;
}
function hitungfrekuensi($d, $q){
    $hitung=round($d/$q);
    return $hitung;
}
function hitungdurasi($hari, $frekuensi){
    $hitung=round($hari/$frekuensi);
    return $hitung;
}
function hitungrop($d, $l, $hari){
    $hitung=round($l*$d/$hari);
    return $hitung;
}
// function bagijumlah($id, $jumlah){
// $data=mysqli_query($koneksi,"select * from alternatif where id_barcode=$id");
// while($a = mysqli_fetch_array($data)){
//     if($jumlah % ){

//     }

// }




?>
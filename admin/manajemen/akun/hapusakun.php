<?php
include('../../../session.php');
include "../../../koneksi.php";

$idn=$_GET['baris'];


$data=mysqli_query($koneksi,"select * from login where id_login=$idn;");
while($a = mysqli_fetch_array($data)){

    if($a['user']==$login_session){
        $hapus=mysqli_query($koneksi,"Delete from login where id_login=$idn");
        $_SESSION['sukses'] ="Data Berhasil Dihapus";
        header("location:../../../logout.php");
    }else{
        $hapus=mysqli_query($koneksi,"Delete from login where id_login=$idn");
        $_SESSION['sukses'] ="Data Berhasil Dihapus";
        header("location:akun.php");
    }
}
?>
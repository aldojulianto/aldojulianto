<?php
include('../../session.php');
include "../../koneksi.php";
include "../rumus.php";

function convert($a){
	if($a==NULL or $a==0){
		$a=1;
	}
	return $a;
}

$id=$_GET['id'];
$idbr=$_GET['idbr'];
$harga=$_GET['harga'];
$data1=mysqli_query($koneksi,"select * from barang a join supplier b on a.kode_supplier=b.kode_supplier where a.id_barcode=$idbr;");
$data2=mysqli_query($koneksi,"select * from toko");
$data3=mysqli_query($koneksi,"select sum(jumlah) as jumlah from transaksi where id_barcode='$idbr' and year(tanggal_input)=year(DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR))");
$data4=mysqli_query($koneksi,"select a.lead_time as lead_time from supplier a join barang b on a.kode_supplier=b.kode_supplier where b.id_barcode=$idbr;");
$biaya=mysqli_query($koneksi,"select sum(biaya) as biaya from biaya where year(tanggal)=year(DATE_ADD(CURRENT_DATE(), INTERVAL -1 YEAR))");


//ambil data 1
while($a = mysqli_fetch_array($data1)){ 
	$biaya_pemesanan=$a['biaya_pengiriman'];
	$nama=$a['nama_barang'];
	$stok=$a['stok'];
	$kode=$a['kode_supplier'];
}
//ambil biaya
while($d = mysqli_fetch_array($biaya)){
	$biayatotal=$d['biaya'];
}
//ambil data 2
while($b = mysqli_fetch_array($data2)){ 
	$biaya_penyimpanan=$b['biaya_gudang']+$b['biaya_listrik']+$biayatotal;
	$hari=$b['hari_kerja'];
}
//ambil data 3
while($c = mysqli_fetch_array($data3)){ 
	$jumlahtransaksi=$c['jumlah'];
}
//ambil data 4
while($f = mysqli_fetch_array($data4)){ 
	$lead=$f['lead_time'];
}

//PERHITUNGAN EOQ
$hitungeoq=hitungeoq(convert($jumlahtransaksi), convert($biaya_pemesanan), convert($biaya_penyimpanan));
// $hitungbiaya="Rp " . number_format(hitungbiaya(convert($biaya_penyimpanan), convert($hitungeoq), convert($biaya_pemesanan), convert($jumlahtransaksi)),2,',','.');
$hitungfrekuensi=hitungfrekuensi(convert($jumlahtransaksi), convert($hitungeoq));
$hitungdurasi=hitungdurasi(convert($hari), convert($hitungfrekuensi));
$hitungrop=hitungrop(convert($jumlahtransaksi), convert($lead), convert($hari));

if(isset($_POST['submit'])) {

	$jumlah   = $_POST['jumlah'];
	$total = intval($jumlah)*intval($harga);
	echo $jumlahtransaksi." ".$biaya_pemesanan." ".$biaya_penyimpanan;


	// echo "biaya penyimpanan = ".$biaya_penyimpanan."Biaya Pengiriman = ".$biaya_pemesanan;
	$query = "INSERT INTO pembelian (id_pembelian, id_barcode, jumlah, total, tanggal_pesan, status, aktif) VALUES ($id, '$idbr', '$jumlah', '$total', CURRENT_TIMESTAMP(), 0, 1);";
	mysqli_query($koneksi,$query);
	header("location:listbarangpesanan.php?kode=$kode");

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="../../assets/css/adminlte.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="../../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/css/inputPO.css">
	<title>Document</title>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">Admin</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
			aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor02">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Manajemen
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="../manajemen/akun/akun.php">Kelola Akun</a>
					<a class="dropdown-item" href="../manajemen/home.php">Informasi Toko</a>
					<a class="dropdown-item" href="../manajemen/pengaturan.php">Pengaturan Toko</a>
				</div>
				</li>
				<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Barang
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="../barang/barang.php">Daftar Barang</a>
					<a class="dropdown-item" href="../barang/kategori.php">Kategori Barang</a>
				</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="daftarpesanan.php">Pembelian</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../supplier/supplier.php">Supplier</a>
				</li>
			</ul>
			<div class="dropdown">
				<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					Welcome <?php echo $login_session; ?>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<a class="dropdown-item" type="button" href="../../logout.php">Log Out</a>
				</div>
			</div>
		</div>
	</nav>
	<br>
	<div class="container-fluid">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-4">
				<h1>PEMESANAN BARANG</h1>
				<h5><?php echo $nama; ?></h5>
				<h5><?php echo "Stok saat ini = ".$stok ?></h5>
				<br>
					<div class="form-group">
                        <label for="jumlah">Masukkan Jumlah Barang yang dipesan</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success">Tambah Barang</button>
                </div>
                <div class="col-md-2">
                </div>
				<div class="col-md-6">
				<H2>Informasi Perhitungan Pemesanan Barang</H2>
				<h2><?php echo $nama ?></h2>
				<br>
					<h5>Jumlah Transaksi Tahun Kemarin = <?php echo $jumlahtransaksi?></h5>
					<h5>Biaya Pemesanan = <?php echo $biaya_pemesanan?></h5>
					<h5>Biaya Penyimpanan = <?php echo $biaya_penyimpanan?></h5>
					<h5>Lead Time = <?php echo $lead." Hari" ?></h5>
					<h5>=================================</h5>
                    <H5>EOQ/Pemesanan ekonomis = <?php echo $hitungeoq; ?> Unit</H5>
                    <!-- <H5>Biaya = <?php echo $hitungbiaya ?></H5> -->
                    <H5>Reorder Point = <?php echo $hitungrop ?></H5>
                    <H5>Durasi Pemesanan = <?php echo $hitungdurasi?> hari sekali</H5>
                    <!-- <H5>Frekuensi = <?php echo $hitungfrekuensi?></H5> -->
				</div>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../assets/plugins/jquery/jquery.min.js"></script>
	<script src="../../assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
	<script src="../../assets/js/adminlte.min.js"></script>
	<script src="../../assets/js/demo.js"></script>
	<script src="../../assets/js/jquery.js"></script>
	<script src="../../assets/js/popper.js"></script>
	<script src="../../assets/js/bootstrap.js"></script>
	<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="../../assets/js/adminlte.js"></script>
	<script src="../../assets/plugins/chart.js/Chart.min.js"></script>
	<script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href );}</script>

</body>

</html>
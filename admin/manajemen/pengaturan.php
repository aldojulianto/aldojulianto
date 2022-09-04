<?php
    include('../../session.php');
    include "../../koneksi.php";


	$data1=mysqli_query($koneksi,"select * from toko")
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
						<a class="dropdown-item" href="akun/akun.php">Kelola Akun</a>
						<a class="dropdown-item" href="home.php">Informasi Toko</a>
						<a class="dropdown-item" href="pengaturan.php">Pengaturan Toko</a>
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
					<a class="nav-link" href="../po/daftarpesanan.php">Pembelian</a>
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
		<h3>PENGATURAN TOKO</h3>
		<br>
			<div class="row">
				<?php while($a=mysqli_fetch_array($data1)){ ?>
					<div class="col-md-4">
						<div class="form-group">
							<label for="nama">NAMA TOKO</label>
							<input type="text" class="form-control" id="nama" name="nama" placeholder="<?php echo $a['nama']; ?>" value="<?php echo $a['nama']; ?>">
						</div>
						<div class="form-group">
							<label for="telp">NOMOR TELEFON</label>
							<input type="text" class="form-control" id="telp" name="telp" placeholder="<?php echo $a['telp']; ?>" value="<?php echo $a['telp']; ?>">
						</div>
						<div class="form-group">
							<label for="alamat">ALAMAT TOKO</label>
							<textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="<?php echo $a['alamat']; ?>" rows="3" ><?php echo $a['alamat']; ?></textarea>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="hari">JUMLAH HARI KERJA</label>
							<input type="text" class="form-control" id="hari" name="hari" placeholder="<?php echo "Hari Kerja/Tahun = ".$a['hari_kerja']; ?>" value="<?php echo $a['hari_kerja']; ?>">
						</div>
						<div class="form-group">
							<label for="gudang">BIAYA SEWA GUDANG/TAHUN</label>
							<input type="text" class="form-control" id="gudang" name="gudang" placeholder="<?php echo "Biaya/Tahun = ".$a['biaya_gudang']; ?>" value="<?php echo $a['biaya_gudang']; ?>">
						</div>
						<!-- <div class="form-group">
							<label for="listrik">BIAYA LISTRIK/TAHUN</label>
							<input type="text" class="form-control" id="listrik" name="listrik" placeholder="<?php echo "Biaya/Tahun = ".$a['biaya_listrik']; ?>" value="<?php echo $a['biaya_listrik']; ?>">
						</div> -->
						<a href="biaya.php" class="btn btn-primary">Detail Tambahan Biaya Lainya</a>
					</div>
					<div class="col-md-4">
					</div>
				<?php } ?>
			</div>
		<button type="submit" name="submit" class="btn btn-success">Update Informasi Toko</button>
		</form>
  	</div>
  <!-- /.content-wrapper -->
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href );}</script>
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
	<script src="../../assets/js/dashboard3.js"></script>
	<script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"autoWidth": false,
			});
		});
	</script>
	<?php 
	if(isset($_POST['submit'])){
		$nama=$_POST['nama'];
		$telp=$_POST['telp'];
		$alamat=$_POST['alamat'];
		$hari=$_POST['hari'];
		$gudang=$_POST['gudang'];
		// $listrik=$_POST['listrik'];

		echo "<script>Swal.fire('Pengaturan Berhasil Di Update!', '', 'success')</script>";
		mysqli_query($koneksi,"UPDATE `toko` SET `nama`='$nama',`alamat`='$alamat',`telp`='$telp',`hari_kerja`='$hari',`biaya_gudang`='$gudang',`biaya_listrik`=0;");
	}

	?>
</body>

</html>
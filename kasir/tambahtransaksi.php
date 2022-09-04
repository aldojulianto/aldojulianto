<?php 
include "../koneksi.php";
include "../session.php";

$id=$_GET['id'];
$idbr=$_GET['idbr'];
$max=$_GET['stok'];

	//simpan data transaksi
	if (isset($_POST['submit'])) 
	{
		//ambil harga
		$harga= mysqli_query($koneksi,"select stok, harga_jual from barang where id_barcode='$idbr';");

		while($h = mysqli_fetch_array($harga)){
			$hargajual=$h["harga_jual"];
			$stok=$h['stok'];
			$jumlah=$_POST['jumlah'];
			$totalstok=$stok-$jumlah;
			$tot=$hargajual*$jumlah;
			echo $hargajual." dan ".$jumlah." dan ".$tot;
			mysqli_query($koneksi,"insert into transaksi values ('$id','$id_login','$idbr','$jumlah','$tot',CURRENT_TIMESTAMP())");
			mysqli_query($koneksi,"UPDATE `barang` SET `stok`=$totalstok WHERE id_barcode=$idbr;");
		}
		header("location:transaksi.php");
	}
	?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="../assets/css/adminlte.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="../assets/css/inputPO.css">
	<title>Document</title>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#">Kasir</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
			aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor02">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="transaksi.php">Transaksi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="daftartransaksi.php">Daftar Transaksi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="cekharga.php">Cek Harga</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="terimapesanan.php">Daftar Pesanan</a>
				</li>
			</ul>
			<div class="dropdown">
				<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					Welcome <?php echo $login_session; ?>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<a class="dropdown-item" type="button" href="../logout.php">Log Out</a>
				</div>
			</div>
		</div>
	</nav>
	<br>
	<div class="container-fluid">


		
<div class="detailtransaksi">
	<div class="form-group col-md-6">
		<form method="POST" action="">
			<label for="jumlah">MASUKKAN JUMLAH ITEM</label>
			<input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Item" width=100px max="<?php echo $max; ?>">
			<br>
			<input type="submit" value="Simpan" name="submit" class="btn btn-primary">
		</form>
	</div>
</div>




		</div>
	</div>
	<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../assets/plugins/jquery/jquery.min.js"></script>
	<script src="../assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
	<script src="../assets/js/adminlte.min.js"></script>
	<script src="../assets/js/demo.js"></script>
	<script src="../assets/js/jquery.js"></script>
	<script src="../assets/js/popper.js"></script>
	<script src="../assets/js/bootstrap.js"></script>
	<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"autoWidth": false,
			});
		});
	</script>
</body>

</html>
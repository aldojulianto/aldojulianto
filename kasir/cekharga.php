<?php
    include('../session.php');
    include "../koneksi.php";


	// menambah kode transaksi baru
	

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
				<li class="nav-item">
					<a class="nav-link" href="transaksi.php">Transaksi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="daftartransaksi.php">Daftar Transaksi</a>
				</li>
				<li class="nav-item active">
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
<div class="container">
<?php 

if (isset($_POST['submit'])) { 
	$id=$_POST['id']; 
	$data=mysqli_query($koneksi,"Select harga_jual from barang where id_barcode='$id';");
	while($d = mysqli_fetch_array($data)){	
?>

	   <h1>Harga Barang = <?php echo $d["harga_jual"]; ?></h1>

<?php  } } ?>

	<form action="" method="post">
	<label for="jumlah">MASUKKAN ID BARCODE</label>
	<input type="text" class="form-control" id="id" name="id" placeholder="ID_BARCODE" width=100px>
	<br>
	<input type="submit" value="Simpan" name="submit" class="btn btn-primary">
	</form>
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
				// "processing": true,
        		// "serverSide": true,
        		// "ajax": "scripts/server_processing.php"
			});
			// $('#example2').DataTable({
			//   "paging": true,
			//   "lengthChange": false,
			//   "searching": false,
			//   "ordering": true,
			//   "info": true,
			//   "autoWidth": false,
			//   "responsive": true,
			// });
		});
	</script>
</body>

</html>
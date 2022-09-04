<?php
    include('../../session.php');
    include "../../koneksi.php";

    $data=mysqli_query($koneksi,"select * from supplier");

    // if (isset($_POST['submit'])) 
	// {
    //     echo $id;
    //     $pemesanan = $_POST['biayapemesanan'];
    //     $penyimpanan = $_POST['biayapenyimpanan'];

    //     mysqli_query($koneksi,"INSERT INTO eoq (id_barcode, biayapemesanan, biayapenyimpanan) VALUES ('$id', $pemesanan, $penyimpanan);");
    //     header("location:eoq.php");
    // }
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
					<a class="nav-link" href="../po/daftarpesanan.php">Pembelian</a>
			</li>
            <li class="nav-item">
					<a class="nav-link" href="supplier.php">Supplier</a>
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
            <div class="row">
                <div class="col-md-8">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                                <tr>
                                    <th scope="col">KODE_SUPPLIER</th>
                                    <th scope="col">NAMA_SUPPLIER</th>
                                    <th scope="col">NO_TELEPON</th>
                                    <th scope="col">BIAYA_PENGIRIMAN</th>
                                    <th scope="col">
                                        <a class="btn btn-success" href="tambahsupplier.php" role="button">Tambah</a>
                                    </th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while($a=mysqli_fetch_array($data)){ ?>
                                    <tr>
                                        <th><?php echo $a["kode_supplier"]; ?></th>
                                        <th><?php echo $a["nama_supplier"]; ?></th>
                                        <th><?php echo $a["telp"]; ?></th>
                                        <th><?php echo $a["biaya_pengiriman"]; ?></th>
                                        <?php $kode=$a['kode_supplier']; ?>
                                        <td>
                                            <?php 
                                            $hasil=mysqli_query($koneksi,"select count(nama_barang) as nama from barang where kode_supplier='$kode'");
                                            if($b = mysqli_fetch_array($hasil)){
                                                if($b['nama']==0){
                                                    ?> <a href="hapussupplier.php?baris=<?php echo $kode;?>" class="btn btn-danger" role="button" aria-disabled="true">Hapus</a> <?php
                                                }else{
                                                    ?> <a href="#" class="btn btn-danger disabled" role="button" aria-disabled="true">Hapus</a> <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                            <?php } ?>
                        </tbody>
				    </table>
                </div>
                <div class="col-md-4">
                    <h4>KETERANGAN</h4>
                    <br>
                    <h5>Jika tombol hapus tidak muncul maka masih terdapat barang yang menggunakan supplier tersebut</h5>
			    </div>
            </div>
        </div>


  <!-- /.content-wrapper -->
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
</body>

</html>
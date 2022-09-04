<?php
    include('../../session.php');
    include "../../koneksi.php";
    include "../rumus.php";

    $id=$_GET['baris'];

    
    $data = mysqli_query($koneksi,"select * from barang a join kategori b on a.id_kategori=b.id_kategori where a.id_barcode=$id");   //where month(tgl_invoice)=month(curdate()) and year(tgl_invoice)=year(curdate())     





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
					<a class="dropdown-item" href="barang.php">Daftar Barang</a>
					<a class="dropdown-item" href="kategori.php">Kategori Barang</a>
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
        <?php while($d = mysqli_fetch_array($data)){ ?>
            <div class="row">
                <div class="col-md-3">
                        <form action="" method="post">
							<div class="form-group">
								<label for="barcode">ID BARCODE</label>
								<input type="text" class="form-control" name="barcode" id="barcode" placeholder="<?php echo $id; ?>" value="<?php echo $id; ?>" disabled>
							</div>
							<div class="form-group">
								<label for="nama">MASUKKAN NAMA</label>
								<input type="text" class="form-control" name="nama" id="nama" placeholder="<?php echo $d['nama_barang']; ?>" value="<?php echo $d['nama_barang']; ?>" required>
							</div>
							<div class="form-group">
								<label for="beli">HARGA BELI</label>
								<input type="text" class="form-control" name="beli" id="beli" placeholder="<?php echo $d['harga_beli']; ?>" value="<?php echo $d['harga_beli']; ?>" required>
							</div>
							<div class="form-group">
								<label for="jual">HARGA JUAL</label>
								<input type="text" class="form-control" name="jual" id="jual" placeholder="<?php echo $d['harga_jual']; ?>" value="<?php echo $d['harga_jual']; ?>" required>
							</div>
							<div class="form-group">
								<label for="satuan">SATUAN</label>
								<input type="text" class="form-control" name="satuan" id="satuan" placeholder="<?php echo $d['satuan_barang']; ?>" value="<?php echo $d['satuan_barang']; ?>" required>
							</div>
							<div class="form-group">
								<label for="stok">STOK</label>
								<input type="text" class="form-control" name="stok" id="stok" placeholder="<?php echo $d['stok']; ?>" value="<?php echo $d['stok']; ?>" disabled>
							</div>
							<br>
							<button type="submit" name="submit" class="btn btn-success">Update Informasi Barang</button>
                        </form>
                </div>
            </div>
        <?php } ?>
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
	<script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"autoWidth": false,
			});
		});
	</script>
	<script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href );}</script>
	<script>
		<?php if(@$_SESSION['sukses']){ ?>
            <script>
                Swal.fire({            
                    icon: 'success',                   
                    title: 'Sukses',    
                    text: 'data berhasil dihapus',                        
                    timer: 3000,                                
                    showConfirmButton: false
                })
            </script>
        <?php unset($_SESSION['sukses']); } ?>
        <script>
            $('.alert_notif').on('click',function(){
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Yakin hapus data?",            
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: "Batal"
                
                }).then(result => {
                    //jika klik ya maka arahkan ke proses.php
                    if(result.isConfirmed){
                        window.location.href = getLink
                    }
                })
                return false;
            });
        </script>
		<?php 
			if(isset($_POST['submit'])) {

				$nama   = $_POST['nama'];
				$beli   = $_POST['beli'];
				$jual   = $_POST['jual'];
				$satuan = $_POST['satuan'];
		
				echo "<script>Swal.fire('Barang Berhasil Di Update!', '', 'success')</script>";
				$query = "UPDATE `barang` SET `nama_barang`='$nama',`harga_beli`='$beli',`harga_jual`='$jual',`tgl_update`=CURRENT_TIMESTAMP() WHERE id_barcode=$id;";
				mysqli_query($koneksi,$query);
				

			}
		?>
</body>

</html>
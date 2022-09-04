<?php
    include('../../session.php');
    include "../../koneksi.php";
	$_SESSION['sukses'] ="Data Berhasil Dihapus";

	//fungsi generate kode pemesanan
	function generateRandomString($length = 10) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
		}
	
	$kodesup=$_GET['kode'];

    $data = mysqli_query($koneksi,"select * from barang b join kategori c on b.id_kategori=c.id_kategori where b.kode_supplier='$kodesup';");   //where month(tgl_invoice)=month(curdate()) and year(tgl_invoice)=year(curdate())     
    
	// mencari transaksi terakhir
	$data2=mysqli_query($koneksi,"SELECT sum(aktif) as aktif from pembelian;");
	while($a = mysqli_fetch_array($data2)){
		$aktif=$a["aktif"];
	}

	if($aktif==0){
	//input nomor transaksi baru
	$kode=date("Ymd").generateRandomString(10);
	}else{
		//menggunakan nomor transaksi lama
		$data3=mysqli_query($koneksi,"SELECT * FROM pembelian WHERE tanggal_pesan IN (SELECT max(tanggal_pesan) FROM pembelian)");
		while($b = mysqli_fetch_array($data3)){
		$kode=$b['id_pembelian'];
		}
	}
	
	//menampilkan pesanan
	$data4=mysqli_query($koneksi,"select *, sum(a.jumlah) as jumlah, b.harga_beli as harga_beli from pembelian a join barang b on a.id_barcode=b.id_barcode where id_pembelian=$kode group by b.id_barcode;");


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
		<!-- <form action="" method="POST">
		<input class="btn btn-danger" type="submit" name="submit" value="+ Transaksi Baru">
		</form> -->

	<!-- Tabel Barang -->
	<div class="cari barang">
        <h4>PILIH BARANG YANG AKAN DIPESAN</h4>
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col" width=50px>No Barcode</th>
					<th scope="col">Nama Barang</th>
					<th scope="col" width=200px>Kategori</th>
					<th scope="col" width=150px>Harga Beli</th>
					<th scope="col" width=150px>Satuan</th>
                    <th scope="col" width=150px>Stok</th>
					<th scope="col" width=100px>Tambah Pesanan</th>
				</tr>
			</thead>
			<tbody>
			<?php 
  			while($d = mysqli_fetch_array($data)){?>
				<tr>
					<th><?php echo $d["id_barcode"]; ?></th>
					<th><?php echo $d["nama_barang"]; ?></th>
					<th><?php echo $d["nama_kategori"]; ?></th>
					<td>Rp. <?php echo number_format($d["harga_beli"],2,',','.');?></td>
					<td><?php echo $d["satuan_barang"]; ?></td>
					<td><?php echo $d["stok"]; ?></td>
					<td>
						<a class="btn btn-danger" href="tambahpesanan.php?id=<?php echo $kode; ?>&idbr=<?php echo $d["id_barcode"]; ?>&harga=<?php echo $d['harga_beli']; ?>&kode=<?php echo $kodesup;?>" role="button">+</a>
					</td>
				</tr>
				<?php } ?>
			
			</tbody>
		</table>
		
	<!-- Tabel Transaksi -->
	<div class="transaksi">
		<h4>Daftar Pesanan</h4>
        <h5>Nomor Pesanan</h5>
        <h5><?php echo $kode; ?></h5>
    </div>
	<table id="example" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col" width=50px>No Barcode</th>
					<th scope="col">Nama Barang</th>
					<th scope="col" width=200px>Harga Beli</th>
                    <th scope="col" width=150px>Satuan</th>
					<th scope="col" width=150px>Jumlah</th>
					<th scope="col" width=150px>Subtotal</th>
					<th scope="col" width=100px>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			//Tabel Perulangan
  			while($c = mysqli_fetch_array($data4)){
				$total=($c['harga_beli']*$c['jumlah']);
  			?>
				<tr>
					<th><?php echo $c["id_barcode"]; ?></th>
					<th><?php echo $c["nama_barang"]; ?></th>
					<td><?php echo number_format($c["harga_beli"],2,',','.');?></td>
					<td><?php echo $c["satuan_barang"]; ?></td>
					<td><?php echo $c["jumlah"]; ?></td>
					<td align="right">Rp. <?php echo number_format($total,2,',','.');?></td>
					<td>
						<a class="btn btn-danger" href="hapuslistpesanan.php?id=<?php echo $kode; ?>&idbr=<?php echo $c["id_barcode"]; ?>&kode=<?php echo $kodesup;?>" role="button">X</a>
					</td>
				</tr>
				<?php } ?>
			<!-- Tabel Perhitungan Total Belanja -->
			<?php
			$ongkos=mysqli_query($koneksi,"select * from supplier where kode_supplier='$kodesup';");
			while($e = mysqli_fetch_array($ongkos)){
				$ongkir=$e["biaya_pengiriman"];
			?>
			<tr>
				<td colspan="5">Ongkos Kirim</td>
				<td align="right">Rp. <?php echo number_format($e["biaya_pengiriman"],2,',','.'); ?></td>
			</tr>
			<?php
			}
			$data5=mysqli_query($koneksi,"SELECT sum(total) as totalbarang FROM `pembelian` WHERE id_pembelian='$kode';");
			while($d = mysqli_fetch_array($data5)){
			?>
			<tr>
				<th colspan="5">Total</th>
				<td align="right">Rp. <?php echo number_format($d["totalbarang"]+$ongkir,2,',','.'); ?></td>
				<td>
					<a type="button" name="cetak" class="btn btn-primary alert_notif" href="selesaikanpesanan.php?baris=<?php echo $kode; ?>">PESAN BARANG</a>
				</td>	
			</tr>
			<?php } ?>
			</tbody>
		</table>


		</div>
	</div>

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
    <script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"autoWidth": false,
			});
		});
	</script>
		<?php 
			if(isset($_POST['submit'])) {

				$barcode   = $_POST['barcode'];
				$jumlah   = $_POST['jumlah'];
		

				$query = "INSERT INTO pembelian (id_barcode, jumlah, tanggal) VALUES ('$barcode', '$jumlah', CURRENT_TIMESTAMP());";
				mysqli_query($koneksi,$query);
				echo "<script>Swal.fire('Barang Berhasil Di Update!', '', 'success')</script>";

			}
		?>
</body>

</html>
<?php
    include('../session.php');
    include "../koneksi.php";
	$_SESSION['sukses'] ="Transaksi Berhasil Disimpan";

	// mencari transaksi terakhir
	$akhirtransaksi=mysqli_query($koneksi,"SELECT * FROM transaksi WHERE tanggal_input IN (SELECT max(tanggal_input) FROM transaksi)");

	while($e = mysqli_fetch_array($akhirtransaksi)){
		$kodecetak=$e["id_transaksi"];
	}

	// data barang
	$data = mysqli_query($koneksi,"select * from barang where stok>0 and harga_jual>0 ");   //where month(tgl_invoice)=month(curdate()) and year(tgl_invoice)=year(curdate())     
			
	//menampilkan data transaksi pada kode transaksi
	$datatransaksi= mysqli_query($koneksi,"select a.id_transaksi, a.id_barcode, sum(a.jumlah) as jumlah, sum(a.total) as total, a.tanggal_input, b.id_kategori, b.nama_barang, b.harga_beli, b.harga_jual, b.satuan_barang, b.stok, tgl_input, tgl_update from transaksi a join barang b on a.id_barcode=b.id_barcode where a.id_transaksi=$kodecetak and a.jumlah>=1 group by b.id_barcode");

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
		<!-- <form action="" method="POST">
		<input class="btn btn-danger" type="submit" name="submit" value="+ Transaksi Baru">
		</form> -->

	<!-- Tabel Barang -->
	<div class="cari barang">
        <h4>List Barang</h4>
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col" width=50px>No Barcode</th>
					<th scope="col">Nama Barang</th>
					<th scope="col" width=200px>Harga</th>
                    <th scope="col" width=150px>Satuan</th>
					<th scope="col" width=150px>Stok</th>
					<th scope="col" width=100px>Tambah Transaksi</th>
				</tr>
			</thead>
			<tbody>
			<?php 
  			while($d = mysqli_fetch_array($data)){?>
				<tr>
					<th><?php echo $d["id_barcode"]; ?></th>
					<th><?php echo $d["nama_barang"]; ?></th>
					<td>Rp. <?php echo number_format($d["harga_jual"],2,',','.');?></td>
					<td><?php echo $d["satuan_barang"]; ?></td>
					<td><?php echo $d["stok"]; ?></td>
					<td>
						<a class="btn btn-danger" href="tambahtransaksi.php?id=<?php echo $kodecetak; ?>&idbr=<?php echo $d["id_barcode"]; ?>&stok=<?php echo $d['stok'];?>" role="button">+</a>
					</td>
				</tr>
				<?php } ?>
			
			</tbody>
		</table>
		
	<!-- Tabel Transaksi -->
	<div class="transaksi">
		<h4>Daftar Transaksi</h4>
        <h5>Nomor Transaksi</h5>
        <h5><?php echo $kodecetak; ?></h5>
    </div>
	<table id="example" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col" width=50px>No Barcode</th>
					<th scope="col">Nama Barang</th>
					<th scope="col" width=200px>Harga</th>
                    <th scope="col" width=150px>Satuan</th>
					<th scope="col" width=150px>Jumlah</th>
					<th scope="col" width=150px>Subtotal</th>
					<th scope="col" width=100px>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			//Tabel Perulangan
  			while($e = mysqli_fetch_array($datatransaksi)){
  			?>
				<tr>
					<th><?php echo $e["id_barcode"]; ?></th>
					<th><?php echo $e["nama_barang"]; ?></th>
					<td><?php echo $e["harga_jual"];?></td>
					<td><?php echo $e["satuan_barang"]; ?></td>
					<td><?php echo $e["jumlah"]; ?></td>
					<td>Rp. <?php echo number_format($e["total"],2,',','.');?></td>
					<td>
						<a class="btn btn-danger" href="hapustransaksi.php?id=<?php echo $kodecetak; ?>&idbr=<?php echo $e["id_barcode"]; ?>&stok=<?php echo $e['jumlah']?>" role="button">X</a>
					</td>
				</tr>
				<?php } ?>
			<!-- Tabel Perhitungan Total Belanja -->
			<tr>
				<?php 
					$total=mysqli_query($koneksi,"SELECT sum(total) as totalbarang FROM `transaksi` WHERE id_transaksi='$kodecetak';");
					while($tot = mysqli_fetch_array($total)){
				?>
				<th colspan="5">Total</th>
				<td>Rp. <?php echo number_format($tot["totalbarang"],2,',','.'); ?></td>
				<?php } ?>
				<?php 
					$jumlah=mysqli_query($koneksi,"SELECT sum(jumlah) as jumlah FROM `transaksi` WHERE id_transaksi='$kodecetak';");
					while($j = mysqli_fetch_array($jumlah)){ $jml=$j['jumlah'];}
				?>
				<td>
					<?php
					if($jml==0){
						?><a type="button" name="cetak" class="btn btn-primary disabled">Cetak/Simpan Transaksi</a>
					<?php }else{ ?>
						<a type="button" name="cetak" class="btn btn-primary alert_notif" href="cetakstruk.php?baris=<?php echo $kodecetak; ?>">Cetak/Simpan Transaksi</a>
					<?php } ?>
				</td>	
			</tr>
			
			</tbody>
		</table>


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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href );}</script>
	<script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"autoWidth": false
			});
		});
	</script>
	<script>
		<?php if(@$_SESSION['sukses']){ ?>
            <script>
                Swal.fire({            
                    icon: 'success',                   
                    title: 'Sukses',    
                    text: 'transaksi berhasil disimpan',                        
                    timer: 3000,                                
                    showConfirmButton: false
                })
            </script>
        <?php unset($_SESSION['sukses']); } ?>
        <script>
            $('.alert_notif').on('click',function(){
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Yakin Transaksi Baru & Cetak Nota?",            
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
</body>
</html>
<?php
    include('../../session.php');
    include "../../koneksi.php";
	$_SESSION['sukses'] ="Data Berhasil Dihapus";
	$_SESSION['diterima'] ="Barang Telah Diterima";
    $data = mysqli_query($koneksi,"SELECT id_pembelian, sum(jumlah) as jumlah, sum(total) as total,tanggal_pesan, tanggal_diterima, sum(status) as status from pembelian group by id_pembelian"); 
    
	


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
        <h2>TABEL ANTRIAN PEMESANAN</h2>
		<a type="button" class="btn btn-success" href="pilihsupplier.php">Pesan Barang</a>
		<br><br>

		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col">ID_Pemesanan</th>
					<th scope="col">Jumlah Barang</th>
                    <!-- <th scope="col">Total Pesanan</th> -->
					<th scope="col">tgl_pesan</th>
					<th scope="col">tgl_diterima</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php while($d = mysqli_fetch_array($data)){ ?>
				<tr>
					<th><?php echo $d["id_pembelian"]; ?></th>
					<td><?php echo $d["jumlah"]; ?></td>
                    <!-- <td><?php echo $d["total"]; ?></td> -->
					<td><?php echo $d["tanggal_pesan"]; ?></td>
					<td><?php echo $d["tanggal_diterima"]; ?></td>
					<?php $status=$d['status']; ?>
					<td>
						<?php 
						if($status==0){ ?>
							<a class="btn btn-primary" href="cetak.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">CETAK PO/DETAIL PESANAN</a>
							<!-- <a class="btn btn-success alert_notif_diterima" href="barangditerima.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">TERIMA BARANG</a> -->
							<a class="btn btn-danger alert_notif" href="hapuspesanan.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">BATALKAN</a>	
						<?php }else{ ?>
							<a class="btn btn-primary" href="cetak.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">CETAK PO/DETAIL PESANAN</a>
							<a class="btn btn-success alert_notif_diterima disabled" href="barangditerima.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">BARANG TELAH DITERIMA</a>
						<?php } ?>
						<!-- <a class="btn btn-danger  alert_notif" href="hapuspesanan.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">X</a>
						<a class="btn btn-primary" href="cetakpo.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">CETAK PO</a>
						<a class="btn btn-success alert_notif_diterima" href="barangditerima.php?baris=<?php echo $d['id_pembelian'] ?>" role="button">BARANG DITERIMA</a> -->
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
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
    <script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"autoWidth": false,
			});
		});
	</script>
	
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

		<script>
		<?php if(@$_SESSION['diterima']){ ?>
            <script>
                Swal.fire({            
                    icon: 'success',                   
                    title: 'Sukses',    
                    text: 'data berhasil ditambahkan ke stok',                        
                    timer: 3000,                                
                    showConfirmButton: false
                })
            </script>
        <?php unset($_SESSION['diterima']); } ?>
        <script>
            $('.alert_notif_diterima').on('click',function(){
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Barang Telah Diterima?",            
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

				$barcode   = $_POST['barcode'];
				$jumlah   = $_POST['jumlah'];
		

				$query = "INSERT INTO pembelian (id_barcode, jumlah, tanggal) VALUES ('$barcode', '$jumlah', CURRENT_TIMESTAMP());";
				mysqli_query($koneksi,$query);
				echo "<script>Swal.fire('Barang Berhasil Di Update!', '', 'success')</script>";

			}
		?>
</body>

</html>
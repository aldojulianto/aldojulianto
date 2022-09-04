<?php
    include('../session.php');
    include "../koneksi.php";
	$_SESSION['sukses'] ="Data Berhasil Dihapus";
	$_SESSION['diterima'] ="Barang Telah Diterima";

    $idpesanan=$_GET['baris'];
    $data = mysqli_query($koneksi,"SELECT b.harga_beli as harga, b.id_barcode, b.nama_barang, a.nama_supplier, c.id_pembelian, sum(c.jumlah) as jumlah, sum(c.total) as total,c.tanggal_pesan, c.tanggal_diterima, sum(c.status) as status from supplier a join barang b on a.kode_supplier=b.kode_supplier join pembelian c  on b.id_barcode=c.id_barcode where c.id_pembelian=$idpesanan group by b.id_barcode"); 
    


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
		<a class="navbar-brand" href="#">Admin</a>
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
				<li class="nav-item">
					<a class="nav-link" href="cekharga.php">Cek Harga</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="terimapesanan.php">Daftar Pesanan</a>
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
        <h2>DETAIL PEMESANAN</h2>
        <h5>ID = <?php echo $idpesanan ?></h5>
		<br><br>

		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col">ID_Barcode</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Nama Barang</th>
					<th scope="col">Jumlah Barang</th>
                    <th scope="col">Harga/Barang</th>
                    <th scope="col">Total Pesanan</th>
				</tr>
			</thead>
			<tbody>
				<?php while($d = mysqli_fetch_array($data)){ ?>
				<tr>
					<td><?php echo $d["id_barcode"]; ?></td>
                    <td><?php echo $d["nama_supplier"]; ?></td>
                    <td><?php echo $d["nama_barang"]; ?></td>
                    <td><?php echo $d["jumlah"]; ?></td>
                    <td align="right">Rp. <?php echo number_format($d["harga"],2,',','.');?></td> 
                    <td align="right">Rp. <?php echo number_format($d["total"],2,',','.');?></td> 
				</tr>
                <?php } 
                $data2=mysqli_query($koneksi,"select * from pembelian a join barang b on a.id_barcode=b.id_barcode join supplier c on b.kode_supplier=c.kode_supplier where id_pembelian=$idpesanan group by c.kode_supplier");
                $data3=mysqli_query($koneksi,"select sum(total) as total from pembelian where id_pembelian=$idpesanan");
                while($a = mysqli_fetch_array($data2)){
                ?>
                <tr>
                    <th colspan=5>Ongkos Kirim</th>
                    <td align="right">Rp. <?php echo number_format($a["biaya_pengiriman"],2,',','.');?></td>
                    
                </tr>
                <?php 
                $ongkir=$a["biaya_pengiriman"];
                } 
                while($b = mysqli_fetch_array($data3)){
                ?>
                <tr>
                    <th colspan=5>Grand Total</th>
                    <td align="right">Rp. <?php echo number_format($ongkir+$b['total'],2,',','.');?></td>
                </tr>
                <?php } ?>
			</tbody>
		</table>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
	<script src="../assets/js/adminlte.js"></script>
	<script src="../assets/plugins/chart.js/Chart.min.js"></script>
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
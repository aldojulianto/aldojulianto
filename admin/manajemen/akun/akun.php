<?php
    include('../../../session.php');
    include "../../../koneksi.php";
	$_SESSION['sukses'] ="Data Berhasil Dihapus";
    $data = mysqli_query($koneksi,"select * from login"); 
	// header("Refresh:0"); 
	
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../../assets/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="../../../assets/css/adminlte.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="../../../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="../../../assets/css/inputPO.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                        <a class="dropdown-item" href="akun.php">Kelola Akun</a>
                        <a class="dropdown-item" href="../home.php">Informasi Toko</a>
                        <a class="dropdown-item" href="../pengaturan.php">Pengaturan Toko</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Barang
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../../barang/barang.php">Daftar Barang</a>
                        <a class="dropdown-item" href="../../barang/kategori.php">Kategori Barang</a>
                    </div>
                </li>
				<li class="nav-item">
					<a class="nav-link" href="../../po/daftarpesanan.php">Pembelian</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../supplier/supplier.php">Supplier</a>
				</li>
			</ul>
			<div class="dropdown">
				<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
					aria-haspopup="true" aria-expanded="false">
					Welcome <?php echo $login_session; ?>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<a class="dropdown-item" type="button" href="../../../logout.php">Log Out</a>
				</div>
			</div>
		</div>
	</nav>
	<br>
	<div class="container-fluid">
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-primary">
			+ Tambah Akun
		</button>		
		<br><br>

		<div class="modal fade" id="modal-primary">
			<div class="modal-dialog">
				<div class="modal-content bg-dark">
					<div class="modal-header">
						<h4 class="modal-title">Tambah Akun</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form role="form" method="POST" action="">
							<div class="card-body">
								<div class="dropdown">
								<label for="level" class="control-label">Pilih Jenis Akun</label><br>
									<select class="form-select" aria-label="Default select example" name="level[]" >
										<option value="" disabled selected>Choose option</option>
										<option value="admin">ADMIN</option>
                                        <option value="kasir">KASIR</option>
									</select>
								</div>
								<br>
								<div class="form-group">
									<label for="user">Nama User</label>
									<input type="text" class="form-control" id="user" name="user" required>
								</div>
                                <div class="form-group">
									<label for="pass">Password</label>
									<input type="password" class="form-control" id="pass" name="pass" required>
								</div>
                                
							</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
						<button type="submit" name="submit" class="btn btn-outline-light">Save</button>
					</div>
					</form>
				</div>
			</div>
		</div>

		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nama User</th>
					<th scope="col">Level</th>
				</tr>
			</thead>

			<tbody>
				<?php
  while($d = mysqli_fetch_array($data)){
  
  ?>
				<tr>
					<th><?php echo $d["id_login"]; ?></th>
					<td><?php echo $d["user"]; ?></td>
					<td><?php echo $d["level"]; ?></td>
					<td>
						<a class="btn btn-danger alert_notif" href="hapusakun.php?baris=<?php echo $d['id_login']; ?>">X</a>
					</td>
				</tr>
				<?php
  }
  ?>
			</tbody>
		</table>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="../../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../../assets/plugins/jquery/jquery.min.js"></script>
	<script src="../../../assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
	<script src="../../../assets/js/adminlte.min.js"></script>
	<script src="../../../assets/js/demo.js"></script>
	<script src="../../../assets/js/jquery.js"></script>
	<script src="../../../assets/js/popper.js"></script>
	<script src="../../../assets/js/bootstrap.js"></script>
	<script src="../../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href );}</script>
	<script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true,
				"autoWidth": false,
			});
		});
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
				$user   = $_POST['user'];
				$pass   = $_POST['pass'];


				if(!empty($_POST['level'])) {
					foreach($_POST['level'] as $level){
					
					$result = mysqli_query($koneksi,"SELECT * FROM login where user='$user' and level='$level';");

					if(mysqli_num_rows($result) > 0)
					while($row = mysqli_fetch_array($result))
					{
						echo "<script>Swal.fire('Gagal Menambahkan Akun','Username dan Level sudah digunakan!','question')</script>";
						// echo "<script>location.reload();</script>";
					} else {
						$mdpass=md5($pass);
						$query = "INSERT INTO login (level, user, pass) VALUES ('$level', '$user', '$mdpass');";
						mysqli_query($koneksi,$query);
						echo "<script>Swal.fire('Akun Berhasil Ditambahkan!', '', 'success')</script>";
					}
					}          
				} else {
					echo 'Please select the value.';
				}
			}

		?>
</body>

</html>
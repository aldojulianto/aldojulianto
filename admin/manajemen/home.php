<?php
include('../../session.php');
include "../../koneksi.php";
include "../rumus.php";
$nama_barang="";$jumlah="";$nama_barang2="";$jumlah2="";

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

$barang=mysqli_query($koneksi,"SELECT LEFT(b.nama_barang,8) as 'Nama Barang',sum(a.jumlah) as 'Jumlah', max(a.jumlah) as 'max' from transaksi a join barang b on a.id_barcode=b.id_barcode where month(a.tanggal_input)=month(curdate()) group by b.nama_barang order by jumlah desc LIMIT 5");
while($data = mysqli_fetch_array($barang)) {

  //data barang
  $brg=$data['Nama Barang'];
  $nama_barang .= "'$brg'". ", ";
  //data jumlah
  $jum=$data['Jumlah'];
  $jumlah .= "$jum". ", ";
  //maximal data jumlah
  $max=$data['max'];
}
//menghitung pendapatan bulan ini
$pendapatanbulanini=mysqli_query($koneksi,"select sum((a.harga_jual-a.harga_beli)*b.jumlah) as untung from barang a join transaksi b on a.id_barcode=b.id_barcode where month(b.tanggal_input)=month(curdate())");
while($data2 = mysqli_fetch_array($pendapatanbulanini)) {

  $untungtotal= "Rp " . number_format($data2['untung'],2,',','.');
}
//menghitung pendapatan bulan ini per barang
$pendapatanbulanini=mysqli_query($koneksi,"select LEFT(a.nama_barang,8) as nama,sum((a.harga_jual-a.harga_beli)*b.jumlah) as untung from barang a join transaksi b on a.id_barcode=b.id_barcode where month(b.tanggal_input)=month(curdate()) group by a.nama_barang order by untung desc LIMIT 5");
while($data2 = mysqli_fetch_array($pendapatanbulanini)) {

  $brg2=$data2['nama'];
  $nama_barang2 .= "'$brg2'". ", ";
  $jum2=$data2['untung'];
  $jumlah2 .= "$jum2". ", ";
}
//Menghitung jumlah barang bulan ini
$jumlahtotalbarang=mysqli_query($koneksi,"select sum(jumlah) as tot from transaksi where month(tanggal_input)=month(curdate())");
while($jm = mysqli_fetch_array($jumlahtotalbarang)) {
  $tot=$jm['tot'];
}

//perhitungan notifikasi EOQ
$eoq=mysqli_query($koneksi,"SELECT b.id_barcode as id_barcode, b.harga_jual as jual, b.kode_supplier as kode_supplier, b.nama_barang as nama, IF((b.stok)<=(a.lead_time*sum(c.jumlah)/(select hari_kerja from toko)),1,0) as notif FROM supplier a join barang b on a.kode_supplier=b.kode_supplier join transaksi c on b.id_barcode=c.id_barcode group by b.id_barcode;");


// mencari transaksi terakhir
$data3=mysqli_query($koneksi,"SELECT sum(aktif) as aktif from pembelian;");
while($a = mysqli_fetch_array($data3)){
  $aktif=$a["aktif"];
}

if($aktif==0){
//input nomor transaksi baru
$kode=date("Ymd").generateRandomString(10);
}else{
  //menggunakan nomor transaksi lama
  $data6=mysqli_query($koneksi,"SELECT * FROM pembelian WHERE tanggal_pesan IN (SELECT max(tanggal_pesan) FROM pembelian)");
  while($b = mysqli_fetch_array($data6)){
  $kode=$b['id_pembelian'];
  }
}


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
        <li class="nav-item dropdown style notif">
          <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- <span class="dropdown-item dropdown-header">15 Notifications</span> -->
          <?php 
          while( $z = mysqli_fetch_array($eoq)){ 
            
            if($z['notif']==1){
            ?>
            <div class="dropdown-divider"></div>
            <a href="../po/tambahpesanan.php?id=<?php echo $kode;?>&idbr=<?php echo $z['id_barcode'];?>&harga=<?php echo $z['jual'];?>&kode=<?php echo $z['kode_supplier'];?>" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i><?php echo $z['nama'];?> *
            </a>
          <?php } }  ?>
          <div class="dropdown-divider"></div>
            <!-- <a href="#" class="dropdown-item dropdown-footer">Tampilkan Detail Notifikasi</a> -->
            <center><small>Ket : * Perlu di restock</small></center>
          </div>
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
	<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">

            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Total Penjualan Barang Bulan Ini</h3>
                  <a href="detilpenjualan.php">Detail Penjualan Bulan Ini</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?php echo "Total Barang = ".$tot; ?></span>
                    <span>Barang Terlaku Bulan Ini</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>
              </div>
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Total Pendapatan Toko Murah Bulan ini</h3>
                  <a href="detilpemasukan.php">Detail Pendapatan Bulan Ini</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?php echo $untungtotal; ?></span>
                    <span>Detail Pendapatan</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
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
	<!-- <script src="../../assets/js/dashboard3.php"></script> -->
	<script>
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }
  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: [<?php echo $nama_barang2; ?>],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [<?php echo $jumlah2; ?>]
        }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {

              }

              return 'Rp. ' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  var $visitorsChart = $('#visitors-chart')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels: [<?php echo $nama_barang; ?>],
      datasets: [{
        type: 'line',
        data: [<?php echo $jumlah; ?>],
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: <?php echo $max; ?>
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
})

// lgtm [js/unused-local-variable]

</script>
</body>

</html>
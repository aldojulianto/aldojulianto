<?php
include('../../session.php');
include "../../koneksi.php";

$data = mysqli_query($koneksi,"SELECT b.id_barcode as id, b.nama_barang as 'nama',sum(a.jumlah) as 'jumlah', max(a.jumlah) as 'max' from transaksi a join barang b on a.id_barcode=b.id_barcode where month(a.tanggal_input)=month(curdate()) group by b.nama_barang order by jumlah desc");

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
        <table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col">ID_Barang</th>
					<th scope="col">Nama Barang</th>
					<th scope="col">Jumlah Total Penjualan</th>
                    <th scope="col">Jumlah Pembelian Terbanyak</th>
				</tr>
			</thead>

			<tbody>
				<?php while($d = mysqli_fetch_array($data)){ ?>
				<tr>
					<th><?php echo $d["id"]; ?></th>
					<td><?php echo $d["nama"]; ?></td>
					<td><?php echo $d["jumlah"]; ?></td>
                    <td><?php echo $d["max"]; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
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
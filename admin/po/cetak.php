<?php 
	include '../../koneksi.php';

    $id=$_GET['baris'];
    $data=mysqli_query($koneksi,"select *, a.jumlah as jumlah from pembelian a join barang b on a.id_barcode=b.id_barcode join supplier c on b.kode_supplier=c.kode_supplier where a.id_pembelian=$id;");
    $data2=mysqli_query($koneksi,"select * from toko");
	$data3=mysqli_query($koneksi,"select sum(total) as total from pembelian where id_pembelian=$id");
	function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
        return $hasil_rupiah;
    }

?>
<html>
<head>
	<title>.</title>
	<link rel="stylesheet" href="/assets/css/stylecetak.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<style type="text/css">
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
		font-family: 12pt "Times New Roman", Times, serif;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 10mm;
        margin: 5mm;
		margin-top: 25mm;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 257mm;
        outline: 2cm #FFEAEA solid;
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
</style>
</head>
<body>
	<div class="page" id="printableArea">
		<div class="container-fluid">
		<div class="row">
			<?php while($b = mysqli_fetch_array($data2)){ ?>
				<div class="col-md-5">
					<h1><?php echo strtoupper($b['nama']);?></h1>
					<small><?php echo $b['alamat']." ".$b['telp'];?></small>
				</div>
				<div class="col-md-2">

				</div>
				<div class="col-md-5">
					<h5>PURCHASE ORDER ID : <?php echo $id;?></h5>
					<h5><?php echo "";?></h5>
				</div>
			<?php } ?>
		</div>
		<br>
		<br>

 
 
			<table border="1" style="width: 100%" id="t01">
				<tr>
					<th scope="col">ID Barcode</th>
					<th scope="col">Nama Barang</th>
					<th scope="col">Harga Beli</th>
					<th scope="col">Qty</th>
					<th scope="col">Jumlah</th>
				</tr>
				<?php
				$no = 1;
				while($a = mysqli_fetch_array($data)){
					$total=$a['jumlah']*$a['harga_beli'];
					$kode=$a['kode_supplier'];
				?>
				<tr>
				<td><?php echo $a["id_barcode"]; ?></td>
				<td><?php echo $a["nama_barang"]; ?></td>
				<td><?php echo rupiah($a["harga_beli"]); ?></td>
				<td align="right"><?php echo $a["jumlah"]; ?></td>
				<td><?php echo rupiah($total); ?></td>
				<!-- <td><?php echo $a["tgl_lunas"]; ?></td> -->
				</tr>
				<?php } ?>
				<?php 
				$data4=mysqli_query($koneksi,"select * from supplier where kode_supplier='$kode';");
				while($d = mysqli_fetch_array($data4)){ ?>
				<tr>
					<td colspan="4">Ongkos Kirim Supplier</td>
					<?php $ongkir=$d['biaya_pengiriman'];?>
					<td align="right"><?php echo rupiah($d['biaya_pengiriman']); ?></td>
				</tr>
				<?php } ?>
				<?php while($b = mysqli_fetch_array($data3)){ ?>
				<tr>
					<th colspan="4">GRAND TOTAL</th>
					<td align="right"><?php echo rupiah($b['total']+$ongkir); ?></td>
				</tr>
				<?php } ?>
			</table>
			<br>
			<br>
			<br>
			<br>
			<div class="row">
				<div class="col-md-3">
					<?php echo "----------------------";?>
				</div>
				<div class="col-md-4">

				</div>
				<div class="col-md-3">
					<?php 
					echo "----------------------";
					echo "Toko Murah"

					?>
				</div>
			</div>
		</div>
	</div>
	<input type="button" onclick="printDiv('printableArea')" value="print a div!" />
 </div>
	<!-- <script>
		window.print();
	</script> -->
	<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../assets/plugins/jquery/jquery.min.js"></script>
	<script src="../../assets/js/jquery.js"></script>
	<script src="../../assets/js/popper.js"></script>
	<script src="../../assets/js/bootstrap.js"></script>
	<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href );}</script>
	<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
	}
	</script>
 
</body>
</html>
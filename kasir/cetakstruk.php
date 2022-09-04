<?php
include ('../koneksi.php');
include ('../session.php');


$id=$_GET['baris'];
$data = mysqli_query($koneksi,"select *,sum(b.jumlah) as jumlah from barang a join transaksi b on a.id_barcode=b.id_barcode where b.id_transaksi=$id and b.jumlah>=1 group by a.id_barcode;");
$data2 = mysqli_query($koneksi,"select sum(total) as grandtotal from transaksi where id_transaksi=$id;");
$data3 = mysqli_query($koneksi,"select * from toko;");
$data4 = mysqli_query($koneksi,"select *,current_timestamp() as tgl from transaksi a join login b on a.id_login=b.id_login where a.id_transaksi=$id group by a.id_login;");

?>
<!DOCTYPE html>
<html lang="en" >
 
<head>
 
  <meta charset="UTF-8">
  <title>Cetak Struk</title>
 
  <style>
@media print {
    .page-break { display: block; page-break-before: always; }
}
      #invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 44mm;
  background: #FFF;
}
#invoice-POS ::selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS ::moz-selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS h1 {
  font-size: 1.5em;
  color: #222;
}
#invoice-POS h2 {
  font-size: .9em;
}
#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
#invoice-POS p {
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
  /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}
#invoice-POS #top {
  min-height: 100px;
}
#invoice-POS #mid {
  min-height: 80px;
}
#invoice-POS #bot {
  min-height: 50px;
}
#invoice-POS .info {
  display: block;
  margin-left: 0;
}
#invoice-POS .title {
  float: right;
}
#invoice-POS .title p {
  text-align: right;
}
#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
}
#invoice-POS .tabletitle {
  font-size: .5em;
  background: #EEE;
}
#invoice-POS .service {
  border-bottom: 1px solid #EEE;
}
#invoice-POS .item {
  width: 24mm;
}
#invoice-POS .itemtext {
  font-size: .5em;
}
#invoice-POS #legalcopy {
  margin-top: 5mm;
}
 
    </style>
 
  <script>
  window.console = window.console || function(t) {};
</script>
 
 
 
  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>
 
 
</head>
 
<body translate="no" >
 
 
  <div id="invoice-POS">
 
    <!-- <center id="top">
      <div class="logo"></div>
      <div class="info"> 
        <h2>SistemIT.com</h2>
      </div>
    </center> -->
 
    <div id="mid">
      <div class="info">
        <?php while($a = mysqli_fetch_array($data3)){?>
        <center><h2><?php echo strtoupper($a['nama']);?></h2></center>
        <center>
          <p> 
            <?php echo strtoupper($a['alamat']);?><br>
            <?php echo "Telepon : ".$a['telp'];?>
            </br>
          </p>
        </center>
        <?php } ?>

        <?php while($c = mysqli_fetch_array($data4)){?>
        <div class="row">
          <div class="col-md-6">
            <p>Kasir : <?php echo $c['user'];?> <br> <?php echo $c['tgl'];?></p>
          </div>
          <div class="col-md-6">
          </div>
        </div>
        <?php } ?>
      </div>
    </div><!--End Invoice Mid-->
 
    <div id="bot">
                    <div id="table">
                        <table>
                            <tr class="tabletitle">
                                <td class="item"><h2>Item</h2></td>
                                <td class="Hours"><h2>Qty</h2></td>
                                <td class="Rate"><h2>Sub Total</h2></td>
                            </tr>
                        <?php 
                        while($d=mysqli_fetch_array($data)){ ?>

                            <tr class="service">
                                <td class="tableitem"><p class="itemtext"><?php echo $d['nama_barang'] ;?></p></td>
                                <td class="tableitem"><p class="itemtext"><?php echo $d['jumlah'] ;?></p></td>
                                <td class="tableitem"><p class="itemtext"><?php echo "Rp " . number_format($d['total'],2,',','.') ;?></p></td>
                            </tr>
                            
                        <?php } 

                        while($e=mysqli_fetch_array($data2)){ ?>
                            <tr class="tabletitle">
                                <td></td>
                                <td class="Rate"><h2>Total</h2></td>
                                <td class="payment"><h2><?php echo "Rp " . number_format($e['grandtotal'],2,',','.') ;?></h2></td>
                            </tr>
                        <?php } ?>

 
                        </table>
                    </div><!--End Table-->
 
                    <div id="legalcopy">
                        <p class="legal"><strong>Terimakasih Telah Berbelanja!</strong>  Barang yang sudah dibeli tidak dapat dikembalikan. Jangan lupa berkunjung kembali
                        </p>
                    </div>
 
                </div><!--End InvoiceBot-->
  </div><!--End Invoice-->


<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
  // menambah kode transaksi baru
        // generate kode transaksi
        function generateRandomString($length = 10) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
            }

            //input nomor transaksi baru
            $kode=generateRandomString(10).date("Ymd");
            mysqli_query($koneksi,"INSERT INTO `transaksi`(`id_transaksi`,`id_login`,`tanggal_input`) VALUES ('$kode',$id_login,CURRENT_TIMESTAMP())");
            echo "<script>Swal.fire('Transaksi Berhasil Disimpan!', '', 'success')</script>";
         ?>
 
</body>
 
</html>
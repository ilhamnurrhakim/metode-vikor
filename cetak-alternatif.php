<?php 
// include './../koneksi/koneksi.php'; 
require_once('includes/init.php');

$date = new DateTime();
$formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
$formatter->setPattern('d MMMM yyyy');
$tgl = $formatter->format($date);
error_reporting(false);
 session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="shortcut icon" href="assets/images/logo-sman-5.png"/>
   <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
   <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="plugins/font awesome/font-awesome.min.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Laporan</title>
</head>

<style type="text/css" media="print">

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 5px;
    line-height: 0.9;

}
</style>
<style type="text/css" media="screen">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 5px;
    line-height: 0.9;


}
</style>

<body onload="window.print();">
<table width="100%">
    <tr>
        <td width="15%" align="center">
            <img src="assets/img/smkn1.jpg" alt="" style="width:100px;height:70px;">
        </td>
        <td width="85%" align="center">
            <h4 style="margin: 0;">SEKOLAH MENENGAH KEJURUAN NEGERI 1 SOLOK SELATAN</h4>
            <h5 style="margin: 0;">Jl. Raya Koto Baru Jl. Raya Muara Labuh No.KM. 3, Pulakek Koto Baru, Kec. Sungai Pagu, Kabupaten Solok Selatan, Sumatera Barat 27776</h5>
        </td>
    </tr>
</table>

	
	<div style="border-bottom: 2px solid #555;  margin-bottom: 20px;">
		<div style="width:100%; float: left; ">
      <br>
  <center>Laporan  Alternatif Pertukaran Pelajar</center>  
  <center>Tanggal : <b><?php echo $tgl ?></b></center>

 
  </div>
  </div>
  <div style="width: 100%;float: left">
  <br>
  <br>
  <table width="100%" cellspacing="0" cellpadding="5" border="1">
                      
  <thead>
  <tr align="center">	
						<th width="5%">No</th>
						<th>NIS</th>
						<th>Nama</th>
						<th>Jenis Kelamin</th>
						<th>Telephone</th>
						<th>Alamat</th>
					</tr>
				</thead>
				<tbody>			
				<?php
				$no=0;
				$query = mysqli_query($koneksi,"SELECT * FROM alternatif");			
				while($data = mysqli_fetch_array($query)):
				$no++;
				?>
					<tr align="center">
						<td><?php echo $no; ?></td>
						<td align="left"><?php echo $data['nis']; ?></td>
						<td align="left"><?php echo $data['nama']; ?></td>
						<td align="left"><?php echo $data['jk']; ?></td>
						<td align="left"><?php echo $data['nohp']; ?></td>
						<td align="left"><?php echo $data['alamat']; ?></td>
						
					</tr>
				<?php endwhile; ?>
				</tbody>            
                  </table>
                  <br>
                  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" >
<tr>
	<td width="63%" bgcolor="#FFFFFF">
		<p align="center"></p><br/>
	</td>
 	<td width="37%" bgcolor="#FFFFFF">
		<br> 
		<br> 
   <div align="center">Solok Selatan, <?php 
		echo " $tgl";?><br/>
		Kepala Sekolah SMKN 1 Solok Selatan
		<br/><br/>
		<br/><br/>
		<br/><br/>

    <?php
   // Ambil data dari session
   if (isset($_SESSION['tmpnama'])) {
    $tmpnama = $_SESSION['tmpnama'];
   }
   if (isset($_SESSION['tmpalamat'])) {
    $tmpalamat = $_SESSION['tmpalamat'];
   }
   // End script ambil data
  ?>
  <?php 
  for ($i=0; $i < count($tmpalamat); $i++) {
   ?>
     <strong><u> <?= $tmpalamat[$i]; ?></u> </strong>
      <?php } ?>
  
<br>
<?php 
  for ($i=0; $i < count($tmpnama); $i++) {
   ?>
      <?= $tmpnama[$i]; ?>
      <?php } ?>
    </div>
</td> 
  </tr>
</table> 
</body>
</html>

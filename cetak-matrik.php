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
  <center>Laporan  Hasil Perhitungan Pertukaran Pelajar</center>  
  <center>Tahun : <b><?php echo date('Y',strtotime($_GET['tgl1'])); ?></b></center>

 
  </div>
  </div>
  <div style="width: 100%;float: left">

<?php
 $tanggal=$_GET['tgl1'];
$kriterias = array();
$q1 = mysqli_query($koneksi,"SELECT * FROM kriteria ORDER BY kode_kriteria ASC");			
while($krit = mysqli_fetch_array($q1)){
	$kriterias[$krit['id_kriteria']]['id_kriteria'] = $krit['id_kriteria'];
	$kriterias[$krit['id_kriteria']]['kode_kriteria'] = $krit['kode_kriteria'];
	$kriterias[$krit['id_kriteria']]['nama'] = $krit['nama'];
	$kriterias[$krit['id_kriteria']]['bobot'] = $krit['bobot'];
	$kriterias[$krit['id_kriteria']]['ada_pilihan'] = $krit['ada_pilihan'];
}

$alternatifs = array();
$q2 = mysqli_query($koneksi,"SELECT * FROM penilaian INNER JOIN alternatif on penilaian.id_alternatif=alternatif.id_alternatif  WHERE penilaian.tgl ='$tanggal'");				
while($alt = mysqli_fetch_array($q2)){
	$alternatifs[$alt['id_alternatif']]['id_alternatif'] = $alt['id_alternatif'];
	$alternatifs[$alt['id_alternatif']]['nama'] = $alt['nama'];
} 

//Matrix Keputusan (X)
$matriks_x = array();
foreach($alternatifs as $alternatif):
	foreach($kriterias as $kriteria):
		
		$id_alternatif = $alternatif['id_alternatif'];
		$id_kriteria = $kriteria['id_kriteria'];
		
		if($kriteria['ada_pilihan']==1){
			$q4 = mysqli_query($koneksi,"SELECT sub_kriteria.nilai FROM penilaian JOIN sub_kriteria WHERE penilaian.nilai=sub_kriteria.id_sub_kriteria AND penilaian.id_alternatif='$alternatif[id_alternatif]' AND penilaian.id_kriteria='$kriteria[id_kriteria]' AND penilaian.tgl ='$tanggal'");
			$data = mysqli_fetch_array($q4);
			$nilai = $data['nilai'];
		}else{
			$q4 = mysqli_query($koneksi,"SELECT nilai FROM penilaian WHERE id_alternatif='$alternatif[id_alternatif]' AND id_kriteria='$kriteria[id_kriteria]'  AND penilaian.tgl ='$tanggal' ");
			$data = mysqli_fetch_array($q4);
			$nilai = $data['nilai'];
		}
		$matriks_x[$id_kriteria][$id_alternatif] = $nilai;
		
	endforeach;
endforeach;

//Matriks Normalisasi (X)
$nilai_x = array();
foreach($alternatifs as $alternatif):
	foreach($kriterias as $kriteria):
		$id_alternatif = $alternatif['id_alternatif'];
		$id_kriteria = $kriteria['id_kriteria'];
		$nilai = $matriks_x[$id_kriteria][$id_alternatif];
		
		$nilai_max = @(max($matriks_x[$id_kriteria]));
		$nilai_min = @(min($matriks_x[$id_kriteria]));
	
		if ($nilai_max != $nilai_min) {
			$x = ($nilai_max - $nilai)/($nilai_max-$nilai_min);	
		} 
		$nilai_x[$id_alternatif][$id_kriteria] = round($x,3);
		// $x = ($nilai_max - $nilai)/($nilai_max-$nilai_min);	
		// $nilai_x[$id_alternatif][$id_kriteria] = round($x,3);

	endforeach;
endforeach;

//Matrix Normalisasi (R)
$nilai_r = array();
$s = array();
$n_s = array();
foreach($alternatifs as $alternatif):
	$total_r = 0;
	foreach($kriterias as $kriteria):
		$id_alternatif = $alternatif['id_alternatif'];
		$id_kriteria = $kriteria['id_kriteria'];
		$bobot = $kriteria['bobot'];
		$nilai = $nilai_x[$id_alternatif][$id_kriteria];
		
		$r = $nilai*$bobot;
			
		$nilai_r[$id_alternatif][$id_kriteria] = round($r,3);
		$total_r += round($r,3);
	endforeach;
	$s[$id_alternatif] = $total_r;
	$n_s[$id_alternatif]['nilai'] = $total_r;
endforeach;

// Nilai R
$r = array();
$n_r = array();
foreach($alternatifs as $alternatif):
	$id_alternatif = $alternatif['id_alternatif'];
		
	$nilai_max = @(max($nilai_r[$id_alternatif]));
		
	$r[$id_alternatif] = $nilai_max;
	$n_r[$id_alternatif]['nilai'] = $nilai_max;
endforeach;

// Max R
$r_nilai = array();
foreach($n_r as $key =>$row):
	$r_nilai[$key] = $row['nilai'];
endforeach;

// Max S
$s_nilai = array();
foreach($n_s as $key =>$row):
	$s_nilai[$key] = $row['nilai'];
endforeach;

//Nilai Qi
$nilai_q = array();
foreach($alternatifs as $alternatif):
	$id_alternatif = $alternatif['id_alternatif'];
	
	$nil_s = $s[$id_alternatif];
	$nil_r = $r[$id_alternatif];
	$max_s = max($s_nilai);
	$min_s = min($s_nilai);
	$max_r = max($r_nilai);
	$min_r = min($r_nilai);
	
	$v = 0.5;
	$n1 = $nil_s-$min_s;
	$n2 = $max_s-$min_s;
	$n3 = $nil_r-$min_r;
	$n4 = $max_r-$min_r;
	
	$bagi1=$n1/$n2;
	$bagi2=$n3/$n4;
	
	$hasil1= $bagi1*$v;
	$hasil2= $bagi2*(1-$v);
	$q = $hasil1+$hasil2;
	$nilai_q[$id_alternatif] = round($q,4);
endforeach;	
	
	
	?>

    <!-- /.card-header -->
    <div class="card shadow mb-2">
    <div class=" card-header py-3 d-sm-flex align-items-center justify-content-between mb-2">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Matrix Keputusan (X)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead class="bg-info text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th>Nama Alternatif</th>
						<?php foreach ($kriterias as $kriteria): ?>
							<th><?= $kriteria['kode_kriteria'] ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $alternatif['nama'] ?></td>
						<?php
						foreach ($kriterias as $kriteria):
							$id_alternatif = $alternatif['id_alternatif'];
							$id_kriteria = $kriteria['id_kriteria'];
							echo '<td>';
							echo $matriks_x[$id_kriteria][$id_alternatif];
							echo '</td>';
						endforeach
						?>
					</tr>
					<?php
						$no++;
						endforeach
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Normalisasi Matrix (X)</h6>
    </div>
    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead class="bg-info text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th>Nama Alternatif</th>
						<?php foreach ($kriterias as $kriteria): ?>
							<th><?= $kriteria['kode_kriteria'] ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $alternatif['nama'] ?></td>
						<?php						
						foreach($kriterias as $kriteria):
							$id_alternatif = $alternatif['id_alternatif'];
							$id_kriteria = $kriteria['id_kriteria'];
							echo '<td>';
							echo $nilai_x[$id_alternatif][$id_kriteria];
							echo '</td>';
						endforeach;
						?>
					</tr>
					<?php
						$no++;
						endforeach
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="card shadow mb-2">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Bobot Kriteria (W)</h6>
    </div>
    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead class="bg-info text-white">
					<tr align="center">
						<?php foreach ($kriterias as $kriteria): ?>
						<th><?= $kriteria['kode_kriteria'] ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<?php 
						
						foreach ($kriterias as $kriteria): ?>
						<td>
						<?php 
						echo $kriteria['bobot'];
						?>
						</td>
						<?php endforeach ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="card shadow mb-2">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Matrix Normalisasi (R)</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead class="bg-info text-white">
					<tr align="center">
						<th width="5%" rowspan="2">No</th>
						<th>Nama Alternatif</th>
						<?php foreach ($kriterias as $kriteria): ?>
							<th><?= $kriteria['kode_kriteria'] ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $alternatif['nama'] ?></td>
						<?php						
						foreach($kriterias as $kriteria):
							$id_alternatif = $alternatif['id_alternatif'];
							$id_kriteria = $kriteria['id_kriteria'];
							echo '<td>';
							echo $nilai_r[$id_alternatif][$id_kriteria];
							echo '</td>';
						endforeach;
						?>
					</tr>
					<?php
						$no++;
						endforeach
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<div class="card shadow mb-2">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai R</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1"">
				<thead class="bg-info text-white">
					<tr align="center">
						<?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
						<th>R<sub><?= $no ?></sub></th>
						<?php 
						$no++;
						endforeach ?>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<?php 
						foreach ($alternatifs as $alternatif): 
						$id_alternatif = $alternatif['id_alternatif'];
						?>
						<td>
						<?php 
						echo $r[$id_alternatif];
						?>
						</td>
						<?php endforeach ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="card shadow mb-2">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai S</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead class="bg-info text-white">
					<tr align="center">
						<?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
						<th>S<sub><?= $no ?></sub></th>
						<?php 
						$no++;
						endforeach ?>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<?php 
						foreach ($alternatifs as $alternatif): 
						$id_alternatif = $alternatif['id_alternatif'];
						?>
						<td>
						<?php 
						echo $s[$id_alternatif];
						?>
						</td>
						<?php endforeach ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="card shadow mb-2">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai S dan R</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead class="bg-info text-white">
					<tr align="center">
						<th>S<sup>+</sup></th>
						<th>S<sup>-</sup></th>
						<th>R<sup>+</sup></th>
						<th>R<sup>-</sup></th>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<td><?= max($s_nilai); ?></td>
						<td><?= min($s_nilai); ?></td>
						<td><?= max($r_nilai); ?></td>
						<td><?= min($r_nilai); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="card shadow mb-2">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai Qi</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0" cellpadding="5" border="1">
				<thead class="bg-info text-white">
					<tr align="center">
						<th width="5%">No</th>
						<th>Alternatif</th>
						<th>Nilai Qi</th>
					</tr>
				</thead>
				<tbody>
					<tr align="center">
						<?php 
						$no=1;
						foreach ($alternatifs as $alternatif):
						$id_alternatif = $alternatif['id_alternatif'];
						?>
					<tr align="center">
						<td><?= $no; ?></td>
						<td align="left"><?= $alternatif['nama'] ?></td>
						<td>
						<?php 
						// echo $hasil = $nilai_q[$id_alternatif];
						 echo number_format($hasil = $nilai_q[$id_alternatif], 2, '.', '');
						?>
						</td>
					</tr>
					<?php
						$no++;
						// mysqli_query($koneksi,"INSERT INTO hasil (id_hasil, id_alternatif, nilai, tgl) VALUES ('', '$alternatif[id_alternatif]', '$hasil','$tanggal')");
						endforeach
					?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
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

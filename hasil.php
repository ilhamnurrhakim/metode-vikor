<?php
error_reporting(false);
session_start();
require_once('includes/init.php');

$user_role = get_role();
if($user_role == 'admin' || $user_role == 'user') {

$page = "Hasil";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>
	
	<!-- <a href="cetak.php" target="_blank" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </a> -->
</div>

<div class="card shadow mb-4">
    <div class="box-header">
        <h3 class="box-title m-3">Kepala Sekolah</h3>  
    </div><!-- /.box-header -->
    <div class="box-header">
        <div class="row">
            <div class="col-lg-12 m-3 ml-4">
                <form action="" method="post" class="form-inline">
                    <div class="form-group mr-3">
                        <input type="text" class="form-control" name="nama" placeholder="NIP">
                    </div>
                    <div class="form-group mr-3">
                        <input type="text" class="form-control" name="nip" placeholder="Nama Kepala Sekolah">
                    </div>
                    <button type="submit" name="kirim" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- /.box-header -->

<?php
 // Ambil data dari session
 if (isset($_SESSION['tmpnama'])) {
  $tmpnama = $_SESSION['tmpnama'];
 }
 if (isset($_SESSION['tmpalamat'])) {
  $tmpalamat = $_SESSION['tmpalamat'];
 }
 // End ambil data dari session

 // Tambahkan array (hasil dari data session tadi) dengan data inputan yang baru
 $tmpnama[] = $_POST['nama'];
 $tmpalamat[] = $_POST['nip'];
 // End script tambah ke array

 // Simpan data array yang baru ke session
 $_SESSION['tmpnama'] = $tmpnama;
 $_SESSION['tmpalamat'] = $tmpalamat;
 // End script simpan ke session
?>

<div class="card shadow mb-4">
    <form action="" method="post">
        <div class="row">
            <div class="col-lg-12 m-3 ml-4  d-flex align-items-center">
                <div class="input-group">
                    <select class="form-control" name="tanggal1" required>
                        <option value="">Pilih Tahun</option>
                        <?php
                        $currentYear = date("Y");
                        $startYear = 2020; // Tahun mulai yang diinginkan
                        for ($year = $startYear; $year <= $currentYear; $year++) {
                            echo "<option value=\"$year\"";
                            if (!empty($_POST['tanggal1']) && $_POST['tanggal1'] == $year) {
                                echo " selected";
                            }
                            echo ">$year</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- </div> -->
				<div class="col-lg-2 m-3 mr-2 ml-2  d-flex align-items-center ">
					<!-- <div class="m-3"> -->
						<button type="submit" name="b1" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
					</div>
				</div>
        </div>
    </form>
</div><!-- /.box-header -->

<?php 
if(!empty($_POST['tanggal1'])) {

	$tanggal=$_POST['tanggal1'];

	$q2 = mysqli_query($koneksi, "SELECT * FROM hasil  WHERE tgl = '$tanggal'");
if (mysqli_num_rows($q2) == 0) { ?>

 
	<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
    </div>
	<h4 class ="text-center"> Data Hasil Akhir untuk Tahun <?= htmlspecialchars($tanggal); ?>  tidak ditemukan</h4>
    <div class="card-body">
		<div class="table-responsive">
			
		</div>
	</div>
</div>
<?php 
} else {
?>
<div class="card shadow mb-4">
    <!-- /.card-header -->
	<div class=" card-header py-3 d-sm-flex align-items-center justify-content-between mb-2">
    <!-- <div class="card-header py-3"> -->
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Hasil Akhir Perankingan</h6>
		<a href="cetak.php?tgl1=<?= $tanggal; ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </a>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thead class="bg-info text-white">
					<tr align="center">
						<th>NIS</th>
						<th>Nama Alternatif</th>
						<th>Nilai Qi</th>
						<th width="15%">Rank</th>
				</thead>
				<tbody>
					<?php 
						$no=0;
						$query = mysqli_query($koneksi,"SELECT * FROM hasil JOIN alternatif ON hasil.id_alternatif=alternatif.id_alternatif ORDER BY hasil.nilai ASC");
						while($data = mysqli_fetch_array($query)){
						$no++;
					?>
					<tr align="center">
						<td align="left"><?= $data['nis'] ?></td>
						<td align="left"><?= $data['nama'] ?></td>
						<td><?= number_format($data['nilai'], 2, '.', '');  ?></td>
						<td><?= $no; ?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php 
}
}
?>
<?php
require_once('template/footer.php');
}
else {
	header('Location: login.php');
}
?>
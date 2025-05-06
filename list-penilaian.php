<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$page = "Penilaian";
require_once('template/header.php');

if(isset($_POST['tambah'])):	
	$id_alternatif = $_POST['id_alternatif'];
	$id_kriteria = $_POST['id_kriteria'];
	$nilai = $_POST['nilai'];
	$tgl = date('Y');

	if(!$id_kriteria) {
		$errors[] = 'ID kriteria tidak boleh kosong';
	}
	if(!$id_alternatif) {
		$errors[] = 'ID Alternatif kriteria tidak boleh kosong';
	}		
	if(!$nilai) {
		$errors[] = 'Nilai kriteria tidak boleh kosong';
	}	
	
	if(empty($errors)):
		$i = 0;
		foreach ($nilai as $key) {
			$simpan = mysqli_query($koneksi,"INSERT INTO penilaian (id_penilaian, id_alternatif, id_kriteria, nilai, tgl) VALUES ('', '$id_alternatif', '$id_kriteria[$i]', '$key', '$tgl')");
			$i++;
		}
		if($simpan) {
			$sts[] = 'Data berhasil disimpan';
		}else{
			$sts[] = 'Data gagal disimpan';
		}
	endif;
endif;

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-edit"></i> Data Penilaian</h1>
</div>

<?php if(!empty($sts)): ?>
	<div class="alert alert-info">
		<?php foreach($sts as $st): ?>
			<?php echo $st; ?>
		<?php endforeach; ?>
	</div>
<?php
endif;
?>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Daftar Data Penilaian</h6>
    </div>
	
	<div class="card-body">
		<div class="table-responsive">
		<div class="col-lg-12">

			<form id="contactForm" action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
							<label>Nama Alternatif</label>
							<select name="id_alternatif" id="" class="form-control">
							<option disabled selected>-- Silahkan Pilih Alternatif --</option>
							<?php 
								// Ambil tahun yang sesuai dari sumber yang relevan
								// $tahun = 2024; // Sesuaikan ini dengan sumber yang sesuai, seperti input dari pengguna atau variabel lain
								$tahun = date('Y');
								// Query untuk mengambil data alternatif yang tidak ada di tabel penilaian untuk tahun yang sama
								$query = "
									SELECT * FROM alternatif 
									WHERE id_alternatif NOT IN (
										SELECT id_alternatif FROM penilaian WHERE tgl = '$tahun'
									)
								";
								$ambildata = mysqli_query($koneksi, $query);
								
								// Loop untuk menampilkan data alternatif
								while ($fetcharray = mysqli_fetch_array($ambildata)) {
									$namabarang = $fetcharray['nama'];
									$idbarang = $fetcharray['nis'];
									$id_alternatif = $fetcharray['id_alternatif'];
							?>
								<option value="<?= $id_alternatif; ?>">(<?= $idbarang; ?>) <?= $namabarang; ?></option>
							<?php 
								}
							?>
						</select>
								</div>
								
							</div>
			

							<?php
							$query = "SELECT * FROM kriteria";
							$execute = $koneksi->query($query);

							if ($execute->num_rows > 0) {
								echo "<div class='modal-body'>";
								while ($data = $execute->fetch_array(MYSQLI_ASSOC)) {
									$id_kriteria = htmlspecialchars($data['id_kriteria']);
									$nama_kriteria = htmlspecialchars($data['nama']);

									echo "<div class='row mb-3'>";

									if ($data['ada_pilihan'] == 1) {
										// Nama Kriteria dan Input Nilai
										echo "<div class='col-lg-8'>";
										echo "<label for='nilai_$id_kriteria'>$nama_kriteria</label>";
										echo "<input type='hidden' value='$id_kriteria' name='id_kriteria[]'>";
										echo "<select  name='nilai[]' class='form-control form-select' required id='nilai_$id_kriteria' onchange='getOrganisasi(this.value, \"$id_kriteria\")'>";
										echo "<option disabled selected>-- Pilih $nama_kriteria --</option>";

										$query2 = "SELECT * FROM sub_kriteria WHERE id_kriteria='$id_kriteria'";
										$execute2 = $koneksi->query($query2);

										if ($execute2->num_rows > 0) {
											while ($data2 = $execute2->fetch_array(MYSQLI_ASSOC)) {
												$nilai = htmlspecialchars($data2['id_sub_kriteria']);
												$keterangan = htmlspecialchars($data2['nama']);
												echo "<option value='$nilai'>$keterangan</option>";
											}
										} else {
											echo "<option disabled value=''>Belum ada Nilai Kriteria</option>";
										}
										echo "</select>";
										echo "</div>";

										// Field Organisasi
										echo "<div class='col-lg-4'>";
										echo "<label for='organisasi_$id_kriteria'> $nama_kriteria</label>";
										echo "<input type='text' class='form-control' id='organisasi_$id_kriteria' value='' readonly>";
										echo "</div>";
									} else {
										// Nama Kriteria tanpa pilihan
										echo "<input type='hidden' value='$id_kriteria' name='id_kriteria[]'>";
										echo "<div class='col-lg-8'>";
										echo "<label for='nilai_$id_kriteria'>$nama_kriteria</label>";
										echo "<input type='text' autocomplete='off'  class='form-control'  id='nilai_$id_kriteria'  onkeyup='isi_otomatis(\"$id_kriteria\")' value=''>";
										echo "</div>";

										// Field Organisasi
										echo "<div class='col-lg-4'>";
										echo "<label for='organisasi_$id_kriteria'> $nama_kriteria</label>";
										echo "<input type='text' name='nilai[]' class='form-control' id='organisasi_$id_kriteria' value='' readonly>";
										echo "</div>";
									}

									echo "</div>"; // End of row
								}
								echo "</div>"; // End of modal-body
							}
							?>

					<div class="col-lg-12">
						<button type="submit" name="tambah" class="btn btn-success"><i class="fa fa-save"></i>  Penilaian</button>
						
					</div>
				</div>
			</form>
			</div>
			<br>
			


		



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function getOrganisasi(nilai, id_kriteria) {
    $.ajax({
        url: 'cek_data.php',
        type: 'POST',
        data: { nilai: nilai, id_kriteria: id_kriteria },
        success: function(response) {
            $('#organisasi_' + id_kriteria).val(response);
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });
}
function isi_otomatis(id_kriteria) {
    var nilai = $('#nilai_' + id_kriteria).val();
    $.ajax({
        url: 'ajax2.php',
        data: { nilai: nilai },
        success: function(data) {
            var obj = JSON.parse(data);
            $('#organisasi_' + id_kriteria).val(obj.nilai);
        }
    });
}

// Untuk memastikan modal tampil dengan benar
// 
</script>

<?php
require_once('template/footer.php');
?>
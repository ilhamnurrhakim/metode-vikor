<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$nis = (isset($_POST['nis'])) ? trim($_POST['nis']) : '';
$nama = (isset($_POST['nama'])) ? trim($_POST['nama']) : '';
$nohp = (isset($_POST['nohp'])) ? trim($_POST['nohp']) : '';
$jk = (isset($_POST['jk'])) ? trim($_POST['jk']) : '';
$alamat = (isset($_POST['alamat'])) ? trim($_POST['alamat']) : '';

if(isset($_POST['submit'])):	
	
	// Validasi
	if(!$nis) {
		$errors[] = 'Nama tidak boleh kosong';
	}
	if(!$nama) {
		$errors[] = 'Nama tidak boleh kosong';
	}
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		$simpan = mysqli_query($koneksi,"INSERT INTO alternatif (id_alternatif, nis, nama,jk,nohp,alamat) VALUES ('','$nis','$nama','$jk','$nohp','$alamat')");
		if($simpan) {
			redirect_to('list-alternatif.php?status=sukses-baru');
		}else{
			$errors[] = 'Data gagal disimpan';
		}
	endif;

endif;

$page = "Alternatif";
require_once('template/header.php');
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Alternatif</h1>

	<a href="list-alternatif.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>
			
<?php if(!empty($errors)): ?>
	<div class="alert alert-info">
		<?php foreach($errors as $error): ?>
			<?php echo $error; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>			
			
<form action="tambah-alternatif.php" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-info"><i class="fas fa-fw fa-plus"></i> Tambah Data Alternatif</h6>
		</div>
		<div class="card-body">
			<div class="row">				
				<div class="form-group col-md-12">
					<label class="font-weight-bold">NIS</label>
					<input autocomplete="off" type="text" name="nis" required value="<?php echo $nis; ?>" class="form-control"/>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">				
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Nama</label>
					<input autocomplete="off" type="text" name="nama" required value="<?php echo $nama; ?>" class="form-control"/>
				</div>
			</div>
		</div>
		<div class="card-body">
		<div class="row">	
		<div class="form-group col-md-12">
					<label class="font-weight-bold">Jenis Kelamin</label>
					<select name="jk" class="form-control" required>
						<option value="">--Pilih Jenis Kelamin--</option>
						<option value="Pria">Pria</option>
						<option value="Wanita">Wanita</option>						
					</select>
				</div>
				</div>
				</div>
		<div class="card-body">
			<div class="row">				
				<div class="form-group col-md-12">
					<label class="font-weight-bold">No Handphone</label>
					<input autocomplete="off" type="text" name="nohp" required value="<?php echo $nohp; ?>" class="form-control"/>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="row">				
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Alamat</label>
					<input autocomplete="off" type="text" name="alamat" required value="<?php echo $alamat; ?>" class="form-control"/>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
	</div>
</form>

<?php
require_once('template/footer.php');
?>
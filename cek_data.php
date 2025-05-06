
<?php
 include "includes/konek-db.php"; // Pastikan file koneksi database Anda disertakan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nilai = $_POST['nilai'];
    $id_kriteria = $_POST['id_kriteria'];



    // Query ke database untuk mendapatkan data yang diinginkan
    $query = "SELECT nilai FROM sub_kriteria WHERE id_sub_kriteria = '$nilai' AND id_kriteria = '$id_kriteria'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo $row['nilai']; // Mengembalikan data organisasi
    } else {
        echo "Data tidak ditemukan";
    }
}
?>

<?php

//membuat koneksi ke database
include "includes/konek-db.php"; // Pastikan file koneksi database Anda disertakan


//variabel nim yang dikirimkan form.php
$nilai = $_GET['nilai'];

//mengambil data
$query = mysqli_query($koneksi, "SELECT * FROM nilai_test WHERE keterangan ='$nilai'");
$mahasiswa = mysqli_fetch_array($query);
$data = array(
            'nilai'      =>  @$mahasiswa['nilai'],
        );
        //tampil data
        echo json_encode($data);
?>


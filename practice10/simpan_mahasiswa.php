<?php
include "koneksi.php";
include "create_message.php";
$fileName = $_FILES['gambar']['name'];


if (isset($_POST['mahasiswa_id'])) {
    //Kondisi Update
    $sql = "UPDATE mahasiswa SET nama_lengkap = '" . $_POST['nama_lengkap'] . "',alamat = '" . $_POST['alamat'] . "',kelas_id = '" . $_POST['kelas_id'] . "',foto = '$fileName' WHERE (`mahasiswa_id` = '" . $_POST['mahasiswa_id'] . "');";
    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/".$_FILES['gambar']['name']);
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        create_message("Ubah Data Berhasil", "success", "check");
        header("location: index.php");
        exit();
    } else {
        $conn->close();
        create_message("Error: " . $sql . "<br>" . $conn->error, "danger", "warning");
        header("location: index.php");
        exit();
    }
} else {
    //Kondisi Insert
    $fileName = $_FILES['gambar']['name'];
    $sql = "INSERT INTO mahasiswa (nama_lengkap, kelas_id, alamat, foto) VALUES ('" . $_POST['nama_lengkap'] . "', " . $_POST['kelas_id'] . ", '" . $_POST['alamat'] . "','$fileName')";
    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/" . $_FILES['gambar']['name']);
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        create_message("Simpan Data Berhasil", "success", "check");
        header("location:index.php");
        exit();
    } else {
        $conn->close();
        create_message("Error: " . $sql . "<br>" . $conn->error, "danger", "warning");
        header("location:index.php");
        exit();
    }
}

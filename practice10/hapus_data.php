<?php

    include "koneksi.php";
    include "create_message.php";

    $sql = "DELETE FROM mahasiswa where mahasiswa_id=".$_GET['mahasiswa_id'];
    if($conn->query($sql) === true) {
        $conn->close();
        create_message("Hapus Data Berhasil","success","check");
        header("location:index.php");
        exit();
    } else {
        $conn->close();
        create_message("Error: " . $sql . "<br>" . $conn->error,"danger","warning");
        header("location:index.php");
        exit();
    }

?>
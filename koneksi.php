<?php

$db_host="localhost";
$db_user="root";
$db_pass="";
$db_nama="db_tokobuku";

    $link = mysqli_connect($db_host, $db_user, $db_pass, $db_nama);

    //if($konek){
        //echo "Terkoneksi database";
    //} else {
        //echo "gagal koneksi";
    //}

    if(!$link){
        die("Gagal Koneksi Karena".mysqli_connect_errno()."-".mysqli_connect_error());
    }
?>
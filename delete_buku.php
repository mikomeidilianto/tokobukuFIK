<?php
   include("koneksi.php");
   
   if (isset($_POST["submit"])) {
      $id = $_POST["id"];

      $query = "SELECT judul_buku, ISBN FROM buku WHERE id='$id' ";
      $result = mysqli_query($link, $query);
      $data = mysqli_fetch_assoc($result);
      $judul_buku = $data["judul_buku"];
      $ISBN = $data["ISBN"];
      $query = "DELETE FROM buku WHERE id='$id' ";
      $result = mysqli_query($link, $query);

      if($result) {
         $message = "Buku dengan judul \"<b>$judul_buku</b>\" dan ISBN \"<b>$ISBN</b>\" sudah berhasil dihapus";
         $message = urlencode($message);
         header("Location: dashboard.php?message={$message}");
      } else {
         die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
      }
   }
?>
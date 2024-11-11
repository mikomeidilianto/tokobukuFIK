<?php
   include("koneksi.php");
   
   if (isset($_POST["submit"])) {
      $id = $_POST["id"];

      $query = "SELECT nama_publisher FROM publisher WHERE id='$id' ";
      $result = mysqli_query($link, $query);
      $data = mysqli_fetch_assoc($result);
      $nama = $data["nama_publisher"];
      $query = "DELETE FROM publisher WHERE id='$id' ";
      $result = mysqli_query($link, $query);

      if($result) {
         $message = "Publisher dengan nama \"<b>$nama</b>\" sudah berhasil dihapus";
         $message = urlencode($message);
         header("Location: publisher.php?message={$message}");
      } else {
         die ("Query Error: ".mysqli_errno($link)." - ".mysqli_error($link));
      }
   }
?>
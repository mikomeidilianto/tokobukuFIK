<?php
include("koneksi.php");

if (isset($_POST["submit"])) {
    // Menerima data dari form menggunakan $_POST
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $usia = htmlentities(strip_tags(trim($_POST["usia"])));
    $phone = htmlentities(strip_tags(trim($_POST["phone"])));
    $email = htmlentities(strip_tags(trim($_POST["email"])));
    $error_message = "";

    if (empty($nama)) $error_message .= "<li>Nama penulis belum diisi</li>";
    if (empty($usia)) $error_message .= "<li>Usia belum diisi</li>";
    if (empty($phone)) $error_message .= "<li>Nomor telepon belum diisi</li>";
    if (empty($email)) $error_message .= "<li>Email belum diisi</li>";

    if ($error_message === "") {
        $nama = mysqli_real_escape_string($link, $nama);
        $usia = mysqli_real_escape_string($link, $usia);
        $phone = mysqli_real_escape_string($link, $phone);
        $email = mysqli_real_escape_string($link, $email);

        // Query untuk memasukkan data ke tabel
        $query = "INSERT INTO penulis (nama, usia, phone, email) VALUES ('$nama', '$usia', '$phone', '$email')";
        $result = mysqli_query($link, $query);

        if ($result) {
            $message = "Penulis dengan nama \"<b>$nama</b>\" sudah berhasil ditambahkan";
            $message = urlencode($message);
            header("Location: penulis.php?message={$message}");
        } else {
            die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container mt-5 border rounded bg-white py-4 px-5 mb-5">
    <header class="header-title mb-4">
        <h1><a href="./penulis.php" style="text-decoration: none;"> <span class="text-primary">Kembali</span></a></h1>
        <hr>
    </header>
    <section>
        <h2 class="mb-3">Tambah Penulis</h2>
        <?php
        if (isset($error_message) && $error_message !== "") {
            echo "<div class=\"alert alert-danger mb-3\"><ul class=\"m-0\">$error_message</ul></div>";
        }
        ?>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama penulis</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo (isset($nama)) ? $nama : ""; ?>" placeholder="Masukkan Nama Penulis">
            </div>
            <div class="mb-3">
                <label for="usia" class="form-label">Usia</label>
                <input type="number" name="usia" id="usia" class="form-control" value="<?php echo (isset($usia)) ? $usia : ""; ?>" placeholder="Masukkan Usia">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="number" name="phone" id="phone" class="form-control" value="<?php echo (isset($phone)) ? $phone : ""; ?>" placeholder="Masukkan Nomor Telepon">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" id="email" class="form-control" value="<?php echo (isset($email)) ? $email : ""; ?>" placeholder="Masukkan Email">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </section>
</div>
</body>
</html> 

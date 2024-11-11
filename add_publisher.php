<?php
include("koneksi.php");

if (isset($_POST["submit"])) {
    // Menerima data dari form menggunakan $_POST
    $nama_publisher = htmlentities(strip_tags(trim($_POST["nama_publisher"])));
    $alamat = htmlentities(strip_tags(trim($_POST["alamat"])));
    $tahun_berdiri = htmlentities(strip_tags(trim($_POST["tahun_berdiri"])));
    $error_message = "";

    if (empty($nama_publisher)) $error_message .= "<li>Nama publisher belum diisi</li>";
    if (empty($alamat)) $error_message .= "<li>Alamat belum diisi</li>";
    if (empty($tahun_berdiri)) $error_message .= "<li>Tahun berdiri belum diisi</li>";

    if ($error_message === "") {
        $nama_publisher = mysqli_real_escape_string($link, $nama_publisher);
        $alamat = mysqli_real_escape_string($link, $alamat);
        $tahun_berdiri = mysqli_real_escape_string($link, $tahun_berdiri);

        // Query untuk memasukkan data ke tabel
        $query = "INSERT INTO publisher (nama_publisher, alamat, tahun_berdiri) VALUES ('$nama_publisher', '$alamat', '$tahun_berdiri')";
        $result = mysqli_query($link, $query);

        if ($result) {
            $message = "Publisher dengan nama \"<b>$nama_publisher</b>\" sudah berhasil ditambahkan";
            $message = urlencode($message);
            header("Location: publisher.php?message={$message}");
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
        <h1><a href="./publisher.php" style="text-decoration: none;"><span class="text-primary">Kembali</span></a></h1>
        <hr>
    </header>
    <section>
        <h2 class="mb-3">Tambah Publisher</h2>
        <?php
        if (isset($error_message) && $error_message !== "") {
            echo "<div class=\"alert alert-danger mb-3\"><ul class=\"m-0\">$error_message</ul></div>";
        }
        ?>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form">
            <div class="mb-3">
                <label for="nama_publisher" class="form-label">Nama publisher</label>
                <input type="text" name="nama_publisher" id="nama_publisher" class="form-control" value="<?php echo (isset($nama_publisher)) ? $nama_publisher : ""; ?>" placeholder="Masukkan Nama Publisher">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo (isset($alamat)) ? $alamat : ""; ?>" placeholder="Masukkan Alamat">
            </div>
            <div class="mb-3">
                <label for="tahun_berdiri" class="form-label">Tahun berdiri</label>
                <input type="number" name="tahun_berdiri" id="tahun_berdiri" class="form-control" value="<?php echo (isset($tahun_berdiri)) ? $tahun_berdiri : ""; ?>" placeholder="Masukkan Tahun Berdiri">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </section>
</div>
</body>
</html> 

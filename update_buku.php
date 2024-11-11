<?php
include("koneksi.php");

$publisher_query = "SELECT * FROM publisher ORDER BY nama_publisher ASC";
$publisher_result = mysqli_query($link, $publisher_query);

$author_query = "SELECT * FROM penulis ORDER BY nama ASC";
$author_result = mysqli_query($link, $author_query);

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Update") {
        $id = htmlentities(strip_tags(trim($_POST["id"])));
        $id = mysqli_real_escape_string($link, $id);
        $query = "SELECT * FROM buku WHERE id='$id'";
        $result = mysqli_query($link, $query);
        if (!$result) {
            die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
        }
        $data = mysqli_fetch_assoc($result);
        $judul_buku = $data["judul_buku"];
        $foto = $data["foto"];
        $ISBN = $data["ISBN"];
        $tahun_terbit = $data["tahun_terbit"];
        $harga = $data["harga"];
        $stok_buku = $data["stok_buku"];
        $publisher = $data["publisher"];
        $author = $data["author"];
        mysqli_free_result($result);
    } elseif ($_POST["submit"] == "Update Data") {

        $id = htmlentities(strip_tags(trim($_POST["id"])));
        $judul_buku = htmlentities(strip_tags(trim($_POST["judul_buku"])));
        $foto = htmlentities(strip_tags(trim($_POST["foto"])));
        $ISBN = htmlentities(strip_tags(trim($_POST["ISBN"])));
        $tahun_terbit = htmlentities(strip_tags(trim($_POST["tahun_terbit"])));
        $harga = htmlentities(strip_tags(trim($_POST["harga"])));
        $stok_buku = htmlentities(strip_tags(trim($_POST["stok_buku"])));
        $publisher = htmlentities(strip_tags(trim($_POST["publisher"])));
        $author = htmlentities(strip_tags(trim($_POST["author"])));

        $error_message = "";
        
        if (empty($judul_buku)) $error_message .= "<li>Judul Buku belum diisi</li>";
        $judul_buku = mysqli_real_escape_string($link, $judul_buku);
        $query = "SELECT * FROM buku WHERE judul_buku='$judul_buku' AND NOT id='$id'";
        $result = mysqli_query($link, $query);
        $num_rows = mysqli_num_rows($result);

        if (empty($judul_buku)) $error_message .= "<li>Judul buku belum diisi</li>";
        if (empty($foto)) $error_message .= "<li>foto belum diisi</li>";
        if (empty($ISBN)) $error_message .= "<li>ISBN belum diisi</li>";
        if (empty($tahun_terbit)) $error_message .= "<li>Tahun terbit belum diisi</li>";
        if (empty($harga)) $error_message .= "<li>Harga belum diisi</li>";
        if (empty($stok_buku)) $error_message .= "<li>Stok buku belum diisi</li>";
        if (empty($publisher)) $error_message .= "<li>Publisher belum diisi</li>";
        if (empty($author)) $error_message .= "<li>Author belum diisi</li>";

        if ($error_message === "") {
            $judul_buku = mysqli_real_escape_string($link, $judul_buku);
            $foto = mysqli_real_escape_string($link, $foto);
            $ISBN = mysqli_real_escape_string($link, $ISBN);
            $tahun_terbit = mysqli_real_escape_string($link, $tahun_terbit);
            $harga = mysqli_real_escape_string($link, $harga);
            $stok_buku = mysqli_real_escape_string($link, $stok_buku);
            $publisher = mysqli_real_escape_string($link, $publisher);
            $author = mysqli_real_escape_string($link, $author);
            
            $query = "UPDATE buku SET 
              judul_buku = '$judul_buku',
              foto = '$foto',
              ISBN = '$ISBN',
              tahun_terbit = '$tahun_terbit',
              harga = '$harga',
              stok_buku = '$stok_buku',
              publisher = '$publisher',
              author = '$author'
              WHERE id = $id";
            $result = mysqli_query($link, $query);

            if ($result) {
            $message = "Buku dengan nama \"<b>$judul_buku</b>\" sudah berhasil di-update";
            $message = urlencode($message);
            header("Location: dashboard.php?message={$message}");
        } else {
            die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
            }
        }
    } else {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 border rounded bg-white py-4 px-5 mb-5">
        <header class="header-title mb-4">
            <h1><a href="./dashboard.php" style="text-decoration: none;"> <span class="text-primary">Kembali</span></a></h1>
            <hr>
        </header>
        <section>
            <h2 class="mb-3">Update Data buku</h2>
            <?php if (isset($error_message) && $error_message !== "") { echo "<div class=\"alert alert-danger mb-3\"><ul class=\"m-0\">$error_message</ul></div>"; } ?>
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form">
            <div class="mb-3">
                <label for="judul_buku" class="form-label">Judul buku</label>
                <input type="text" name="judul_buku" id="judul_buku" class="form-control" value="<?php echo (isset($judul_buku)) ? $judul_buku : ""; ?>" placeholder="Masukkan Judul Buku">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="text" name="foto" id="foto" class="form-control" value="<?php echo (isset($foto)) ? $foto : ""; ?>" placeholder="Masukkan Foto">
            </div>
            <div class="mb-3">
                <label for="ISBN" class="form-label">ISBN</label>
                <input type="text" name="ISBN" id="isbn" class="form-control" value="<?php echo (isset($ISBN)) ? $ISBN : ""; ?>" placeholder="Masukkan Nomor ISBN">
            </div>
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" value="<?php echo (isset($tahun_terbit)) ? $tahun_terbit : ""; ?>" placeholder="Masukkan Tahun Terbit">
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control" value="<?php echo (isset($harga)) ? $harga : ""; ?>" placeholder="Masukkan Harga">
            </div>
            <div class="mb-3">
                <label for="stok_buku" class="form-label">Stok Buku</label>
                <input type="number" name="stok_buku" id="stok_buku" class="form-control" value="<?php echo (isset($stok_buku)) ? $stok_buku : ""; ?>" placeholder="Masukkan Stok Buku">
            </div>
            <div class="mb-3">
                <label for="publisher" class="form-label">Publisher</label>
                <select name="publisher" id="publisher" class="form-select">
                <option value="">Pilih Publisher</option>
                <?php while($pub = mysqli_fetch_assoc($publisher_result)): ?>
                        <option value="<?php echo $pub['nama_publisher']; ?>">
                            <?php echo $pub['nama_publisher']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <select name="author" id="author" class="form-select">
                <option value="">Pilih Penulis</option>
                <?php while($auth = mysqli_fetch_assoc($author_result)): ?>
                        <option value="<?php echo $auth['nama']; ?>">
                            <?php echo $auth['nama']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="submit" value="Update Data" class="btn btn-primary">Update Data</button>
            </form>
        </section>
    </div>
</body>
</html>

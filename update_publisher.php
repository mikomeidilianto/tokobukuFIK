<?php
include("koneksi.php");

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Update") {
        $id = htmlentities(strip_tags(trim($_POST["id"])));
        $id = mysqli_real_escape_string($link, $id);
        $query = "SELECT * FROM publisher WHERE id='$id'";
        $result = mysqli_query($link, $query);
        if (!$result) {
            die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
        }
        $data = mysqli_fetch_assoc($result);
        $nama_publisher = $data["nama_publisher"];
        $alamat = $data["alamat"];
        $tahun_berdiri = $data["tahun_berdiri"];
        mysqli_free_result($result);
    } elseif ($_POST["submit"] == "Update Data") {
        // Sanitasi input
        $id = htmlentities(strip_tags(trim($_POST["id"])));
        $nama_publisher = htmlentities(strip_tags(trim($_POST["nama_publisher"])));
        $alamat = htmlentities(strip_tags(trim($_POST["alamat"])));
        $tahun_berdiri = htmlentities(strip_tags(trim($_POST["tahun_berdiri"])));
        
        $error_message = "";

        // Validasi input
        if (empty($nama_publisher)) $error_message .= "<li>Nama Publisher belum diisi</li>";
        if (empty($alamat)) $error_message .= "<li>Alamat belum diisi</li>";
        if (empty($tahun_berdiri)) $error_message .= "<li>Tahun berdiri belum diisi</li>";
        

        // Cek duplikat nama
        $nama_publisher = mysqli_real_escape_string($link, $nama_publisher);
        $query = "SELECT * FROM publisher WHERE nama_publisher='$nama_publisher' AND id != '$id'";
        $result = mysqli_query($link, $query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            $error_message .= "<li>Nama publisher sudah ada di database</li>";
        }

        if ($error_message === "") {
            // Escape string untuk query
            $id = mysqli_real_escape_string($link, $id);
            $nama_publisher = mysqli_real_escape_string($link, $nama_publisher);
            $alamat = mysqli_real_escape_string($link, $alamat);
            $tahun_berdiri = mysqli_real_escape_string($link, $tahun_berdiri);
            
            // Perbaikan query UPDATE - menghilangkan koma terakhir sebelum WHERE
            $query = "UPDATE publisher SET 
                nama_publisher = '$nama_publisher',
                alamat = '$alamat',
                tahun_berdiri = '$tahun_berdiri'
                WHERE id = '$id'";
            
            $result = mysqli_query($link, $query);

            if ($result) {
                $message = "Publisher dengan nama \"<b>$nama_publisher</b>\" sudah berhasil di-update";
                $message = urlencode($message);
                header("Location: publisher.php?message={$message}");
                exit(); // Tambahkan exit setelah redirect
            } else {
                die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
            }
        }
    } else {
        header("Location: publisher.php");
        exit();
    }
}

// Ambil ID dari URL jika ada
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($link, $_GET['id']);
    $query = "SELECT * FROM publisher WHERE id='$id'";
    $result = mysqli_query($link, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $nama_publisher = $data["nama_publisher"];
        $alamat = $data["alamat"];
        $tahun_berdiri = $data["tahun_berdiri"];
        mysqli_free_result($result);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Publisher - Toko Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container mt-5 border rounded bg-white py-4 px-5 mb-5">
    <header class="header-title mb-4">
        <h1><a href="./publisher.php" style="text-decoration: none;"><span class="text-primary">Kembali</span></a></h1>
        <hr>
    </header>
    <section>
        <h2 class="mb-3">Update Publisher</h2>
        <?php
        if (isset($error_message) && $error_message !== "") {
            echo "<div class=\"alert alert-danger mb-3\"><ul class=\"m-0\">$error_message</ul></div>";
        }
        ?>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? htmlspecialchars($id) : ''; ?>">
            
            <div class="mb-3">
                <label for="nama_publisher" class="form-label">Nama Publisher</label>
                <input type="text" name="nama_publisher" id="nama_publisher" class="form-control" value="<?php echo isset($nama_publisher) ? htmlspecialchars($nama_publisher) : ''; ?>" placeholder="Masukkan Nama Publisher">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo isset($alamat) ? htmlspecialchars($alamat) : ''; ?>" placeholder="Masukkan Alamat">
            </div>
            <div class="mb-3">
                <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                <input type="text" name="tahun_berdiri" id="tahun_berdiri" class="form-control" value="<?php echo isset($tahun_berdiri) ? htmlspecialchars($tahun_berdiri) : ''; ?>" placeholder="Masukkan Nomor Telepon">
            </div>
            <button type="submit" name="submit" value="Update Data" class="btn btn-primary">Update Data</button>
        </form>
    </section>
</div>
</body>
</html>
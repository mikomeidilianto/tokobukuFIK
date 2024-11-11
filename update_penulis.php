<?php
include("koneksi.php");

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Update") {
        $id = htmlentities(strip_tags(trim($_POST["id"])));
        $id = mysqli_real_escape_string($link, $id);
        $query = "SELECT * FROM penulis WHERE id='$id'";
        $result = mysqli_query($link, $query);
        if (!$result) {
            die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
        }
        $data = mysqli_fetch_assoc($result);
        $nama = $data["nama"];
        $usia = $data["usia"];
        $phone = $data["phone"];
        $email = $data["email"];
        mysqli_free_result($result);
    } elseif ($_POST["submit"] == "Update Data") {
        // Sanitasi input
        $id = htmlentities(strip_tags(trim($_POST["id"])));
        $nama = htmlentities(strip_tags(trim($_POST["nama"])));
        $usia = htmlentities(strip_tags(trim($_POST["usia"])));
        $phone = htmlentities(strip_tags(trim($_POST["phone"])));
        $email = htmlentities(strip_tags(trim($_POST["email"])));
        
        $error_message = "";

        // Validasi input
        if (empty($nama)) $error_message .= "<li>Nama Penulis belum diisi</li>";
        if (empty($usia)) $error_message .= "<li>Usia belum diisi</li>";
        if (empty($phone)) $error_message .= "<li>Phone belum diisi</li>";
        if (empty($email)) $error_message .= "<li>Email belum diisi</li>";

        // Cek duplikat nama
        $nama = mysqli_real_escape_string($link, $nama);
        $query = "SELECT * FROM penulis WHERE nama='$nama' AND id != '$id'";
        $result = mysqli_query($link, $query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            $error_message .= "<li>Nama penulis sudah ada di database</li>";
        }

        if ($error_message === "") {
            // Escape string untuk query
            $id = mysqli_real_escape_string($link, $id);
            $usia = mysqli_real_escape_string($link, $usia);
            $phone = mysqli_real_escape_string($link, $phone);
            $email = mysqli_real_escape_string($link, $email);
            
            // Perbaikan query UPDATE - menghilangkan koma terakhir sebelum WHERE
            $query = "UPDATE penulis SET 
                nama = '$nama',
                usia = '$usia',
                phone = '$phone',
                email = '$email'
                WHERE id = '$id'";
            
            $result = mysqli_query($link, $query);

            if ($result) {
                $message = "Penulis dengan nama \"<b>$nama</b>\" sudah berhasil di-update";
                $message = urlencode($message);
                header("Location: penulis.php?message={$message}");
                exit(); // Tambahkan exit setelah redirect
            } else {
                die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
            }
        }
    } else {
        header("Location: penulis.php");
        exit();
    }
}

// Ambil ID dari URL jika ada
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($link, $_GET['id']);
    $query = "SELECT * FROM penulis WHERE id='$id'";
    $result = mysqli_query($link, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $nama = $data["nama"];
        $usia = $data["usia"];
        $phone = $data["phone"];
        $email = $data["email"];
        mysqli_free_result($result);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Penulis - Toko Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container mt-5 border rounded bg-white py-4 px-5 mb-5">
    <header class="header-title mb-4">
        <h1><a href="./penulis.php" style="text-decoration: none;"> <span class="text-primary">Kembali</span></a></h1>
        <hr>
    </header>
    <section>
        <h2 class="mb-3">Update Penulis</h2>
        <?php
        if (isset($error_message) && $error_message !== "") {
            echo "<div class=\"alert alert-danger mb-3\"><ul class=\"m-0\">$error_message</ul></div>";
        }
        ?>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? htmlspecialchars($id) : ''; ?>">
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama penulis</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ''; ?>" placeholder="Masukkan Nama Penulis">
            </div>
            <div class="mb-3">
                <label for="usia" class="form-label">Usia</label>
                <input type="number" name="usia" id="usia" class="form-control" value="<?php echo isset($usia) ? htmlspecialchars($usia) : ''; ?>" placeholder="Masukkan Usia">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="tel" name="phone" id="phone" class="form-control" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" placeholder="Masukkan Nomor Telepon">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" placeholder="Masukkan Email">
            </div>
            <button type="submit" name="submit" value="Update Data" class="btn btn-primary">Update Data</button>
        </form>
    </section>
</div>
</body>
</html>
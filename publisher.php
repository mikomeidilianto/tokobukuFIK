<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css" rel="stylesheet" integrity="sha256-V6lu+OdYNKTKTsVFBuQsyIlDiRWiOmtC8VQ8Lzdm2i4=" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-u3h5SFn5baVOWbh8UkOrAaLXttgSF0vXI15ODtCSxl0v/VKivnCN6iHCcvlyTL7L" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <aside>
<div class="sidebar sidebar-narrow-unfoldable border-end">
  <div class="sidebar-header border-bottom">
    <div class="sidebar-brand">Book</div>
  </div>
  <ul class="sidebar-nav">
    <li class="nav-title">Daftar</li>
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
        <i class="nav-icon cil-speedometer"></i> Buku
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="publisher.php">
        <i class="nav-icon cil-speedometer"></i> Publisher
      </a>
    </li>
    <li class="nav-item nav-group show">
      <a class="nav-link" href="penulis.php">
        <i class="nav-icon cil-speedometer"></i> Penulis
      </a>
    </li>
    <li class="nav-item mt-auto">
        <li class="nav-item">
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="nav-icon cil-layers"></i> Logout
          </a>
        </li>
    </li>
  </ul>
</div>
  </aside>
  <main style="padding-left: 60px">
    <header style="padding: 20px; margin-left: 20px;">
    <h2>Daftar Publisher</h2>
  </header>
  <div class="clearfix">
            <a href="add_publisher.php" class="btn btn-primary float-end" style="width: 100px; margin-right: 50px;">Add</a>
        </div>
        <?php
        if (isset($_GET["message"])) {
            echo "<div class=\"alert alert-success my-3\">".$_GET["message"]."</div>";
        }
        ?>
    <table class="table table-striped text-center">
      <thead style="margin: 20px;">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama Publisher</th>
      <th scope="col">Alamat</th>
      <th scope="col">Tahun berdiri</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
  <?php
  include("koneksi.php");
  $query = "SELECT * FROM publisher ORDER BY nama_publisher ASC";
  $result = mysqli_query($link, $query);
  if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
  }

  $i = 1;
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<th scope=\"row\">$i</th>";
                    echo "<td>{$data['nama_publisher']}</td>";
                    echo "<td>{$data['alamat']}</td>";
                    echo "<td>{$data['tahun_berdiri']}</td>";
                    echo "<td class=\"text-center\">
                            <form action=\"./update_publisher.php\" method=\"post\" class=\"d-inline-block mb-2\">
                                <input type=\"hidden\" name=\"id\" value=\"{$data['id']}\">
                                <input type=\"submit\" name=\"submit\" value=\"Update\" style=\"width: 80px\" class=\"btn btn-info text-white\">
                            </form>
                            <form action=\"./delete_publisher.php\" method=\"post\" class=\"d-inline-block\">
                                <input type=\"hidden\" name=\"id\" value=\"{$data['id']}\">
                                <input type=\"submit\" name=\"submit\" value=\"Delete\" style=\"width: 80px\" class=\"btn btn-danger text-white\">
                            </form>
                          </td>";
                    echo "</tr>";
                    $i++;
                }
                
                mysqli_free_result($result);
                mysqli_close($link);
                ?>
  </tbody>
</table>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/js/coreui.bundle.min.js" integrity="sha384-JdRP5GRWP6APhoVS1OM/pOKMWe7q9q8hpl+J2nhCfVJKoS+yzGtELC5REIYKrymn" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
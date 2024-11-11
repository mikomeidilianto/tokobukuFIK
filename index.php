<!-- index.php -->
<?php
// session dimulai
    session_start();
//cek session untuk memeriksa user telah login atau belum
    if(isset($_SESSION['username'])){// jika tidak ada session username
    header("location: dashboard.php");// redirect ke halaman dashboard.php
    }

?>
<html>
    <head>
        <title>Login</title>
    </head>

    <body>
        <h1>Silahkan Login</h1>
        <div style="color: red; margin-bottom: 15px">
        <?php
        // cek apakah terdapat cookie dengan nama message
            if(isset($_COOKIE["notifikasi"])){// jika ada
                echo $_COOKIE["notifikasi"];// tampilkan pesannya
        }
        ?>
        </div>
        <form method="post" action="login.php">
        <label>Username</label><br />
        <input type="text" name="username" placeholder="Username" />
        <br />
        <br/>

        <label>Password</label><br />
        <input type="password" name="password" placeholder="Password"/>
        <br/>
        <br />
        <input type="submit" name="login" value="Login" />
        <input type="reset" name="cancel" value="Batal" />
        </form>
    </body>
</html>
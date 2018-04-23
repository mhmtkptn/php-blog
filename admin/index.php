<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 10.07.2017
 * Time: 15:46
 */

//config dosyası kontrolü
$file = "/var/www/sf_projeler/hafta1/blog/config.php";
if (file_exists($file)) {

    $unlink_result = unlink($file);
    echo("Dosya basariyla silindi");
} else {

};

if ($_SESSION['userLogin']["loggedIn"] === true) {
} else {
    header("Location: /blog/login.php");
    exit();
};

echo "Giris yapan kullanici: " . $_SESSION['userLogin']["userName"];
echo "<br>" . "Ip adresiniz: " . $_SESSION['userLogin']["ipAdd"] . "<br>";

?>
<html>
<head>
    <title>Yonetim Paneli</title>
</head>

<h2>Yonetim Paneli</h2>
<br><br>
<a href="article.php">Makale Ekle </a>
<br><br>
<a href="category.php">Kategori Ekle </a>
<br><br>
<a href="user.php">Kullanici Ekle </a>
<br><br>
<a href="update.php">Update </a>
<br><br>
<a href="../import.php">Data Import</a>
<br><br>
<a href="../export.php">Data Export</a>
<br><br>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>
<br><br>


</body>
</html>


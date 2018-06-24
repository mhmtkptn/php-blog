<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 11.07.2017
 * Time: 09:40
 */
require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');

//kullanıcı login kontrolü yapıyoruz
if ($_SESSION["userLogin"]["loggedIn"] === true) {
    header("Location: /blog/login.php");
    exit();
};

echo "Giris yapan kullanici: " . $_SESSION["userLogin"]["userName"];
echo "<br>" . "Ip adresiniz: " . $_SESSION["userLogin"]["ipAdd"];

if ($_POST) {
    $categoryController = new \src\controller\CategoryController();
    $categoryController->insert($_POST);
}

?>

<html>
<head>
    <title>Kategori Yonetimi</title>
    <meta charset="utf-8">
</head>
<body>


<h2>Kategori Yonetimi</h2>
<a href="index.php">Yonetim Anasayfa </a>
<br>
<a href="article.php">Makale Yoneticisi </a>
<br>
<a href="user.php">Kullanici Yoneticisi </a>
<br><br><br>

<form action="" method="POST">
    Kategori adi:<br>
    <input type="text" name="name">
    <br><br>
    <input type="submit" value="Ekle">
</form>

<br><br>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>

</body>
</html>



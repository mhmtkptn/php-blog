<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 10.07.2017
 * Time: 15:40
 */
require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');
require_once('/var/www/sf_projeler/hafta1/blog/Validation.php');

//kullanıcı login kontrolü yapıyoruz
if ($_SESSION['userLogin']["loggedIn"] !== true) {
    header("Location: /blog/login.php");
    exit();
};

echo "Giris yapan kullanici: " . $_SESSION["userLogin"]["userName"];
echo "<br>" . "Ip adresiniz: " . $_SESSION["userLogin"]["ipAdd"];

// asıl değişkenlere ve hata olması durumunda kullanılacak değişkenleri null boş atadık
$nameSurnameErr = $userNameErr = $passwordErr = $eMailErr = "";
$nameSurname = $userName = $password = $password_md5 = $eMail = "";

$nameSurname = $_POST["nameSurname"];
$userName = $_POST["userName"];
//parolayı md5 algoritmasına soktuk
$_POST["password_md5"] = md5($_POST["password_md5"]);
$eMail = $_POST["eMail"];

if ($_POST) {
    try {
        //ad soyad dolduruldumu kontrolunu yaptık
        if (empty($_POST["nameSurname"])) {
            $nameSurnameErr = "Ad Soyad bilgisi zorunludur <br>";
            echo("$nameSurnameErr");
        } else {
            $nameSurname = Validation::testInput($_POST["nameSurname"]);
        }


        //kullanıcı adı dolduruldumu kontrolunu yaptık
        if (empty($_POST["userName"])) {
            $userNameErr = "Kullanıcı adı bilgisi zorunludur";
            echo("$userNameErr");
        } else {
            $userName = Validation::testInput($_POST["userName"]);
            //sadece standart karakter ve boşluk kontrolü yaptık
            if (!preg_match("/^[a-zA-Z ]*$/", $userName)) {
                $userNameErr = "Sadece standart karakter ve boşluğa izin verilmektedir <br>";
                echo("$userNameErr");
            }
        }


        //parola dolduruldumu kontrolunu yaptık
        if (empty($_POST["password_md5"])) {
            $passwordErr = "Parola bilgisi zorunludur <br>";
            echo("$passwordErr");
        } else {
            $password = Validation::testInput($_POST["password_md5"]);
        }


        if (empty($_POST["eMail"])) {
            $eMailErr = "E-posta bilgisi zorunludur";
            echo("$eMailErr");
        } else {
            $eMail = Validation::testInput($_POST["eMail"]);
// e-posta adresi için uygunluk kontrolü yapıldı
            if (!filter_var($eMail, FILTER_VALIDATE_EMAIL)) {
                $eMailErr = "Hatali e-posta formatı";
            }
        }

        if (!filter_var($eMail, FILTER_VALIDATE_EMAIL) === false) {
            $userController = new \src\controller\UserController();
            $userController->insert($_POST);
            if ($result == false) {
                printf("Error: %s\n", $conn->error);
            }
        }
    } catch (\Exception $exception) {
        var_dump($exception);
        exit;
    }
}
?>

<html>
<head>
    <title> Kullanici Yonetimi</title>
    <meta charset="utf-8">
</head>
<body>

<h2>Kullanici Yonetimi</h2>
<a href="index.php">Yonetim Anasayfa </a>
<br>
<a href="category.php">Kategori Yoneticisi </a>
<br>
<a href="article.php">Makale Yoneticisi </a>
<br><br><br>

<form action="" method="POST">
    Ad Soyad:<br>
    <input type="text" name="nameSurname">
    <br><br>
    Kullanici Adi:<br>
    <input type="text" name="userName">
    <br><br>
    Parola:<br>
    <input type="password" name="password_md5">
    <br><br>
    E-Posta:<br>
    <input type="text" name="eMail">
    <br><br>
    <input type="submit" value="Ekle">
</form>

</body>

<br><br>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>
</html>
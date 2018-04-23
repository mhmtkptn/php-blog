<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 26.07.2017
 * Time: 10:29
 */
require_once __DIR__ . "/vendor/autoload.php";
$captchaCode = $_SESSION["captchaCode"];


//captcha doğrulaması yapıyoruz
if ($_POST) {
    $captchaCodeCheck = $_POST['captcha'];
    if ($captchaCode == $captchaCodeCheck) {

        $memberController = new src\controller\MemberController();
        $memberController->insert($_POST);
        echo "Uye kaydi basariyla olusturuldu";
    } else {
        echo "Dogrulama kodu hatasi";
    }

}


?>

<html>
<head>
    <title>Kayıt Ol</title>
    <meta charset="utf-8">
</head>
<body>

<h2>Kayıt Ol</h2>
<a href="index.php">Blog Anasayfa</a>
<br>
<a href="login.php">Login</a>
<br><br><br>
<form action="" method="POST">
    Ad Soyad:<br>
    <input type="text" name="nameSurname">
    <br><br>
    Kullanici Adi:<br>
    <input type="text" name="memberName">
    <br><br>
    Parola:<br>
    <input type="password" name="password">
    <br><br>
    E-Posta:<br>
    <input type="text" name="eMail">
    <br><br>
    <img src='captcha.php'/>
    <br><br>
    Doğrulama Kodu:<br>
    <input type="text" name="captcha">
    <br><br>
    <input type="submit" value="Ekle">
</form>

</body>
</html>
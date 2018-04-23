<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 28.07.2017
 * Time: 10:43
 */
require_once __DIR__ . "/vendor/autoload.php";
$captchaCode = $_SESSION["captchaCode"];


//Captcha doğrulaması yapıyoruz
if ($_POST) {
    $captchaCodeCheck = $_POST['captcha'];
    if ($captchaCode == $captchaCodeCheck) {

        $contactController = new \src\controller\ContactController();
        $contactController->insert($_POST);
        echo "Mesajınız başarıyla gönderilmiştir";

    } else {
        echo "Doğrulama kodunu yanlış girdiniz";
    }
} else {
    echo "Formu eksiksiz doldurarak tekrar deneyin";
}

?>
<html>
<head>
    <title>Bize Ulaşın</title>
    <meta charset="utf-8">
</head>
<body>

<h2>İletişim Formu</h2>
<br><br><br>

<form action="" method="POST">
    Ad / Soyad:<br>
    <input type="text" name="nameSurname">
    <br><br>
    E-Posta:<br>
    <input type="text" name="eMail">
    <br><br>
    Başlık:<br>
    <input type="text" name="title">
    <br><br>
    Mesaj:<br>
    <textarea name="message" rows="10" cols="33">
İletmek istediğiniz mesaj</textarea>
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
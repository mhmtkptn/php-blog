<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 26.07.2017
 * Time: 14:36
 */

require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');

//Kullanıcı login kontrolü yapıyoruz
if ($_SESSION['userLogin']["loggedIn"] !== true) {
    header("Location: /blog/login.php");
    exit();
};

echo "Giris yapan kullanici: " . $_SESSION["userLogin"]["userName"];
echo "<br>" . "Ip adresiniz: " . $_SESSION["userLogin"]["ipAdd"];
var_dump($_GET["id"]);

//Select için
if (isset($_GET["id"])) {
    $member = new src\entity\User();
    $member->setId($_GET["id"]);
    $memberController = new \src\controller\MemberController();
    $memberController->select();
    $memberRows = $memberController->select();
    foreach ($memberRows as $memberRow) {
    }
}
echo $_GET["id"];

// Delete için
if (isset($_POST["sil"])) {
    $member = new \src\entity\Member();
    $member->setId($_GET["id"]);
    $memberAdapter = new src\adapter\MemberAdapter();
    $memberAdapter->delete($member);
    $memberAdapter->execute();
    if ($memberAdapter->getResult() == false) {
        printf("Error: %s\n", $memberAdapter->getConn()->error);

    } else {
        echo "Kullanici basariyla silindi. Anasayfaya yonlendiriliyorsunuz.";
        header("Location: /blog/admin/index.php");
        exit;
    }
}


//Update için
if (isset($_GET["id"])) {
    $nameSurname = $_POST["nameSurname"];
    $memberName = $_POST["memberName"];
    $eMail = $_POST["eMail"];
    $member = new src\entity\Member();
    $member->setId($_GET["id"]);
    $memberAdapter = new src\adapter\MemberAdapter();
    //Yeni parola girildimi
    if (isset($_POST["password_md5"]) && !empty($_POST["password_md5"])) {
        $password_md5 = $_POST["password_md5"];
        $password = md5($password_md5);
        $memberAdapter->update($member, ["nameSurname" => $nameSurname, "memberName" => $memberName, "password" => $password, "eMail" => $eMail]);
        $memberAdapter->execute();
    } else {
        $memberAdapter->update($member, ["nameSurname" => $nameSurname, "memberName" => $memberName, "eMail" => $eMail]);
        $memberAdapter->execute();
    }


    if ($memberAdapter->getResult() == false) {
        printf("Error: %s\n", $memberAdapter->getConn()->error);
    }
}
?>

<html>
<head>
    <title>Kullanıcı Yonetimi</title>
    <meta charset="utf-8">
</head>
<body>

<h2>Kullanıcı Düzenle</h2>
<a href="index.php">Yonetim Anasayfa </a>
<br><br>
<a href="update.php">Update/Delete Yoneticisi </a>
<br><br><br>


<form action="" method="POST">
    Ad Soyad:<br>
    <input type="text" name="nameSurname" value="<?= $memberRow["nameSurname"]; ?>">
    <br><br>
    Kullanici Adi:<br>
    <input type="text" name="memberName" value="<?= $memberRow["memberName"]; ?>">
    <br><br>
    Parola:<br>
    <input type="password" name="password_md5">
    <br><br>
    E-Posta:<br>
    <input type="text" name="eMail" value="<?= $memberRow["eMail"]; ?>">
    <br><br>
    <label><input type="checkbox" name="sil"/> Sil</label><br><br>
    <input type="submit" value="Onayla">
</form>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>
</body>
</html>


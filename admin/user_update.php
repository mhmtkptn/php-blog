<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 14.07.2017
 * Time: 14:41
 */
require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');

//Kullanıcı login kontrolü yapıyoruz
if ($_SESSION["userLogin"]["loggedIn"] === true) {
} else {
    header("Location: /blog/login.php");
    exit();
};


echo "Giris yapan kullanici: " . $_SESSION["userLogin"]["userName"];
echo "<br>" . "Ip adresiniz: " . $_SESSION["userLogin"]["ipAdd"];


//Select için
if (isset($_GET["id"])) {
    $user = new src\entity\User();
    $user->setId($_GET["id"]);
    $userController = new \src\controller\UserController();
    $userController->select();
    $userRows = $userController->select();
    foreach ($userRows as $userRow) {

    }
}


// Delete için
if (isset($_POST["sil"])) {
    $user = new \src\entity\User();
    $user->setId($_GET["id"]);
    $userAdapter = new src\adapter\UserAdapter();
    $userAdapter->delete($user);
    $userAdapter->execute();
    if ($userAdapter->getResult() == false) {
        printf("Error: %s\n", $userAdapter->getConn()->error);

    } else {
        echo "Kullanici basariyla silindi. Anasayfaya yonlendiriliyorsunuz.";
        header("Location: /blog/admin/index.php");
        exit;
    }


}


//Update için
if (isset($_GET["id"])) {
    $nameSurname = $_POST["nameSurname"];
    $userName = $_POST["userName"];
    $eMail = $_POST["eMail"];
    $user = new src\entity\User();
    $user->setId($_GET["id"]);
    $userAdapter = new src\adapter\UserAdapter();
    //Yeni parola girildimi
    if (isset($_POST["password_md5"]) && !empty($_POST["password_md5"])) {
        $password_md5 = $_POST["password_md5"];
        $password = md5($password_md5);
        $userAdapter->update($user, ["nameSurname" => $nameSurname, "userName" => $userName, "password" => $password, "eMail" => $eMail]);
        $userAdapter->execute();
    } else {
        $userAdapter->update($user, ["nameSurname" => $nameSurname, "userName" => $userName, "eMail" => $eMail]);
        $userAdapter->execute();
    }


    if ($userAdapter->getResult() == false) {
        printf("Error: %s\n", $userAdapter->getConn()->error);
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
    <input type="text" name="nameSurname" value="<?= $userRow["nameSurname"]; ?>">
    <br><br>
    Kullanici Adi:<br>
    <input type="text" name="userName" value="<?= $userRow["userName"]; ?>">
    <br><br>
    Parola:<br>
    <input type="password" name="password_md5">
    <br><br>
    E-Posta:<br>
    <input type="text" name="eMail" value="<?= $userRow["eMail"]; ?>">
    <br><br>
    <label><input type="checkbox" name="sil"/> Sil</label><br><br>
    <input type="submit" value="Onayla">
</form>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>
</body>
</html>


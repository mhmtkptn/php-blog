<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 14.07.2017
 * Time: 14:40
 */
require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');


//kullanıcı login kontrolü yapıyoruz
if ($_SESSION["userLogin"]["loggedIn"] === true) {
} else {
    header("Location: /blog/login.php");
    exit();
};


echo "Giris yapan kullanici: " . $_SESSION["userLogin"]["userName"];
echo "<br>" . "Ip adresiniz: " . $_SESSION["userLogin"]["ipAdd"];


//Update sayfasına id ile mi girdi ?
if (isset($_GET["id"])) {
    $_SESSION["idErr"] = "";
} else {
    header("Location: /blog/update.php");
    $_SESSION["idErr"] = "Lutfen duzenlemek istediğiniz nesnenin id'sini giriniz";
    exit();
}


//Select için
if (isset($_GET["id"])) {
    $category = new \src\entity\Category();
    $category->setId($_GET["id"]);
    $categoryController = new \src\controller\CategoryController();
    $categoryController->select();
    $categoryRows = $categoryController->select();
    foreach ($categoryRows as $categoryRow) {
    }

}


// delete için
if (isset($_POST["sil"])) {
    $category = new \src\entity\Category();
    $category->setId($_GET["id"]);
    $categoryAdapter = new src\adapter\CategoryAdapter();
    $categoryAdapter->delete($category);
    $categoryAdapter->execute();
    if ($categoryAdapter->getResult() == false) {
        printf("Error: %s\n", $categoryAdapter->getConn()->error);

    } else {
        echo "Kategori basariyla silindi. Anasayfaya yonlendiriliyorsunuz.";
        header("Location: /blog/admin/index.php");
        exit;
    }
}


//Update için
if (isset($_GET["id"])) {
    $name = $_POST["name"];
    $category = new src\entity\Category();
    $category->setId($_GET["id"]);
    $categoryAdapter = new \src\adapter\CategoryAdapter();
    $categoryAdapter->update($category, ["name" => $name]);
    $categoryAdapter->execute();
    if ($categoryAdapter->getResult() == false) {
        printf("Error: %s\n", $categoryAdapter->getConn()->error);
    }

}

?>


<html>
<head>
    <title>Kategori Yonetimi</title>
    <meta charset="utf-8">
</head>
<body>

<h2>Kategori Düzenle</h2>
<a href="index.php">Yonetim Anasayfa </a>
<br><br>
<a href="update.php">Update/Delete Yoneticisi </a>
<br><br><br>


<form action="" method="POST">
    <br><br>
    <?php
    echo("Duzenleyen: <br>" . $_SESSION['userName']);
    ?>
    <br><br>
    Kategori Adi:<br>
    <input type="text" name="name" value="<?php echo $categoryRow["name"]; ?>">

    <br><br>
    <br><br>
    <label><input type="checkbox" name="sil"/> Sil</label><br><br>
    <input type="submit" value="Onayla">
</form>


<a href="../logout.php"><h4>Oturumu kapat</h4></a>
</body>
</html>

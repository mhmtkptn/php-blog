<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 10.07.2017
 * Time: 14:58
 */

require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');
define('targetDir', 'uploads/');

//kullanıcı login kontrolü yapıyoruz
if ($_SESSION["userLogin"]["loggedIn"] === true) {
} else {
    header("Location: /blog/login.php");
    exit;
};


echo "Giris yapan kullanici: " . $_SESSION["userLogin"]["userName"];
echo "<br>" . "Ip adresiniz: " . $_SESSION["userLogin"]["ipAdd"];


//Kategori listelemek için
$categoryController = new \src\controller\CategoryController();
$categoryRows = $categoryController->select();

//sessiondaki username'i posttaki username'e eşitledik
$_POST['userName'] = $_SESSION['userName'];

//fileId varmı ? ve value'su boşmu ? kontrolü yaptık
if (isset($_FILES['fileId']['tmp_name']) && !empty($_FILES['fileId']['tmp_name'])) {
    $tmpName = $_FILES["fileId"]["name"];
    $tmpNamePieces = explode(".", $tmpName);
    $extension = end($tmpNamePieces);
    if (preg_match("/(gif|png|jpeg|tiff|jpg)$/", $extension)) {
        $targetFile = rand() . '_' . time() . '.' . $extension;
        $targetPath = targetDir . $targetFile;
        if (isset($_POST)) {
            $_POST['fileId'] = $targetPath;
            move_uploaded_file($_FILES["fileId"]["tmp_name"], $targetPath);
            $articleController = new \src\controller\ArticleController();
            $articleController->insert($_POST);
        } else {

            echo "Tekrar deneyiniz";
        }
    }

} else {

    if (isset($_POST)) {
        $_POST['fileId'] = NULL;
        $articleController = new \src\controller\ArticleController();
        $articleController->insert($_POST);
        $lastId = $articleController->getLastId();
    }

}

?>

<html>
<head>
    <title>Makale Yonetimi</title>
    <meta charset="utf-8">
</head>
<body>

<h2>Makale Yonetimi</h2>
<a href="index.php">Yonetim Anasayfa </a>
<br>
<a href="category.php">Kategori Yoneticisi </a>
<br>
<a href="user.php">Kullanici Yoneticisi </a>
<br><br><br>

<form action="" method="POST" enctype="multipart/form-data">
    Yazinin ait oldugu kategori:<br>


    <?php
    //category'deki id ve name'i mysqli_fetch_assoc ile kolon sırasına göre getirdik
    foreach ($categoryRows["categories"] as $categoryRow) {
        if ($articleRow["categoryId"] == $categoryRow["id"]) {

            $options .= "<option selected value='" . $categoryRow['id'] . "'>" . $categoryRow['name'] . "</option>";

        } else {
            $options .= "<option value='" . $categoryRow['id'] . "'>" . $categoryRow['name'] . "</option>";

        }

    }
    ?>
    <select name="categoryId">
        <?php echo $options; ?>
    </select>
    <br><br>
    Yazar:<br>
    <?= $_SESSION['userName']; ?>

    <br><br>
    Başlık:<br>
    <input type="text" name="description">
    <br><br>
    Yazi:<br>
    <textarea name="article" rows="10" cols="33">
Eklenecek yazi
</textarea>
    <br><br>
    Meta Keyword:<br>
    <textarea name="keyword" rows="5" cols="33">
Eklemek istediğiniz keywordlerin arasına , ekleyin
</textarea>
    <br><br>
    Dosyayi secin:
    <br><br>
    <input type="file" name="fileId" id="fileId">
    <br><br>
    <input type="submit" value="Ekle">
</form>


<br><br>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>
</body>
</html>
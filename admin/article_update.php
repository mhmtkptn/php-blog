<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 10.07.2017
 * Time: 14:58
 */
require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');


//kullanıcı login kontrolü yapıyoruz
if ($_SESSION["userLogin"]["loggedIn"] === true) {
} else {
    header("Location: /blog/login.php");
    exit();
};
echo("Giris yapan kullanici: " . $_SESSION["userLogin"]['userName'] . "<br>");


$id = $_GET["id"];

//Update için
if (isset($_POST["id"])) {
    $categoryId = $_POST["categoryId"];
    $userName = $_POST["userName"];
    $description = $_POST['description'];
    $content = $_POST["article"];
    $keyword = $_POST["keyword"];
    $article = new \src\entity\Article();
    $article->setId($_GET["id"]);
    $articleController = new \src\controller\ArticleController();
    $articleController->update($_POST);

    if ($articleController->getResult() == false) {
        printf("Error: %s\n", $articleController->getConn()->error);
    }
}

//Düzenlenmek istenen article'ı veritabanından select ile çekiyoruz
if (isset($_GET["id"])) {
    $article = new \src\entity\Article();
    $article->setId($_GET["id"]);
    $articleController = new \src\controller\ArticleController();
    $articleController->select();
    $articleRows = $articleController->select();
    foreach ($articleRows as $articleRow) {

    }
}

// Delete için
if (isset($_POST['sil'])) {
    $articleAdapter = new \src\adapter\ArticleAdapter();
    $article = new \src\entity\Article();
    $article->setId($_GET["id"]);
    $articleAdapter->delete($article);
    $articleAdapter->execute();
    if ($articleAdapter->getResult() == false) {
        printf("Error: %s\n", $articleAdapter->getConn()->error);

    } else {
        echo "Makale basariyla silindi. Anasayfaya yonlendiriliyorsunuz.";
        header("Location: /blog/admin/index.php");
        exit;
    }

}

//Category dropdown menu için
$categoryController = new \src\controller\CategoryController();
$categoryController->select();
$categoryRows = $categoryController->select();
?>

<html>
<head>
    <title>Makale Yonetimi</title>
    <meta charset="utf-8">
</head>
<body>

<h2>Makale Düzenle</h2>
<a href="index.php">Yonetim Anasayfa </a>
<br><br>
<a href="update.php">Update/Delete Yoneticisi </a>
<br><br><br>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $articleRow[0] ?>"/>
    Yazının ait olduğu kategori:<br>
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
    <?php
    echo("Yazar: <br>" . $_SESSION['userName']);
    ?>
    <br><br>
    Başlık:<br>
    <input type="text" name="description" value="<?= $articleRow["description"]; ?>">
    <br><br>
    Yazı:<br>
    <textarea name="article" rows="10" cols="33">
            <?php echo $articleRow["article"]; ?>
    </textarea>
    <br><br>
    Meta Keyword:<br>
    <textarea name="keyword" rows="5" cols="33">
            <?php echo $articleRow["keyword"]; ?>
</textarea>
    <br><br>
    <label><input type="checkbox" name="sil"/> Sil</label><br><br>
    <input type="submit" value="Onayla">
</form>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>
</body>
</html>

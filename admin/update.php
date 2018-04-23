<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 14.07.2017
 * Time: 14:13
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

//Hata mesajı varsa yazdır yoksa devam
if (isset($_SESSION["idErr"]) && !empty($_SESSION["idErr"])) {
    echo("Hata: " . $_SESSION["idErr"] . "<br><br>");
}


//Article listele
$articleController = new \src\controller\ArticleController();
$articleRows = $articleController->select();

//Kategori listele
$categoryController = new \src\controller\CategoryController();
$categoryRows = $categoryController->select();

//User listele
$userController = new src\controller\UserController();
$userRows = $userController->select();

//Member Listele
$memberController = new src\controller\MemberController();
$memberRows = $memberController->select();


?>
<html>
<head>
    <title>Blog Yonetimi</title>
    <meta charset="utf-8">
</head>
<body>
<h2>Update / Delete</h2>
<a href="index.php">Yonetim Anasayfa </a>
<br><br><br>


<h2>Article Update</h2>
<!-- // makale update için -->
<form action="article_update.php" method="GET">
    Duzenlemek istediginiz yaziyi seciniz:<br>
    <?php
    $articles = $articleRows["blogs"];
    //category'deki id ve name'i mysqli_fetch_assoc ile kolon sırasına göre getirdik
    foreach ($articles as $articleRow) {

        $optionsArticle .= "<option selected value='" . $articleRow['id'] . "'>" . $articleRow['description'] . "</option>";
    }
    ?>
    <select name="id">
        <?php echo $optionsArticle; ?>
    </select>
    <br><br>
    <input type="submit" value="Duzenle">
</form>

<br><br>


<h2>Kategori Update</h2>
<!-- kategori update için -->
<form action="category_update.php" method="GET">
    Duzenlemek istediginiz kategoriyi seciniz:<br>
    <?php
    foreach ($categoryRows["categories"] as $categoryRow) {

        $optionsCategory .= "<option selected value='" . $categoryRow['id'] . "'>" . $categoryRow['name'] . "</option>";
    }
    ?>
    <select name="id">
        <?php echo $optionsCategory; ?>
    </select>
    <br><br>
    <input type="submit" value="Duzenle">
</form>
<br><br>


<h2>User Update</h2>
<!-- //user update için -->
<form action="user_update.php" method="GET">
    Duzenlemek istediginiz kullaniciyi seciniz:<br>
    <?php
    foreach ($userRows as $userRow) {

        $optionsUser .= "<option selected value='" . $userRow['Id'] . "'>" . $userRow['userName'] . "</option>";
    }
    ?>
    <select name="id">
        <?php echo $optionsUser; ?>
    </select>
    <br><br>
    <input type="submit" value="Duzenle">
</form>

<br><br>


<h2>Member Update</h2>
<!-- //user update için -->
<form action="member_update.php" method="GET">
    Duzenlemek istediginiz üyeyi seciniz:<br>
    <?php
    foreach ($memberRows as $memberRow) {

        $optionsMember .= "<option selected value='" . $memberRow['Id'] . "'>" . $memberRow['memberName'] . "</option>";
    }
    ?>
    <select name="id">
        <?php echo $optionsMember; ?>
    </select>
    <br><br>
    <input type="submit" value="Duzenle">
</form>

<br><br>
<a href="../logout.php"><h4>Oturumu kapat</h4></a>


</body>
</html>
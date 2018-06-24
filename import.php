<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 26.07.2017
 * Time: 16:05
 */

require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');
define('targetDir', 'uploads/');

//fileId varmı ? ve value'su boşmu ? kontrolü yaptık
if (isset($_FILES['fileId']['tmp_name']) && !empty($_FILES['fileId']['tmp_name'])) {
    $tmpName = $_FILES["fileId"]["name"];
    $tmpNamePieces = explode(".", $tmpName);
    $extension = end($tmpNamePieces);
    if (preg_match("/(xml)$/", $extension)) {
        $targetFile = rand() . '_' . time() . '.' . $extension;
        $targetPath = targetDir . $targetFile;
        if (isset($_POST)) {
            $_POST['fileId'] = $targetPath;
            move_uploaded_file($_FILES["fileId"]["tmp_name"], $targetPath);
            //yüklenen xml dosyasını arraye ekledik
            $xml = simplexml_load_file("$targetPath") or die("Error: Cannot create object");
        } else {

            echo "Tekrar deneyiniz";
        }

//Seçime göre yüklenen xml dosyasındaki data tabloya insert edilecek
        $tableName = $_POST["table"];
        switch ($tableName) {
            case "user":
                $_POST["id"] = $xml->id;
                $_POST["nameSurname"] = $xml->nameSurname;
                $_POST["userName"] = $xml->userName;
                $_POST["password"] = $xml->password;
                $_POST["eMail"] = $xml->eMail;

                $userController = new \src\controller\UserController();
                $userController->insert($_POST);

                break;

            case "member":
                $_POST["id"] = $xml->id;
                $_POST["nameSurname"] = $xml->nameSurname;
                $_POST["memberName"] = $xml->memberName;
                $_POST["password"] = $xml->password;
                $_POST["eMail"] = $xml->eMail;

                $memberController = new \src\controller\MemberController();
                $memberController->insert($_POST);

                break;

            case "article":
                $_POST["id"] = $xml->id;
                $_POST["categoryId"] = $xml->categoryId;
                $_POST["userName"] = $xml->userName;
                $_POST["description"] = $xml->description;
                $_POST["article"] = $xml->article;
                $_POST["keyword"] = $xml->keyword;
                $_POST["fileId"] = $xml->fileId;
                $_POST["date"] = $xml->date;

                $articleController = new \src\controller\ArticleController();
                $articleController->insert($_POST);

                break;

            case "category":
                $_POST["id"] = $xml->id;
                $_POST["name"] = $xml->name;

                $categoryController = new \src\controller\CategoryController();
                $categoryController->insert($_POST);

                break;
        }
    }
}
?>

<html>
<head>
    <title>Data İmport</title>
    <meta charset="utf-8">
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    Lütfen yüklemek istediğiniz xml dosyasını seçin:
    <br><br>
    <input type="file" name="fileId" id="fileId">
    <br><br>
    <input type="radio" name="table" value="user"> User tablosuna yükle<br>
    <input type="radio" name="table" value="member">Member tablosuna yükle<br>
    <input type="radio" name="table" value="article">Article tablosuna yükle<br>
    <input type="radio" name="table" value="category">Category tablosuna yükle
    <br><br>
    <input type="submit" value="Yukle" name="submit">
</form>

</body>
</html>
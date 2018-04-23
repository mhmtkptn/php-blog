<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 27.07.2017
 * Time: 15:54
 */
require_once('/var/www/sf_projeler/hafta1/blog/vendor/autoload.php');

$tableName = $_POST["table"];
switch ($tableName) {
    case "user":

        $userController = new \src\controller\UserController();
        $users = $userController->select();

        $xmlExport = new XMLWriter();
        $xmlExport->openMemory();

//veritabanındaki veriyi xml olarak export edeceğimiz dosyayı belirledik
        $xmlExport->openURI("user_export.xml");

//xml versiyon ve karakter seti tanımlayarak başlattık
        $xmlExport->startDocument('1.0', 'utf-8');
        $xmlExport->setIndent(true);
//element adını belirledik
        $xmlExport->startElement('blog');

        foreach ($users as $user) {
            $xmlExport->startElement('user');
            $xmlExport->writeAttribute('id', $user['id']);
            $xmlExport->writeAttribute('nameSurname', $user['categoryId']);
            $xmlExport->writeAttribute('userName', $user['userName']);
            $xmlExport->writeAttribute('password', $user['password']);
            $xmlExport->writeAttribute('eMail', $user['eMail']);
            $xmlExport->endElement();
        }
        $xmlExport->endElement();
        echo "User tablosu başarıyla export edildi";
        $xmlExport->flush();

        break;

    case "member":

        $memberController = new \src\controller\MemberController();
        $members = $memberController->select();

        $xmlExport = new XMLWriter();
        $xmlExport->openMemory();

//veritabanındaki veriyi xml olarak export edeceğimiz dosyayı belirledik
        $xmlExport->openURI("member_export.xml");

//xml versiyon ve karakter seti tanımlayarak başlattık
        $xmlExport->startDocument('1.0', 'utf-8');
        $xmlExport->setIndent(true);
//element adını belirledik
        $xmlExport->startElement('blog');

        foreach ($members as $member) {
            $xmlExport->startElement('member');
            $xmlExport->writeAttribute('id', $member['id']);
            $xmlExport->writeAttribute('nameSurname', $member['categoryId']);
            $xmlExport->writeAttribute('userName', $member['memberName']);
            $xmlExport->writeAttribute('password', $member['password']);
            $xmlExport->writeAttribute('eMail', $member['eMail']);
            $xmlExport->endElement();
        }
        $xmlExport->endElement();
        echo "Member tablosu başarıyla export edildi";
        $xmlExport->flush();


        break;

    case "article":

        $articleController = new \src\controller\ArticleController();
        $articleReturn = $articleController->select();
        $articles = $articleReturn["blogs"];

        $xmlExport = new XMLWriter();
        $xmlExport->openMemory();

//veritabanındaki veriyi xml olarak export edeceğimiz dosyayı belirledik
        $xmlExport->openURI("article_export.xml");

//xml versiyon ve karakter seti tanımlayarak başlattık
        $xmlExport->startDocument('1.0', 'utf-8');
        $xmlExport->setIndent(true);
//element adını belirledik
        $xmlExport->startElement('blog');

        foreach ($articles as $article) {
            $xmlExport->startElement('article');
            $xmlExport->writeAttribute('id', $article['id']);
            $xmlExport->writeAttribute('categoryId', $article['categoryId']);
            $xmlExport->writeAttribute('userName', $article['userName']);
            $xmlExport->writeAttribute('description', $article['description']);
            $xmlExport->writeAttribute('article', $article['article']);
            $xmlExport->writeAttribute('keyword', $article['keyword']);
            $xmlExport->writeAttribute('fileId', $article['fileId']);
            $xmlExport->writeAttribute('date', $article['date']);
            $xmlExport->endElement();
        }
        $xmlExport->endElement();
        $xmlExport->flush();
        echo "Article tablosu başarıyla export edildi";
        header("Refresh:1; url=export.php");
        break;

    case "category":
        $categoryController = new \src\controller\CategoryController();
        $categorys = $categoryController->select();

        $xmlExport = new XMLWriter();
        $xmlExport->openMemory();

//veritabanındaki veriyi xml olarak export edeceğimiz dosyayı belirledik
        $xmlExport->openURI("category_export.xml");

//xml versiyon ve karakter seti tanımlayarak başlattık
        $xmlExport->startDocument('1.0', 'utf-8');
        $xmlExport->setIndent(true);
//element adını belirledik
        $xmlExport->startElement('blog');

        foreach ($categorys as $category) {
            $xmlExport->startElement('category');
            $xmlExport->writeAttribute('id', $category['id']);
            $xmlExport->writeAttribute('name', $category['name']);
            $xmlExport->endElement();
        }
        $xmlExport->endElement();
        echo "Category tablosu başarıyla export edildi";
        $xmlExport->flush();

        break;

}


?>

<html>
<head>
    <title>Data Export</title>
    <meta charset="utf-8">
</head>
<body>
<form action="" method="post">
    Lütfen export istediğiniz tabloyu seçin:
    <br><br>
    <input type="radio" name="table" value="user"> User<br>
    <input type="radio" name="table" value="member">Member<br>
    <input type="radio" name="table" value="article">Article<br>
    <input type="radio" name="table" value="category">Category<br><br>
    <input type="submit" value="Export" name="submit">
</form>
</body>
</html>

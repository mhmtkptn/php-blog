<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 26.07.2017
 * Time: 10:27
 */

if ($_SESSION["memberLogin"]["loggedIn"] === true){

    echo "Merhaba". $_SESSION["memberLogin"]["memberName"] ."<br><br>";

}else{

    header("Refresh:1; url=index.php");
}


?>

<html>
<head>
    <title>Üye Kontrol Paneli</title>
    <meta charset="utf-8">
</head>
<body>
<h1>Üye Kontrol Paneli</h1>
<br><br><br><br>
<a href="index.php"> <h4>Blog Anasayfa</h4> </a>
<br><br>
<a href="member_update.php?id=<?=$_SESSION["memberLogin"]["memberId"]?>"> <h4>Üyelik Bilgilerimi Düzenle</h4> </a>
<br><br>
<a href="logout.php"> <h4>Oturumu kapat</h4> </a>
<br><br>
</body>



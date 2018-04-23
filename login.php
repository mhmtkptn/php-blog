<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 10.07.2017
 * Time: 16:14
 */

require_once __DIR__ . "/vendor/autoload.php";


if(isset($_POST['loginName']) && isset($_POST['password'])) {
    $loginName = $_POST['loginName'];
    $password = md5($_POST['password']);

    $userAdapter = new \src\adapter\UserAdapter();
    $userAdapter->select("User",  ["where" => ["and" => ["userName" => $loginName, "password" => $password]]]);
    $userAdapter->execute();

    if ($userAdapter->getResult()->num_rows !== 0) {

        $_SESSION["userLogin"] = array('userName' => $_POST["loginName"], 'ipAdd' => $_SERVER['SERVER_ADDR'], 'loggedIn' => true);
        header("Refresh:1; url=admin/index.php");

    } elseif (isset($_POST['loginName']) && isset($_POST['password'])){

        $memberAdapter = new \src\adapter\MemberAdapter();
        $memberAdapter->select("Member",  ["where" => ["and" => ["memberName" => $loginName, "password" => $password]]]);
        $memberAdapter->execute();

        if ($memberAdapter->getResult()->num_rows !== 0) {
            $_SESSION["memberLogin"] = array('memberName' => $_POST["loginName"], 'ipAdd' => $_SERVER['SERVER_ADDR'], 'loggedIn' => true);


            $memberController = new src\controller\MemberController();
            $memberRows = $memberController->select();

            //Member id'sini aldık
            foreach ($memberRows as $memberRow) {
                if ($memberRow['memberName'] == $_SESSION["memberLogin"]["memberName"]){
                    $_SESSION["memberLogin"]['memberId'] = $memberRow['id'];
                }
            }

            var_dump($_SESSION["memberLogin"]);
            header("Refresh:1; url=member.php");

        }else{
            echo ("Kullanıcı adınız veya şifreniz hatalı");
        }

    }
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hafta1 Blog Yonetimi</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="" method="POST">
        <h2 class="form-signin-heading">Lutfen giris yapınız</h2>
        <label for="text" class="sr-only"></label>
        <input type="text" name="loginName" class="form-control" placeholder="Kullanici Adi" required autofocus>
        <label for="inputPassword" class="sr-only">Parola</label>
        <input type="password" name="password" class="form-control" placeholder="Parola" required>
        <div class="checkbox">

        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Giris yap</button>
      </form>

    </div> <!-- /container -->


    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

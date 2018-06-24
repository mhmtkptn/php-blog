<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 20.07.2017
 * Time: 15:05
 */

namespace src\controller;


use src\adapter\UserAdapter;

class UserController extends Controller
{
    public function check()
    {
        // TODO: Implement check() method.
    }

    public function insert($postUser)
    {
        $userController = new \src\controller\UserController();
        $result = $userController->selectOne(strtolower($postUser["userName"]));

        if ($result["blog"] == NULL) {
            $user = new \src\entity\User();
            $userAdapter = new \src\adapter\UserAdapter();
            $user->setNameSurname($postUser["nameSurname"])
                ->setUserName(strtolower($postUser["userName"]))
                ->setEMail(strtolower($postUser["eMail"]))
                ->setPassword($postUser["password_md5"]);
            $userAdapter->insert($user);
            $userAdapter->execute();
        } else {
            echo "Bu kullanıcı adı daha önce eklenmiştir...";

        }
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function select()
    {
        $userDatas = [];
        $userAdapter = new UserAdapter();
        $userAdapter->select("User");
        $userAdapter->execute();
        while ($row = $userAdapter->getResult()->fetch_assoc()) {
            $userDatas[] = $row;
        }
        $returnData = [
            "users" => $userDatas,
        ];
        return $returnData;
    }


    public function selectOne($userName)
    {
        $userAdapter = new UserAdapter();
        $userAdapter->select("User", ["where" => ["and" => ["userName" => $userName]]]);
        $userAdapter->execute();
        $row = $userAdapter->getResult()->fetch_assoc();
        $returnData = [
            "blog" => $row,
        ];
        return $returnData;
    }


    public function login()
    {

    }

    public function loginPost()
    {

        // loadUser işlemi yaptık

        //Bir problem yok ise
        $this->redirectUrl("/admin");
    }

    public function logOut(){

        $userAdapter = new UserAdapter();
        $userAdapter->logOut();
        return $this->redirectUrl("/blog/index");
    }
}



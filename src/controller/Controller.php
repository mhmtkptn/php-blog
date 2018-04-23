<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 31.07.2017
 * Time: 15:16
 */

namespace src\controller;


abstract class Controller implements ControllerInterface
{
    public function check()
    {
        $checkData = [];
        if(isset($_SESSION["userLogin"]["loggedIn"])){
            $checkData["user_logged_in"] = 1;
            $checkData["user_name"] = (string)$_SESSION["userLogin"]["userName"];
            $checkData["ip_address"] =  (string)$_SESSION["userLogin"]["ipAdd"];
        }
        return $checkData;
    }

    public function redirectUrl($url)
    {
        header("Location: ".$url);
    }


}
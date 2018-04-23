<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 20.07.2017
 * Time: 13:37
 */

namespace src\controller;


interface ControllerInterface
{
    public function insert($params);
    public function update();
    public function delete();
    public function select();
    public function check();
}
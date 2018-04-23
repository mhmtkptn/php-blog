<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 17.07.2017
 * Time: 15:11
 */

namespace src\adapter;


interface AdapterInterface
{
    public function insert($entity);
    public function select($tableName,$params);
    public function update($entity, $params);
    public function delete ($entity);
}
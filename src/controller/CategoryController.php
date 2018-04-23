<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 20.07.2017
 * Time: 13:35
 */

namespace src\controller;


use src\adapter\CategoryAdapter;

class CategoryController extends Controller
{
    public function insert($postCategory)
    {

        $categoryController = new \src\controller\CategoryController();
        $result = $categoryController->selectOne($postCategory["name"]);
        if ($result["blog"] == NULL) {
            $category = new \src\entity\Category();
            $categoryAdapter = new \src\adapter\CategoryAdapter();
            $category->setName(strtolower($postCategory["name"]));
            $categoryAdapter->insert($category);
            $categoryAdapter->execute();

        } else {
            echo "Bu kategori adı daha önce eklenmiştir...";

        }


    }

    public function update()
    {

    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function select()
    {
        $categoryDatas = [];
        $categoryAdapter = new CategoryAdapter();
        $categoryAdapter->select("Category");
        $categoryAdapter->execute();
        while ($row = $categoryAdapter->getResult()->fetch_assoc()) {
            $categoryDatas[] = $row;
        }
        $returnData = [
            "categories" => $categoryDatas,
        ];
        return $returnData;
    }

    public function selectOne($name)
    {
        $categoryAdapter = new CategoryAdapter();
        $categoryAdapter->select("Category", ["where" => ["and" => ["name" => $name]]]);
        $categoryAdapter->execute();
        $row = $categoryAdapter->getResult()->fetch_assoc();
        $returnData = [
            "blog" => $row,
        ];
        return $returnData;
    }


}


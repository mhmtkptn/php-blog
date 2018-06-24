<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 20.07.2017
 * Time: 13:29
 */

namespace src\controller;

use src\adapter\ArticleAdapter;
use src\adapter\CategoryAdapter;
use src\entity\Article;


class ArticleController extends Controller
{

    public function update()
    {
        $articleAdapter = new ArticleAdapter();
        $article = new Article();
        $article->setId();
        $article->setCategoryId($_POST["categoryId"])
            ->setDescription($_POST["description"])
            ->setArticle($_POST["article"])
            ->setKeyword($_POST["keyword"]);
        $articleAdapter->update($article, ["categoryId" => $article->getCategoryId(), "description" => $article->getDescription(), "article" => $article->getArticle(), "keyword" => $article->getKeyword()]);
        $articleAdapter->execute();
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function select()
    {
        $articleDatas = [];
        $categoryDatas = [];
        $articleAdapter = new ArticleAdapter();
        $articleAdapter->select("Article");
        $articleAdapter->execute();
        while ($row = $articleAdapter->getResult()->fetch_assoc()) {
            $articleDatas[] = $row;
        }
        $categoryAdapter = new CategoryAdapter();
        $categoryAdapter->select("Category");
        $categoryAdapter->execute();
        while ($row = $categoryAdapter->getResult()->fetch_assoc()) {
            $categoryDatas[] = $row;
        }

        $returnData = [
            "blogs" => $articleDatas,
            "categories" => $categoryDatas

        ];
        return $returnData;
    }

    public function selectOne($id)
    {
        $articleAdapter = new ArticleAdapter();
        $articleAdapter->select("Article", ["where" => ["and" => ["id" => $id]]]);
        $articleAdapter->execute();
        $row = $articleAdapter->getResult()->fetch_assoc();
        $returnData = [
            "blog" => $row,
        ];
        return $returnData;
    }


    /**
     * @param $postData
     */
    public function insert($postData)
    {
        $article = new \src\entity\Article();
        $articleAdapter = new \src\adapter\ArticleAdapter();
        $article->setArticle($postData["article"])
            ->setCategoryId($postData["categoryId"])
            ->setUserName($postData["userName"])
            ->setKeyword($postData["keyword"])
            ->setDescription($postData["description"])
            ->setFileId($postData["fileId"]);
        $articleAdapter->insert($article);
        $articleAdapter->execute();
    }
}





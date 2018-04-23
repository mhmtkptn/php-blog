<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 02.08.2017
 * Time: 21:04
 */

namespace test;

use src\adapter\ArticleAdapter;
use src\controller\ArticleController;
use src\entity\Article;

class ArticleControllerTest extends \PHPUnit_Framework_TestCase
{
public function testUpdate(){

    $articleAdapter = new ArticleAdapter();
    $article = new Article();
    $article->setId(19);
    $article->setUserName("km")
        ->setKeyword("sdsds")
        ->setDescription("sdsd");
    $articleAdapter->update($article, ["userName" => $article->getUserName()]);
    $articleAdapter->execute();


}

public function testDelete(){

    $articleAdapter = new ArticleAdapter();
    $article = new Article();
    $article->setId(25);
    $articleAdapter->delete($article, ["id" => $article->getId()]);
    $articleAdapter->execute();



}

public function testInsert(){




}


}

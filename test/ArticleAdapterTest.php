<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 17.07.2017
 * Time: 15:20
 */

namespace test;

use src\adapter\ArticleAdapter;
use src\entity\Article;

class ArticleAdapterTest extends \PHPUnit_Framework_TestCase {

    public function testInsert(){
        $articleAdapter = new ArticleAdapter();
        $entity = new Article();
        $entity->setArticle("yeni");
        $entity->setCategoryId(2);
        $articleAdapter->insert($entity);
        $actualSql = $articleAdapter->getSql();
        $this->assertEquals("INSERT INTO Article(categoryId,article) VALUES('2','yeni');", $actualSql);
    }

    public function testSelect(){
        $articleAdapter = new ArticleAdapter();
        $articleAdapter->select("Article", ["where" => ["and" => ["categoryId" => 0, "description" => "kaptan"]]]);
        $actualSql = $articleAdapter->getSql();
        $expectedQuery = "SELECT * FROM Article WHERE categoryId='0' AND description='kaptan'";
        $this->assertEquals($expectedQuery, $actualSql);

        $articleAdapter->select("Article", ["where" => ["or" => ["categoryId" => 0, "description" => "kaptan"]]]);
        $actualSql = $articleAdapter->getSql();
        $expectedQuery = "SELECT * FROM Article WHERE categoryId='0' OR description='kaptan'";
        $this->assertEquals($expectedQuery, $actualSql);

        $articleAdapter->select("Article", ["where" => ["id" => 1]]);
        $actualSql = $articleAdapter->getSql();
        $expectedQuery = "SELECT * FROM Article WHERE id='1'";
        $this->assertEquals($expectedQuery, $actualSql);

    }

    public function testUpdate(){
        $expectedQuery = "UPDATE Article SET categoryId='2',description='deneme' WHERE id='1'";
        $articleAdapter = new ArticleAdapter();
        $article = new Article();
        $article->setId(1);
        $articleAdapter->update($article, ['categoryId' => '2', 'description' => 'deneme']);
        $actualSql = $articleAdapter->getSql();
        $this->assertEquals($expectedQuery, $actualSql);
    }

    public function testDelete(){
        $expectedQuery = "DELETE FROM Article WHERE id='371'";
        $articleAdapter = new ArticleAdapter();
        $article = new Article();
        $article->setId(371);
        $articleAdapter->delete($article);
        $actualSql = $articleAdapter->getSql();
        $this->assertEquals($expectedQuery, $actualSql);
    }


    public function testSelectOne(){
        $expectedQuery = "SELECT * FROM Article WHERE id='1'";
        $articleAdapter = new ArticleAdapter();
        $articleAdapter->select("Article", ["where" => ["and" => ["id" => 1]]]);
        $actualSql = $articleAdapter->getSql();
        $this->assertEquals($expectedQuery, $actualSql);

    }

}

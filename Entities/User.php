<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 04.09.2018
 * Time: 17:44
 */

namespace App\Entities;

class User 
{
    /**
     * User id
     * @var integer
     */
    public $id;

    /**
     * User name
     * @var integer
     */
    public $name;

    /**
     * User avatar
     * @var string
     */
    public $image;

    /**
     * table name
     * @var string
     */
    protected static $table = 'users';

    /**
     * Method for getting articles by user
     * @return array
     */
    public function getArticles() : array
    {
        $articles = Article::find()->where(['user_id' => $this->id])->all();

        if (empty($articles)) {
            return [];
        }

        return $articles;
    }

    /**
     * Method for creating article
     * @param $title
     * @param $text
     */
    public function createArticle(string $title,string $text)
    {
        $article = new Article($this,$title,$text);
        $article->save();
    }
}
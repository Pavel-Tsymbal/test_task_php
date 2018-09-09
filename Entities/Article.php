<?php

namespace App\Entities;

class Article
{
    /**
     * Article id
     * @var integer
     */
    public $id;

    /**
     * Author id
     * @var integer
     */
    public $user_id;

    /**
     * Article title
     * @var string
     */
    public $title;

    /**
     * Article id
     * @var string
     */
    public $text;

    /**
     * Article creating date
     */
    public $date;

    /**
     * table name
     * @var string
     */
    protected static $table = 'articles';

    /**
     * Article constructor.
     * @param User $user
     * @param string $title
     * @param string $text
     */
    public function __construct(User $user,string $title,string $text)
    {
        $this->user_id = $user->id;
        $this->title = $title;
        $this->text = $text;
        $this->date = time();
    }

    /**
     * method for getting author
     * @return User
     * @throws \Exception
     */
    public function getAuthor(){
        /** @var User $author */
        $author = User::find()->where(['id' => $this->user_id])->one();
        if(!$author){
            throw new \Exception('Author isn\'t exist');
        }
        return $author;
    }

    /**
     * method for changing author
     * @param User $user
     */
    public function changeAuthor(User $user) {
        $this->user_id = $user->id;
        return $this->save();
    }

    /**
     * method for saving article and changes
     */
    public function save(){
    }

}
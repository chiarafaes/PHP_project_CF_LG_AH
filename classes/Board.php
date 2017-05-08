<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/04/2017
 * Time: 9:28
 */
class Board
{
    private $m_sTitle;
    private $m_bPrivate;
    private $m_sUser;
    private $m_aTopics;

    /**
     * @return mixed
     */
    public function getMATopics()
    {
        return $this->m_aTopics;
    }

    /**
     * @param mixed $m_aTopics
     */
    public function setMATopics($m_aTopics)
    {
        $this->m_aTopics = $m_aTopics;
    }

    /**
     * @return mixed
     */
    public function getMSUser()
    {
        return $this->m_sUser;
    }

    /**
     * @param mixed $m_sUser
     */
    public function setMSUser($m_sUser)
    {
        $this->m_sUser = $m_sUser;
    }

    /**
     * @return mixed
     */
    public function getMSTitle()
    {
        return $this->m_sTitle;
    }

    /**
     * @param mixed $m_sName
     */
    public function setMSTitle($m_sTitle)
    {
        $this->m_sTitle = $m_sTitle;
    }

    /**
     * @return mixed
     */
    public function getMBPrivate()
    {
        return $this->m_bPrivate;
    }

    /**
     * @param mixed $m_bPrivate
     */
    public function setMBPrivate($m_bPrivate)
    {
        $this->m_bPrivate = filter_var($m_bPrivate, FILTER_VALIDATE_BOOLEAN);
    }

    public function createBoard()
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('INSERT INTO boards (title, user, private) VALUES (:title, :user, :private)');
        $statement->bindValue(':title', $this->m_sTitle);
        $statement->bindValue(':user', $this->m_sUser);
        $statement->bindValue(':private', $this->m_bPrivate);

        if($statement->execute()){
            echo json_encode("bord gemaakt");

            $id = $conn->lastInsertId();

            foreach ($this->m_aTopics as $key => $topic){

                $insertTopics = $conn->prepare('INSERT INTO boards_categories (board, category) VALUES (:board, :category)');
                $insertTopics->bindValue(':board', $id);
                $insertTopics->bindValue(':category', $topic);

                if($insertTopics->execute()) {
                    echo json_encode("bord gekoppeld");
                };
            }
        }
    }

    public static function getBoards($p_sUser)
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT boards.*, boards_categories.board, boards_categories.category, topics.name FROM boards JOIN boards_categories ON boards.id = boards_categories.board JOIN topics ON boards_categories.category = topics.id WHERE user = :user');
        $statement->bindValue(':user', $p_sUser);

        if ($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function getPostsInBoards()
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT * FROM boards_posts INNER JOIN posts ON posts.id = boards_posts.post ');

        if ($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function saveToBoard($p_sBoard, $p_sPost){
        $conn = Db::getInstance();
        $exists = false;

        $existsStatement = $conn->prepare('SELECT * FROM boards_posts');

        if ($existsStatement->execute()){
            foreach ($res = $existsStatement->fetchAll(PDO::FETCH_ASSOC) as $item){
                if ($item['board'] == $p_sBoard && $item['post'] == $p_sPost){
                    $exists = true;
                }
            }
        }

        if (!$exists){
            $statement = $conn->prepare('INSERT INTO boards_posts (board, post) VALUES (:board, :post)');
            $statement->bindValue(':board', $p_sBoard);
            $statement->bindValue(':post', $p_sPost);

            return $statement->execute();
        } else {
            return false;
        }
    }
}
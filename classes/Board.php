<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/04/2017
 * Time: 9:28
 */
class Board
{
    private $m_sName;
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
    public function getMSName()
    {
        return $this->m_sName;
    }

    /**
     * @param mixed $m_sName
     */
    public function setMSName($m_sName)
    {
        $this->m_sName = $m_sName;
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

        $statement = $conn->prepare('INSERT INTO boards (name, user, private) VALUES (:name, :user, :private)');
        $statement->bindValue(':name', $this->m_sName);
        $statement->bindValue(':user', $this->m_sUser);
        $statement->bindValue(':private', $this->m_bPrivate);

        if($statement->execute()){
            echo json_encode("bord gemaakt");

            $id = $conn->lastInsertId();

            foreach ($this->m_aTopics as $key => $topic){

                $insertTopics = $conn->prepare('INSERT INTO boards_categories (board, category) VALUES (:board, :category)');
                $insertTopics->bindValue(':board', $id);
                $insertTopics->bindValue(':category', $topic);

                if($insertTopics->execute()){
                    echo json_encode("bord gekoppeld");
                };

            }
        }
    }
}
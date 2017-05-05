<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/05/2017
 * Time: 22:57
 */
class Topic
{
    private $m_aTopics;
    private $m_sUser;

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

    public static function getAllTopics()
    {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM topics");
        $statement->execute();

        return ($statement->fetchAll(PDO::FETCH_ASSOC));
    }


    public function getTopicsByUser(){
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT users_topics.fk_topics FROM users_topics INNER JOIN topics ON topics.id = users_topics.fk_topics WHERE fk_users = :user");
        $statement->bindValue(':user', $this->m_sUser);

        if($statement->execute()){
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        }
    }

    public function saveTopics(){
        $conn = Db::getInstance();

        foreach ($this->m_aTopics as $topic){
            $statement = $conn->prepare("INSERT INTO users_topics (fk_users, fk_topics) VALUES (:user, :topic)");
            $statement->bindValue(':user', $this->m_sUser);
            $statement->bindValue(':topic', $topic);

            $statement->execute();
        }

    }


}
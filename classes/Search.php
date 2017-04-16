<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16/04/2017
 * Time: 16:09
 */
class Search
{
    private $m_sSearchParam;

    /**
     * @return mixed
     */
    public function getMSSearchParam()
    {
        return $this->m_sSearchParam;
    }

    /**
     * @param mixed $m_sSearchParam
     */
    public function setMSSearchParam($m_sSearchParam)
    {
        $this->m_sSearchParam = $m_sSearchParam;
    }

    public function Search(){
        $conn = Db::getInstance();

        $statement = $conn->prepare('SELECT * FROM posts WHERE MATCH (`title`,`description`) AGAINST (:searchParam)');
        $statement->bindValue(':searchParam', $this->m_sSearchParam);

        if ($statement->execute()){
            return ($statement->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return false;
        }
    }
}
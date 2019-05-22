<?php 

class Hashtag {
    private $hashtag;

    /**
     * Get the value of hashtag
     */ 
    public function getHashtag()
    {
        return $this->hashtag;
    }

    /**
     * Set the value of hashtag
     *
     * @return  self
     */ 
    public function setHashtag($hashtag)
    {
        $this->hashtag = $hashtag;

        return $this;
    }


    public function checkHashtag($hashtag){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from hashtag where hashtag = :hashtag");
        $statement->bindParam(':hashtag', $hashtag);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result == false){
            $this->addHashtag($hashtag);
        }
    }

    public function addHashtag($hashtag){
        $conn = Db::getInstance();
        $statement = $conn->prepare('insert into hashtag (hashtag) values (:hashtag)');
        $statement->bindParam(':hashtag', $hashtag);
        $result = $statement->execute();
        

    }

    public function getIdByHashtag(){
        $conn = Db::getInstance();
        $statement = $conn->prepare('select * from hashtag where hashtag = :hashtag');
        $statement->bindParam(':hashtag', $this->hashtag);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $hashtagId = $result['id'];

        return $hashtagId;
    }

}
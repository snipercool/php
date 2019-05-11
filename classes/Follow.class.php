<?php
    Class Follow {
        public function checkFollow($getId){
            $conn = Db::getInstance();
            $stmt = $conn->prepare("SELECT * from `follow` where followuser_id = :followuser_id AND user_id = :user_id");
            $stmt->bindValue(":followuser_id", $getId, PDO::PARAM_INT);
            $stmt->bindValue(":user_id", $_SESSION['user'][0], PDO::PARAM_INT);
            $stmt->execute();
            $result =  $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($result)){
                    return "Unfollow";
            }else{
                    return "Follow";
            }
        }
    }
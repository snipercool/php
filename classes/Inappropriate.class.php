<?php

        class Inappropriate
        {
            private $postId;
            private $userId;

            /**
             * Get the value of postId.
             */
            public function getPostId()
            {
                return $this->postId;
            }

            /**
             * Set the value of postId.
             *
             * @return self
             */
            public function setPostId($postId)
            {
                $this->postId = $postId;

                return $this;
            }

            /**
             * Get the value of userId.
             */
            public function getUserId()
            {
                return $this->userId;
            }

            /**
             * Set the value of userId.
             *
             * @return self
             */
            public function setUserId($userId)
            {
                $this->userId = $userId;

                return $this;
            }

            private function addInappropriate()
            {
                $conn = Db::getInstance();
                $query = 'insert into inappropriate (post_id, user_id, report) values (:post_id, :user_id, 1)';
                $statement = $conn->prepare($query);
                $statement->bindValue(':post_id', $this->getPostId());
                $statement->bindValue(':user_id', $this->getUserId());
                $statement->execute();
            }

            private function deleteInappropriate()
            {
                $conn = Db::getInstance();
                $query = 'DELETE FROM inappropriate WHERE post_id = :post_id AND user_id =:user_id';
                $statement = $conn->prepare($query);
                $statement->bindValue(':post_id', $this->getPostId());
                $statement->bindValue(':user_id', $this->getUserId());
                $statement->execute();
            }

            public function checkInappropriate()
            {
                $conn = Db::getInstance();
                $query = 'SELECT COUNT(*) FROM inappropriate WHERE post_id=:post_id AND user_id=:user_id';
                $statement = $conn->prepare($query);
                $statement->bindValue(':post_id', $this->getPostId());
                $statement->bindValue(':user_id', $this->getUserId());
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if ($result[0]['COUNT(*)'] == 0) {
                    $this->addInappropriate();

                    return 'flagged';
                } else {
                    $this->deleteInappropriate();

                    return 'unflagged';
                }

                return $result;
            }

            public function isPostInappropriate()
            {
                $conn = Db::getInstance();
                $query = 'SELECT COUNT(*) as amount FROM inappropriate WHERE post_id = :post_id';
                $statement = $conn->prepare($query);
                $statement->bindValue(':post_id', $this->getPostId());
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if ((int) $result['amount'] == 3) {
                    return true;
                } else {
                    return false;
                }

                /* this function checks if a post has three votes against it */
                // select count inappropriates voor huidige post id
                // indien 3 of meer
                //  return true
                // else
                //  return false
            }
        }

<?php

        class Like
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

            private function addLike()
            {
                $conn = db::getInstance();
                $query = 'insert into likes (post_id, user_id) values (:post_id, :user_id)';
                $statement = $conn->prepare($query);
                $statement->bindValue(':post_id', $this->getPostId());
                $statement->bindValue(':user_id', $this->getUserId());
                $statement->execute();
            }

            private function deleteLike()
            {
                $conn = db::getInstance();
                $query = 'DELETE FROM likes WHERE post_id = :post_id AND user_id =:user_id';
                $statement = $conn->prepare($query);
                $statement->bindValue(':post_id', $this->getPostId());
                $statement->bindValue(':user_id', $this->getUserId());
                $statement->execute();
            }

            public function checkLike()
            {
                $conn = db::getInstance();
                $query = 'SELECT COUNT(*) FROM likes WHERE post_id=:post_id AND user_id=:user_id';
                $statement = $conn->prepare($query);
                $statement->bindValue(':post_id', $this->getPostId());
                $statement->bindValue(':user_id', $this->getUserId());
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if ($result[0]['COUNT(*)'] == 0) {
                    $this->Addlike();

                    return 'liked';
                } else {
                    $this->Deletelike();

                    return 'unliked';
                }

                return $result;
            }
        }

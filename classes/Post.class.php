<?php
    class Post
    {
        private $image;
        private $description;
        private $timestamp;
        private $filter;

        /**
         * Get the value of description.
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * Set the value of description.
         *
         * @return self
         */
        public function setDescription($description)
        {
            $this->description = $description;

            return $this;
        }

        /**
         * Get the value of image.
         */
        public function getImage()
        {
            return $this->image;
        }

        /**
         * Set the value of image.
         *
         * @return self
         */
        public function setImage($image)
        {
            $this->image = $image;

            return $this;
        }

        /**
         * Get the value of timestamp.
         */
        public function getTimestamp()
        {
            return $this->timestamp;
        }

        /**
         * Set the value of timestamp.
         *
         * @return self
         */
        public function setTimestamp($timestamp)
        {
            $this->timestamp = $timestamp;

            return $this;
        }

        /**
         * Get the value of filter.
         */
        public function getFilter()
        {
            return $this->filter;
        }

        /**
         * Set the value of filter.
         *
         * @return self
         */
        public function setFilter($filter)
        {
            $this->filter = $filter;

            return $this;
        }

        public function checkImage($image)
        {
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
            if ($check !== false) {
                $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'
                && $imageFileType != 'gif') {
                    echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';

                    return false;
                }
                //echo 'File is an image - '.$check['mime'].'.';

                return true;
            } else {
                echo 'File is not an image.';

                return false;
            }
        }

        public function uploadImage()
        {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $this->image)) {
                $conn = Db::getInstance();
                $statement = $conn->prepare('insert into post (image, description, user_id, filter, active) values (:image, :description, :user_id, :filter, 1)');
                $statement->bindParam(':image', $this->image);
                $statement->bindParam(':description', $this->description);
                $statement->bindParam(':user_id', $_SESSION['user'][0]);
                $statement->bindParam(':filter', $this->filter);
                $statement->execute();
                //echo 'file '.$this->image.' has been uploaded with description '.$this->description.'and user_id '.$_SESSION['user'][0];
            } else {
                echo 'file has not been uploaded';
            }
        }

        public function checkDescription($description)
        {
            if (!empty($description)) {
                //echo 'description is ok';

                return true;
            } else {
                echo "description can't be empty!";

                return false;
            }
        }

        public function createImageName()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('select * from post');
            $statement->execute();
            $result = $statement->fetchAll();
            $temp = explode('.', $_FILES['fileToUpload']['name']);
            $newfilename = count($result) + 1 .'.'.$temp[1];
            $target_dir = 'images/uploads/';
            $target_file = $target_dir.$newfilename;

            return $target_file;
        }

        public function getPosts($amount)
        {
            try {
                $conn = Db::getInstance();

                $statement2 = $conn->prepare("select hashtag_id from followhashtag where user_id = :user_id ");
                $statement2->bindValue(':user_id', $_SESSION['user'][0]);
                $statement2->execute();
                $hashtagIds = $statement2->fetchAll(PDO::FETCH_COLUMN, 0);

                $hashtags = [];
                foreach($hashtagIds as $hashtagId){
                    $statement3 = $conn->prepare("select hashtag from hashtag where id = :hashtag_id");
                    $statement3->bindValue(':hashtag_id', $hashtagId, PDO::PARAM_INT);
                    $statement3->execute();
                    array_push($hashtags, $statement3->fetch(PDO::FETCH_COLUMN, 0));
                }
                
                $result = [];
                foreach($hashtags as $hashtag){
                    $statement1 = $conn->prepare("select * from post WHERE description like :hashtag ORDER BY timestamp DESC");
                    $statement1->bindValue(':hashtag', '%' . $hashtag . '%');
                    $statement1->execute();
                    $resultHashtags = $statement1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($resultHashtags as $h){
                        array_push($result,  $h);
                    }
                }
                
               $statement4 = $conn->prepare("select * from post WHERE user_id IN (SELECT followuser_id from follow where user_id = :user_id) OR user_id = :user_id ORDER BY timestamp DESC");
                $statement4->bindValue(':user_id', $_SESSION['user'][0]);
                $statement4->bindValue(':hashtag', '%' . $hashtag . '%');
                $statement4->execute();
                $resultUsers = $statement4->fetchAll(PDO::FETCH_ASSOC);
                foreach($resultUsers as $u){
                    array_push($result, $u);
                }

                $result = array_map("unserialize", array_unique(array_map("serialize", $result)));  
                usort($result, function($a, $b) {
                    $ts1 = strtotime($a['timestamp']);
                    $ts2 = strtotime($b['timestamp']);
                    return $ts2 - $ts1;
                });
                
                $result = array_slice($result, 0, $amount);


                return $result;
            } catch (Throwable $t) {
                echo $t;
            }
        }

        public function countPosts()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('select count(*) as amount from post where user_id != :id and active = 1 LIMIT 20');
            $statement->bindParam(':id', $_SESSION['user'][0]);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result[0]['amount'];
        }

        public function getHumanTime($timestamp)
        {
            date_default_timezone_set('Europe/Brussels');

            $now = time();
            $time = strtotime($timestamp);
            
            $today = date("d", $now);
            $month = date("m", $now);
            $year = date("Y", $now);
            $postDay = date("d", $time);
            $postMonth = date("m", $time);
            $postYear = date("Y", $time);



            if($today - $postDay == 1 && $month == $postMonth && $year == $postYear){
                return "yesterday at " . date("H:i", $time);
            }else if(($now - $time) >= 3600){
                
                if(($now - $time) < 7200 ){
                    return "1 hour ago";
                }else if (($now - $time) < 86400){
                    return ceil(($now - $time)/3600) . " hours ago";
                }else if($year == $postYear){
                    return date("d M", $time) . " at " . date("H:i", $time);
                }else if($year != $postYear){
                    return date("d M Y", $time);
                }
            } elseif (($now - $time) < 3600) {
                if (($now - $time < 300)) {
                    return 'just now';
                } else {
                    return ceil(($now - $time) / 60).' minutes ago';
                }
            }
        }

        public function getUserPosts()
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('select * from post where user_id = :id');
            $statement->bindParam(':id', $_GET['id']);
            $statement->execute();
            $resultpost = $statement->fetchAll();

            return $resultpost;
        }

        public function getPostsbyHashtag($hashtag){
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from post where description LIKE :hashtag");
            $statement->bindValue(':hashtag', "%" . $hashtag . "%");
            $statement->execute();
            $result = $statement->fetchAll();

            return $result;
        }

        public function getLikes($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('select count(*) as count from likes where post_id = :postid');
            $statement->bindValue(':postid', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result['count'];
        }

        public function getReports($id)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('select count(*) as count from inappropriate where post_id = :postid');
            $statement->bindValue(':postid', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result['count'];
        }

        public static function deactivate($postId)
        {
            $conn = Db::getInstance();
            $query = 'UPDATE post SET active = 0 WHERE id = :id';
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $postId);
            $statement->execute();
        }

        public function setCity()
        {
            $curl = curl_init('https://eu1.locationiq.com/v1/reverse.php?key=fb4c4b4d98b007&lat='.$_SESSION['lat'].'&lon='.$_SESSION['long'].'&format=json');

            curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                echo 'cURL Error #:'.$err;
            } else {
                $json = json_decode($response);
            }
            $this->city = $json->address->city_district;
            console.log($this->city);
        }
    }

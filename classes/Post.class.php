<?php
    Class Post {
        private $image;
        private $description;
        private $timestamp;

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of image
         */ 
        public function getImage()
        {
                return $this->image;
        }

        /**
         * Set the value of image
         *
         * @return  self
         */ 
        public function setImage($image)
        {
                $this->image = $image;

                return $this;
        }

         /**
         * Get the value of timestamp
         */ 
        public function getTimestamp()
        {
                return $this->timestamp;
        }

        /**
         * Set the value of timestamp
         *
         * @return  self
         */ 
        public function setTimestamp($timestamp)
        {
                $this->timestamp = $timestamp;

                return $this;
        }

        public function checkImage($image){
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    return false;
                }
                echo "File is an image - " . $check["mime"] . ".";
                return true;
            } else {
                echo "File is not an image.";
                return false;
            }
        }

        public function uploadImage(){
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->image)){
                $conn = Db::getInstance();
                $statement = $conn->prepare("insert into post (image, description) values (:image, :description)");
                $statement->bindParam(":image", $this->image);
                $statement->bindParam(":description", $this->description);
                $statement->execute();
                echo "file ". $this->image . " has been uploaded with description " . $this->description;
            }else{
                echo "file has not been uploaded";
            }
        }

        public function checkDescription($description){
            if(!empty($description)){
                echo "description is ok";
                return true;
            }else{
                echo "description can't be empty!";
                return false;
            }
        }

        public function createImageName(){
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from post");
            $statement->execute();
            $result = $statement->fetchAll();
            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $newfilename = count($result) . "." . $temp[1];
            $target_dir = "images/uploads/";
            $target_file = $target_dir . $newfilename;
            return $target_file;
        }

    }

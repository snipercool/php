<?php
    Class Post {
        private $image;
        private $description;

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

        public function uploadImage($image){
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $image)){
                echo "file ". $image . "has been uploaded";
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



    }

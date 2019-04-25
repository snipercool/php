<?php

    require_once("Security.class.php");
    require_once("Db.class.php");


    class User {
        private $fullname;
        private $username;
        private $email;
        private $password;
<<<<<<< HEAD
=======
        private $description;
>>>>>>> nicolas
        private $passwordConfirmation;

        /**
         * Get the value of fullname
         */ 
        public function getFullname()
        {
                return $this->fullname;
        }

        /**
         * Set the value of fullname
         *
         * @return  self
         */ 
        public function setFullname($fullname)
        {
                $this->fullname = $fullname;

                return $this;
        }

        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
                $this->username = $username;

                return $this;
        }
        
        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of passwordConfirmation
         */ 
        public function getPasswordConfirmation()
        {
                return $this->passwordConfirmation;
        }

        /**
         * Set the value of passwordConfirmation
         *
         * @return  self
         */ 
        public function setPasswordConfirmation($passwordConfirmation)
        {
                $this->passwordConfirmation = $passwordConfirmation;

                return $this;
        }

<<<<<<< HEAD
=======
        /**
         * Get the value of avatar
         */ 
        public function getAvatar()
        {
                return $this->avatar;
        }

        /**
         * Set the value of avatar
         *
         * @return  self
         */ 
        public function setAvatar($avatar)
        {
                $this->avatar = $avatar;

                return $this;
        }
        
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
        
        

>>>>>>> nicolas
        
        /**
         * @return boolean - true if registration, false if unsuccessful.
         */
        public function register() {

                $password = Security::hash($this->password);
        
                try {
                    $conn = Db::getInstance();
                    $statement = $conn->prepare('INSERT INTO user (fullname, username, email, password) values (:fullname, :username, :email, :password)');
                    $statement->bindParam(':fullname', $this->fullname);
                    $statement->bindParam(':username', $this->username);
                    $statement->bindParam(':email', $this->email);
                    $statement->bindParam(':password', $password);  
                    $result = $statement->execute();
                    return($result);
        
                } catch ( Throwable $t ) {
                    return false;
        
                }
            
        }

<<<<<<< HEAD
=======
        public function update(){
                $password = Security::hash($this->password);
                try {
                        if(move_uploaded_file($_FILES["avatar"]["tmp_name"], $this->avatar)){
                                $conn = Db::getInstance();
                                $statement = $conn->prepare("update user set avatar= :avatar, fullname = :fullname, username = :username, email = :email, password = :password, description = :description");
                                $statement->bindParam(":avatar", $this->avatar);
                                $statement->bindParam(":fullname", $this->fullname );
                                $statement->bindParam(":username", $this->username);
                                $statement->bindParam(":email", $this->email);
                                $statement->bindParam(":desxription", $this->description);
                                $statement->bindParam(":password", $password);

                                $statement->execute();
                            }
                            else {
                                $conn = Db::getInstance();
                                $statement = $conn->prepare("update user set fullname = :fullname, username = :username, email = :email, password = :password, description = :description");
                                $statement->bindParam(":fullname", $this->fullname );
                                $statement->bindParam(":username", $this->username);
                                $statement->bindParam(":email", $this->email);
                                $statement->bindParam(":description", $this->description);
                                $statement->bindParam(":password", $password);

                                $statement->execute();
                            }
                } catch (\Throwable $th) {
                        var_dump($th);
                }
        }

>>>>>>> nicolas
        public static function findByEmail($email){
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from users where email = :email limit 1");
            $statement->bindValue(":email", $email);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public static function isAccountAvailable($email){
            $e = self::findByEmail($email);
            
            // PDO returns false if no records are found so let's check for that
            if($e == false){
                return true;
            } else {
                return false;
            }
        }

        public static function findByUsername($username){
                $conn = Db::getInstance();
                $statement = $conn->prepare("select * from users where username = :username limit 1");
                $statement->bindValue(":username", $username);
                $statement->execute();
                return $statement->fetch(PDO::FETCH_ASSOC);
            }
    
        public static function isUsernameAvailable($username){
                $u = self::findByUsername($username);
                
                // PDO returns false if no records are found so let's check for that
                if($u == false){
                    return true;
                } else {
                    return false;
                }
        }

        function canILogin(){
                $conn = Db::getInstance();
                $statement = $conn->prepare("select * from user where username = :username");
                $statement->bindParam(":username", $this->username);
                $statement->execute();
                $result = $statement->fetchAll();
                if(!empty($result)){
                    if(password_verify($this->password, $result[0]['password'])){
                        return array($resut[0]['id'], $result[0]['username'], $result[0]['email']);
                    }
                }
        }

    }

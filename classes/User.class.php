<?php

    require_once("Security.class.php");
    require_once("Db.class.php");


    class User {
        private $fullname;
        private $username;
        private $email;
        private $password;
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
                    $statement->execute();
                
                    $getData = $conn->prepare('select * from user where username = :username');
                    $getData->bindParam(':username', $this->username);
                    $getData->execute();
                    $data = $getData->fetchAll();
                
                    if(!empty($data)){
                        return array($data[0]['id'], $data[0]['username'], $data[0]['email']);
                    }else{
                        return false;
                    }

        
                } catch ( Throwable $t ) {
                    return false;
        
                }
            
        }

        public static function findByEmail($email){
            $conn = Db::getInstance();
            $statement = $conn->prepare("select * from user where email = :email limit 1");
            $statement->bindValue(":email", $email);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if(!empty($result)){
                    return true;
            }else{
                    return false;
            }
            
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
                $statement = $conn->prepare("select * from user where username = :username limit 1");
                $statement->bindValue(":username", $username);
                $statement->execute();
                $result =  $statement->fetch(PDO::FETCH_ASSOC);
                if(!empty($result)){
                        return true;
                }else{
                        return false;
                }
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
                        return array($result[0]['id'], $result[0]['username'], $result[0]['email']);
                    }
                    return false;
                }
        }

        function getUserById($id){
                $conn = Db::getInstance();
                $statement = $conn->prepare('select * from user where id = :id');
                $statement->bindParam(':id', $id);
                $statement->execute();
                $result = $statement->fetch();
                return $result;
        }

    }

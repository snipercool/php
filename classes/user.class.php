<?php

    require_once("security.class.php");

    class User {
        private $email;
        private $password;
        private $passwordConfirmation;


        
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
                $conn = new PDO( 'mysql:host=localhost;dbname=phpinsta', 'root', 'root', null);
                $statement = $conn->prepare('INSERT INTO user (email, password) values (:email, :password)');
                $statement->bindParam(':email', $this->email);
                $statement->bindParam(':password', $password);  
                $result = $statement->execute();
                return($result);
    
            } catch ( Throwable $t ) {
                return false;
    
            }
        }

    }
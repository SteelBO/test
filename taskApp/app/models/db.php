<?php 

    class Database{

        private $DB_HOST = 'localhost';
        private $DB_USER = "SBO";
        private $DB_PASS = "123456";
        private $DB_NAME = "test";
        private $CONN;

        public function connect(){
            try { 
            $dsn = 'mysql:host=' . $this->DB_HOST . ';&dbname=' . $this->DB_NAME . ';';
            $this->CONN = new PDO($dsn, $this->DB_USER, $this->DB_PASS);
            $this->CONN->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e){
                echo "ERROR: " . $e->getMessage();
            }

            return $this->CONN;
        }

        public function getDBname(){
            return $this->DB_NAME;
        }

    }
?>
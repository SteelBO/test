<?php

    require_once '../app/models/model.php';
    require_once '../app/models/db.php';

    class User extends Model{
        //private $CONN;
        private $query_table = 'test.users';
        private $query_tasks = 'test.tasks';
        private $Clauses = ['id', 'name', 'email', 'date'];
        public $tasks;
        public $id;
        public $name;
        public $email;
        public $password;
        public $date;

        public function __construct()
        {
            $this->CONN = new Database;
            $this->CONN = $this->CONN->connect();
        }

        public function fetch_tasks(){
            try{
                $query = 'SELECT * FROM ' . $this->query_tasks . ' WHERE user_id = ?';
                $stmt = $this->CONN->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $data = $stmt->fetchAll();
                return $data;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                die();
            }
        }

        public function set_fields($id, $name, $email, $password, $date){
            $this->id = ($id == null) ? $this->id : $id;
            $this->name = ($name == null) ? $this->name : $name;
            $this->email = ($email == null) ? $this->email : $email;
            $this->password = ($password == null) ? $this->password : $password;
            $this->date = ($date == null) ? $this->date : $date;
        }

        public function fetch_all(){
            try{
                $query = 'SELECT * FROM ' . $this->query_table;
                $stmt = $this->CONN->query($query);
                $data = $stmt->fetchall(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                die();
            }
        }

        public function search(){
            try{
                $query = 'SELECT * FROM ' . $this->query_table . ' WHERE id = ?';
                $stmt = $this->CONN->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $data = $stmt->fetchAll();
                $this->set_fields($data[0]['id'], $data[0]['name'], $data[0]['email'], $data[0]['password'], $data[0]['date']);
                return $data;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                die();
            }
        }
        

        public function search_by($clause){
            try{
                if(!in_array($clause, $this->Clauses)){
                    return null;
                }
                $query = 'SELECT * FROM ' . $this->query_table . ' WHERE ' . $clause . " = '" . $this->$clause . "'";
                $stmt = $this->CONN->prepare($query);
                $stmt->execute();
                $data = $stmt->fetchAll();
                return $data;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }

        public function create_user(){
            try{
                $query = 'INSERT INTO ' . $this->query_table . " (name, email, password) VALUES  (:name, :email, :password)";
                $stmt = $this->CONN->prepare($query);
                $stmt->execute(array(':name' => $this->name, ':email' => $this->email, ':password' => $this->password));
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
        

        public function delete_user(){
            try{
                $query = 'DELETE FROM ' . $this->query_table . " WHERE id = :id";
                $stmt = $this->CONN->prepare($query);
                $stmt->execute(array(":id" => $this->id));
                return true;
            } catch (PDOException $e){
                echo "Error: " . $e->getMessage();
                return false;
            } 
        }

        public function update(){
            try{
                $query = 'UPDATE ' . $this->query_table . " SET name = :name, email = :email, password = :password
                WHERE id = :id";
                $stmt = $this->CONN->prepare($query);
                $stmt->execute(array(":id" => $this->id, ':name' => $this->name, ':email' => $this->email, ':password' => $this->password));
                return true;
            } catch (PDOException $e){
                echo "ERROR: " . $e->getMessage();
                return false;
            } 
        }

    }
?>
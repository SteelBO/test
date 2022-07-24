<?php

require_once '../app/models/model.php';
require_once '../app/models/db.php';

class Task extends model{

    public $user;
    public $id;
    public $title;
    public $date;
    public $address;
    public $reminder;
    private $query_table = 'test.tasks';
    private $Clauses = ['id', 'title', 'date', 'address', 'reminder'];

    public function __construct()
    {
        $this->CONN = new Database;
        $this->CONN = $this->CONN->connect();
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
            die();
        }
    }

    public function changeReminder(){
        try{
            $query = 'UPDATE ' . $this->query_table . " SET reminder = :reminder WHERE id = :id";
            $stmt = $this->CONN->prepare($query);
            $stmt->execute(array(":reminder" => $this->reminder, ':id' => $this->id));
            return true;
        } catch (PDOException $e){
            echo "ERROR: " . $e->getMessage();
            return false;
        } 
    }

    public function deleteTask(){
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

    public function create_task($uid){
        try{
            $query = 'INSERT INTO ' . $this->query_table . " (user_id, title, date, address, reminder) VALUES  (:user_id, :title, :date, :address, :reminder)";
            $stmt = $this->CONN->prepare($query);
            $stmt->execute(array(':user_id' => $uid, ':title' => $this->title, ':date' => $this->date, ':address' => $this->address, ':reminder' => $this->reminder));
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
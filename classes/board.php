<?php

require_once 'database.php';

class board{

private  $conn;

//Конструктор подключения дб

    public function __construct(){
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
    // Функция запроса SQL

    public function runQuery($sql){
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
//Insert

    public function insert($title, $desc, $price, $email){
        try{
            $stmt = $this->conn->prepare("INSERT INTO board (title, desc, price, email) VALUES(:title, :desc, :price, :email)");
            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":desc", $desc);
            $stmt->bindparam(":price", $price);
            $stmt->bindparam(":email", $email);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //Update

    public function update($title, $desc, $price, $email, $id){
        try{
            $stmt = $this->conn->prepare("UPDATE board SET title = :title, desc = :desc, price = :price, email = :email WHERE id = :id");
            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":desc", $desc);
            $stmt->bindparam(":price", $price);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //Delete

    public function delete($id){
        try{
            $stmt = $this->conn->prepare("DELETE FROM board WHERE id = :id");
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    //Переназначение URL

    public function redirect($url){
        header("Location: $url");
    }

}
?>
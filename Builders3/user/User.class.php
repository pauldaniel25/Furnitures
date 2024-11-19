<?php

require_once 'database.php';

class user{
    public $user_id ='';
    public $username = '';
    public $pwd = '';

    protected $db;
    
}

function __construct(){
    $this->db = new Database();
}
function add(){
    $sql = "INSERT INTO users (username, pwd) VALUES (:username, :pwd)";
    $query = $this->db->connect()->prepare($sql);

    $query->bindParam(':username', $this->username);
    $query->bindParam(':pwd', $this->pwd);

    if($query->execute()){
        return true;
    }else{
        return false;
    }

    function showALL(){
        $sql = "SELECT * FROM users ORDER BY user_id DESC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;

        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }
}
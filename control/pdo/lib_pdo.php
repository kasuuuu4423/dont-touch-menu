<?php
class Lib_pdo{
    private $db;
    function __construct(){
        require 'pdo_info.php';
        try {
            $this->db = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }
    public function select($table, $store_id){
        if($table == "store"){
            $id = "id";
        }
        else{
            $id = "store_id";
        }
        try{
            $stmt = $this->db->prepare("SELECT * FROM ". $table ." WHERE ". $id ." = :store_id");
            $stmt->bindparam(':store_id', $store_id ,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function insert_guest($guest_num, $store_id){
        try{
            $null = NULL;
            $stmt = $this->db->prepare("INSERT INTO guest (id,num,store_id,enter_datetime,leave_datetime,created_at,updated_at) VALUES(:id,:num,:store_id,now(),:leave_datetime,now(),now())");
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':num', $guest_num, PDO::PARAM_INT);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':leave_datetime', $null, PDO::PARAM_STR);
            $stmt->execute();
            $user = $this->db->lastInsertId();
            header('Location: https://artful.jp/staging-menu/public/menu?id='.$store_id.'&user='.$user);
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function leave_guest($guest_id){
        try{
            $stmt = $this->db->prepare("UPDATE guest SET leave_datetime = now() WHERE id = :id");
            $stmt->bindparam(':id', $guest_id, PDO::PARAM_INT);
            $stmt->execute();
            session_start();
            $_SESSION['message'] =  "ご来店ありがとうございました。";
        }
        catch(Exception $e){
            echo $e;
        }
    }
}
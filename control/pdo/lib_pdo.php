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
    public function select_menu_cat_id($cat_id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM menu_category WHERE id = :cat_id");
            $stmt->bindparam(':cat_id', $cat_id ,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function select_menu_id($menu_id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM menu WHERE id = :id");
            $stmt->bindparam(':id', $menu_id ,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function select_guest_byDate($enter_date_time, $store_id){
        try{
            $stmt = $this->db->prepare('SELECT * FROM guest WHERE DATE(enter_datetime) = :enter_datetime AND store_id = :store_id');
            $stmt->bindparam(':enter_datetime', DATE($enter_date_time), PDO::PARAM_STR);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->execute();
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
    private function upload_menu_img($menu_img){
        try{
        //requireできないからベタ打ち 画像絶対パス
        $img_folder_path = "../img/";
        //requireできないからベタ打ち 画像絶対パス
        $img_name = uniqid(mt_rand(), true);
        $img_name .= '.' . explode('.', $menu_img['name'])[1];
        $menu_img_path = $img_folder_path.$img_name;
        move_uploaded_file($menu_img['tmp_name'], $menu_img_path);
        return $menu_img_path;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function insert_menu($menu_name, $menu_price, $menu_desc, $menu_img, $menu_enabled, $store_id, $menu_cat_id){
        try{
            $menu_img_path = $this->upload_menu_img($menu_img);
            $null = NULL;
            $stmt = $this->db->prepare("INSERT INTO menu (id, name, price, description, img_path, enabled, store_id, menu_category_id, created_at, update_at) VALUES (:id, :name, :price, :description, :img_path, :enabled, :store_id, :menu_category_id, now(), now())");
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_name, PDO::PARAM_STR);
            $stmt->bindparam(':price', $menu_price, PDO::PARAM_INT);
            $stmt->bindparam(':description', $menu_desc, PDO::PARAM_STR);
            $stmt->bindparam(':img_path', $menu_img_path, PDO::PARAM_STR);
            $stmt->bindparam(':enabled', $menu_enabled, PDO::PARAM_INT);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':menu_category_id', $menu_cat_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function insert_menu_category($menu_cat_name, $store_id){
        try{
            $null = NULL;
            $stmt = $this->db->prepare('INSERT INTO menu_category (id, name, store_id, created_at, update_at) VALUES (:id, :name, :store_id, now(), now())');
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_cat_name, PDO::PARAM_STR);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_store_seats($store_seats, $store_id){
        try{
            $stmt = $this->db->prepare('UPDATE store SET seats = :seats, update_at = now() WHERE id = :id');
            $stmt->bindparam(':id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':seats', $store_seats, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_menu($menu_id, $menu_name, $menu_price, $menu_desc, $menu_img, $menu_enabled){
        try{
            $tmp_menu = $this->select_menu_id($menu_id)[0];
            $tmp_img_path = $tmp_menu['img_path'];
            unlink($tmp_img_path);

            $menu_img_path = $this->upload_menu_img($menu_img);
            $stmt = $this->db->prepare('UPDATE menu SET name = :name, price = :price, description = :description, img_path = :img_path, enabled = :enabled WHERE id = :id');
            $stmt->bindparam(':id', $menu_id, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_name, PDO::PARAM_STR);
            $stmt->bindparam(':price', $menu_price, PDO::PARAM_INT);
            $stmt->bindparam(':description', $menu_desc, PDO::PARAM_STR);
            $stmt->bindparam(':img_path', $menu_img_path, PDO::PARAM_STR);
            $stmt->bindparam(':enabled', $menu_enabled, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_menu_cat($menu_cat_id, $menu_cat_name){
        try{
            $stmt = $this->db->prepare('UPDATE menu_category SET name = :name WHERE id = :id');
            $stmt->bindparam(':id', $menu_cat_id, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_cat_name, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
}

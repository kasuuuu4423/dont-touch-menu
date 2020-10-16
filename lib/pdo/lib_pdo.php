<?php
class Lib_pdo{
    public $db;
    function __construct(){
        require 'pdo_info.php';
        try {
            $this->db = new PDO($dsn, $user, $password);
            $this->db->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_EXCEPTION);
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
            if($result[0]['img_path']){
                for($i = 0; $i < count($result); $i++){
                    $result[$i]['img_path'] = str_replace('../img/', '', $result[$i]['img_path']);
                    $result[$i]['img_path'] = str_replace('../', '', $result[$i]['img_path']);
                }
            }
<<<<<<< HEAD
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function select_sorted($table, $store_id){
        $items = $this->select($table, $store_id);
        return $this->sort_byOrder($items);
    }
    public function select_by_storeid_and_cat($table, $store_id, $cat_id){
        if($table == "store"){
            $id = "id";
        }
        else{
            $id = "store_id";
        }
        try{
            $stmt = $this->db->prepare("SELECT * FROM  $table  WHERE  $id  = :store_id AND  {$table}_category_id = :cat_id");
            $stmt->bindparam(':store_id', $store_id ,PDO::PARAM_INT);
            $stmt->bindparam(':cat_id', $cat_id ,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result[0]['img_path']){
                for($i = 0; $i < count($result); $i++){
                    $result[$i]['img_path'] = str_replace('../img/', '', $result[$i]['img_path']);
                    $result[$i]['img_path'] = str_replace('../', '', $result[$i]['img_path']);
                }
            }
=======
>>>>>>> 95c08c2c3d322f003d97c9ae06ec0d07c5d1b97d
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
    public function select_ByCatid($table, $cat_id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM ". $table ." WHERE ". $table ."_category_id = :cat_id");
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
            if($result[0]['img_path']){
                for($i = 0; $i < count($result); $i++){
                    $result[$i]['img_path'] = str_replace('../img/', '', $result[$i]['img_path']);
                    $result[$i]['img_path'] = str_replace('../', '', $result[$i]['img_path']);
                }
            }
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function select_rule_cat_id($rule_cat_id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM rule_category WHERE id = :id");
            $stmt->bindparam(':id', $rule_cat_id ,PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function select_rule_id($rule_id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM rule WHERE id = :id");
            $stmt->bindparam(':id', $rule_id ,PDO::PARAM_INT);
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
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function select_date_toHistory($store_id){
        try{
            $stmt = $this->db->prepare("SELECT DISTINCT DATE_FORMAT(guest.enter_datetime,'%Y-%m-%d') AS 'date' FROM guest WHERE store_id = :store_id");
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function select_store_id($user_id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM store WHERE userid = :userid");
            $stmt->bindValue(':userid', $user_id, PDO::PARAM_STR);
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
    public function leave_guest_byDatetime($start, $end){
        try{
            $sql = "UPDATE guest SET leave_datetime = now() WHERE leave_datetime IS NULL AND `enter_datetime` BETWEEN ". $start ." AND ". $end."";
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    private function upload_img($img, $full_path, $dir){
        try{
            $img_name = uniqid(mt_rand(), true);
            $img_name .= '.' . explode('.', $img['name'])[1];
            $img_path = $full_path . $img_name;
            //pathベタ打ち、改善の余地あり
            move_uploaded_file($img['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/staging-menu/resources/img/' . $dir . '/' . $img_name);
            //pathベタ打ち、改善の余地あり
            return $img_name;
        }
        catch(Exception $e){
            echo $e;
        }
    }
<<<<<<< HEAD
    private function get_nextOrder_forItem($table, $store_id, $cat_id){
        $items = $this->select_by_storeid_and_cat($table, $store_id, $cat_id);
        if(!empty($items)){
            foreach ($items as $key => $value) {
                $sort[$key] = $value['sort_order'];
            }
            array_multisort($sort, SORT_ASC, $items);
            return end($items)['sort_order'] + 1;
        }
        else{
            return 1;
        }
    }
    private function get_nextOrder_forCat($table, $store_id){
        $items = $this->select($table, $store_id);
        if(!empty($items)){
            foreach ($items as $key => $value) {
                $sort[$key] = $value['sort_order'];
            }
            array_multisort($sort, SORT_ASC, $items);
            return end($items)['sort_order'] + 1;
        }
        else{
            return 1;
        }
    }
=======
>>>>>>> 95c08c2c3d322f003d97c9ae06ec0d07c5d1b97d
    public function insert_menu($menu_name, $menu_price, $menu_desc, $menu_img, $menu_enabled, $store_id, $menu_cat_id, $full_path){
        try{
            if($menu_img['error'] != 4){
                $menu_img_path = $this->upload_img($menu_img, $full_path, 'menu');
            }
            else{
                $menu_img_path = NULL;
            }
            $sort_order = $this->get_nextOrder_forItem('menu', $store_id, $menu_cat_id);
            $null = NULL;
            $stmt = $this->db->prepare("INSERT INTO menu (id, name, price, description, img_path, enabled, store_id, menu_category_id, sort_order, created_at, updated_at) VALUES (:id, :name, :price, :description, :img_path, :enabled, :store_id, :menu_category_id, :sort_order, now(), now())");
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_name, PDO::PARAM_STR);
            $stmt->bindparam(':price', $menu_price, PDO::PARAM_INT);
            $stmt->bindparam(':description', $menu_desc, PDO::PARAM_STR);
            $stmt->bindparam(':img_path', $menu_img_path, PDO::PARAM_STR);
            $stmt->bindparam(':enabled', $menu_enabled, PDO::PARAM_INT);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':menu_category_id', $menu_cat_id, PDO::PARAM_INT);
            $stmt->bindparam(':sort_order', $sort_order, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    private function sort_byOrder($data){
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $sort[$key] = $value['sort_order'];
            }
            array_multisort($sort, SORT_ASC, $data);
            return $data;
        }
    }
    public function insert_rule($rule_content, $rule_cat_id, $store_id){
        $sort_order = $this->get_nextOrder_forItem('rule', $store_id, $rule_cat_id);
        try{
            $null = NULL;
            $stmt = $this->db->prepare('INSERT INTO rule (id, content, store_id, rule_category_id, sort_order, created_at, updated_at) VALUES (:id, :content, :store_id, :rule_category_id, :sort_order, now(), now())');
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':content', $rule_content, PDO::PARAM_STR);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':rule_category_id', $rule_cat_id, PDO::PARAM_INT);
            $stmt->bindparam(':sort_order', $sort_order, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function insert_menu_category($menu_cat_name, $store_id){
        try{
            $sort_order = $this->get_nextOrder_forCat('menu_category', $store_id);
            $null = NULL;
            $stmt = $this->db->prepare('INSERT INTO menu_category (id, name, store_id, sort_order, created_at, updated_at) VALUES (:id, :name, :store_id, :sort_order, now(), now())');
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_cat_name, PDO::PARAM_STR);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':sort_order', $sort_order, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function insert_rule_category($menu_cat_name, $store_id){
        try{
            $sort_order = $this->get_nextOrder_forCat('rule_category', $store_id);
            $null = NULL;
            $stmt = $this->db->prepare('INSERT INTO rule_category (id, name, store_id, sort_order, created_at, updated_at) VALUES (:id, :name, :store_id, :sort_order, now(), now())');
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_cat_name, PDO::PARAM_STR);
            $stmt->bindparam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':sort_order', $sort_order, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function insert_store($store_name, $user_id, $user_pw, $store_seats, $store_img, $store_opentime, $store_closetime, $store_lastorder, $store_exception, $full_path){
        try{
            if($store_img['error'] != 4){
                $store_img_path = $this->upload_img($store_img, $full_path, 'store');
            }
            else{
                $store_img_path = NULL;
            }
            $null = NULL;
            $stmt = $this->db->prepare("INSERT INTO store (id, name, userid, password, seats, img_path,  open, close, last_order, exception, created_at, updated_at) VALUES (:id, :name, :userid, :password, :seats, :img_path,  :open, :close, :last_order, :exception,  now(), now())");
            $stmt->bindparam(':id', $null, PDO::PARAM_INT);
            $stmt->bindparam(':name', $store_name, PDO::PARAM_STR);
            $stmt->bindparam(':userid', $user_id, PDO::PARAM_STR);
            $stmt->bindparam(':password', $user_pw, PDO::PARAM_STR);
            $stmt->bindparam(':seats', $store_seats, PDO::PARAM_INT);
            $stmt->bindparam(':img_path', $store_img_path, PDO::PARAM_STR);
            $stmt->bindparam(':open', $store_opentime, PDO::PARAM_STR);
            $stmt->bindparam(':close', $store_closetime, PDO::PARAM_STR);
            if($store_lastorder == NULL){
                $stmt->bindparam(':last_order', $null, PDO::PARAM_NULL);
            }
            else{
                $stmt->bindparam(':last_order', $store_lastorder, PDO::PARAM_STR);
            }
            $stmt->bindparam(':exception', $store_exception, PDO::PARAM_STR);
            $stmt->execute();
            return $this->db->lastInsertId();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_store_seats($store_seats, $store_id){
        try{
            $stmt = $this->db->prepare('UPDATE store SET seats = :seats WHERE id = :id');
            $stmt->bindparam(':id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':seats', $store_seats, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
<<<<<<< HEAD
    public function update_add_menu_like($menu_id, $flag){
        try{
            if($flag == 1){
                $sql = 'UPDATE menu SET likes = likes + 1 WHERE id = :id';
            }
            else{
                $sql = 'UPDATE menu SET likes = likes - 1 WHERE id = :id';
            }
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $menu_id, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
=======
>>>>>>> 95c08c2c3d322f003d97c9ae06ec0d07c5d1b97d
    public function update_store($store_id, $store_name, $store_seats, $store_img, $store_open, $store_close, $store_lastorder, $store_exception, $full_path){
        try{
            if($store_img['error'] != 4){
                $sql = 'UPDATE store SET name = :name, seats = :seats, img_path = :img_path, open = :open, close = :close, last_order = :last_order, exception = :exception WHERE id = :id';
                $store_img_path = $this->upload_img($store_img, $full_path, 'store');
            }
            else{
                $sql = 'UPDATE store SET name = :name, seats = :seats, open = :open, close = :close, last_order = :last_order, exception = :exception WHERE id = :id';
            }
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $store_id, PDO::PARAM_INT);
            $stmt->bindparam(':name', $store_name, PDO::PARAM_STR);
            $stmt->bindparam(':seats', $store_seats, PDO::PARAM_INT);
            if($store_img['error'] != 4) $stmt->bindparam(':img_path', $store_img_path, PDO::PARAM_STR);
            $stmt->bindparam(':open', $store_open, PDO::PARAM_STR);
            $stmt->bindparam(':close', $store_close, PDO::PARAM_STR);
            $stmt->bindparam(':last_order', $store_lastorder, PDO::PARAM_STR);
            $stmt->bindparam(':exception', $store_exception, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_menu($menu_id, $menu_name, $menu_price, $menu_desc, $menu_img, $menu_enabled, $full_path){
        try{
            if($menu_img['error'] != 4){
                $tmp_menu = $this->select_menu_id($menu_id)[0];
                $tmp_img_path = $tmp_menu['img_path'];
                unlink($tmp_img_path);
                $menu_img_path = $this->upload_img($menu_img, $full_path, 'menu');
                $sql = 'UPDATE menu SET name = :name, price = :price, description = :description, img_path = :img_path, enabled = :enabled WHERE id = :id';
                $flg = true;
            }
            else{
                $sql = 'UPDATE menu SET name = :name, price = :price, description = :description, enabled = :enabled WHERE id = :id';
                $flg = false;
            }
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $menu_id, PDO::PARAM_INT);
            $stmt->bindparam(':name', $menu_name, PDO::PARAM_STR);
            $stmt->bindparam(':price', $menu_price, PDO::PARAM_INT);
            $stmt->bindparam(':description', $menu_desc, PDO::PARAM_STR);
            if($flg){
                $stmt->bindparam(':img_path', $menu_img_path, PDO::PARAM_STR);
            }
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
    public function update_rule_cat($rule_cat_id, $rule_cat_name){
        try{
            $stmt = $this->db->prepare('UPDATE rule_category SET name = :name WHERE id = :id');
            $stmt->bindparam(':id', $rule_cat_id, PDO::PARAM_INT);
            $stmt->bindparam(':name', $rule_cat_name, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_rule($rule_id, $rule_content){
        try{
            $stmt = $this->db->prepare('UPDATE rule SET content = :content WHERE id = :id');
            $stmt->bindparam(':id', $rule_id, PDO::PARAM_INT);
            $stmt->bindparam(':content', $rule_content, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_order($table, $item_id, $order){
        try{
            $stmt = $this->db->prepare('UPDATE '. $table .' SET sort_order = :order WHERE id = :id');
            $stmt->bindparam(':id', $item_id, PDO::PARAM_INT);
            $stmt->bindparam(':order', $order, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function update_menu_enable($menu_id, $menu_enabled){
        try{
            $sql = 'UPDATE menu SET enabled = :enabled WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':id', $menu_id, PDO::PARAM_INT);
            $stmt->bindparam(':enabled', $menu_enabled, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function delete($table, $id){
        try{
            $stmt = $this->db->prepare('DELETE FROM '. $table .' WHERE  id = :id');
            $stmt->bindparam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        catch(Exception $e){
            echo $e;
        }
    }
    public function secRmvFromTime($time){
        $ex_time = explode(':', $time);
        $result_time = $ex_time[0].':'.$ex_time[1]; 
        if($time){
            return $result_time;
        }
        else{
            return NULL;
        }
    }
}

<?php
require '../pdo/lib_pdo.php';
session_start();
$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "<div><a href='../logout/index.php'>ログアウトはこちら</a></div>";
  echo "<h1>お店のメニューを追加、変更</h1>";

  $id = $_SESSION['ID'];
  $menu_cat = $pdo->select("menu_category", $id);
  foreach($menu_cat as $index => $row){
    $row_menu_cat[$index]['id'] = $row['id'];
    $row_menu_cat[$index]['name'] = $row['name'];
  }
  $menu = $pdo->select("menu", $id);
  foreach($menu as $index => $row){
    $row_menu[$index]['id'] = $row['id'];
    $row_menu[$index]['name'] = $row['name'];
    $row_menu[$index]['menu_category_id'] = $row['menu_category_id'];
  }
  
  if(!isset($row_menu_cat)){
    //存在していなかった場合
    echo '<div>メニューカテゴリーがありません</div>';
    echo "<div><a href=insert.php?id=".$_SESSION['ID']."&target=cat>メニューカテゴリーを追加</a></div>";
    }
  else{
    foreach($row_menu_cat as $value_cat){
      echo '<h2>'.$value_cat['name'].'</h2>';
      echo "<a href=update.php?cat_id=".$value_cat['id'].">カテゴリー名を編集</a>";
      if(is_array($row_menu)){
        $flag = false;
        foreach($row_menu as $value_menu){
          if($value_menu['menu_category_id'] == $value_cat['id']){
            echo '<div>';
            echo $value_menu['name'];
            echo "<a href=update.php?menu_id=".$value_menu['id'].">メニューを編集</a>";
            echo '</div>';
            $flag = true;
          }
        }
        if(!$flag){
          echo '<div>メニューがありません</div>';
        }
      }
      echo "<div><a href=insert.php?cat_id=".$value_cat['id']."&target=menu>メニューを追加</a></div>";
    }
    echo "<div><a href=insert.php?target=cat>メニューカテゴリーを追加</a></div>";
  }
}

?>


<p>
  <a href="../index.php">管理画面TOPへ</a>
</p>
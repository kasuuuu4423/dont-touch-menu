<?php
require '../pdo/lib_pdo.php';
session_start();
$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "<div><a href='../logout/index.php'>ログアウトはこちら</a></div>";
  echo "<h1>お店のルールを追加、変更</h1>";

  $id = $_SESSION['ID'];
  $rule_cat = $pdo->select("rule_category", $id);
  foreach($rule_cat as $index => $row){
    $row_rule_cat[$index]['id'] = $row['id'];
    $row_rule_cat[$index]['name'] = $row['name'];
  }
  $rule = $pdo->select("rule", $id);
  foreach($rule as $index => $row){
    $row_rule[$index]['id'] = $row['id'];
    $row_rule[$index]['content'] = $row['content'];
    $row_rule[$index]['rule_category_id'] = $row['rule_category_id'];
  }

  if (!isset($row_rule_cat)) {
    //存在していなかった場合
    echo '<div>ルールカテゴリーがありません</div>';
    echo "<div><a href=insert.php?id=".$_SESSION['ID']."&target=cat>ルールカテゴリーを追加</a></div>";
  }
  else{
    foreach($row_rule_cat as $value_cat){
      echo '<h2>'.$value_cat['name'].'</h2>';
      echo "<a href=update.php?cat_id=".$value_cat['id']."&>カテゴリー名を編集</a>";
      if(is_array($row_rule)){
        $flag = false;
        foreach($row_rule as $value_rule){
          if($value_rule['rule_category_id'] == $value_cat['id']){
            echo '<div>';
            echo $value_rule['content'];
            echo "<a href=update.php?rule_id=".$value_rule['id'].">ルールを編集</a>";
            echo '</div>';
            $flag = true;
          }
        }
        if(!$flag){
          echo '<div>ルールがありません</div>';
        }
      }
      echo "<div><a href=insert.php?cat_id=".$value_cat['id']."&target=rule>ルールを追加</a></div>";
    }
    echo "<div><a href=insert.php?target=cat>ルールカテゴリーを追加</a></div>";
  }
}

?>


<p>
  <a href="../index.php">管理画面TOPへ</a>
</p>
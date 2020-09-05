<?php

session_start();
if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "<div><a href='../logout/index.php'></div>ログアウトはこちら</a>";
  if(isset($_GET['cat_id'])){
  require "../pdo/pdo_connect.php";
  $sql_rule_cat = 'SELECT * FROM rule_category WHERE id = '.$_GET['cat_id'].'';
  $stmt_rule_cat = $dbh -> query($sql_rule_cat);
  $params_rule_cat = $stmt_rule_cat -> fetch(PDO::FETCH_ASSOC);

  $rule_cat_id = $params_rule_cat['id'];
  $rule_cat_name = $params_rule_cat['name'];

?>

<form action="update.php" method="post">
  <input type="hidden" name="rule_cat_id" value="<?php if (!empty($rule_cat_id)) echo(htmlspecialchars($rule_cat_id, ENT_QUOTES, 'UTF-8'));?>">
  <h2>カテゴリー名</h2>
  <input type="text" name="rule_cat_name" value="<?php if (!empty($rule_cat_name)) echo(htmlspecialchars($rule_cat_name, ENT_QUOTES, 'UTF-8'));?>">
  <input type="submit" name="confirm_cat" value="編集を確定">
</form>
<a href="delete.php">このカテゴリーを削除する</a>
<?php
  }
  if(isset($_GET['rule_id'])){
    require "../pdo/pdo_connect.php";
    $sql_rule = 'SELECT * FROM rule WHERE id = '.$_GET['rule_id'].'';
    $stmt_rule = $dbh -> query($sql_rule);
    $params_rule = $stmt_rule -> fetch(PDO::FETCH_ASSOC);
  
    $rule_id = $params_rule['id'];
    $rule_content = $params_rule['content'];
  ?>
  
  <form action="update.php" method="post">
    <input type="hidden" name="rule_id" value="<?php if (!empty($rule_id)) echo(htmlspecialchars($rule_id, ENT_QUOTES, 'UTF-8'));?>">
    <h2>ルール名</h2>
    <input type="text" name="rule_content" value="<?php if (!empty($rule_content)) echo(htmlspecialchars($rule_content, ENT_QUOTES, 'UTF-8'));?>">
    <input type="submit" name="confirm_rule" value="編集を確定">
  </form>
  <a href="delete.php">このルールを削除する</a>
  <?php 
  }
}
?>

<?php

if(isset($_POST['confirm_cat'])){
  require "../pdo/pdo_connect.php";
  $sql_rule_cat_update = 'UPDATE rule_category SET name = :name WHERE id = :id';
  $stmt_rule_cat_update = $dbh->prepare($sql_rule_cat_update);
  $stmt_rule_cat_update->bindparam(':id', $_POST['rule_cat_id'], PDO::PARAM_INT);
  $stmt_rule_cat_update->bindparam(':name', $_POST['rule_cat_name'], PDO::PARAM_STR);
  $stmt_rule_cat_update->execute();

  echo "情報を更新しました。";
}

if(isset($_POST['confirm_rule'])){
  require "../pdo/pdo_connect.php";
  $sql_rule_update = 'UPDATE rule SET content = :content WHERE id = :id';
  $stmt_rule_update = $dbh->prepare($sql_rule_update);
  $stmt_rule_update->bindparam(':id', $_POST['rule_id'], PDO::PARAM_INT);
  $stmt_rule_update->bindparam(':content', $_POST['rule_content'], PDO::PARAM_STR);
  $stmt_rule_update->execute();

  echo "情報を更新しました。";
}
?>

<p>
    <a href="index.php">ルール変更画面へ戻る</a>
</p>        
<p>
    <a href="../index.php">管理画面TOPへ</a>
</p>
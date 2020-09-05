<?php
require '../pdo/lib_pdo.php';
session_start();
$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "<div><a href='../logout/index.php'></div>ログアウトはこちら</a>";
  if(isset($_GET['cat_id'])){
  $rule_cat = $pdo->select_rule_cat_id($_GET['cat_id'])[0];

  $rule_cat_id = $rule_cat['id'];
  $rule_cat_name = $rule_cat['name'];
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
    $rule = $pdo->select_rule_id($_GET['rule_id'])[0];
  
    $rule_id = $rule['id'];
    $rule_content = $rule['content'];
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
  $pdo->update_rule_cat($_POST['rule_cat_id'], $_POST['rule_cat_name']);
  echo "情報を更新しました。";
}

if(isset($_POST['confirm_rule'])){
  $pdo->update_rule($_POST['rule_id'], $_POST['rule_content']);
  echo "情報を更新しました。";
}
?>

<p>
    <a href="index.php">ルール変更画面へ戻る</a>
</p>        
<p>
    <a href="../index.php">管理画面TOPへ</a>
</p>
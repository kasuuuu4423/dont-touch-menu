<?php
require  '../pdo/lib_pdo.php';
session_start();
$pdo = new Lib_pdo();

require '../header.php';
?>
<?php if($_GET['target'] == 'cat'): ?>
<h2>ルールカテゴリーの追加</h2>
<form action="insert.php" method="post">
  <h2>カテゴリー名</h2>
  <input type="text" name="rule_cat_name">
  <input type="submit" name="insert_cat" value="ルールカテゴリーを追加">
</form>
<?php endif; ?>

<?php if($_GET['target'] == 'rule'): ?>
<h2>ルールの追加</h2>
<form action="insert.php" method="post">
  <h2>内容</h2>
  <input type="text" name="rule_content">
  <input type="hidden" name="rule_cat_id" value="<?php echo $_GET['cat_id']?>">
  <input type="submit" name="insert_rule" value="ルールを追加">
</form>
<?php endif; ?>

<?php 
if(isset($_POST['insert_cat'])){
  $pdo->insert_rule_category($_POST['rule_cat_name'], $_SESSION['ID']);
  echo '<p><a href="index.php">ルール変更画面へ戻る</a></p>';
  echo '<p><a href="../index.php">管理画面TOPへ</a></p>';
}
if(isset($_POST['insert_rule'])){
  $pdo->insert_rule($_POST['rule_content'], $_POST['rule_cat_id'], $_SESSION['ID']);
  echo 'ルールの追加が完了しました';
  echo '<p><a href="index.php">ルール変更画面へ戻る</a></p>';
  echo '<p><a href="../index.php">管理画面TOPへ</a></p>';
}

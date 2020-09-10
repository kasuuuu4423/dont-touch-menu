<?php
require  '../pdo/lib_pdo.php';
$pdo = new Lib_pdo();

require '../header.php';
?>
<main class="container">
  <div class="row">
    <div class="col-12 bar"></div>
    <?php if($_GET['target'] == 'cat'): ?>
    <h2 class="col-12">ルールカテゴリーの追加</h2>
    <form class="col-12 mt-4 text-center" action="insert.php" method="post">
      <div class="mb-4">
        <h2>カテゴリー名</h2>
        <input class="w-100" type="text" name="rule_cat_name">
      </div>
      <input class="btn btn-blue" type="submit" name="insert_cat" value="ルールカテゴリーを追加">
    </form>
    <?php elseif($_GET['target'] == 'rule'): ?>
    <h2 class="col-12">ルールの追加</h2>
    <form class="col-12 mt-4 text-center" action="insert.php" method="post">
      <div class="mb-4">
        <h2>内容</h2>
        <input class="w-100" type="text" name="rule_content">
      </div>
      <input type="hidden" name="rule_cat_id" value="<?php echo $_GET['cat_id']?>">
      <input class="btn btn-blue" type="submit" name="insert_rule" value="ルールを追加">
    </form>
    <?php endif; ?>
  </div>
</main>
<?php 
if(isset($_POST['insert_cat'])){
  $pdo->insert_rule_category($_POST['rule_cat_name'], $_SESSION['ID']);
  $_SESSION['rule_msg'] = 'カテゴリーを追加しました。';
  header('Location: ./');
}
if(isset($_POST['insert_rule'])){
  $pdo->insert_rule($_POST['rule_content'], $_POST['rule_cat_id'], $_SESSION['ID']);
  $_SESSION['rule_msg'] = 'ルールを追加しました。';
  header('Location: ./');
}

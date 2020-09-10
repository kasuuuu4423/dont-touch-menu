<?php
require '../pdo/lib_pdo.php';
require '../header.php';
$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
?>

<main class="container">
  <div class="row">
    <div class="col-12 bar"></div>
<?php
  if(isset($_GET['cat_id'])):
  $rule_cat = $pdo->select_rule_cat_id($_GET['cat_id'])[0];

  $rule_cat_id = $rule_cat['id'];
  $rule_cat_name = $rule_cat['name'];
?>
    <form class="col-12 mt-12 text-center" action="update.php" method="post">
      <input type="hidden" name="rule_cat_id" value="<?php if (!empty($rule_cat_id)) echo(htmlspecialchars($rule_cat_id, ENT_QUOTES, 'UTF-8'));?>">
      <div class="mb-4">
        <h2>カテゴリー名</h2>
        <input class="w-100" type="text" name="rule_cat_name" value="<?php if (!empty($rule_cat_name)) echo(htmlspecialchars($rule_cat_name, ENT_QUOTES, 'UTF-8'));?>">
      </div>
      <input type="submit" name="confirm_cat" value="編集を確定">
    </form>
    <a href="delete.php?rule_cat_id=<?php echo $rule_cat_id; ?>">このカテゴリーを削除する</a>
    <?php
      elseif(isset($_GET['rule_id'])):
        $rule = $pdo->select_rule_id($_GET['rule_id'])[0];
      
        $rule_id = $rule['id'];
        $rule_content = $rule['content'];
      ?>     
      <form class="col-12 mt-12 text-center" action="update.php" method="post">
        <input type="hidden" name="rule_id" value="<?php if (!empty($rule_id)) echo(htmlspecialchars($rule_id, ENT_QUOTES, 'UTF-8'));?>">
        <div class="mb-4">
          <h2>ルール名</h2>
          <input class="w-100" type="text" name="rule_content" value="<?php if (!empty($rule_content)) echo(htmlspecialchars($rule_content, ENT_QUOTES, 'UTF-8'));?>">
        </div>
        <input class="btn btn-green" type="submit" name="confirm_rule" value="編集を確定">
      </form>
      <a class="btn btn-red mt-4" href="delete.php?rule_id=<?php echo $_GET['rule_id']; ?>">このルールを削除する</a>
      <?php 
      endif;
    endif;
    ?>
  </div>
</main>
<?php

if(isset($_POST['confirm_cat'])){
  $pdo->update_rule_cat($_POST['rule_cat_id'], $_POST['rule_cat_name']);
  $_SESSION['rule_msg'] = 'カテゴリーを変更しました。';
  header('Location: ./');
}

if(isset($_POST['confirm_rule'])){
  $pdo->update_rule($_POST['rule_id'], $_POST['rule_content']);
  $_SESSION['rule_msg'] = 'ルールを変更しました。';
  header('Location: ./');
}

require '../footer.php';
?>
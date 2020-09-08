<?php
require '../pdo/lib_pdo.php';
require '../header.php';
session_start();
$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
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
?>
<main class="container pt-5 pb-5">
  <div class="row">
    <h2 class="col-12 mb-4">お店のルールを追加、変更</h2>
    <?php 
    if(!isset($row_rule_cat)):
    ?>
      <div>ルールカテゴリーがありません</div>
      <div><a href="./insert.php?id=<?php echo $_SESSION['ID']; ?>&target=cat">ルールカテゴリーを追加</a></div>
    <?php
    else:
      foreach($row_rule_cat as $value_cat):
    ?>
    <section class="category col-12 mb-4">
      <h3 class=""><?php echo $value_cat['name']; ?></h3>
      <a class="btn btn-green" href="./update.php?cat_id=<?php echo $value_cat['id'] ?>">カテゴリー名を編集</a>
      <?php
        if(is_array($row_rule)):
          $flag = false;
          foreach($row_rule as $value_rule):
            if($value_rule['rule_category_id'] == $value_cat['id']):
              $flag = true;
      ?>
      <div class="">
        <span><?php echo $value_rule['content']; ?></span>
        <a href="./update.php?rule_id=<?php echo $value_rule['id']; ?>">ルールを編集</a>
      </div>
  <?php
            endif;
          endforeach;
          if(!$flag){
            echo '<div class="col-12">ルールがありません</div>';
          }
        endif;
        echo "<div class='col-12'><a class='btn btn-blue' href=insert.php?cat_id=".$value_cat['id']."&target=rule>ルールを追加</a></div>";
        echo "</section>";
      endforeach;
      echo "<div class='col-12'><a class='btn btn-blue' href=insert.php?target=cat>カテゴリーを追加</a></div>";
    endif;
  endif;
  ?>
  </div>
</main>
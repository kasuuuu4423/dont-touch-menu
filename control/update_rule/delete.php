<?php

require '../../config.php';
require '../elements/header.php';
require '../../lib/pdo/lib_pdo.php';

session_start();
$pdo = new Lib_pdo();

if(isset($_POST['rule_delete'])){
    $id = $_POST['rule_id'];
    $pdo->delete("rule", $id);
    header('Location: ./');
}
elseif(isset($_POST['rule_category_delete'])){
    $id = $_POST['rule_category_id'];
    $tmp_rules = $pdo->select_ByCatid("rule", $id);
    foreach($tmp_rules as $rule){
        $pdo->delete("rule", $rule['id']);
    }
    $pdo->delete("rule_category", $id);
    header('Location: ./');
}

$flg_rule = false;
if(isset($_GET['rule_id'])){
    $id = $_GET['rule_id'];
    $rule_info = $pdo->select_rule_id($id)[0];
    $rule_name = $rule_info['content'];
    $flg_rule = true;
}
elseif(isset($_GET['rule_cat_id'])){
    $id = $_GET['rule_cat_id'];
    $rule_info = $pdo->select_rule_cat_id($id)[0];
    $rule_name = $rule_info['name'];
    $flg_rule = false;
}
?>

<main class="pt-5 pb-5 container">
    <div class="row">
        <div class="col-12">
            <h2><?php echo $rule_name; ?></h2>
            <p class="text-center"><?php if($flg_rule) echo 'このルールを削除しますか'; else echo 'このカテゴリーを削除しますか'; ?></p>
        </div>
        <form method="post" class="text-center col-12">
            <input type="hidden" name="<?php if($flg_rule) echo 'rule_id'; else echo 'rule_category_id'; ?>" value="<?php echo $id; ?>">
            <a class="btn btn-blue" href="./update.php?<?php  if($flg_rule) echo 'rule_id='. $id; else echo 'cat_id='. $id; ?>">戻る</a>
            <input class="btn btn-red" type="submit" name="<?php if($flg_rule) echo 'rule_delete'; else echo 'rule_category_delete'; ?>" value="削除する">
        </form>
    </div>
</main>

<?php
require '../elements/footer.php';
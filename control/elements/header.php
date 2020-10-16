<?php

session_start();
$current_path = explode("?", (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
$current_path = $current_path[0];
if($current_path == $ctrl_path or $current_path == $ctrl_path.'index.php'){
  $css_path = $ctrl_css_path.'ctrl_top.css';
}

if(!isset($_SESSION['USERID'])) {
  if(($current_path != $ctrl_login_path) and ($current_path != $ctrl_signup_path)){
    header("Location:$ctrl_login_path");
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理画面</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $ctrl_css_path.'common.css' ?>">
  <link rel="stylesheet" href="<?php echo $css_path ?>">
</head>
<body>
  <header class="container">
    <?php if(isset($_SESSION['USERID']) and $current_path != $ctrl_logout_path): ?>
    <div class="row">
      <h1 class="col-12">管理画面</h1>
      <ul class="col-12 text-center nav_ctrl">
        <li><a href="<?php echo $ctrl_path; ?>">トップ</a></li>
        <span class="nav_bar">|</span>
        <li><a href="<?php echo $ctrl_update_store_path; ?>">基本情報</a></li>
        <span class="nav_bar">|</span>
        <li><a href="<?php echo $ctrl_update_menu_path; ?>">メニュー一覧</a></li>
        <br>
        <li><a href="<?php echo $ctrl_update_rule_path; ?>">ルール一覧</a></li>
        <span class="nav_bar">|</span>
        <li><a href="<?php echo $ctrl_history_path; ?>">来店履歴</a></li>
        <span class="nav_bar">|</span>
        <li><a href="<?php echo $ctrl_logout_path; ?>">ログアウト</a></li>
        <br>
        <li><a href="<?php echo $public_path_forGet; ?>?id=<?php echo $_SESSION['ID']; ?>&store=1">お客様側の画面へ</a></li>
      </ul>
    </div>
    <?php endif; ?>
  </header>
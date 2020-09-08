<?php
require '../pdo/lib_pdo.php';
session_start();

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "<div><a href='../logout/index.php'></div>ログアウトはこちら</a>";
  if(isset($_GET['cat_id'])){
    require "../pdo/pdo_connect.php";
    $menu_cat = $pdo->select_menu_cat_id($_GET['cat_id'])[0];
    $menu_cat_id = $menu_cat['id'];
    $menu_cat_name = $menu_cat['name'];
    ?>
    <form action="update.php" method="post">
      <input type="hidden" name="menu_cat_id" value="<?php if (!empty($menu_cat_id)) echo(htmlspecialchars($menu_cat_id, ENT_QUOTES, 'UTF-8'));?>">
      <h2>カテゴリー名</h2>
      <input type="text" name="menu_cat_name" value="<?php if (!empty($menu_cat_name)) echo(htmlspecialchars($menu_cat_name, ENT_QUOTES, 'UTF-8'));?>">
      <input type="submit" name="confirm_cat" value="編集を確定">
    </form>
    <a href="delete.php">このカテゴリーを削除する</a>
    <?php
  }
  if(isset($_GET['menu_id'])){
    $menu = $pdo->select_menu_id($_GET['menu_id'])[0];
    $menu_id = $menu['id'];
    $menu_name = $menu['name'];
    $menu_price = $menu['price'];
    $menu_desc = $menu['description'];
    $menu_img = $menu['img_path'];
    $menu_enabled = $menu['enabled'];
    ?>
    <form action="update.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="menu_id" value="<?php if (!empty($menu_id)) echo(htmlspecialchars($menu_id, ENT_QUOTES, 'UTF-8'));?>">
      <h2>メニュー名</h2>
      <input type="text" name="menu_name" value="<?php if (!empty($menu_name)) echo(htmlspecialchars($menu_name, ENT_QUOTES, 'UTF-8'));?>">
      <h2>値段</h2>
      <input type="text" name="menu_price" value="<?php if (!empty($menu_price)) echo(htmlspecialchars($menu_price, ENT_QUOTES, 'UTF-8'));?>">
      <h2>説明</h2>
      <input type="text" name="menu_desc" value="<?php if (!empty($menu_desc)) echo(htmlspecialchars($menu_desc, ENT_QUOTES, 'UTF-8'));?>">
      <h2>画像パス</h2>
      <img src="<?php if (!empty($menu_img)) echo $menu_img;?>">
      <input type="file" name="menu_img">
      <h2>販売状況</h2>
      <input type="text" name="menu_enabled" value="<?php if (!empty($menu_enabled)) echo(htmlspecialchars($menu_enabled, ENT_QUOTES, 'UTF-8'));?>">
      <input type="submit" name="confirm_menu" value="編集を確定">
    </form>
    <a href="delete.php">このメニューを削除する</a>
  <?php 
  }
}
?>

<?php
if(isset($_POST['confirm_cat'])){
  $pdo->update_menu_cat($_POST['menu_cat_id'], $_POST['menu_cat_name']);
  echo "情報を更新しました。";
}
else if(isset($_POST['confirm_menu'])){
  $pdo->update_menu($_POST['menu_id'], $_POST['menu_name'], $_POST['menu_price'], $_POST['menu_desc'], $_FILES['menu_img'], $_POST['menu_enabled']);
  echo "情報を更新しました。";
}
?>

<p>
    <a href="index.php">メニュー変更画面へ戻る</a>
</p>        
<p>
    <a href="../index.php">管理画面TOPへ</a>
</p>
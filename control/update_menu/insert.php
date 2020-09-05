<?php
require '../pdo/lib_pdo.php';
session_start();

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])) {
  echo "ようこそ".($_SESSION["USERID"])."さん<br>";
  echo "<div><a href='../logout/index.php'></div>ログアウトはこちら</a>";
}

if ($_GET['target'] == 'cat') :
?>
<h2>メニューカテゴリーの追加</h2>
<form action="insert.php" method="post">
  <h2>カテゴリー名</h2>
  <input type="text" name="menu_cat_name">
  <input type="submit" name="insert_cat" value="メニューカテゴリーを追加">
</form>
<?php elseif($_GET['target'] == 'menu'): ?>
<h2>メニューの追加</h2>
<form action="insert.php" method="post" enctype="multipart/form-data">
  <h2>メニュー名</h2>
  <input type="text" name="menu_name">
  <h2>値段</h2>
  <input type="text" name="menu_price">
  <h2>説明</h2>
  <input type="text" name="menu_desc">
  <h2>商品画像</h2>
  <input type="file" name="menu_img">
  <h2>販売状況</h2>
  <input type="text" name="menu_enabled">
  <input type="hidden" name="menu_cat_id" value="<?php echo $_GET['cat_id']?>">
  <input type="submit" name="insert_menu" value="メニューを追加">
</form>
<?php
endif; 

if(isset($_POST['insert_cat'])){
  $pdo->insert_menu_category($_POST['menu_cat_name'], $_SESSION['ID']);
  echo 'メニューカテゴリーの追加が完了しました';
  echo '<p><a href="index.php">メニュー変更画面へ戻る</a></p>';
  echo '<p><a href="../index.php">管理画面TOPへ</a></p>';
}
elseif(isset($_POST['insert_menu'])){
  $pdo->insert_menu($_POST['menu_name'], $_POST['menu_price'], $_POST['menu_desc'], $_FILES['menu_img'], $_POST['menu_enabled'], $_SESSION['ID'], $_POST['menu_cat_id']);
  echo 'メニューの追加が完了しました';
  echo '<p><a href="index.php">メニュー変更画面へ戻る</a></p>';
  echo '<p><a href="../index.php">管理画面TOPへ</a></p>';
}

<?php
require '../pdo/lib_pdo.php';
session_start();

$pdo = new Lib_pdo();

require '../header.php';

?>

<main class="container">
  <div class="row">
    <div class="col-12 bar"></div>

<?php if ($_GET['target'] == 'cat') : ?>
    <h2 class="col-12">メニューカテゴリーの追加</h2>
    <form class="mt-4" action="insert.php" method="post">
      <h3 class="col-12">カテゴリー名</h3>
      <input class="w-100" type="text" name="menu_cat_name">
      <input type="submit" name="insert_cat" value="メニューカテゴリーを追加">
    </form>
    <?php elseif($_GET['target'] == 'menu'): ?>
    <h2 class="col-12">メニューの追加</h2>
    <form class="text-center mt-4 col-12" action="insert.php" method="post" enctype="multipart/form-data">
      <div class="mb-4">
        <h3>メニュー名</h3>
        <input class="w-100" type="text" name="menu_name">
      </div>
      <div class="mb-4">
        <h3>値段</h3>
        <input class="w-100" type="text" name="menu_price">
      </div>
      <div class="mb-4">
        <h3>説明</h3>
        <input class="w-100" type="text" name="menu_desc">
      </div>
      <div class="mb-4">
        <h3>商品画像</h3>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div>
          <div class="custom-file">
            <input type="file" name="menu_img" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <h3>販売状況</h3>
        <!-- <input class="w-100" type="text" name="menu_enabled"> -->
        <div class="form-group w-100">
          <select id="inputState" name="menu_enabled" class="form-control">
            <option value="1" selected>販売中</option>
            <option value="0">販売停止</option>
          </select>
        </div>
      </div>
      <input type="hidden" name="menu_cat_id" value="<?php echo $_GET['cat_id']?>">
      <input class="btn btn-blue" type="submit" name="insert_menu" value="メニューを追加">
    </form>
<?php endif; ?>

  </div>
</main>

<?php 

if(isset($_POST['insert_cat'])){
  $pdo->insert_menu_category($_POST['menu_cat_name'], $_SESSION['ID']);
  $_SESSION['menu_msg'] = 'カテゴリーを追加しました。';
  header('Location: ./');
}
elseif(isset($_POST['insert_menu'])){
  $pdo->insert_menu($_POST['menu_name'], $_POST['menu_price'], $_POST['menu_desc'], $_FILES['menu_img'], $_POST['menu_enabled'], $_SESSION['ID'], $_POST['menu_cat_id']);
  $_SESSION['menu_msg'] = 'メニューを追加しました。';
  header('Location: ./');
}

require '../footer.php';
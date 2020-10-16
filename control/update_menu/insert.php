<?php

require '../../config.php';
require '../elements/header.php';
require '../../lib/pdo/lib_pdo.php';

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
  ?>
  <main>
    <section class="update_insert container">
      <div class="row">
        <div class="col-12 bar"></div>
        <?php if ($_GET['target'] == 'cat'): ?>
        <h2 class="col-12">メニューカテゴリーの追加</h2>
        <form class="col-12 tbl form_update" action="insert.php" method="post">
          <div class="row">
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">カテゴリー名<span class="required_field">*必須</span></div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12"><input type="text" name="menu_cat_name" required></div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $ctrl_update_menu_path; ?>">戻る</a></div>
            <div><input class="btn btn-green" type="submit" name="insert_cat" value="メニューカテゴリーを追加"></div>
          </div>
        </form>
        <?php elseif($_GET['target'] == 'menu'):
          $menu_data = array(
            array('メニュー名<span class="required_field">*必須</span>', 'menu_name'),
            array('値段<span class="required_field">*必須</span>', 'menu_price'),
            array('説明', 'menu_desc'),
          );
        ?>
        <h2 class="col-12">メニューの追加</h2>
        <form class="col-12 tbl form_update" action="insert.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <?php foreach($menu_data as $row): ?>
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text"><?php echo $row[0] ?></div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <?php if($row[1] == 'menu_desc'): ?>
                <div class="col-12"><textarea class="w-100" style="height: 100px" type="text" name="<?php echo $row[1] ?>"></textarea></div>
                <?php elseif($row[1] == 'menu_price'): ?>
                <div class="col-12"><input type="number" min="1" name="<?php echo $row[1] ?>" required></div>
                <?php else: ?>
                <div class="col-12"><input type="text" name="<?php echo $row[1] ?>" required></div>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">商品画像</div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">画像をアップロード</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" name="menu_img" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">ファイルを選択</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">販売状況<span class="required_field">*必須</span></div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12 item_enabled btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-primary active">
                    <input type="radio" name="menu_enabled" value="1" autocomplete="off" checked>販売中
                  </label>
                  <label class="btn btn-primary">
                    <input type="radio" name="menu_enabled" value="0" autocomplete="off">販売停止中
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $ctrl_update_menu_path; ?>">戻る</a></div>
            <div><input class="btn btn-blue" type="submit" name="insert_menu" value="メニューを追加"></div>
          </div>
          <input type="hidden" name="menu_cat_id" value="<?php echo $_GET['cat_id']?>">
        </form>
        <?php endif;

        if(isset($_POST['insert_cat'])){
          $pdo->insert_menu_category($_POST['menu_cat_name'], $_SESSION['ID']);
          $_SESSION['menu_msg'] = 'カテゴリーを追加しました';
          header('Location: ./');
        }
        elseif(isset($_POST['insert_menu'])){
          $pdo->insert_menu($_POST['menu_name'], $_POST['menu_price'], $_POST['menu_desc'], $_FILES['menu_img'], $_POST['menu_enabled'], $_SESSION['ID'], $_POST['menu_cat_id'], $img_menu_path);
          $_SESSION['menu_msg'] = 'メニューを追加しました';
          header('Location: ./');
        }
        ?>
      </div>
    </section>
  </main>
<?php
endif;

require '../elements/footer.php';
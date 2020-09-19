<?php

require '../header.php';
require '../pdo/lib_pdo.php';

$pdo = new Lib_pdo();

if (isset($_SESSION["USERID"])):
  ?>
  <main>
    <section class="update_update container">
      <div class="row">
        <div class="col-12 bar"></div>
        <h2 class="col-12">メニューの編集</h2>
        <?php
        if(isset($_GET['cat_id'])):
        $menu_cat = $pdo->select_menu_cat_id($_GET['cat_id'])[0];
        $menu_cat_id = $menu_cat['id'];
        $menu_cat_name = $menu_cat['name'];
        ?>
        <form class="col-12 tbl form_update" action="update.php" method="post">
          <div class="row">
            <div class="col-10 offset-1 tbl_row field">
              <div class="row">
                <div class="col-12 field_text">カテゴリー名<span class="required_field">*必須</span></div>
              </div>
            </div>
            <div class="col-10 offset-1 tbl_row value">
              <div class="row">
                <div class="col-12"><input type="text" name="menu_cat_name" value="<?php if (!empty($menu_cat_name)) echo(htmlspecialchars($menu_cat_name, ENT_QUOTES, 'UTF-8'));?>" required></div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $update_menu_path; ?>">戻る</a></div>
            <div><input class="btn btn-green" type="submit" name="confirm_cat" value="編集を確定"></div>
            <div class="delete_btn col-12 text-center"><a class="btn btn-red" href="<?php echo $update_menu_path; ?>delete.php?menu_cat_id=<?php echo $menu_cat_id; ?>">このカテゴリーを削除する</a></div>
          </div>
          <input type="hidden" name="menu_cat_id" value="<?php if (!empty($menu_cat_id)) echo(htmlspecialchars($menu_cat_id, ENT_QUOTES, 'UTF-8'));?>">
        </form>
        <?php
        elseif(isset($_GET['menu_id'])):
        $menu = $pdo->select_menu_id($_GET['menu_id'])[0];
        $menu_id = $menu['id'];
        $menu_name = $menu['name'];
        $menu_price = $menu['price'];
        $menu_desc = $menu['description'];
        $menu_img = $menu['img_path'];
        $menu_enabled = $menu['enabled'];
        $menu_data = array(
          array('メニュー名<span class="required_field">*必須</span>', 'menu_name'),
          array('値段<span class="required_field">*必須</span>', 'menu_price'),
          array('説明', 'menu_desc'),
        );
        ?>
        <form class="col-12 tbl form_update" action="update.php" method="post" enctype="multipart/form-data">
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
                <div class="col-12"><textarea class="w-100" style="height: 100px" type="text" name="<?php echo $row[1] ?>"><?php if (!empty(${$row[1]})) echo(htmlspecialchars(${$row[1]}, ENT_QUOTES, 'UTF-8'));?></textarea></div>
                <?php elseif($row[1] == 'menu_price'): ?>
                <div class="col-12"><input type="number" min="1" name="<?php echo $row[1] ?>" value="<?php if (!empty(${$row[1]})) echo(htmlspecialchars(${$row[1]}, ENT_QUOTES, 'UTF-8'));?>" required></div>
                <?php else: ?>
                <div class="col-12"><input type="text" name="<?php echo $row[1] ?>" value="<?php if (!empty(${$row[1]})) echo(htmlspecialchars(${$row[1]}, ENT_QUOTES, 'UTF-8'));?>" required></div>
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
                <?php if (!empty($menu_img)) echo '<img class="col-12" src="'. $menu_img .'">';?>
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
                <div class="col-12">
                  <?php $flg_enabled = false; if (!empty($menu_enabled)) if($menu_enabled == 1) $flg_enabled = true; ?>
                  <select id="inputState" name="menu_enabled" class="form-control" required>
                    <option value="1" <?php if($flg_enabled) echo 'selected'; ?>>販売中</option>
                    <option value="0" <?php if(!$flg_enabled) echo 'selected'; ?>>販売停止</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row btns">
            <div><a class="btn btn-blue" href="<?php echo $update_menu_path; ?>">戻る</a></div>
            <div><input class="btn btn-green" type="submit" name="confirm_menu" value="編集を確定"></div>
            <div class="delete_btn col-12 text-center"><a class="btn btn-red" href="<?php echo $update_menu_path; ?>delete.php?menu_id=<?php echo $_GET['menu_id']; ?>">このメニューを削除する</a></div>
          </div>
          <input type="hidden" name="menu_id" value="<?php if (!empty($menu_id)) echo(htmlspecialchars($menu_id, ENT_QUOTES, 'UTF-8'));?>">
        </form>
        <?php 
        endif;
        
        if(isset($_POST['confirm_cat'])){
          $pdo->update_menu_cat($_POST['menu_cat_id'], $_POST['menu_cat_name']);
          $_SESSION['menu_msg'] = 'カテゴリーを変更しました';
          header('Location: ./');
        }
        else if(isset($_POST['confirm_menu'])){
          $pdo->update_menu($_POST['menu_id'], $_POST['menu_name'], $_POST['menu_price'], $_POST['menu_desc'], $_FILES['menu_img'], $_POST['menu_enabled']);
          $_SESSION['menu_msg'] = 'メニューを変更しました';
          header('Location: ./');
        }
        ?>
      </div>
    </section>
  </main>
<?php
endif;

require '../footer.php';
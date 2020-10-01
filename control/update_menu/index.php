<?php

require '../../config.php';
require '../elements/header.php';
require '../../lib/pdo/lib_pdo.php';

if (isset($_SESSION["USERID"])):
  if(isset($_SESSION['menu_msg'])){
    echo '<div class="update_msg"><span>'.$_SESSION['menu_msg'].'</span></div>';
    unset($_SESSION['menu_msg']);
  }
  ?>
  <main>
    <section class="update_index container">
      <div class="row">
        <div class="col-12 bar"></div>
          <h2 class="col-12">メニュー一覧</h2>
          <button class="btn btn-green" id="btn_sort">順番を変更</button>
      <?php
      $pdo = new Lib_pdo();
      $id = $_SESSION['ID'];
      $menu_cat = $pdo->select("menu_category", $id);
      foreach($menu_cat as $index => $row){
        $row_menu_cat[$index]['id'] = $row['id'];
        $row_menu_cat[$index]['name'] = $row['name'];
      }
      $menu = $pdo->select("menu", $id);
      foreach($menu as $index => $row){
        $row_menu[$index]['id'] = $row['id'];
        $row_menu[$index]['name'] = $row['name'];
        $row_menu[$index]['enabled'] = $row['enabled'];
        $row_menu[$index]['likes'] = $row['likes'];
        $row_menu[$index]['menu_category_id'] = $row['menu_category_id'];
      }

      if(!isset($row_menu_cat)):
      ?>
        <div class="col-12 text-center no_cat">カテゴリーがありません</div>
      <?php
      else:
        ?>
        <div class="tbls">
          <?php
          $count = 0;
          foreach($row_menu_cat as $value_cat):
            $count++;
            ?>
            <div id="<?php echo $value_cat['id']; ?>" class="col-12 tbl_item" data-tbl="menu_category" data-id="<?php echo $count; ?>">
              <div class="row">
                <div class="col-12 cat_name">カテゴリー：<?php echo $value_cat['name']; ?></div>
                <?php
                $flag = false;
                if(is_array($row_menu)):
                  ?>
                  <div class="col-12 tbl tbl_update_index update_menu_index">
                    <div class="row">
                      <?php
                      foreach($row_menu as $value_menu):
                        if($value_menu['menu_category_id'] == $value_cat['id']):
                          ?>
                          <div class="col-12 tbl_row" id="<?php echo $value_menu['id']; ?>">
                            <div class="row">
                              <div class="col-8 item_name"><?php echo $value_menu['name']; ?></div>
                              <div class="col-4 likes">♡<?php echo $value_menu['likes']; ?></div>
                              <div class="col-8 item_enabled btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                  <input type="radio" name="radio<?php echo $value_menu['id']; ?>" id="enable" autocomplete="off" <?php  if($value_menu['enabled'] == 1){ echo 'checked'; }?>>販売中
                                </label>
                                <label class="btn btn-primary">
                                  <input type="radio" name="radio<?php echo $value_menu['id']; ?>" id="disable" autocomplete="off" <?php  if($value_menu['enabled'] == 0){ echo 'checked'; }?>>販売停止中
                                </label>
                              </div>
                              <div class="col-4 edit"><a class="btn btn-green" href="update.php?menu_id=<?php echo $value_menu['id']; ?>">編集</a></div>
                            </div>
                          </div>
                          <?php
                          $flag = true;
                        endif;
                      endforeach;
                      ?>
                    </div>
                  </div>
                  <?php
                endif;
                if(!$flag):
                  ?>
                  <div class="col-12 tbl tbl_update_index">
                    <div class="row">
                      <div class="col-12 tbl_row no_items">
                        <div class="row">
                          <div class="col-12">メニューがありません</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                endif;
                ?>
                <div class="col-12">
                  <div class="row btns">
                    <div><a class="btn btn-blue" href="insert.php?cat_id=<?php echo $value_cat['id']; ?>&target=menu">メニューを追加</a></div>
                    <div><a class="btn btn-green" href="update.php?cat_id=<?php echo $value_cat['id']; ?>">カテゴリーを編集</a></div>
                  </div>
                </div>
              </div>
            </div>
            <?php
          endforeach;
          ?>
        </div>
        <?php
        endif;
        ?>
      <div class="col-12 text-center new_cat"><a class="btn btn-blue" href="insert.php?target=cat">新しいカテゴリーを追加</a></div>
      </div>
    </section>
  </main>
<script src="<?php echo $ctrl_js_path; ?>enabled.js" type="module"></script>
<?php
endif;
require '../elements/footer.php';
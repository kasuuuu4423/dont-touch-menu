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
          <button id="btn_sort_cat" class="btn btn-green" id="btn_sort">カテゴリーの順番を変更</button>
      <?php
      $pdo = new Lib_pdo();
      $id = $_SESSION['ID'];
      
      $menus = $pdo->select("menu", $id);
      $cats = $pdo->select_sorted("menu_category", $id);
      $sort_menus = array();
      foreach($menus as $menu){
        if(!is_array($sort_menus[$menu['menu_category_id']])){
          $sort_menus[$menu['menu_category_id']] = array();
        }
        $sort_menus[$menu['menu_category_id']][$menu['sort_order']] = $menu;
      }
      foreach($sort_menus as $key => $menus){
        ksort($sort_menus[$key]);
      }
      if(!isset($cats)):
      ?>
        <div class="col-12 text-center no_cat">カテゴリーがありません</div>
      <?php
      else:
        ?>
        <div class="tbls">
          <?php
          $count_cat = 0;
          foreach($cats as $value_cat):
            $count_cat++;
            if($value_cat['sort_order'] != "0"){
              $data_id_cat = $value_cat['sort_order'];
            }
            else{
              $data_id_cat = $count_cat;
            }
            ?>
            <div id="<?php echo $value_cat['id']; ?>" class="col-12 tbl_item" data-tbl="menu_category" data-id="<?php echo $data_id_cat; ?>">
              <div class="row">
                <div class="col-12 cat_name">カテゴリー：<?php echo $value_cat['name']; ?></div>
                <?php
                $flag = false;
                if(!empty($sort_menus)):
                  ?>
                  <div class="col-12 tbl tbl_update_index update_menu_index">
                    <div class="row items">
                      <?php
                      $count_item = 0;
                      if($sort_menus[$value_cat['id']]):
                        foreach($sort_menus[$value_cat['id']] as $value_menu):
                          $count_item++;
                          if($value_cat['sort_order']){
                            $data_id_item = $value_menu['sort_order'];
                          }
                          else{
                            $data_id_item = $count_item;
                          }
                          ?>
                          <div class="col-12 tbl_row" id="<?php echo $value_menu['id']; ?>" data-tbl="menu" data-id="<?php echo $data_id_item; ?>">
                            <div class="row">
                              <div class="col-8 item_name"><?php echo $value_menu['name']; ?></div>
                              <div class="col-4 likes">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 123 106" xml:space="preserve">
                                  <path d="M61.6,103.2C47.8,91.5,10.4,52.6,10.4,52.6c-11.9-11.9-9-31.2,3.3-42.3c11.9-10.7,39-11.8,47.9,8.6c8.1-20.4,39.1-19.3,50.8-8c10.8,10.4,9.6,33.2,1.2,41.7C89.4,76.8,80.6,85.2,61.6,103.2z"/>
                                </svg>
                                <?php echo $value_menu['likes']; ?>
                              </div>
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
                          $count_item = 0;
                        endforeach;
                      endif;
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
                  <div class="row btns <?php if($flag) echo 'sortable'; ?>">
                    <div><a class="btn btn-blue" href="insert.php?cat_id=<?php echo $value_cat['id']; ?>&target=menu">メニューを追加</a></div>
                    <button class="btn btn-info btn_sort_item" style="<?php if(!$flag) echo 'display:none;' ?>">メニューの順番を変更</button>
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
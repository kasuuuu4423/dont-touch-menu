<?php

require '../header.php';
require '../pdo/lib_pdo.php';

if (isset($_SESSION["USERID"])):
  ?>
  <main>
    <section class="update_index container">
      <div class="row">
        <div class="col-12 bar"></div>
          <h2 class="col-12">メニュー変更</h2>
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
        $row_menu[$index]['menu_category_id'] = $row['menu_category_id'];
      }

      if(!isset($row_menu_cat)):
      ?>
        <div class="col-12 text-center">メニューカテゴリーがありません</div>
        <div><a href="insert.php?id=<?php echo $_SESSION['ID']; ?>&target=cat">メニューカテゴリーを追加</a></div>
      <?php
      else:
        ?>
        <div class="tbls">
          <?php
          foreach($row_menu_cat as $value_cat):
            ?>
            <div class="col-12 tbl_item">
              <div class="row">
                <div class="col-12 menu_cat">カテゴリー：<?php echo $value_cat['name']; ?></div>
                <?php
                $flag = false;
                if(is_array($row_menu)):
                  ?>
                  <div class="col-12 tbl tbl_update_index">
                    <div class="row">
                      <?php
                      foreach($row_menu as $value_menu):
                        if($value_menu['menu_category_id'] == $value_cat['id']):
                          ?>
                          <div class="col-12 tbl_row">
                            <div class="row">
                              <div class="col-6 menu"><?php echo $value_menu['name']; ?></div>
                              <div class="col-6 edit"><a class="btn btn-green" href="update.php?menu_id=<?php echo $value_menu['id']; ?>">編集</a></div>
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
                      <div class="col-12 tbl_row no_menu">
                        <div class="row">
                          <div class="col-12">メニューがありません</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                endif;
                ?>
                <div class="col-12 btns">
                  <div class="row">
                    <div class="col-6 text-right"><a class="btn btn-blue" href="insert.php?cat_id=<?php echo $value_cat['id']; ?>&target=menu">メニューを追加</a></div>
                    <div class="col-6 text-left"><a class="btn btn-green" href="update.php?cat_id=<?php echo $value_cat['id']; ?>">カテゴリーを編集</a></div>
                  </div>
                </div>
              </div>
            </div>
            <?php
          endforeach;
          ?>
          <div class="col-12 text-center new_cat"><a class="btn btn-blue" href="insert.php?target=cat">新しいカテゴリーを追加</a></div>
        </div>
        <?php
      endif;
      ?>
      </div>
    </section>
  </main>
<?php
endif;
?>
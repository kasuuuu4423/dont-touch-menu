<?php

require '../../config.php';
require '../elements/header.php';
require '../../lib/pdo/lib_pdo.php';

if (isset($_SESSION["USERID"])):
  if(isset($_SESSION['rule_msg'])){
    echo '<div class="update_msg"><span>'.$_SESSION['rule_msg'].'</span></div>';
    unset($_SESSION['rule_msg']);
  }
  ?>
  <main>
    <section class="update_index container">
      <div class="row">
        <div class="col-12 bar"></div>
          <h2 class="col-12">ルール一覧</h2>
          <div id="btns_cat" class="btns_cat col-12 d-flex">
            <div id="wrap_btn_add"><a class="btn btn-blue" href="insert.php?target=cat">新しいカテゴリーを追加</a></div>
            <button id="btn_sort_cat" class="btn btn-info" id="btn_sort_cat">カテゴリーの順番を変更</button>
          </div>
      <?php
      $pdo = new Lib_pdo();
      $id = $_SESSION['ID'];

      $rules = $pdo->select("rule", $id);
      $cats = $pdo->select_sorted("rule_category", $id);
      $sort_rules = array();
      foreach($rules as $rule){
        if(!is_array($sort_rules[$rule['rule_category_id']])){
          $sort_rules[$rule['rule_category_id']] = array();
        }
        $sort_rules[$rule['rule_category_id']][$rule['sort_order']] = $rule;
      }
      foreach($sort_rules as $key => $rules){
        ksort($sort_rules[$key]);
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
            <div  id="<?php echo $value_cat['id']; ?>" class="col-12 tbl_item" data-tbl="rule_category" data-id="<?php echo $data_id_cat; ?>">
              <div class="row">
                <div class="col-12 cat_name">カテゴリー：<?php echo $value_cat['name']; ?></div>
                <?php
                $flag = false;
                if(!empty($sort_rules)):
                  ?>
                  <div class="col-12 cat_nav">
                    <button class="tgl_nav btn btn-green">編集▽</button>
                    <div class="row btns <?php if($sort_rules[$value_cat['id']]) echo 'sortable'; ?>">
                      <div><a href="insert.php?cat_id=<?php echo $value_cat['id']; ?>&target=rule">ルールを追加</a></div>
                      <div><a class="btn_sort_item <?php if(!$sort_rules[$value_cat['id']]) echo 'd-none' ?>">ルールの順番を変更</a></div>
                      <div><a href="update.php?cat_id=<?php echo $value_cat['id']; ?>">カテゴリーを編集</a></div>
                    </div>
                  </div>
                  <div class="col-12 tbl tbl_update_index">
                    <div class="row items">
                      <?php
                      $count_item = 0;
                      if($sort_rules[$value_cat['id']]):
                        foreach($sort_rules[$value_cat['id']] as $value_rule):
                          $count_item++;
                          if(isset($value_cat['sort_order'])){
                            $data_id_item = $value_rule['sort_order'];
                          }
                          else{
                            $data_id_item = $count_item;
                          }
                          ?>
                          <div id="<?php echo $value_rule['id']; ?>" class="col-12 tbl_row" data-tbl="rule" data-id="<?php echo $data_id_item; ?>">
                            <div class="row">
                              <div class="col-8 item_name"><?php echo $value_rule['content']; ?></div>
                              <div class="col-4 edit"><a class="btn btn-green" href="update.php?rule_id=<?php echo $value_rule['id']; ?>">編集</a></div>
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
                          <div class="col-12">ルールがありません</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                endif;
                ?>
              </div>
            </div>
            <?php
          endforeach;
          ?>
        </div>
        <?php
        endif;
        ?>
      </div>
    </section>
  </main>
<?php
endif;
require '../elements/footer.php';
<?php

require '../header.php';
require '../pdo/lib_pdo.php';

if (isset($_SESSION["USERID"])):
  if(isset($_SESSION['rule_msg'])){
    echo '<div class="mt-3 w-100 text-center update_msg"><span>'.$_SESSION['rule_msg'].'</span></div>';
    unset($_SESSION['rule_msg']);
  }
  ?>
  <main>
    <section class="update_index container">
      <div class="row">
        <div class="col-12 bar"></div>
          <h2 class="col-12">ルール変更</h2>
      <?php
      $pdo = new Lib_pdo();
      $id = $_SESSION['ID'];
      $rule_cat = $pdo->select("rule_category", $id);
      foreach($rule_cat as $index => $row){
        $row_rule_cat[$index]['id'] = $row['id'];
        $row_rule_cat[$index]['name'] = $row['name'];
      }
      $rule = $pdo->select("rule", $id);
      foreach($rule as $index => $row){
        $row_rule[$index]['id'] = $row['id'];
        $row_rule[$index]['content'] = $row['content'];
        $row_rule[$index]['rule_category_id'] = $row['rule_category_id'];
      }

      if(!isset($row_rule_cat)):
      ?>
        <div class="col-12 text-center no_cat">カテゴリーがありません</div>
      <?php
      else:
        ?>
        <div class="tbls">
          <?php
          foreach($row_rule_cat as $value_cat):
            ?>
            <div class="col-12 tbl_item">
              <div class="row">
                <div class="col-12 rule_cat">カテゴリー：<?php echo $value_cat['name']; ?></div>
                <?php
                $flag = false;
                if(is_array($row_rule)):
                  ?>
                  <div class="col-12 tbl tbl_update_index">
                    <div class="row">
                      <?php
                      foreach($row_rule as $value_rule):
                        if($value_rule['rule_category_id'] == $value_cat['id']):
                          ?>
                          <div class="col-12 tbl_row">
                            <div class="row">
                              <div class="col-6 rule"><?php echo $value_rule['content']; ?></div>
                              <div class="col-6 edit"><a class="btn btn-green" href="update.php?rule_id=<?php echo $value_rule['id']; ?>">編集</a></div>
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
                      <div class="col-12 tbl_row no_rule">
                        <div class="row">
                          <div class="col-12">ルールがありません</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                endif;
                ?>
                <div class="col-12 btns">
                  <div class="row">
                    <div class="col-6 text-right"><a class="btn btn-blue" href="insert.php?cat_id=<?php echo $value_cat['id']; ?>&target=rule">ルールを追加</a></div>
                    <div class="col-6 text-left"><a class="btn btn-green" href="update.php?cat_id=<?php echo $value_cat['id']; ?>">カテゴリーを編集</a></div>
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
<?php
endif;
?>
<?php

require 'header.php';
require 'pdo/lib_pdo.php';

if(isset($_SESSION['USERID'])){
  $pdo = new Lib_pdo();
  $store_info = $pdo->select("store", $_SESSION['ID'])[0];
  $seats = $store_info["seats"];
  $today = date("Y-m-d");
  $guests = array_reverse($pdo->select_guest_byDate($today, $_SESSION['ID']));

  $guest_sum = 0;
  foreach($guests as $guest){
    $guest_enter_date = substr($guest['enter_datetime'], 0, 10);
    if(($guest['leave_datetime'] == NULL) and ($today == $guest_enter_date)){
      $guest_sum += $guest['num'];
    }
  }

  if(isset($_SESSION['seats_inCtrl_msg'])){
    echo '<div class="col-12 update_msg"><span>'.$_SESSION['seats_inCtrl_msg'].'</span></div>';
    unset($_SESSION['seats_inCtrl_msg']);
  }
  else if(isset($_SESSION['leave_inCtrl_msg'])){
    echo '<div class="col-12 update_msg"><span>'.$_SESSION['leave_inCtrl_msg'].'</span></div>';
    unset($_SESSION['leave_inCtrl_msg']);
  }

  if(isset($_POST['update_seats'])){
    $pdo = new Lib_pdo();
    $pdo->update_store_seats($_POST['store_seats'], $_SESSION['ID']);
    $_SESSION['seats_inCtrl_msg'] = '最大席数を更新しました';
    header("Location:$control_path");
  }
  else if(isset($_GET['guest_id'])){
    $pdo->leave_guest($_GET['guest_id']);
    $_SESSION['leave_inCtrl_msg'] = 'お客様が退店しました';
    header("Location:$control_path");
  }
  ?>
  <main class="ctrl_top">
    <section class="status container">
      <div class="row">
        <div class="col-12 bar"></div>
        <h2 class="col-12">現在の店内状況</h2>
        <div class="col-12 text-center seats"><?php echo $guest_sum; ?>/<?php echo $seats ?><span>席</span></div>
        <form class="col-12 text-center" action="index.php" method="post">
          <span>最大席数</span>
          <input class="store_seats" type="text" name="store_seats" value="<?php if (!empty($seats)) echo(htmlspecialchars($seats, ENT_QUOTES, 'UTF-8'));?>">
          <input class="update_seats btn btn-green" type="submit" name="update_seats" value="変更">
        </form>
      </div>
    </section>
    <section class="history container">
      <div class="row">
        <div class="col-12 bar"></div>
        <h2 class="col-12">履歴</h2>
        <?php
          if(empty($guests)):
        ?>
        <div class="col-12 text-center no_history">本日の履歴はありません</div>
          <?php else: ?>
        <div class="col-12 tbl tbl_history">
          <div class="row">
            <div class="col-12 tbl_row">
              <div class="row">
                <div class="col-3 tbl_num">人数</div>
                <div class="col-4 tbl_enter">入店時刻</div>
              </div>
            </div>
            <?php
            foreach($guests as $index=>$guest){
              $enter_time = str_replace(array(" ", "-", ":"), "", $guest['enter_datetime']);
              $enter_times[$index] = array(
                'month' => str_replace("0", "", substr($enter_time, 4, 1)).substr($enter_time, 5, 1),
                'day' => str_replace("0", "", substr($enter_time, 6, 1)).substr($enter_time, 7, 1),
                'hour' => str_replace("0", "", substr($enter_time, 8, 1)).substr($enter_time, 9, 1),
                'min' => substr($enter_time, 10, 2),
              );
              $leave_time = str_replace(array(" ", "-", ":"), "", $guest['leave_datetime']);
              $leave_times[$index] = array(
                'hour' => str_replace("0", "", substr($leave_time, 8, 1)).substr($leave_time, 9, 1),
                'min' => substr($leave_time, 10, 2),
              );
            ?>
            <div class="col-12 tbl_row">
              <div class="row">
                <div class="col-3 tbl_num"><?php echo $guest['num']; ?>名</div>
                <div class="col-4 tbl_enter">
                  <span class="tbl_enter_date">
                    <?php echo $enter_times[$index]['month'].'/'.$enter_times[$index]['day']; ?>
                  </span>
                  <span class="tbl_enter_time">
                    <?php echo $enter_times[$index]['hour'].':'.$enter_times[$index]['min']; ?>
                  </span>
                </div>
                <div class="col-5 tbl_leave">
                  <?php
                  if(empty($guest['leave_datetime'])){
                    echo '<input type="hidden" name="guest_id" value="'.$guest['id'].'">';
                    echo '<a class="btn btn-red" href="'.$control_path.'?guest_id='.$guest['id'].'">ご退店</a>';
                  }
                  else{
                    echo '<span class="tbl_leave_date">'.$leave_times[$index]['hour'].':'.$leave_times[$index]['min'].'</span>';
                    echo '<span>退店</span>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
        </div>
          <?php endif; ?>
      </div>
    </section>
  </main>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
  <?php
}
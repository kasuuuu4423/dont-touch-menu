<?php
require '../../control/config.php';
require '../../control/pdo/lib_pdo.php';
session_start();

$pdo = new Lib_pdo();
if(isset($_GET['guest_id'])){
    $guest_id = $_GET['guest_id'];
    $pdo->leave_guest($guest_id);
}
elseif(isset($_GET["id"])){
    $id = $_GET["id"];
    $store_info = $pdo->select("store", $id)[0];
    $name = $store_info["name"];
    $seats = $store_info["seats"];
    $img_path = $store_info["img_path"];
    $open = $store_info["open"];
    $close = $store_info["close"];
    $last = $store_info["last_order"];
    $exception = $store_info["exception"];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $public_path; ?>/css/common.css">
    <link rel="stylesheet" href="<?php echo $public_path; ?>/css/home.css">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_SESSION['message'])):
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    else:
    ?>
    <header>
        <div class="container-fluid">
            <div class="row">
            <h1 class="col-12">
                <figure class="logo"><img src="<?php echo $img_path; ?>" alt="<?php echo $name; ?>"></figure>
            </h1>
            </div>
        </div>
    </header>
    <main class="leave container">
        <form class="row" id="form" method="get">
            <input class="col-12" id="submit_btn" type="button" value="退店">
        </form>
    </main><script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script>
    window.onload = () => {
        let button = document.getElementById("submit_btn");
        let form = document.getElementById("form");
        button.addEventListener('click', () => {
            let id = $.cookie("id");
            let input = document.createElement('input');
            $.cookie("id", "",{path:"/",expires:-1});
            $.cookie("like", "",{path:"/",expires:-1});
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'guest_id');
            input.setAttribute('value', id);
            form.insertBefore(input, form.firstChild);
            form.submit();
        });
    };
    </script>
    <?php endif; ?>
</body>
</html>
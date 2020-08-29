<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="form" action="https://artful.jp/staging-menu/control/pdo/pdo_guest_delete.php">
        <button id="submit" value="">退店</button>
    </form>
    <script>
    window.onload = () => {
        console.log(document.cookie);
        let button = document.getElementById("submit");
        let form = document.getElementById("form");
        button.addEventListener('click', () => {
            let cookies = document.cookie;
            cookies = cookies.split(';');
            for(let cookie of cookies){
                let key = cookie.split('=')[0];
                let value = cookie.split('=')[1];
                if(key == 'id'){
                    button.value = value;
                    document.cookie = "id=" + value + ";max-age=0";
                    console.log(document.cookie);
                }
            }
            form.submit();
        });
    };
    </script>
</body>
</html>
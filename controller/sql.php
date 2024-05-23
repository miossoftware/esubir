<?php
include 'DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
if ($islem == "register_user") {
    $veritabani_kaydi = DB::insert('users', $_POST);
    if ($veritabani_kaydi) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "session_check"){
    if (isset($_SESSION["user_id"])){
        echo 1;
    }else{
        echo 2;
    }
}
if ($islem == "yetkisi_ne_sql"){
    echo $_SESSION["user_root"];
}
if ($islem == "authentication") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $login = DB::single_query("select * from users where username='$username' and status=1");
    if ($login > 0) {
        $hash_password = $login["user_password"];// VT DEĞERİ
        if (password_verify($password, $hash_password)) {
            $id = $login["id"];
            $root = $login["user_root"];
            $_SESSION["username"] = $username;
            $_SESSION["name_surname"] = $login["name_surname"];
            $_SESSION["user_id"] = $id;
            $_SESSION["user_root"] = $root;
            $_SESSION["cari_key"] = $login["cari_key"];
            $_SESSION["sube_key"] = $login["sube_key"];
            echo 1;
        }else{
            echo 3;
        }
    } else {
        echo 2;
    }
}
if ($islem == "logout") {
    $id = $_SESSION["user_id"];
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    echo 1;
}
if ($islem == "kullanicilari_getir") {
    $veri = DB::all_data("SELECT * FROM users");
    if ($veri > 0) {
        echo json_encode($veri);
    } else {
        echo 2;
    }
}
if ($islem == "get_all_panels_for_root") {
    $paneller = DB::all_data("SELECT * FROM panels");
    if ($paneller > 0) {
        echo json_encode($paneller);
    } else {
        echo 2;
    }
}
<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$_POST["cari_key"] = $_SESSION["cari_key"];
$_GET["cari_key"] = $_SESSION["cari_key"];
$_POST["sube_key"] = $_SESSION["sube_key"];
$sube_key = $_SESSION["sube_key"];
$cari_key = $_SESSION["cari_key"];
$ek_sorgu = "";
if ($sube_key != 0){
    $ek_sorgu = " AND sube_key='$sube_key'";
}
if ($islem == "kullanicilari_getir") {
    $id = $_SESSION["user_id"];
    if ($_SESSION["user_root"] == 1) {
        $users = DB::all_data("SELECT * FROM users WHERE id NOT IN ($id) AND user_root!=2 AND status!=3 and cari_key='$cari_key' $ek_sorgu");
        if ($users > 0) {
            echo json_encode($users);
        } else {
            echo 2;
        }
    } else {
        $users = DB::all_data("SELECT * FROM users WHERE  id NOT IN ($id) and cari_key='$cari_key' $ek_sorgu");
        if ($users > 0) {
            echo json_encode($users);
        } else {
            echo 2;
        }
    }
}
if ($islem == "kullanici_aktif_et_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 1;
    $id = $_POST["id"];
    $kullanici_durum = DB::single_query("SELECT * FROM users WHERE cari_key='$cari_key' $ek_sorgu id='$id'");
    if ($kullanici_durum["status"] == 4){
        if ($_SESSION["user_root"] == 2){
            $kullanici_aktif_et = DB::update("users", "id", $id, $_POST);
            if ($kullanici_aktif_et) {
                echo 1;
            } else {
                echo 2;
            }
        }else{
            echo 404;
        }
    }else{
        $kullanici_aktif_et = DB::update("users", "id", $id, $_POST);
        if ($kullanici_aktif_et) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "kullanici_pasif_et_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $kull_pasif_et = DB::update("users", "id", $id, $_POST);
    if ($kull_pasif_et) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kullanici_ekle_sql") {
    $_POST["cari_key"] = $_SESSION["cari_key"];
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $password = $_POST["user_password"];
    $option = [
        'cost' => 11,
    ];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, $option);
    $_POST["user_password"] = $hashed_password;
    $kullanici_ekle = DB::insert("users", $_POST);
    if ($kullanici_ekle) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "yetkisi_nedir_sql") {
    echo json_encode($_SESSION["user_root"]);
}
if ($islem == "kullaniciyi_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 3;
    $id = $_POST["id"];
    $kullanici_sil = DB::update("users", "id", $id, $_POST);
    if ($kullanici_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kullanici_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $kullanici_bilgileri = DB::single_query("SELECT * FROM users WHERE id='$id' and cari_key='$cari_key' $ek_sorgu");
    if ($kullanici_bilgileri > 0) {
        echo json_encode($kullanici_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "kullanici_guncelle") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    if (isset($_POST["user_password"])) {
        $password = $_POST["user_password"];
        $option = [
            'cost' => 11,
        ];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $option);
        $_POST["user_password"] = $hashed_password;
        $kullanici_pasif_mi = DB::single_query("SELECT * FROM users WHERE status=1 AND id='$id' and cari_key='$cari_key' $ek_sorgu");
        if ($kullanici_pasif_mi > 0) {
            $kullanici_ekle = DB::update("users", "id", $id, $_POST);
            if ($kullanici_ekle) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 404;
        }
    } else {
        $kullanici_pasif_mi = DB::single_query("SELECT * FROM users WHERE status=1 and id='$id' and cari_key='$cari_key' $ek_sorgu");
        if ($kullanici_pasif_mi > 0) {
            $kullanici_ekle = DB::update("users", "id", $id, $_POST);
            if ($kullanici_ekle) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 404;
        }
    }
}
if ($islem == "user_yetkisi"){
    echo $_SESSION["user_root"];
}
if ($islem == "kullanici_yetkileri_getir"){
    $id = $_GET["id"];
    $kullanici_yetki_mail = DB::single_query("SELECT * FROM users WHERE status=1 AND id='$id' and cari_key='$cari_key' $ek_sorgu");
    if ($kullanici_yetki_mail > 0){
        echo json_encode($kullanici_yetki_mail);
    }else{
        echo 2;
    }
}
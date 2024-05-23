<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$_POST["cari_key"] = $_SESSION["cari_key"];
$_POST["sube_key"] = $_SESSION["sube_key"];
$_GET["cari_key"] = $_SESSION["cari_key"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$ek_sorgu = "";
if ($sube_key != 0){
    $ek_sorgu = " AND sube_key='$sube_key'";
}
if ($islem == "bilancolari_getir"){
    $bilancolar = DB::all_data("SELECT * FROM bilancolar WHERE status=1 and cari_key='$cari_key' ");
    if ($bilancolar > 0){
        echo json_encode($bilancolar);
    }else{
        echo 2;
    }
}
if ($islem == "yeni_bilanco_tanimla"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $bilanco_kodu = $_POST["bilanco_kodu"];
    $varmi = DB::single_query("SELECT * FROM bilancolar WHERE bilanco_kodu='$bilanco_kodu'");
    if ($varmi > 0){
        echo 300;
    }else{
        $alt_grup_ekle = DB::insert("bilancolar",$_POST);
        if ($alt_grup_ekle){
            echo 2;
        }else{
            echo 1;
        }
    }
}
if ($islem == "bilanco_sil"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $cari_sil = DB::update("bilancolar", "id", $id, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "bilanco_guncelle"){
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    $bilanco_guncelle = DB::update("bilancolar","id",$id,$_POST);
    if ($bilanco_guncelle){
        echo 1;
    }else{
        echo 2;
    }
}
if ($islem == "bilanco_bilgileri_getir"){
    $id = $_GET["id"];
    $bilanco_bilgileri = DB::single_query("SELECT * FROM bilancolar WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($bilanco_bilgileri > 0){
        echo json_encode($bilanco_bilgileri);
    }else{
        echo 2;
    }
}
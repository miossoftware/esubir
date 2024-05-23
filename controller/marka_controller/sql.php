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
if ($islem == "marka_listesi_getir"){
    $markalar = DB::all_data("SELECT * FROM marka WHERE status=1 and cari_key='$cari_key' ");
    if ($markalar > 0){
        echo json_encode($markalar);
    }else{
        echo 2;
    }
}
if ($islem == "yeni_marka_ekle"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $ana_grup_ekle = DB::insert("marka",$_POST);
    if ($ana_grup_ekle){
        echo 2;
    }else{
        echo 1;
    }
}
if ($islem == "marka_sil_sql"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $cari_sil = DB::update("marka", "id", $id, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "marka_bilgileri_getir"){
    $id = $_GET["id"];
    $marka_bilgileri = DB::single_query("SELECT * FROM marka WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($marka_bilgileri > 0){
        echo json_encode($marka_bilgileri);
    }else{
        echo 2;
    }
}
if ($islem == "marka_guncelle_sql"){
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    $ana_grup_guncelle = DB::update("marka", "id", $id, $_POST);
    if ($ana_grup_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}